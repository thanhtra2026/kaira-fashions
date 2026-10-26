<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    // Danh sách + tìm (mã đơn, tên, SĐT) + lọc trạng thái + phân trang
    public function index(Request $request)
    {
        $request->validate([
            'q'      => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(array_keys(Order::STATUSES))],
        ]);

        $keyword = trim((string) $request->input('q', ''));
        $status  = $request->input('status');

        $orders = Order::with('user')
            ->when($keyword !== '', function ($q) use ($keyword) {
                $q->where(function ($w) use ($keyword) {
                    $w->where('shipping_name', 'like', "%{$keyword}%")
                      ->orWhere('shipping_phone', 'like', "%{$keyword}%")
                      ->orWhere('id', ltrim($keyword, '#'));
                });
            })
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'keyword', 'status'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }

    // PATCH /admin/orders/{order}/status
    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Order::STATUSES))],
        ], [
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in'       => 'Trạng thái không hợp lệ.',
        ]);

        if ($order->status === 'cancelled') {
            return back()->with('error', 'Đơn đã hủy không thể đổi trạng thái.');
        }

        if ($data['status'] === 'cancelled') {
            $order->cancel(); // hoàn lại tồn kho
        } else {
            $order->update(['status' => $data['status']]);
        }

        return back()->with('success', "Đã cập nhật đơn #{$order->id}: " . Order::STATUSES[$data['status']] . '.');
    }
}
