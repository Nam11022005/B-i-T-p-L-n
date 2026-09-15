<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'price',
        'category_id',
        'image',

        // Đơn vị bán
        'unit',
        'min_quantity',
        'quantity_step',
        'is_featured',

        // Khuyến mãi
        'sale_price',
        'sale_start',
        'sale_end',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'decimal:2',
        'min_quantity' => 'decimal:2',
        'quantity_step' => 'decimal:2',
        'is_featured' => 'boolean',
        'sale_price' => 'decimal:2',
        'sale_start' => 'datetime',
        'sale_end' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Đánh giá sản phẩm
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Chi tiết đơn hàng chứa sản phẩm này
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function averageRating(): float
    {
        return round((float) $this->reviews()->avg('rating'), 1);
    }

    public function reviewCount(): int
    {
        return $this->reviews()->count();
    }

    /*
     * Số lượng đã bán.
     * CHỈ tính OrderItem thuộc đơn có status = delivered.
     *
     * Nếu controller đã dùng withSum(... as sold_quantity),
     * accessor sẽ dùng luôn dữ liệu đó để tránh query lại.
     */
    public function getSoldQuantityAttribute($value): float
    {
        if ($value !== null) {
            return (float) $value;
        }

        return (float) $this->orderItems()
            ->whereHas('order', function ($query) {
                $query->where('status', 'delivered');
            })
            ->sum('quantity');
    }

    /*
     * Scope dùng chung để nạp số lượng đã bán hiệu quả.
     *
     * Ví dụ:
     * Product::withSoldQuantity()->get();
     */
    public function scopeWithSoldQuantity($query)
    {
        return $query->withSum(
            [
                'orderItems as sold_quantity' => function ($itemQuery) {
                    $itemQuery->whereHas('order', function ($orderQuery) {
                        $orderQuery->where('status', 'delivered');
                    });
                },
            ],
            'quantity'
        );
    }

    public function isOnSale(): bool
    {
        if ($this->sale_price === null) {
            return false;
        }

        if ((float) $this->sale_price >= (float) $this->price) {
            return false;
        }

        $now = now();

        if ($this->sale_start && $now->lt($this->sale_start)) {
            return false;
        }

        if ($this->sale_end && $now->gt($this->sale_end)) {
            return false;
        }

        return true;
    }

    public function getCurrentPrice(): float
    {
        return $this->isOnSale()
            ? (float) $this->sale_price
            : (float) $this->price;
    }

    public function getDiscountPercent(): int
    {
        if (!$this->isOnSale() || (float) $this->price <= 0) {
            return 0;
        }

        return (int) round(
            (1 - ((float) $this->sale_price / (float) $this->price)) * 100
        );
    }

    public function scopeOnSale($query)
    {
        $now = now();

        return $query
            ->whereNotNull('sale_price')
            ->whereColumn('sale_price', '<', 'price')
            ->where(function ($q) use ($now) {
                $q->whereNull('sale_start')
                    ->orWhere('sale_start', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('sale_end')
                    ->orWhere('sale_end', '>=', $now);
            });
    }
}
