<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // /san-pham hoặc /danh-muc/{slug}
    // Tham số lọc (GET): q (từ khóa), min_price, max_price, sort
    public function index(Request $request, ?string $slug = null)
    {
        $request->validate([
            'q'         => ['nullable', 'string', 'max:100'],
            'min_price' => ['nullable', 'integer', 'min:0'],
            'max_price' => ['nullable', 'integer', 'min:0'],
            'sort'      => ['nullable', 'in:newest,price_asc,price_desc'],
        ], [
            'q.max'             => 'Từ khóa tối đa 100 ký tự.',
            'min_price.integer' => 'Giá từ phải là số nguyên.',
            'min_price.min'     => 'Giá từ không được nhỏ hơn 0.',
            'max_price.integer' => 'Giá đến phải là số nguyên.',
            'max_price.min'     => 'Giá đến không được nhỏ hơn 0.',
            'sort.in'           => 'Cách sắp xếp không hợp lệ.',
        ]);

        $categories = Category::all();
        $category   = $slug ? Category::where('slug', $slug)->firstOrFail() : null;

        $keyword = trim((string) $request->input('q', ''));
        $min     = $request->filled('min_price') ? (int) $request->input('min_price') : null;
        $max     = $request->filled('max_price') ? (int) $request->input('max_price') : null;
        $sort    = $request->input('sort', 'newest');

        // Nếu nhập ngược (từ lớn hơn đến) thì tự đổi chỗ
        if ($min !== null && $max !== null && $min > $max) {
            [$min, $max] = [$max, $min];
        }

        $query = Product::with('category')
            ->when($category, fn ($q) => $q->where('category_id', $category->id))
            ->when($keyword !== '', function ($q) use ($keyword) {
                $q->where(function ($w) use ($keyword) {
                    $w->where('name', 'like', "%{$keyword}%")
                      ->orWhere('description', 'like', "%{$keyword}%");
                });
            })
            ->when($min !== null, fn ($q) => $q->where('price', '>=', $min))
            ->when($max !== null, fn ($q) => $q->where('price', '<=', $max));

        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default      => $query->latest(),
        };

        // withQueryString(): giữ lại bộ lọc khi chuyển trang
        $products = $query->paginate(6)->withQueryString();

        return view('products.index', [
            'categories' => $categories,
            'category'   => $category,
            'products'   => $products,
            'keyword'    => $keyword,
            'min'        => $min,
            'max'        => $max,
            'sort'       => $sort,
        ]);
    }

    // /san-pham/{slug}
    public function show(string $slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(3)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
