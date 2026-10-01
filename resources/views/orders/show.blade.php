@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng | Tinh Hoa Tây Bắc')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | TRẠNG THÁI ĐƠN HÀNG
    |--------------------------------------------------------------------------
    */

    $statusConfig = [
        'pending' => [
            'label' => 'Chờ xác nhận',
            'icon' => '⏳',
            'class' => 'pending',
            'step' => 1,
        ],

        'confirmed' => [
            'label' => 'Đã xác nhận',
            'icon' => '✓',
            'class' => 'confirmed',
            'step' => 2,
        ],

        'shipped' => [
            'label' => 'Đang giao hàng',
            'icon' => '🚚',
            'class' => 'shipped',
            'step' => 3,
        ],

        'delivered' => [
            'label' => 'Đã giao hàng',
            'icon' => '✅',
            'class' => 'delivered',
            'step' => 4,
        ],

        'cancelled' => [
            'label' => 'Đã hủy',
            'icon' => '✕',
            'class' => 'cancelled',
            'step' => 0,
        ],
    ];


    $currentStatus =
        $statusConfig[
            $order->status
        ]
        ??
        [
            'label' => 'Không xác định',
            'icon' => '📦',
            'class' => 'pending',
            'step' => 0,
        ];


    $statusStep =
        $currentStatus['step'];


    $progressWidth =
        match ($statusStep) {
            1 => '0%',
            2 => '33.33%',
            3 => '66.66%',
            4 => '100%',
            default => '0%',
        };


    /*
    |--------------------------------------------------------------------------
    | THANH TOÁN
    |--------------------------------------------------------------------------
    */

    $paymentStatusConfig = [
        'unpaid' => [
            'label' => 'Chưa thanh toán',
            'icon' => '○',
            'class' => 'unpaid',
        ],

        'pending_confirmation' => [
            'label' => 'Chờ xác nhận thanh toán',
            'icon' => '⏳',
            'class' => 'waiting',
        ],

        'paid' => [
            'label' => 'Đã thanh toán',
            'icon' => '✓',
            'class' => 'paid',
        ],

        'failed' => [
            'label' => 'Thanh toán lỗi',
            'icon' => '✕',
            'class' => 'failed',
        ],
    ];


    $paymentStatus =
        $paymentStatusConfig[
            $order->payment_status
        ]
        ??
        [
            'label' => 'Chưa xác định',
            'icon' => '○',
            'class' => 'unpaid',
        ];


    $paymentMethodLabel =
        match ($order->payment_method) {
            'cod' =>
                'Thanh toán khi nhận hàng',

            'bank' =>
                'Chuyển khoản ngân hàng',

            default =>
                strtoupper(
                    $order->payment_method
                    ??
                    'Không xác định'
                ),
        };


    /*
    |--------------------------------------------------------------------------
    | VẬN CHUYỂN
    |--------------------------------------------------------------------------
    */

    $shippingMethodLabel =
        match ($order->shipping_method) {
            'standard' =>
                'Giao hàng tiết kiệm',

            'fast' =>
                'Giao hàng nhanh',

            'express' =>
                'Giao hàng hỏa tốc',

            default =>
                $order->shipping_method
                ??
                'Chưa xác định',
        };


    /*
    |--------------------------------------------------------------------------
    | FORMAT SỐ LƯỢNG
    |--------------------------------------------------------------------------
    */

    $formatQuantity =
        function ($value) {

            return rtrim(
                rtrim(
                    number_format(
                        (float) $value,
                        2,
                        '.',
                        ''
                    ),
                    '0'
                ),
                '.'
            );

        };


    /*
    |--------------------------------------------------------------------------
    | ĐÁNH GIÁ CỦA KHÁCH
    |--------------------------------------------------------------------------
    |
    | Lấy 1 lần thay vì query từng sản phẩm.
    |
    */

    $myReviews =
        collect();


    if (
        $order->status === 'delivered'
        &&
        $order->items->isNotEmpty()
    ) {

        $myReviews =
            \App\Models\Review::query()

                ->where(
                    'user_id',
                    Auth::id()
                )

                ->whereIn(
                    'product_id',
                    $order
                        ->items
                        ->pluck(
                            'product_id'
                        )
                        ->filter()
                        ->unique()
                )

                ->get()

                ->keyBy(
                    'product_id'
                );

    }


    /*
    |--------------------------------------------------------------------------
    | THÔNG TIN QR BANK
    |--------------------------------------------------------------------------
    |
    | Giữ nguyên thông tin thanh toán hiện tại của project.
    |
    */

    $bankCode =
        'MB';


    $bankName =
        'MB BANK';


    $accountNumber =
        '0385742505';


    $accountNameQr =
        'DO PHUONG NAM';


    $accountNameDisplay =
        'ĐỖ PHƯƠNG NAM';


    $qrAmount =
        (int) round(
            (float)
            $order->total_price
        );


    $qrContent =
        $order->payment_code;


    $qrUrl =
        'https://img.vietqr.io/image/'
        .
        $bankCode
        .
        '-'
        .
        $accountNumber
        .
        '-compact2.png?amount='
        .
        $qrAmount
        .
        '&addInfo='
        .
        urlencode(
            $qrContent
            ??
            ''
        )
        .
        '&accountName='
        .
        urlencode(
            $accountNameQr
        );
@endphp


