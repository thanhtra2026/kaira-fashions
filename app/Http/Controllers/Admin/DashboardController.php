<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'categoryCount' => Category::count(),
            'productCount'  => Product::count(),
            'orderCount'    => Order::count(),
            'pendingCount'  => Order::where('status', 'pending')->count(),
            // Doanh thu: không tính đơn đã hủy
            'revenue'       => Order::where('status', '!=', 'cancelled')->sum('total'),
            'recentOrders'  => Order::with('user')->latest()->take(5)->get(),
            // Sản phẩm sắp hết hàng (tồn kho từ 5 trở xuống)
            'lowStock'      => Product::where('stock', '<=', 5)->orderBy('stock')->take(5)->get(),
        ]);
    }
}
