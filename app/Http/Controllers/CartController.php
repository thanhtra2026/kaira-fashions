<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // GET /gio-hang
    public function index()
    {
        [$items, $total] = Cart::items();

        return view('cart.index', compact('items', 'total'));
    }

    // POST /gio-hang/them/{product}
    // Hỗ trợ cả form thường (redirect) và AJAX (trả JSON khi request có header Accept: application/json)
    public function add(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ], [
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min'     => 'Số lượng tối thiểu là 1.',
            'quantity.max'     => 'Số lượng tối đa mỗi lần thêm là 99.',
        ]);

        if ($product->stock < 1) {
            $msg = "\"{$product->name}\" đã hết hàng.";

            if ($request->expectsJson()) {
                return response()->json(['type' => 'danger', 'message' => $msg, 'count' => Cart::count()], 422);
            }

            return back()->with('error', $msg);
        }

        $cart    = Cart::raw();
        $wanted  = ($cart[$product->id] ?? 0) + (int) ($data['quantity'] ?? 1);
        $final   = min($wanted, $product->stock);
        $cart[$product->id] = $final;
        session(['cart' => $cart]);

        $capped = $final < $wanted;
        $msg = $capped
            ? "Chỉ còn {$product->stock} sản phẩm \"{$product->name}\", đã đặt số lượng tối đa trong giỏ."
            : "Đã thêm \"{$product->name}\" vào giỏ hàng.";

        if ($request->expectsJson()) {
            return response()->json([
                'type'    => $capped ? 'warning' : 'success',
                'message' => $msg,
                'count'   => Cart::count(),
            ]);
        }

        return redirect()->route('cart.index')->with($capped ? 'error' : 'success', $msg);
    }

    // PATCH /gio-hang/{product}
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ], [
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.integer'  => 'Số lượng phải là số nguyên.',
            'quantity.min'      => 'Số lượng tối thiểu là 1 (muốn bỏ sản phẩm hãy bấm Xóa).',
            'quantity.max'      => 'Số lượng tối đa là 99.',
        ]);

        $cart = Cart::raw();
        if (! isset($cart[$product->id])) {
            return redirect()->route('cart.index');
        }

        $qty = min((int) $data['quantity'], max($product->stock, 1));
        $cart[$product->id] = $qty;
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with(
            $qty < (int) $data['quantity'] ? 'error' : 'success',
            $qty < (int) $data['quantity']
                ? "Chỉ còn {$product->stock} sản phẩm \"{$product->name}\"."
                : 'Đã cập nhật số lượng.'
        );
    }

    // DELETE /gio-hang/{product}
    public function remove(Product $product)
    {
        $cart = Cart::raw();
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
}