<style>
    /* =========================================================
       ORDER DETAIL - TINH HOA TAY BAC
    ========================================================= */

    .order-detail-page {
        --od-green: #35562f;
        --od-green-dark: #274522;

        --od-brown: #633820;
        --od-brown-dark: #3d2316;

        --od-red: #b43e2e;
        --od-red-dark: #8d3025;

        --od-gold: #e5ad42;
        --od-gold-soft: #fff0c9;

        --od-border: #e7dfd5;

        --od-text: #302923;
        --od-muted: #776d66;

        --od-shadow:
            0 8px 28px
            rgba(54, 40, 29, .07);

        --od-shadow-lg:
            0 18px 48px
            rgba(54, 40, 29, .12);

        color:
            var(--od-text);
    }


    .order-detail-page *,
    .order-detail-page *::before,
    .order-detail-page *::after {
        box-sizing: border-box;
    }


    .order-detail-page a {
        text-decoration: none;
    }


    /* =========================================================
       BREADCRUMB
    ========================================================= */

    .od-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 7px;

        margin-bottom: 14px;

        color: #958b84;

        font-size: 11px;
    }


    .od-breadcrumb a {
        color: #665349;

        font-weight: 800;
    }


    .od-breadcrumb a:hover {
        color:
            var(--od-red);
    }


    /* =========================================================
       HERO
    ========================================================= */

    .od-hero {
        position: relative;

        isolation: isolate;

        overflow: hidden;

        min-height: 185px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 28px;

        margin-bottom: 18px;

        padding:
            30px 34px;

        border-radius: 19px;

        color: #fff;

        background:
            radial-gradient(
                circle at 88% 15%,
                rgba(229,173,66,.25),
                transparent 27%
            ),
            linear-gradient(
                125deg,
                #284525 0%,
                #3f6338 47%,
                #673a23 100%
            );

        box-shadow:
            var(--od-shadow-lg);
    }


    .od-hero::before {
        content: "";

        position: absolute;

        z-index: -2;

        inset: 0;

        opacity: .06;

        background-image:
            repeating-linear-gradient(
                135deg,
                #fff 0,
                #fff 1px,
                transparent 1px,
                transparent 24px
            );
    }


    .od-hero::after {
        content: "";

        position: absolute;

        z-index: -1;

        right: -30px;
        bottom: -55px;

        width: 325px;
        height: 180px;

        opacity: .1;

        background: #fff;

        clip-path:
            polygon(
                0 100%,
                20% 54%,
                38% 72%,
                57% 24%,
                76% 61%,
                100% 14%,
                100% 100%
            );
    }


    .od-hero-copy {
        position: relative;

        z-index: 2;
    }


    .od-kicker {
        display: inline-flex;
        align-items: center;

        gap: 5px;

        padding:
            6px 10px;

        border:
            1px solid
            rgba(255,255,255,.16);

        border-radius: 999px;

        color: #ffda8b;

        background:
            rgba(255,255,255,.06);

        font-size: 10px;

        font-weight: 900;

        letter-spacing: .09em;

        text-transform: uppercase;
    }


    .od-title {
        margin:
            10px 0 0;

        color: #fff;

        font-size:
            clamp(
                29px,
                3vw,
                40px
            );

        line-height: 1.08;

        font-weight: 950;

        letter-spacing: -.045em;
    }


    .od-description {
        margin-top: 7px;

        color:
            rgba(255,255,255,.72);

        font-size: 12.5px;

        line-height: 1.65;
    }


    .od-hero-side {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: flex-end;
        flex-direction: column;

        gap: 9px;
    }


    .od-status {
        display: inline-flex;
        align-items: center;

        gap: 6px;

        padding:
            8px 12px;

        border:
            1px solid
            rgba(255,255,255,.2);

        border-radius: 999px;

        font-size: 10.5px;

        font-weight: 900;

        backdrop-filter:
            blur(8px);
    }


    .od-status.pending {
        color: #513c0e;

        background:
            #ffe79f;
    }


    .od-status.confirmed {
        color: #175c6d;

        background:
            #dff3f8;
    }


    .od-status.shipped {
        color: #1f588a;

        background:
            #e0efff;
    }


    .od-status.delivered {
        color: #315f2b;

        background:
            #e6f4e2;
    }


    .od-status.cancelled {
        color: #963a31;

        background:
            #fce6e3;
    }


    .od-back {
        min-height: 38px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0 12px;

        border:
            1px solid
            rgba(255,255,255,.24);

        border-radius: 9px;

        color: #fff;

        background:
            rgba(255,255,255,.07);

        font-size: 9.5px;

        font-weight: 850;
    }


    .od-back:hover {
        color: #fff;

        background:
            rgba(255,255,255,.14);
    }


    /* =========================================================
       PAYMENT QR
    ========================================================= */

    .od-payment-card {
        overflow: hidden;

        margin-bottom: 18px;

        border:
            1px solid #dec399;

        border-radius: 17px;

        background: #fff;

        box-shadow:
            var(--od-shadow-lg);
    }


    .od-payment-head {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        padding:
            14px 17px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--od-brown-dark),
                var(--od-brown)
            );
    }


    .od-payment-head strong {
        font-size: 13.5px;

        font-weight: 950;
    }


    .od-payment-head span {
        color:
            rgba(255,255,255,.7);

        font-size: 9.5px;
    }


    .od-payment-body {
        padding: 19px;
    }


    .od-payment-waiting {
        display: grid;

        grid-template-columns:
            330px
            minmax(0, 1fr);

        gap: 26px;

        align-items: center;
    }


    .od-qr-side {
        text-align: center;
    }


    .od-qr-box {
        display: inline-block;

        padding: 13px;

        border:
            1px solid #e5d4bb;

        border-radius: 16px;

        background: #fff;

        box-shadow:
            0 12px 28px
            rgba(54,40,29,.1);
    }


    .od-qr-box img {
        width: 280px;
        max-width: 100%;

        display: block;
    }


    .od-qr-help {
        margin-top: 8px;

        color:
            var(--od-muted);

        font-size: 9.5px;
    }


    .od-payment-alert {
        margin-bottom: 15px;

        padding:
            11px 13px;

        border:
            1px solid #e9d59b;

        border-radius: 10px;

        color: #6d5618;

        background: #fff8d9;

        font-size: 10.5px;

        line-height: 1.55;
    }


    .od-bank-grid {
        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap: 9px;
    }


    .od-bank-info {
        min-width: 0;

        padding:
            10px 11px;

        border:
            1px solid #ece3d8;

        border-radius: 10px;

        background:
            #fbfaf8;
    }


    .od-bank-info.full {
        grid-column:
            1 / -1;
    }


    .od-bank-label {
        color:
            #958981;

        font-size: 8.5px;
    }


    .od-bank-value {
        overflow-wrap: anywhere;

        margin-top: 2px;

        color: #41362e;

        font-size: 12px;

        font-weight: 950;
    }


    .od-bank-value.money {
        color:
            var(--od-red);

        font-size: 20px;
    }


    .od-payment-code-row {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            auto;

        gap: 6px;

        margin-top: 5px;
    }


    .od-payment-code {
        min-width: 0;
        height: 39px;

        padding:
            0 11px;

        border:
            1px dashed #d6b16b;

        border-radius: 8px;

        outline: 0;

        color:
            var(--od-red);

        background: #fff;

        font-size: 11px;

        font-weight: 950;

        letter-spacing: .04em;
    }


    .od-copy-btn {
        min-height: 39px;

        padding:
            0 11px;

        border:
            1px solid #d7c1a1;

        border-radius: 8px;

        color:
            var(--od-brown);

        background: #fff;

        font-size: 9px;

        font-weight: 900;
    }


    .od-copy-btn:hover {
        color: #fff;

        border-color:
            var(--od-brown);

        background:
            var(--od-brown);
    }


    .od-copy-feedback {
        min-height: 18px;

        margin-top: 4px;

        color:
            var(--od-green);

        font-size: 8.5px;

        font-weight: 850;
    }


    .od-payment-checking {
        margin-top: 10px;

        padding:
            9px 11px;

        border:
            1px solid #cbdccd;

        border-radius: 9px;

        color:
            var(--od-green-dark);

        background:
            #f1f7ef;

        font-size: 9.5px;

        line-height: 1.5;
    }


    .od-payment-success {
        padding:
            25px;

        border:
            1px solid #bcd5b7;

        border-radius: 13px;

        color:
            #315d2c;

        background:
            #edf7ea;

        text-align: center;
    }


    .od-payment-success-icon {
        font-size: 43px;
    }


    .od-payment-success h3 {
        margin:
            7px 0 3px;

        font-size: 19px;

        font-weight: 950;
    }


    .od-payment-success p {
        margin: 0;

        font-size: 10.5px;
    }
    /* =========================================================
   PAYMENT COUNTDOWN
========================================================= */

.od-payment-countdown {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 14px;

    margin-bottom: 15px;

    padding:
        13px 15px;

    border:
        1px solid
        #e7c978;

    border-radius:
        11px;

    background:
        linear-gradient(
            135deg,
            #fff8dc,
            #fff1c1
        );
}


.od-payment-countdown-left {
    min-width: 0;
}


.od-payment-countdown-label {
    color:
        #75623c;

    font-size:
        9px;

    font-weight:
        900;

    text-transform:
        uppercase;

    letter-spacing:
        .06em;
}


.od-payment-countdown-note {
    margin-top:
        3px;

    color:
        #7b6b58;

    font-size:
        9px;

    line-height:
        1.5;
}


.od-payment-timer {
    flex:
        0 0 auto;

    color:
        var(--od-red);

    font-size:
        28px;

    line-height:
        1;

    font-weight:
        950;

    font-variant-numeric:
        tabular-nums;

    letter-spacing:
        .02em;
}


.od-payment-timer.urgent {
    animation:
        odTimerPulse
        .8s
        infinite;
}


@keyframes odTimerPulse {

    0%,
    100% {
        opacity: 1;
    }

    50% {
        opacity: .5;
    }
}


/* =========================================================
   PAYMENT EXPIRED
========================================================= */

.od-payment-expired {
    padding:
        27px 22px;

    border:
        1px solid
        #e5b8b3;

    border-radius:
        13px;

    color:
        #8e342c;

    background:
        linear-gradient(
            145deg,
            #fff4f2,
            #fffafa
        );

    text-align:
        center;
}


.od-payment-expired-icon {
    margin-bottom:
        7px;

    font-size:
        42px;
}


.od-payment-expired h3 {
    margin:
        0 0 6px;

    color:
        #963a31;

    font-size:
        19px;

    font-weight:
        950;
}


.od-payment-expired p {
    max-width:
        600px;

    margin:
        0 auto;

    color:
        #7b5b57;

    font-size:
        10.5px;

    line-height:
        1.65;
}


