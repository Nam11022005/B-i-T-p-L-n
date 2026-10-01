<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',

        'label',

        'receiver_name',

        'phone',

        'province',

        'district',

        'ward',

        'address_detail',

        'is_default',
    ];


    protected $casts = [
        'is_default' => 'boolean',
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
    | ĐỊA CHỈ ĐẦY ĐỦ
    |--------------------------------------------------------------------------
    */

    public function getFullAddressAttribute(): string
    {
        return collect([
            $this->address_detail,

            $this->ward,

            $this->district,

            $this->province,
        ])
            ->filter(
                function ($value) {

                    return filled(
                        $value
                    );

                }
            )
            ->implode(', ');
    }
}