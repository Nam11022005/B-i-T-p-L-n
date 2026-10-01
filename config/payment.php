<?php

return [

    /*
    |--------------------------------------------------------------------------
    | BANK TRANSFER TIMEOUT
    |--------------------------------------------------------------------------
    |
    | Số phút khách hàng được phép chờ để thanh toán QR.
    |
    */

    'bank_timeout_minutes' => (int) env(
        'BANK_TRANSFER_TIMEOUT_MINUTES',
        5
    ),

];