@media (max-width: 575.98px) {

    .od-payment-countdown {
        align-items:
            flex-start;

        flex-direction:
            column;
    }


    .od-payment-timer {
        font-size:
            26px;
    }

}


    /* =========================================================
       TWO COLUMN LAYOUT
    ========================================================= */

    .od-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            350px;

        gap: 18px;

        align-items: start;
    }


    .od-main {
        min-width: 0;

        display: grid;

        gap: 15px;
    }


    .od-side {
        position: sticky;

        top: 177px;

        display: grid;

        gap: 13px;
    }


    /* =========================================================
       GENERIC CARD
    ========================================================= */

    .od-card {
        overflow: hidden;

        border:
            1px solid
            var(--od-border);

        border-radius: 15px;

        background: #fff;

        box-shadow:
            var(--od-shadow);
    }


    .od-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 12px;

        padding:
            14px 16px;

        border-bottom:
            1px solid
            var(--od-border);

        background:
            linear-gradient(
                180deg,
                #fff,
                #fffcf8
            );
    }


    .od-card-title {
        margin: 0;

        color: #463a32;

        font-size: 13.5px;

        font-weight: 950;
    }


    .od-card-subtitle {
        margin-top: 2px;

        color:
            var(--od-muted);

        font-size: 9.5px;
    }


    .od-card-body {
        padding:
            16px;
    }


    /* =========================================================
       CANCELLED
    ========================================================= */

    .od-cancelled {
        display: flex;
        align-items: flex-start;

        gap: 12px;

        padding:
            15px;

        border:
            1px solid #ebc3bd;

        border-radius: 12px;

        color: #8e3931;

        background:
            #fff1ef;
    }


    .od-cancelled-icon {
        font-size: 28px;
    }


    .od-cancelled strong {
        font-size: 12px;
    }


    .od-cancelled p {
        margin:
            4px 0 0;

        font-size: 10px;

        line-height: 1.5;
    }


    /* =========================================================
       TRACKING
    ========================================================= */

    .od-tracking {
        position: relative;

        display: grid;

        grid-template-columns:
            repeat(
                4,
                1fr
            );

        margin-top: 8px;
    }


    .od-track-line {
        position: absolute;

        z-index: 1;

        top: 22px;
        left: 12.5%;
        right: 12.5%;

        height: 4px;

        overflow: hidden;

        border-radius: 999px;

        background:
            #e8e3de;
    }


    .od-track-progress {
        height: 100%;

        border-radius: 999px;

        background:
            linear-gradient(
                90deg,
                var(--od-green),
                #72a561
            );

        transition:
            width .25s ease;
    }


    .od-track-step {
        position: relative;

        z-index: 2;

        text-align: center;
    }


    .od-track-circle {
        width: 46px;
        height: 46px;

        display: grid;
        place-items: center;

        margin: 0 auto;

        border:
            4px solid #fff;

        border-radius: 50%;

        color: #958d87;

        background:
            #e9e5e1;

        box-shadow:
            0 3px 10px
            rgba(49,38,30,.08);

        font-size: 17px;

        font-weight: 950;
    }


    .od-track-circle.done {
        color: #fff;

        background:
            var(--od-green);
    }


    .od-track-circle.current {
        color: #fff;

        background:
            var(--od-red);

        box-shadow:
            0 0 0 5px
            rgba(180,62,46,.09);
    }


    .od-track-label {
        margin-top: 7px;

        color:
            #92877e;

        font-size: 9px;

        line-height: 1.35;

        font-weight: 750;
    }


    .od-track-label.done {
        color:
            var(--od-green);

        font-weight: 900;
    }


    .od-track-label.current {
        color:
            var(--od-red);

        font-weight: 950;
    }


    /* =========================================================
       PRODUCTS
    ========================================================= */

    .od-products {
        display: grid;
    }


    .od-product {
        display: grid;

        grid-template-columns:
            78px
            minmax(0, 1fr)
            auto;

        align-items: center;

        gap: 12px;

        padding:
            13px 0;

        border-bottom:
            1px solid #eee7df;
    }


    .od-product:last-child {
        border-bottom: 0;
    }


    .od-product-image {
        width: 78px;
        height: 78px;

        overflow: hidden;

        border:
            1px solid #e9dfd4;

        border-radius: 11px;

        background:
            #faf8f5;
    }


    .od-product-image img {
        width: 100%;
        height: 100%;

        padding: 4px;

        object-fit: contain;
    }


    .od-product-fallback {
        width: 100%;
        height: 100%;

        display: grid;
        place-items: center;

        color: #9a8d82;

        font-size: 29px;
    }


    .od-product-info {
        min-width: 0;
    }


    .od-product-name {
        color: #38302a;

        font-size: 12px;

        line-height: 1.45;

        font-weight: 950;

        display: -webkit-box;

        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;

        overflow: hidden;
    }


    a.od-product-name:hover {
        color:
            var(--od-red);
    }


    .od-product-meta {
        margin-top: 4px;

        color:
            var(--od-muted);

        font-size: 9.5px;
    }


    .od-product-subtotal {
        color:
            var(--od-red);

        font-size: 13px;

        font-weight: 950;

        text-align: right;

        white-space: nowrap;
    }


    .od-product-unit-price {
        margin-top: 3px;

        color: #9a8e85;

        font-size: 8.5px;

        font-weight: 650;
    }


    .od-review-area {
        grid-column:
            1 / -1;

        margin-top: 2px;

        padding-top: 10px;

        border-top:
            1px dashed #e3d8cc;
    }


    .od-review-toggle {
        min-height: 32px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 4px;

        padding:
            0 9px;

        border:
            1px solid #dfc486;

        border-radius: 8px;

        color: #725114;

        background:
            #fff7db;

        font-size: 8.5px;

        font-weight: 900;
    }


    .od-review-toggle.reviewed {
        color: #396734;

        border-color: #bcd2b7;

        background:
            #edf6ea;
    }


    .od-review-box {
        margin-top: 9px;

        padding:
            13px;

        border:
            1px solid #e7d5b4;

        border-radius: 10px;

        background:
            #fffaf0;
    }


    .od-review-head {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 10px;

        margin-bottom: 10px;
    }


    .od-review-head strong {
        font-size: 11px;
    }


    .od-review-current {
        padding:
            4px 7px;

        border-radius: 999px;

        color:
            var(--od-green-dark);

        background:
            #e8f3e4;

        font-size: 8px;

        font-weight: 900;
    }


    .od-review-stars {
        display: flex;

        flex-direction: row-reverse;
        justify-content: flex-end;

        gap: 2px;

        margin-bottom: 10px;
    }


    .od-review-stars input {
        display: none;
    }


    .od-review-stars label {
        margin: 0;

        color: #d7d1cb;

        cursor: pointer;

        font-size: 28px;

        line-height: 1;

        transition:
            color .14s ease,
            transform .14s ease;
    }


    .od-review-stars label:hover,
    .od-review-stars label:hover ~ label,
    .od-review-stars input:checked ~ label {
        color: #eda519;
    }


    .od-review-stars label:hover {
        transform:
            scale(1.08);
    }


    .od-review-textarea {
        width: 100%;

        min-height: 88px;

        padding:
            9px 10px;

        border:
            1px solid #ddd1c4;

        border-radius: 8px;

        outline: 0;

        font-size: 10.5px;

        resize: vertical;
    }


    .od-review-textarea:focus {
        border-color:
            var(--od-gold);

        box-shadow:
            0 0 0 3px
            rgba(229,173,66,.1);
    }


    .od-review-submit {
        min-height: 34px;

        margin-top: 7px;

        padding:
            0 11px;

        border: 0;

        border-radius: 8px;

        color: #fff;

        background:
            var(--od-green);

        font-size: 9px;

        font-weight: 900;
    }


    .od-review-submit:hover {
        background:
            var(--od-green-dark);
    }


    /* =========================================================
       HISTORY
    ========================================================= */

    .od-history {
        position: relative;

        display: grid;

        gap: 0;
    }


    .od-history-item {
        position: relative;

        display: grid;

        grid-template-columns:
            34px
            minmax(0, 1fr);

        gap: 10px;

        padding-bottom: 17px;
    }


    .od-history-item:last-child {
        padding-bottom: 0;
    }


    .od-history-icon-wrap {
        position: relative;

        display: flex;
        justify-content: center;
    }


    .od-history-icon-wrap::after {
        content: "";

        position: absolute;

        top: 32px;
        bottom: -1px;

        width: 2px;

        background:
            #e7dfd5;
    }


    .od-history-item:last-child
    .od-history-icon-wrap::after {
        display: none;
    }


    .od-history-icon {
        position: relative;

        z-index: 2;

        width: 30px;
        height: 30px;

        display: grid;
        place-items: center;

        border:
            1px solid #dcc8aa;

        border-radius: 50%;

        background:
            #fff7e8;

        font-size: 12px;
    }


    .od-history-title {
        color: #473b33;

        font-size: 10.5px;

        font-weight: 950;
    }


    .od-history-note {
        margin-top: 2px;

        color:
            var(--od-muted);

        font-size: 9px;

        line-height: 1.5;
    }


    .od-history-time {
        margin-top: 4px;

        color: #9e938b;

        font-size: 8px;
    }


    /* =========================================================
       SUMMARY
    ========================================================= */

    .od-summary-head {
        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--od-brown-dark),
                var(--od-brown)
            );
    }


    .od-summary-head
    .od-card-title {
        color: #fff;
    }


    .od-summary-head
    .od-card-subtitle {
        color:
            rgba(255,255,255,.67);
    }


    .od-summary-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 12px;

        margin-bottom: 10px;

        color:
            var(--od-muted);

        font-size: 10.5px;
    }


    .od-summary-row strong {
        color: #4a3e36;

        font-size: 11px;

        text-align: right;
    }


    .od-summary-discount strong {
        color:
            var(--od-green);
    }


    .od-summary-divider {
        height: 1px;

        margin:
            14px 0;

        background:
            #eae1d7;
    }


    .od-summary-total {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 10px;
    }


    .od-summary-total-label {
        color: #40352e;

        font-size: 12px;

        font-weight: 950;
    }


    .od-summary-total-price {
        color:
            var(--od-red);

        font-size: 22px;

        line-height: 1;

        font-weight: 950;

        letter-spacing: -.035em;

        text-align: right;
    }


    .od-payment-status {
        display: flex;
        align-items: center;
        justify-content: center;

        gap: 5px;

        min-height: 36px;

        margin-top: 13px;

        padding:
            6px 9px;

        border-radius: 8px;

        font-size: 9px;

        font-weight: 900;

        text-align: center;
    }


    .od-payment-status.unpaid {
        color: #98463c;

        background:
            #fbeae7;
    }


    .od-payment-status.waiting {
        color: #765815;

        background:
            #fff1c4;
    }


    .od-payment-status.paid {
        color:
            var(--od-green-dark);

        background:
            #eaf5e7;
    }


    .od-payment-status.failed {
        color: #9a3932;

        background:
            #f9e1df;
    }


    /* =========================================================
       INFORMATION
    ========================================================= */

    .od-info-list {
        display: grid;

        gap: 11px;
    }


    .od-info-item {
        display: grid;

        grid-template-columns:
            31px
            minmax(0, 1fr);

        gap: 9px;
    }


    .od-info-icon {
        width: 31px;
        height: 31px;

        display: grid;
        place-items: center;

        border-radius: 8px;

        background:
            #fff1d5;

        font-size: 14px;
    }


    .od-info-label {
        color: #978b83;

        font-size: 8.5px;
    }


    .od-info-value {
        margin-top: 1px;

        color: #4b4038;

        font-size: 10px;

        line-height: 1.5;

        font-weight: 850;

        overflow-wrap: anywhere;
    }


    .od-notes {
        margin-top: 13px;

        padding:
            10px;

        border:
            1px solid #ead9bd;

        border-radius: 9px;

        color: #69543d;

        background:
            #fff9e8;

        font-size: 9.5px;

        line-height: 1.55;
    }


    .od-continue {
        min-height: 42px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-top: 12px;

        border-radius: 9px;

        color: #fff;

        background:
            var(--od-green);

        font-size: 10px;

        font-weight: 900;
    }


    .od-continue:hover {
        color: #fff;

        background:
            var(--od-green-dark);
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1199.98px) {

        .od-layout {
            grid-template-columns:
                minmax(0, 1fr)
                315px;
        }


        .od-payment-waiting {
            grid-template-columns:
                280px
                minmax(0, 1fr);
        }

    }


    @media (max-width: 991.98px) {

        .od-layout {
            grid-template-columns: 1fr;
        }


        .od-side {
            position: static;
        }


        .od-payment-waiting {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 767.98px) {

        .od-hero {
            align-items: flex-start;

            flex-direction: column;

            padding:
                25px 22px;
        }


        .od-hero-side {
            align-items: flex-start;
        }


        .od-tracking {
            grid-template-columns: 1fr;

            gap: 10px;

            margin-top: 0;
        }


        .od-track-line {
            display: none;
        }


        .od-track-step {
            display: grid;

            grid-template-columns:
                44px
                minmax(0, 1fr);

            align-items: center;

            gap: 8px;

            text-align: left;
        }


        .od-track-circle {
            width: 40px;
            height: 40px;

            margin: 0;

            border-width: 3px;
        }


        .od-track-label {
            margin-top: 0;
        }

    }


    @media (max-width: 575.98px) {

        .od-payment-body,
        .od-card-body {
            padding: 13px;
        }


        .od-bank-grid {
            grid-template-columns: 1fr;
        }


        .od-bank-info.full {
            grid-column: auto;
        }


        .od-payment-code-row {
            grid-template-columns: 1fr;
        }


        .od-product {
            grid-template-columns:
                62px
                minmax(0, 1fr);
        }


        .od-product-image {
            width: 62px;
            height: 62px;
        }


        .od-product-subtotal {
            grid-column: 2;

            justify-self: start;

            text-align: left;
        }


        .od-summary-total-price {
            font-size: 19px;
        }

    }
</style>


<div class="order-detail-page">


    {{-- =====================================================
        BREADCRUMB
    ====================================================== --}}
    <div class="od-breadcrumb">

        <a href="{{ url('/') }}">
            Trang chủ
        </a>

        <span>›</span>

        <a href="{{ route('orders.index') }}">
            Đơn hàng của tôi
        </a>

        <span>›</span>

        <span>

            #{{
                str_pad(
                    $order->id,
                    6,
                    '0',
                    STR_PAD_LEFT
                )
            }}

        </span>

    </div>


    {{-- =====================================================
        HERO
    ====================================================== --}}
    <section class="od-hero">


        <div class="od-hero-copy">

            <div class="od-kicker">
                🌿 Tinh Hoa Tây Bắc
            </div>


            <h1 class="od-title">

                Đơn hàng
                #{{
                    str_pad(
                        $order->id,
                        6,
                        '0',
                        STR_PAD_LEFT
                    )
                }}

            </h1>


            <div class="od-description">

                Đặt lúc

                <strong>

                    {{
                        $order
                            ->created_at
                            ->format(
                                'H:i · d/m/Y'
                            )
                    }}

                </strong>

                · Theo dõi vận chuyển,
                thanh toán và sản phẩm
                trong đơn hàng.

            </div>

        </div>


        <div class="od-hero-side">

            <span
                class="
                    od-status
                    {{ $currentStatus['class'] }}
                "
            >

                {{ $currentStatus['icon'] }}

                {{ $currentStatus['label'] }}

            </span>


            <a
                href="{{ route('orders.index') }}"
                class="od-back"
            >
                ← Quay lại đơn hàng
            </a>

        </div>

    </section>


    {{-- =====================================================
    BANK PAYMENT
====================================================== --}}

