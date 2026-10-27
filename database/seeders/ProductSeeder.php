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
                $extraProducts = [
            ['nam', 'Áo thun trắng viền xanh navy', 'ao-thun-trang-vien-xanh-navy', 250000, 40, 'images/products/uploads/1792944296-8Z540V1N.jpg'],
            ['nam', 'Quần jean ống rộng nam', 'quan-jean-ong-rong-nam', 590000, 25, 'images/products/uploads/1792944325-b531nuAy.jpg'],
            ['nu', 'Áo sơ mi kem cổ nơ nữ', 'ao-so-mi-kem-co-no-nu', 420000, 30, 'images/products/uploads/1792944356-WA9r1CjZ.jpg'],
            ['nu', 'Chân váy xòe midi màu be', 'chan-vay-xoe-midi-mau-be', 380000, 35, 'images/products/uploads/1792944446-2cjuCmAR.jpg'],
            ['tre-em', 'Áo thun in chữ oversize bé trai', 'ao-thun-in-chu-oversize-be-trai', 180000, 20, 'images/products/uploads/1792944477-I0qPsJ68.jpg'],
            ['tre-em', 'Đầm voan phối yếm bé gái', 'dam-voan-phoi-yem-be-gai', 330000, 13, 'images/products/uploads/1792944499-WkN0LKL9.jpg'],
        ];

        foreach ($extraProducts as [$categorySlug, $name, $slug, $price, $stock, $image]) {
            $categoryId = Category::where('slug', $categorySlug)->value('id');

            if (! $categoryId) {
                throw new \RuntimeException("Không tìm thấy danh mục: {$categorySlug}");
            }

            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $categoryId,
                    'name' => $name,
                    'price' => $price,
                    'stock' => $stock,
                    'image' => $image,
                ]
            );
        }
    }
}