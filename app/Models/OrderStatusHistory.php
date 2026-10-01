<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    use HasFactory;


    protected $fillable = [
        'order_id',
        'user_id',
        'status',
        'title',
        'note',
    ];


    // ==========================================
    // ĐƠN HÀNG
    // ==========================================
    public function order()
    {
        return $this->belongsTo(
            Order::class
        );
    }


    // ==========================================
    // NGƯỜI THAY ĐỔI
    // ==========================================
    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }
}