@if($order->payment_method === 'bank')

    <section
        class="od-payment-card"
        id="autoPaymentCard"

        data-payment-status-url="{{
            route(
                'orders.paymentStatus',
                $order
            )
        }}"

        data-payment-expires-at="{{
            $order->payment_expires_at
                ? $order
                    ->payment_expires_at
                    ->toIso8601String()
                : ''
        }}"
    >


        {{-- =================================================
            HEADER
        ================================================== --}}

        <div class="od-payment-head">

            <div>

                <strong>
                    💳 Thanh toán QR tự động
                </strong>

                <span>
                    · SePay xác nhận giao dịch
                </span>

            </div>


            <div>

                Mã đơn
                #{{
                    str_pad(
                        $order->id,
                        6,
                        '0',
                        STR_PAD_LEFT
                    )
                }}

            </div>

        </div>


        <div class="od-payment-body">


            {{-- =================================================
                ĐÃ THANH TOÁN
            ================================================== --}}

            @if($order->payment_status === 'paid')

                <div
                    class="od-payment-success"
                    id="paymentSuccessBox"
                >

                    <div class="od-payment-success-icon">
                        ✅
                    </div>


                    <h3>
                        Thanh toán thành công
                    </h3>


                    <p>

                        Hệ thống đã ghi nhận
                        thanh toán cho đơn hàng
                        #{{
                            str_pad(
                                $order->id,
                                6,
                                '0',
                                STR_PAD_LEFT
                            )
                        }}.

                    </p>

                </div>


            {{-- =================================================
                ĐÃ HẾT HẠN / BỊ HỦY
            ================================================== --}}

            @elseif($order->status === 'cancelled')

                <div
                    class="od-payment-expired"
                    id="paymentExpiredBox"
                >

                    <div class="od-payment-expired-icon">
                        ⏰
                    </div>


                    <h3>
                        Đã hết thời gian thanh toán
                    </h3>


                    <p>

                        Đơn hàng đã bị hủy vì
                        không nhận được thanh toán
                        chuyển khoản trong vòng
                        5 phút.

                        Số lượng sản phẩm đã được
                        hoàn lại vào kho.

                    </p>

                </div>


            {{-- =================================================
                ĐANG CHỜ THANH TOÁN
            ================================================== --}}

            @else

                <div id="paymentWaitingBox">


                    {{-- =========================================
                        COUNTDOWN
                    ========================================== --}}

                    <div class="od-payment-countdown">

                        <div class="od-payment-countdown-left">

                            <div class="od-payment-countdown-label">
                                Thời gian thanh toán còn lại
                            </div>


                            <div class="od-payment-countdown-note">

                                Đơn hàng sẽ tự động bị hủy
                                nếu chưa nhận được thanh toán
                                khi đồng hồ về 00:00.

                            </div>

                        </div>


                        <div
                            class="od-payment-timer"
                            id="paymentCountdownTimer"
                        >
                            05:00
                        </div>

                    </div>


                    {{-- =========================================
                        ALERT
                    ========================================== --}}

                    <div class="od-payment-alert">

                        ⏳ Đơn hàng đang chờ thanh toán.

                        Hãy chuyển

                        <strong>
                            đúng số tiền
                        </strong>

                        và giữ nguyên

                        <strong>
                            nội dung chuyển khoản
                        </strong>

                        để hệ thống nhận diện
                        giao dịch tự động.

                    </div>


                    <div class="od-payment-waiting">


                        {{-- =====================================
                            QR
                        ====================================== --}}

                        <div class="od-qr-side">

                            <div class="od-qr-box">

                                <img
                                    src="{{ $qrUrl }}"
                                    alt="QR thanh toán đơn hàng"
                                >

                            </div>


                            <div class="od-qr-help">

                                Mở ứng dụng ngân hàng
                                và quét mã QR

                            </div>

                        </div>


                        {{-- =====================================
                            BANK INFO
                        ====================================== --}}

                        <div>

                            <div class="od-bank-grid">


                                <div class="od-bank-info">

                                    <div class="od-bank-label">
                                        Ngân hàng
                                    </div>

                                    <div class="od-bank-value">
                                        {{ $bankName }}
                                    </div>

                                </div>


                                <div class="od-bank-info">

                                    <div class="od-bank-label">
                                        Chủ tài khoản
                                    </div>

                                    <div class="od-bank-value">
                                        {{ $accountNameDisplay }}
                                    </div>

                                </div>


                                <div class="od-bank-info full">

                                    <div class="od-bank-label">
                                        Số tài khoản
                                    </div>

                                    <div class="od-bank-value">
                                        {{ $accountNumber }}
                                    </div>

                                </div>


                                <div class="od-bank-info full">

                                    <div class="od-bank-label">
                                        Số tiền cần chuyển
                                    </div>


                                    <div
                                        class="
                                            od-bank-value
                                            money
                                        "
                                    >

                                        {{
                                            number_format(
                                                (float)
                                                    $order
                                                        ->total_price,
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }}đ

                                    </div>

                                </div>


                                <div class="od-bank-info full">

                                    <div class="od-bank-label">
                                        Nội dung chuyển khoản
                                    </div>


                                    <div class="od-payment-code-row">

                                        <input
                                            type="text"
                                            id="orderPaymentCode"
                                            class="od-payment-code"
                                            value="{{
                                                $order
                                                    ->payment_code
                                            }}"
                                            readonly
                                        >


                                        <button
                                            type="button"
                                            class="od-copy-btn"
                                            id="copyPaymentButton"
                                        >
                                            📋 Sao chép
                                        </button>

                                    </div>


                                    <div
                                        class="od-copy-feedback"
                                        id="copyPaymentFeedback"
                                    >
                                    </div>

                                </div>

                            </div>


                            <div class="od-payment-checking">

                                🔄 Hệ thống đang tự động
                                kiểm tra thanh toán
                                mỗi 3 giây.

                                Khi SePay nhận được
                                giao dịch hợp lệ,
                                trạng thái sẽ tự động
                                chuyển sang
                                thanh toán thành công.

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =============================================
                    SUCCESS BOX - JS SẼ HIỆN
                ============================================== --}}

                <div
                    class="
                        od-payment-success
                        d-none
                    "
                    id="paymentSuccessBox"
                >

                    <div class="od-payment-success-icon">
                        ✅
                    </div>


                    <h3>
                        Thanh toán thành công
                    </h3>


                    <p>

                        Hệ thống đã nhận được tiền
                        và xác nhận thanh toán
                        cho đơn hàng này.

                    </p>

                </div>


                {{-- =============================================
                    EXPIRED BOX - JS SẼ HIỆN
                ============================================== --}}

                <div
                    class="
                        od-payment-expired
                        d-none
                    "
                    id="paymentExpiredBox"
                >

                    <div class="od-payment-expired-icon">
                        ⏰
                    </div>


                    <h3>
                        Đã hết thời gian thanh toán
                    </h3>


                    <p>

                        Đã quá 5 phút
                        nhưng hệ thống chưa nhận được
                        thanh toán hợp lệ.

                        Đơn hàng đã tự động bị hủy
                        và tồn kho được hoàn lại.

                    </p>

                </div>

            @endif

        </div>

    </section>

