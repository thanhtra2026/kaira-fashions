<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    public const STATUSES = [
        'pending'    => 'Chờ xác nhận',
        'processing' => 'Đang xử lý',
        'shipping'   => 'Đang giao',
        'completed'  => 'Hoàn thành',
        'cancelled'  => 'Đã hủy',
    ];

    public const STATUS_CLASSES = [
        'pending'    => 'bg-warning text-dark',
        'processing' => 'bg-info text-dark',
        'shipping'   => 'bg-primary',
        'completed'  => 'bg-success',
        'cancelled'  => 'bg-secondary',
    ];

    protected $fillable = [
        'user_id', 'total', 'status',
        'shipping_name', 'shipping_phone', 'shipping_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getStatusClassAttribute(): string
    {
        return self::STATUS_CLASSES[$this->status] ?? 'bg-secondary';
    }

    /** Hủy đơn và hoàn lại tồn kho (chạy trong transaction). */
    public function cancel(): void
    {
        DB::transaction(function () {
            foreach ($this->items as $item) {
                Product::where('id', $item->product_id)->increment('stock', $item->quantity);
            }
            $this->update(['status' => 'cancelled']);
        });
    }
}
