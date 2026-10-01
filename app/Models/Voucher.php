<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'min_order_value',
        'max_discount',
        'usage_limit',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_value' => 'decimal:2',
        'max_discount' => 'decimal:2',

        'usage_limit' => 'integer',
        'used_count' => 'integer',

        'starts_at' => 'datetime',
        'expires_at' => 'datetime',

        'is_active' => 'boolean',
    ];

    public function isAvailable(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if (
            $this->starts_at &&
            now()->lt($this->starts_at)
        ) {
            return false;
        }

        if (
            $this->expires_at &&
            now()->gt($this->expires_at)
        ) {
            return false;
        }

        if (
            $this->usage_limit !== null &&
            $this->used_count >= $this->usage_limit
        ) {
            return false;
        }

        return true;
    }
}