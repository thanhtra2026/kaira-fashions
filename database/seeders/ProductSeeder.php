<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Đổi thành 'png' hoặc 'webp' nếu file ảnh của bạn không phải .jpg
        $ext = 'jpg';

        // [danh mục, tên sản phẩm, giá, tên file ảnh (không có đuôi)]
        $items = [
            ['nam',    'Áo sơ mi linen nam',   450000, 'ao-so-mi-linen-nam'],
            ['nam',    'Quần tây slim fit',    620000, 'quan-tay-slim-fit'],
            ['nu',     'Đầm midi hoa nhí',     780000, 'dam-midi-hoa-nhi'],
            ['nu',     'Áo khoác dạ dáng dài', 950000, 'ao-khoac-da-dang-dai'],
            ['tre-em', 'Bộ đồ cotton bé trai', 320000, 'bo-do-cotton-be-trai'],
            ['tre-em', 'Váy xòe bé gái',       350000, 'vay-xoe-be-gai'],
        ];

        foreach ($items as [$cat, $name, $price, $file]) {
            Product::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'category_id' => Category::where('slug', $cat)->value('id'),
                    'name'        => $name,
                    'description' => 'Chất liệu thoải mái, form đẹp.',
                    'price'       => $price,
                    'stock'       => 50,
                    'image'       => "images/products/{$file}.{$ext}",
                ]
            );
        }
    }
}