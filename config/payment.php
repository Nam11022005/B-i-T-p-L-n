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

    'bank_code' => env('BANK_CODE', 'MB'),
    'bank_name' => env('BANK_NAME', 'MB BANK'),
    'bank_account_number' => env('BANK_ACCOUNT_NUMBER', '0385742505'),
    'bank_account_name' => env('BANK_ACCOUNT_NAME', 'DO PHUONG NAM'),
    'bank_account_display_name' => env('BANK_ACCOUNT_DISPLAY_NAME', 'ĐỖ PHƯƠNG NAM'),

];