@endif


    {{-- =====================================================
        MAIN LAYOUT
    ====================================================== --}}
    <div class="od-layout">


        {{-- =================================================
            LEFT
        ================================================== --}}
        <div class="od-main">


            {{-- =============================================
                TRACKING
            ============================================== --}}
            <section class="od-card">


                <div class="od-card-head">

                    <div>

                        <h2 class="od-card-title">
                            🚚 Theo dõi đơn hàng
                        </h2>

                        <div class="od-card-subtitle">
                            Trạng thái được cập nhật bởi cửa hàng.
                        </div>

                    </div>

                </div>


                <div class="od-card-body">


                    @if($order->status === 'cancelled')

                        <div class="od-cancelled">

                            <div class="od-cancelled-icon">
                                ❌
                            </div>


                            <div>

                                <strong>
                                    Đơn hàng đã bị hủy
                                </strong>


                                <p>

                                    Đơn hàng này hiện
                                    không còn trong quá trình
                                    xử lý và vận chuyển.

                                </p>

                            </div>

                        </div>


                    @else

                        <div class="od-tracking">


                            <div class="od-track-line">

                                <div
                                    class="od-track-progress"
                                    style="
                                        width:
                                        {{ $progressWidth }};
                                    "
                                >
                                </div>

                            </div>


                            {{-- PENDING --}}
                            <div class="od-track-step">

                                <div
                                    class="
                                        od-track-circle
                                        {{
                                            $statusStep > 1
                                            ? 'done'
                                            : ''
                                        }}
                                        {{
                                            $statusStep === 1
                                            ? 'current'
                                            : ''
                                        }}
                                    "
                                >
                                    🛒
                                </div>


                                <div
                                    class="
                                        od-track-label
                                        {{
                                            $statusStep > 1
                                            ? 'done'
                                            : ''
                                        }}
                                        {{
                                            $statusStep === 1
                                            ? 'current'
                                            : ''
                                        }}
                                    "
                                >
                                    Chờ xác nhận
                                </div>

                            </div>


                            {{-- CONFIRMED --}}
                            <div class="od-track-step">

                                <div
                                    class="
                                        od-track-circle
                                        {{
                                            $statusStep > 2
                                            ? 'done'
                                            : ''
                                        }}
                                        {{
                                            $statusStep === 2
                                            ? 'current'
                                            : ''
                                        }}
                                    "
                                >
                                    ✓
                                </div>


                                <div
                                    class="
                                        od-track-label
                                        {{
                                            $statusStep > 2
                                            ? 'done'
                                            : ''
                                        }}
                                        {{
                                            $statusStep === 2
                                            ? 'current'
                                            : ''
                                        }}
                                    "
                                >
                                    Đã xác nhận
                                </div>

                            </div>


                            {{-- SHIPPED --}}
                            <div class="od-track-step">

                                <div
                                    class="
                                        od-track-circle
                                        {{
                                            $statusStep > 3
                                            ? 'done'
                                            : ''
                                        }}
                                        {{
                                            $statusStep === 3
                                            ? 'current'
                                            : ''
                                        }}
                                    "
                                >
                                    🚚
                                </div>


                                <div
                                    class="
                                        od-track-label
                                        {{
                                            $statusStep > 3
                                            ? 'done'
                                            : ''
                                        }}
                                        {{
                                            $statusStep === 3
                                            ? 'current'
                                            : ''
                                        }}
                                    "
                                >
                                    Đang giao
                                </div>

                            </div>


                            {{-- DELIVERED --}}
                            <div class="od-track-step">

                                <div
                                    class="
                                        od-track-circle
                                        {{
                                            $statusStep >= 4
                                            ? 'done'
                                            : ''
                                        }}
                                    "
                                >
                                    ✅
                                </div>


                                <div
                                    class="
                                        od-track-label
                                        {{
                                            $statusStep >= 4
                                            ? 'done'
                                            : ''
                                        }}
                                    "
                                >
                                    Đã giao
                                </div>

                            </div>

                        </div>

                    @endif

                </div>

            </section>


            {{-- =============================================
                PRODUCTS
            ============================================== --}}
            <section class="od-card">


                <div class="od-card-head">

                    <div>

                        <h2 class="od-card-title">
                            📦 Sản phẩm trong đơn
                        </h2>

                        <div class="od-card-subtitle">

                            {{
                                $order
                                    ->items
                                    ->count()
                            }}
                            dòng sản phẩm

                        </div>

                    </div>

                </div>


                <div class="od-card-body">

                    <div class="od-products">


                        @forelse($order->items as $item)

                            @php
                                $product =
                                    $item->product;


                                $productImage =
                                    null;


                                if (
                                    $product
                                    &&
                                    $product->image
                                ) {

                                    $productImage =
                                        str_starts_with(
                                            $product->image,
                                            'http'
                                        )

                                        ? $product->image

                                        : asset(
                                            'storage/'
                                            .
                                            ltrim(
                                                $product->image,
                                                '/'
                                            )
                                        );

                                }


                                $unit =
                                    $product?->unit
                                    ??
                                    'sản phẩm';


                                $quantity =
                                    (float)
                                    $item->quantity;


                                $itemPrice =
                                    (float)
                                    $item->price;


                                $itemSubtotal =
                                    $itemPrice
                                    *
                                    $quantity;


                                $myReview =
                                    $myReviews->get(
                                        $item->product_id
                                    );


                                $reviewCollapseId =
                                    'order-review-'
                                    .
                                    $item->id;
                            @endphp


                            <article class="od-product">


                                {{-- IMAGE --}}
                                <div class="od-product-image">

                                    @if($productImage)

                                        <img
                                            src="{{ $productImage }}"
                                            alt="{{
                                                $product?->name
                                                ??
                                                'Sản phẩm'
                                            }}"
                                            loading="lazy"
                                            onerror="
                                                this.style.display='none';
                                                this.nextElementSibling.style.display='grid';
                                            "
                                        >


                                        <div
                                            class="od-product-fallback"
                                            style="display:none;"
                                        >
                                            🧺
                                        </div>

                                    @else

                                        <div class="od-product-fallback">
                                            🧺
                                        </div>

                                    @endif

                                </div>


                                {{-- INFO --}}
                                <div class="od-product-info">


                                    @if($product)

                                        <a
                                            href="{{
                                                route(
                                                    'products.show',
                                                    $product
                                                )
                                            }}"
                                            class="od-product-name"
                                        >
                                            {{ $product->name }}
                                        </a>

                                    @else

                                        <div class="od-product-name">
                                            Sản phẩm không còn tồn tại
                                        </div>

                                    @endif


                                    <div class="od-product-meta">

                                        Số lượng:

                                        <strong>

                                            {{
                                                $formatQuantity(
                                                    $quantity
                                                )
                                            }}

                                            {{ $unit }}

                                        </strong>

                                    </div>


                                    <div class="od-product-unit-price">

                                        Đơn giá:

                                        {{
                                            number_format(
                                                $itemPrice,
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }}đ

                                        / {{ $unit }}

                                    </div>

                                </div>


                                {{-- SUBTOTAL --}}
                                <div class="od-product-subtotal">

                                    {{
                                        number_format(
                                            $itemSubtotal,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}đ

                                </div>


                                {{-- REVIEW --}}
                                @if($order->status === 'delivered' && $product)

                                    <div class="od-review-area">


                                        <button
                                            type="button"
                                            class="
                                                od-review-toggle
                                                {{
                                                    $myReview
                                                    ? 'reviewed'
                                                    : ''
                                                }}
                                            "
                                            data-bs-toggle="collapse"
                                            data-bs-target="#{{
                                                $reviewCollapseId
                                            }}"
                                            aria-expanded="false"
                                        >

                                            @if($myReview)

                                                ⭐ Đã đánh giá
                                                {{ $myReview->rating }}/5

                                            @else

                                                ⭐ Đánh giá sản phẩm

                                            @endif

                                        </button>


                                        <div
                                            class="collapse"
                                            id="{{ $reviewCollapseId }}"
                                        >

                                            <div class="od-review-box">


                                                <div class="od-review-head">

                                                    <strong>

                                                        {{
                                                            $myReview
                                                            ? 'Chỉnh sửa đánh giá'
                                                            : 'Đánh giá sản phẩm'
                                                        }}

                                                    </strong>


                                                    @if($myReview)

                                                        <span class="od-review-current">

                                                            {{
                                                                $myReview->rating
                                                            }}/5 sao

                                                        </span>

                                                    @endif

                                                </div>


                                                <form
                                                    action="{{
                                                        route(
                                                            'reviews.store',
                                                            $item->product_id
                                                        )
                                                    }}"
                                                    method="POST"
                                                >

                                                    @csrf


                                                    <div class="od-review-stars">


                                                        @for($star = 5; $star >= 1; $star--)

                                                            <input
                                                                type="radio"
                                                                id="item{{
                                                                    $item->id
                                                                }}Star{{
                                                                    $star
                                                                }}"
                                                                name="rating"
                                                                value="{{
                                                                    $star
                                                                }}"
                                                                {{
                                                                    (int)
                                                                    old(
                                                                        'rating',
                                                                        $myReview
                                                                            ?->rating
                                                                        ??
                                                                        0
                                                                    )
                                                                    ===
                                                                    $star
                                                                    ? 'checked'
                                                                    : ''
                                                                }}
                                                                required
                                                            >


                                                            <label
                                                                for="item{{
                                                                    $item->id
                                                                }}Star{{
                                                                    $star
                                                                }}"
                                                                title="{{
                                                                    $star
                                                                }} sao"
                                                            >
                                                                ★
                                                            </label>

                                                        @endfor

                                                    </div>


                                                    <textarea
                                                        name="comment"
                                                        class="od-review-textarea"
                                                        maxlength="1000"
                                                        placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..."
                                                    >{{ old(
                                                        'comment',
                                                        $myReview
                                                            ?->comment
                                                    ) }}</textarea>


                                                    <button
                                                        type="submit"
                                                        class="od-review-submit"
                                                    >

                                                        @if($myReview)

                                                            ⭐ Cập nhật đánh giá

                                                        @else

                                                            ⭐ Gửi đánh giá

                                                        @endif

                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                @endif

                            </article>


                        @empty

                            <div
                                class="
                                    text-center
                                    text-muted
                                    py-5
                                "
                            >

                                📦

                                <div class="mt-2">
                                    Không có sản phẩm trong đơn hàng.
                                </div>

                            </div>

                        @endforelse

                    </div>

                </div>

            </section>


            {{-- =============================================
                ORDER HISTORY
            ============================================== --}}
            <section class="od-card">


                <div class="od-card-head">

                    <div>

                        <h2 class="od-card-title">
                            🕐 Lịch sử đơn hàng
                        </h2>

                        <div class="od-card-subtitle">
                            Các mốc cập nhật của đơn hàng.
                        </div>

                    </div>

                </div>


                <div class="od-card-body">


                    <div class="od-history">


                        @forelse($order->statusHistories as $history)

                            @php
                                $historyConfig =
                                    $statusConfig[
                                        $history->status
                                    ]
                                    ??
                                    [
                                        'icon'
                                            =>
                                            '📦',
                                    ];
                            @endphp


                            <div class="od-history-item">


                                <div class="od-history-icon-wrap">

                                    <div class="od-history-icon">

                                        {{
                                            $historyConfig['icon']
                                        }}

                                    </div>

                                </div>


                                <div>

                                    <div class="od-history-title">

                                        {{
                                            $history->title
                                            ??
                                            'Trạng thái đơn hàng thay đổi'
                                        }}

                                    </div>


                                    @if($history->note)

                                        <div class="od-history-note">

                                            {{ $history->note }}

                                        </div>

                                    @endif


                                    <div class="od-history-time">

                                        {{
                                            $history
                                                ->created_at
                                                ->format(
                                                    'H:i · d/m/Y'
                                                )
                                        }}


                                        @if($history->user)

                                            · cập nhật bởi

                                            {{
                                                $history
                                                    ->user
                                                    ->name
                                            }}

                                        @endif

                                    </div>

                                </div>

                            </div>


                        @empty

                            <div
                                class="
                                    text-center
                                    text-muted
                                    py-3
                                "
                                style="font-size:10px;"
                            >

                                Chưa có lịch sử cập nhật.

                            </div>

                        @endforelse

                    </div>

                </div>

            </section>

        </div>


        {{-- =================================================
            RIGHT
        ================================================== --}}
        <aside class="od-side">


            {{-- =============================================
                SUMMARY
            ============================================== --}}
            <section class="od-card">


                <div
                    class="
                        od-card-head
                        od-summary-head
                    "
                >

                    <div>

                        <h2 class="od-card-title">
                            🧾 Tổng đơn hàng
                        </h2>

                        <div class="od-card-subtitle">

                            #{{
                                str_pad(
                                    $order->id,
                                    6,
                                    '0',
                                    STR_PAD_LEFT
                                )
                            }}

                        </div>

                    </div>

                </div>


                <div class="od-card-body">


                    <div class="od-summary-row">

                        <span>
                            Tiền sản phẩm
                        </span>

                        <strong>

                            {{
                                number_format(
                                    (float)
                                    (
                                        $order->subtotal
                                        ??
                                        0
                                    ),
                                    0,
                                    ',',
                                    '.'
                                )
                            }}đ

                        </strong>

                    </div>


                    <div class="od-summary-row">

                        <span>
                            Phí vận chuyển
                        </span>

                        <strong>

                            {{
                                number_format(
                                    (float)
                                    (
                                        $order->shipping_fee
                                        ??
                                        0
                                    ),
                                    0,
                                    ',',
                                    '.'
                                )
                            }}đ

                        </strong>

                    </div>


                    <div
                        class="
                            od-summary-row
                            od-summary-discount
                        "
                    >

                        <span>
                            Giảm giá
                        </span>

                        <strong>

                            -{{
                                number_format(
                                    (float)
                                    (
                                        $order->discount
                                        ??
                                        0
                                    ),
                                    0,
                                    ',',
                                    '.'
                                )
                            }}đ

                        </strong>

                    </div>


                    @if($order->voucher_code)

                        <div class="od-summary-row">

                            <span>
                                Voucher
                            </span>

                            <strong>
                                🎟 {{ $order->voucher_code }}
                            </strong>

                        </div>

                    @endif


                    <div class="od-summary-divider">
                    </div>


                    <div class="od-summary-total">

                        <div class="od-summary-total-label">
                            Tổng thanh toán
                        </div>


                        <div class="od-summary-total-price">

                            {{
                                number_format(
                                    (float)
                                    $order->total_price,
                                    0,
                                    ',',
                                    '.'
                                )
                            }}đ

                        </div>

                    </div>


                    <div
                        id="paymentStatusBadge"
                        class="
                            od-payment-status
                            {{ $paymentStatus['class'] }}
                        "
                    >

                        {{ $paymentStatus['icon'] }}

                        <span id="paymentStatusText">
                            {{ $paymentStatus['label'] }}
                        </span>

                    </div>


                    <a
                        href="{{ route('products.index') }}"
                        class="od-continue"
                    >
                        🌿 Tiếp tục mua sắm →
                    </a>

                </div>

            </section>


            {{-- =============================================
                SHIPPING INFO
            ============================================== --}}
            <section class="od-card">


                <div class="od-card-head">

                    <div>

                        <h2 class="od-card-title">
                            📍 Thông tin nhận hàng
                        </h2>

                    </div>

                </div>


                <div class="od-card-body">

                    <div class="od-info-list">


                        <div class="od-info-item">

                            <div class="od-info-icon">
                                👤
                            </div>


                            <div>

                                <div class="od-info-label">
                                    Người nhận
                                </div>

                                <div class="od-info-value">

                                    {{
                                        $order->customer_name
                                        ??
                                        'Chưa cập nhật'
                                    }}

                                </div>

                            </div>

                        </div>


                        <div class="od-info-item">

                            <div class="od-info-icon">
                                ☎
                            </div>


                            <div>

                                <div class="od-info-label">
                                    Số điện thoại
                                </div>

                                <div class="od-info-value">

                                    {{
                                        $order->customer_phone
                                        ??
                                        'Chưa cập nhật'
                                    }}

                                </div>

                            </div>

                        </div>


                        <div class="od-info-item">

                            <div class="od-info-icon">
                                🏠
                            </div>


                            <div>

                                <div class="od-info-label">
                                    Địa chỉ giao hàng
                                </div>

                                <div class="od-info-value">

                                    {{
                                        $order->shipping_address
                                        ??
                                        'Chưa cập nhật'
                                    }}

                                </div>

                            </div>

                        </div>


                        <div class="od-info-item">

                            <div class="od-info-icon">
                                🚚
                            </div>


                            <div>

                                <div class="od-info-label">
                                    Vận chuyển
                                </div>

                                <div class="od-info-value">
                                    {{ $shippingMethodLabel }}
                                </div>

                            </div>

                        </div>


                        <div class="od-info-item">

                            <div class="od-info-icon">
                                💳
                            </div>


                            <div>

                                <div class="od-info-label">
                                    Thanh toán
                                </div>

                                <div class="od-info-value">
                                    {{ $paymentMethodLabel }}
                                </div>

                            </div>

                        </div>

                    </div>


                    @if($order->notes)

                        <div class="od-notes">

                            <strong>
                                📝 Ghi chú:
                            </strong>

                            <br>

                            {{ $order->notes }}

                        </div>

                    @endif

                </div>

            </section>


            {{-- =============================================
                SUPPORT
            ============================================== --}}
            <section class="od-card">


                <div class="od-card-body">

                    <div
                        style="
                            color:#473a32;
                            font-size:11px;
                            font-weight:950;
                        "
                    >
                        Cần hỗ trợ đơn hàng?
                    </div>


                    <div
                        style="
                            margin-top:4px;
                            color:#786d65;
                            font-size:9.5px;
                            line-height:1.55;
                        "
                    >

                        Liên hệ shop nếu bạn cần
                        hỗ trợ về vận chuyển,
                        thanh toán hoặc sản phẩm.

                    </div>


                    <a
                        href="tel:0385742505"
                        style="
                            min-height:38px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            margin-top:10px;
                            border:1px solid #dec8a7;
                            border-radius:8px;
                            color:#633820;
                            background:#fff8e8;
                            font-size:10px;
                            font-weight:900;
                        "
                    >
                        ☎ 0385 742 505
                    </a>

                </div>

            </section>

        </aside>

    </div>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | COPY PAYMENT CODE
        |--------------------------------------------------------------------------
        */

        const copyButton =
            document.getElementById(
                'copyPaymentButton'
            );


        const paymentCode =
            document.getElementById(
                'orderPaymentCode'
            );


        const copyFeedback =
            document.getElementById(
                'copyPaymentFeedback'
            );


        if (
            copyButton
            &&
            paymentCode
        ) {

            copyButton.addEventListener(
                'click',
                async function () {

                    const value =
                        paymentCode.value;


                    try {

                        if (
                            navigator.clipboard
                            &&
                            window.isSecureContext
                        ) {

                            await navigator
                                .clipboard
                                .writeText(
                                    value
                                );

                        }
                        else {

                            paymentCode.focus();
                            paymentCode.select();

                            document.execCommand(
                                'copy'
                            );

                        }


                        if (copyFeedback) {

                            copyFeedback.textContent =
                                '✓ Đã sao chép nội dung chuyển khoản.';


                            window.setTimeout(
                                function () {

                                    copyFeedback.textContent =
                                        '';

                                },
                                2500
                            );

                        }

                    }
                    catch (error) {

                        if (copyFeedback) {

                            copyFeedback.textContent =
                                'Không thể tự sao chép. Hãy copy thủ công.';

                        }

                    }

                }
            );

        }


