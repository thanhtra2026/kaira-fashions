<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Support\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // GET /thanh-toan
    public function show()
    {
        [$items, $total] = Cart::items();

        if (! $items) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng đang trống.');
        }

        return view('checkout.show', compact('items', 'total'));
    }

    // POST /thanh-toan
    public function store(Request $request)
    {
        $data = $request->validate([
            'shipping_name'    => ['required', 'string', 'max:100'],
            'shipping_phone'   => ['required', 'regex:/^(0|\+84)[0-9]{9,10}$/'],
            'shipping_address' => ['required', 'string', 'max:255'],
        ], [
            'shipping_name.required'    => 'Vui lòng nhập họ tên người nhận.',
            'shipping_name.max'         => 'Họ tên tối đa 100 ký tự.',
            'shipping_phone.required'   => 'Vui lòng nhập số điện thoại.',
            'shipping_phone.regex'      => 'Số điện thoại không hợp lệ (ví dụ 0901234567).',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ giao hàng.',
            'shipping_address.max'      => 'Địa chỉ tối đa 255 ký tự.',
        ]);

        $cart = Cart::raw();
        if (! $cart) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng đang trống.');
        }

        try {
            $order = DB::transaction(function () use ($data, $cart) {
                // Khóa các dòng sản phẩm để hai người không mua vượt tồn kho cùng lúc
                $products = Product::whereIn('id', array_keys($cart))->lockForUpdate()->get()->keyBy('id');

                $total = 0;
                foreach ($cart as $id => $qty) {
                    $product = $products->get($id);
                    if (! $product || $product->stock < $qty) {
                        throw new \RuntimeException('Sản phẩm "' . ($product->name ?? 'không còn bán') . '" không đủ hàng. Vui lòng kiểm tra lại giỏ.');
                    }
                    $total += (int) $product->price * $qty;
                }

                $order = Order::create($data + [
                    'user_id' => auth()->id(),
                    'total'   => $total,
                    'status'  => 'pending',
                ]);

                foreach ($cart as $id => $qty) {
                    $product = $products->get($id);
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $product->id,
                        'quantity'   => $qty,
                        'price'      => $product->price, // chốt giá tại thời điểm mua
                    ]);
                    $product->decrement('stock', $qty);
                }

                return $order;
            });
        } catch (\RuntimeException $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }

        session()->forget('cart');

        return redirect()->route('orders.show', $order)
            ->with('success', "Đặt hàng thành công! Mã đơn #{$order->id}.");
    }
}
