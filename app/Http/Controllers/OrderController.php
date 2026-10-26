<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    // GET /don-hang - đơn của chính người dùng
    public function index()
    {
        $orders = Order::withCount('items')
            ->where('user_id', auth()->id())
            ->latest('id')
            ->paginate(5);

        return view('orders.index', compact('orders'));
    }

    // GET /don-hang/{order}
    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403, 'Bạn không có quyền xem đơn hàng này.');

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    // POST /don-hang/{order}/huy - chỉ hủy được khi còn "Chờ xác nhận"
    public function cancel(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403, 'Bạn không có quyền với đơn hàng này.');

        if ($order->status !== 'pending') {
            return back()->with('error', 'Chỉ hủy được đơn đang chờ xác nhận.');
        }

        $order->cancel();

        return redirect()->route('orders.show', $order)->with('success', 'Đã hủy đơn hàng.');
    }
}
