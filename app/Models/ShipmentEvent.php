<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentEvent extends Model
{
    protected $guarded = ['id'];

    public const STATUSES = [
        'preparing' => 'Đang chuẩn bị hàng',
        'handed_over' => 'Đã bàn giao vận chuyển',
        'in_transit' => 'Đang vận chuyển',
        'out_for_delivery' => 'Đang giao đến khách',
        'delivery_failed' => 'Giao chưa thành công',
        'returned' => 'Đã hoàn về shop',
    ];
}
