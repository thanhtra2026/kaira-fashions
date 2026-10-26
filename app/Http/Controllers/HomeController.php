<?php
 
namespace App\Http\Controllers;
 
use App\Models\Category;
use App\Models\Product;
 
class HomeController extends Controller
{
    public function index()
    {
        $categories  = Category::all();
        $newProducts = Product::with('category')->latest()->take(6)->get();
 
        // Tạm thời lấy 6 sản phẩm cũ nhất; khi có đơn hàng sẽ đổi sang tính theo số lượng bán
        $bestSellers = Product::with('category')->oldest()->take(6)->get();
 
        return view('home', compact('categories', 'newProducts', 'bestSellers'));
    }
}