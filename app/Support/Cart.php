<?php

namespace App\Support;

use App\Models\Product;

/**
 * Giỏ hàng lưu trong session: session('cart') = [product_id => số lượng].
 * Khách chưa đăng nhập vẫn thêm giỏ được; chỉ khi thanh toán mới bắt đăng nhập.
 */
class Cart
{
    public static function raw(): array
    {
        return session('cart', []);
    }

    public static function count(): int
    {
        return (int) array_sum(self::raw());
    }

    /** @return array{0: array, 1: int} [danh sách dòng, tổng tiền] */
    public static function items(): array
    {
        $cart = self::raw();
        if (! $cart) {
            return [[], 0];
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $items = [];
        $clean = [];
        $total = 0;

        foreach ($cart as $id => $qty) {
            $product = $products->get($id);
            if (! $product) {
                continue; // sản phẩm đã bị xóa khỏi cửa hàng
            }
            $clean[$id] = $qty;
            $subtotal = (int) $product->price * $qty;
            $total += $subtotal;
            $items[] = [
                'product'  => $product,
                'qty'      => $qty,
                'subtotal' => $subtotal,
                'over'     => $qty > $product->stock, // vượt tồn kho
            ];
        }

        if ($clean !== $cart) {
            session(['cart' => $clean]);
        }

        return [$items, $total];
    }
}
