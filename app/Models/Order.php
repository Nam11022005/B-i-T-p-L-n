<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'customer_name',
        'customer_phone',
        'shipping_address',
        'notes',

        'subtotal',
        'shipping_fee',
        'discount',
        'total_price',

        'status',

        'payment_method',
        'payment_status',
        'payment_code',

        'shipping_method',
        'voucher_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}