/*
|--------------------------------------------------------------------------
| AUTO CHECK PAYMENT + COUNTDOWN 5 PHÚT
|--------------------------------------------------------------------------
*/

const paymentCard =
    document.getElementById(
        'autoPaymentCard'
    );


const waitingBox =
    document.getElementById(
        'paymentWaitingBox'
    );


const successBox =
    document.getElementById(
        'paymentSuccessBox'
    );


const expiredBox =
    document.getElementById(
        'paymentExpiredBox'
    );


const countdownElement =
    document.getElementById(
        'paymentCountdownTimer'
    );


/*
|--------------------------------------------------------------------------
| CHỈ CHẠY KHI ĐƠN ĐANG CHỜ THANH TOÁN
|--------------------------------------------------------------------------
*/

if (
    paymentCard
    &&
    waitingBox
) {

    const statusUrl =
        paymentCard
            .dataset
            .paymentStatusUrl;


    const expiresAtRaw =
        paymentCard
            .dataset
            .paymentExpiresAt;


    let expiresAt =
        expiresAtRaw
            ? new Date(
                expiresAtRaw
            ).getTime()
            : null;


    let paymentCheckTimer =
        null;


    let countdownTimer =
        null;


    let checkingPayment =
        false;


    let finished =
        false;


    /*
    |--------------------------------------------------------------------------
    | DỪNG TẤT CẢ TIMER
    |--------------------------------------------------------------------------
    */

    const stopTimers =
        function () {

            if (
                paymentCheckTimer
            ) {

                window.clearInterval(
                    paymentCheckTimer
                );


                paymentCheckTimer =
                    null;
            }


            if (
                countdownTimer
            ) {

                window.clearInterval(
                    countdownTimer
                );


                countdownTimer =
                    null;
            }

        };


    /*
    |--------------------------------------------------------------------------
    | UPDATE PAYMENT BADGE
    |--------------------------------------------------------------------------
    */

    const updatePaymentBadge =
        function (
            type,
            text
        ) {

            const statusBadge =
                document.getElementById(
                    'paymentStatusBadge'
                );


            const statusText =
                document.getElementById(
                    'paymentStatusText'
                );


            if (statusBadge) {

                statusBadge
                    .classList
                    .remove(
                        'unpaid',
                        'waiting',
                        'paid',
                        'failed'
                    );


                statusBadge
                    .classList
                    .add(
                        type
                    );

            }


            if (statusText) {

                statusText
                    .textContent =
                    text;

            }

        };


    /*
    |--------------------------------------------------------------------------
    | THANH TOÁN THÀNH CÔNG
    |--------------------------------------------------------------------------
    */

    const showPaid =
        function () {

            if (finished) {
                return;
            }


            finished =
                true;


            waitingBox
                .classList
                .add(
                    'd-none'
                );


            if (expiredBox) {

                expiredBox
                    .classList
                    .add(
                        'd-none'
                    );

            }


            if (successBox) {

                successBox
                    .classList
                    .remove(
                        'd-none'
                    );

            }


            updatePaymentBadge(
                'paid',
                'Đã thanh toán'
            );


            stopTimers();


            /*
             * Reload để toàn bộ thông tin
             * trên trang đồng bộ từ server.
             */

            window.setTimeout(
                function () {

                    window.location.reload();

                },
                1200
            );

        };


    /*
    |--------------------------------------------------------------------------
    | ĐƠN HẾT HẠN
    |--------------------------------------------------------------------------
    */

    const showExpired =
        function () {

            if (finished) {
                return;
            }


            finished =
                true;


            waitingBox
                .classList
                .add(
                    'd-none'
                );


            if (successBox) {

                successBox
                    .classList
                    .add(
                        'd-none'
                    );

            }


            if (expiredBox) {

                expiredBox
                    .classList
                    .remove(
                        'd-none'
                    );

            }


            if (countdownElement) {

                countdownElement
                    .textContent =
                    '00:00';

            }


            updatePaymentBadge(
                'failed',
                'Hết hạn thanh toán'
            );


            stopTimers();


            /*
             * Reload để status đơn hàng
             * chuyển thành cancelled.
             */

            window.setTimeout(
                function () {

                    window.location.reload();

                },
                1500
            );

        };


    /*
    |--------------------------------------------------------------------------
    | RENDER ĐỒNG HỒ
    |--------------------------------------------------------------------------
    */

    const renderCountdown =
        function () {

            if (
                finished
                ||
                !countdownElement
                ||
                !expiresAt
            ) {
                return;
            }


            const now =
                Date.now();


            let remaining =
                Math.floor(
                    (
                        expiresAt
                        -
                        now
                    )
                    /
                    1000
                );


            if (
                remaining <= 0
            ) {

                remaining =
                    0;

            }


            const minutes =
                Math.floor(
                    remaining
                    /
                    60
                );


            const seconds =
                remaining
                %
                60;


            countdownElement
                .textContent =
                String(
                    minutes
                )
                    .padStart(
                        2,
                        '0'
                    )
                +
                ':'
                +
                String(
                    seconds
                )
                    .padStart(
                        2,
                        '0'
                    );


            /*
             * Còn <= 60 giây
             * thì nhấp nháy cảnh báo.
             */

            if (
                remaining <= 60
            ) {

                countdownElement
                    .classList
                    .add(
                        'urgent'
                    );

            }
            else {

                countdownElement
                    .classList
                    .remove(
                        'urgent'
                    );

            }


            /*
             * Về 0 thì gọi server ngay.
             *
             * Chính server mới là nơi
             * quyết định hủy đơn.
             */

            if (
                remaining === 0
            ) {

                checkPayment();

            }

        };


    /*
    |--------------------------------------------------------------------------
    | KIỂM TRA TRẠNG THÁI TỪ SERVER
    |--------------------------------------------------------------------------
    */

    const checkPayment =
        async function () {

            if (
                finished
                ||
                checkingPayment
            ) {
                return;
            }


            checkingPayment =
                true;


            try {

                const response =
                    await fetch(
                        statusUrl,
                        {
                            method:
                                'GET',

                            headers: {

                                'Accept':
                                    'application/json',

                                'X-Requested-With':
                                    'XMLHttpRequest'
                            },

                            cache:
                                'no-store'
                        }
                    );


                if (
                    !response.ok
                ) {
                    return;
                }


                const data =
                    await response.json();


                /*
                |--------------------------------------------------------------------------
                | ĐÃ THANH TOÁN
                |--------------------------------------------------------------------------
                */

                if (
                    data.paid
                    ===
                    true
                ) {

                    showPaid();

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | ĐÃ BỊ HỦY
                |--------------------------------------------------------------------------
                */

                if (
                    data.cancelled
                    ===
                    true
                ) {

                    showExpired();

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | ĐỒNG BỘ THỜI HẠN TỪ SERVER
                |--------------------------------------------------------------------------
                */

                if (
                    data.payment_expires_at
                ) {

                    const serverExpiresAt =
                        new Date(
                            data
                                .payment_expires_at
                        )
                            .getTime();


                    if (
                        !Number.isNaN(
                            serverExpiresAt
                        )
                    ) {

                        expiresAt =
                            serverExpiresAt;

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | SERVER BÁO HẾT GIỜ
                |--------------------------------------------------------------------------
                */

                if (
                    Number(
                        data.remaining_seconds
                    )
                    <=
                    0
                ) {

                    /*
                     * paymentStatus() bên Laravel
                     * đã xử lý việc hủy đơn.
                     *
                     * Gọi lại một lần nữa sau
                     * một khoảng ngắn để lấy
                     * trạng thái cancelled.
                     */

                    window.setTimeout(
                        function () {

                            if (
                                !finished
                            ) {

                                checkPayment();

                            }

                        },
                        500
                    );

                }

            }
            catch (error) {

                console.warn(
                    'Không kiểm tra được trạng thái thanh toán:',
                    error
                );

            }
            finally {

                checkingPayment =
                    false;

            }

        };


    /*
    |--------------------------------------------------------------------------
    | KHỞI ĐỘNG
    |--------------------------------------------------------------------------
    */

    renderCountdown();


    checkPayment();


    /*
     * Đồng hồ chạy mỗi giây.
     */

    countdownTimer =
        window.setInterval(
            renderCountdown,
            1000
        );


    /*
     * Kiểm tra SePay / Laravel mỗi 3 giây.
     */

    paymentCheckTimer =
        window.setInterval(
            checkPayment,
            3000
        );


    /*
     * Rời trang thì dừng timer.
     */

    window.addEventListener(
        'beforeunload',
        stopTimers
    );

}

    }
);
</script>

@endsection