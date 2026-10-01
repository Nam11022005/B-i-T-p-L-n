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

        // Thời hạn thanh toán QR
        'payment_expires_at',

        'payment_code',

        'shipping_method',
        'voucher_code',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'payment_expires_at' => 'datetime',

        'subtotal' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];


    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ORDER ITEMS
    |--------------------------------------------------------------------------
    */

    public function items()
    {
        return $this->hasMany(
            OrderItem::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LỊCH SỬ TRẠNG THÁI
    |--------------------------------------------------------------------------
    */

    public function statusHistories()
    {
        return $this->hasMany(
            OrderStatusHistory::class
        )->oldest();
    }


    /*
    |--------------------------------------------------------------------------
    | KIỂM TRA ĐƠN CHUYỂN KHOẢN
    |--------------------------------------------------------------------------
    */

    public function isBankTransfer(): bool
    {
        return $this->payment_method === 'bank';
    }


    /*
    |--------------------------------------------------------------------------
    | KIỂM TRA ĐÃ THANH TOÁN
    |--------------------------------------------------------------------------
    */

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }


    /*
    |--------------------------------------------------------------------------
    | KIỂM TRA ĐANG CHỜ THANH TOÁN QR
    |--------------------------------------------------------------------------
    */

    public function isWaitingForPayment(): bool
    {
        return
            $this->payment_method === 'bank'
            &&
            $this->payment_status === 'pending_confirmation'
            &&
            $this->status !== 'cancelled';
    }


    /*
    |--------------------------------------------------------------------------
    | KIỂM TRA HẾT 5 PHÚT THANH TOÁN
    |--------------------------------------------------------------------------
    */

    public function isPaymentExpired(): bool
    {
        if (
            !$this->isWaitingForPayment()
            ||
            !$this->payment_expires_at
        ) {
            return false;
        }

        return now()->greaterThanOrEqualTo(
            $this->payment_expires_at
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SỐ GIÂY CÒN LẠI ĐỂ THANH TOÁN
    |--------------------------------------------------------------------------
    */

    public function paymentRemainingSeconds(): int
    {
        if (
            !$this->isWaitingForPayment()
            ||
            !$this->payment_expires_at
        ) {
            return 0;
        }

        return max(
            0,
            now()->diffInSeconds(
                $this->payment_expires_at,
                false
            )
        );
    }
}