@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id . ' | Admin')

@section('content')

@php
    $deliveryStarted = $order->statusHistories->where('status', 'shipped')->last();
    $deliveryCompleted = $order->statusHistories->where('status', 'delivered')->last();

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
        $statusConfig[$order->status]
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


    $paymentConfig = [
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
        $paymentConfig[$order->payment_status]
        ??
        [
            'label' => 'Chưa xác định',
            'icon' => '○',
            'class' => 'unpaid',
        ];


    $paymentMethodLabel =
        match ($order->payment_method) {
            'cod' => 'Thanh toán khi nhận hàng',
            'bank' => 'Chuyển khoản ngân hàng',
            default => strtoupper(
                $order->payment_method
                ??
                'Không xác định'
            ),
        };


    $shippingMethodLabel =
        match ($order->shipping_method) {
            'standard' => 'Giao hàng tiết kiệm',
            'fast' => 'Giao hàng nhanh',
            'express' => 'Giao hàng hỏa tốc',
            default =>
                $order->shipping_method
                ??
                'Không xác định',
        };


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


    $totalQuantity =
        $order
            ->items
            ->sum(
                function ($item) {
                    return (float) $item->quantity;
                }
            );
@endphp


<style>
    .admin-order-detail {
        --aod-green: #35562f;
        --aod-green-dark: #274522;

        --aod-brown: #633820;
        --aod-brown-dark: #3d2316;

        --aod-red: #b43e2e;
        --aod-red-dark: #8d3025;

        --aod-gold: #e5ad42;
        --aod-gold-soft: #fff0c9;

        --aod-text: #302923;
        --aod-muted: #776d66;

        --aod-border: #e7dfd5;

        --aod-shadow:
            0 8px 28px
            rgba(54, 40, 29, .07);

        --aod-shadow-lg:
            0 18px 48px
            rgba(54, 40, 29, .12);

        color: var(--aod-text);
    }


    .admin-order-detail *,
    .admin-order-detail *::before,
    .admin-order-detail *::after {
        box-sizing: border-box;
    }


    .admin-order-detail a {
        text-decoration: none;
    }


    /* =========================================================
       BREADCRUMB
    ========================================================= */

    .aod-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 7px;

        margin-bottom: 14px;

        color: #958b84;

        font-size: 11px;
    }


    .aod-breadcrumb a {
        color: #665349;

        font-weight: 800;
    }


    .aod-breadcrumb a:hover {
        color: var(--aod-red);
    }


    /* =========================================================
       HERO
    ========================================================= */

    .aod-hero {
        position: relative;

        isolation: isolate;

        overflow: hidden;

        min-height: 185px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 26px;

        margin-bottom: 18px;

        padding:
            30px 34px;

        border-radius: 19px;

        color: #fff;

        background:
            radial-gradient(
                circle at 87% 15%,
                rgba(229,173,66,.27),
                transparent 28%
            ),
            linear-gradient(
                125deg,
                #2e1a11 0%,
                #633820 52%,
                #385532 100%
            );

        box-shadow:
            var(--aod-shadow-lg);
    }


    .aod-hero::before {
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


    .aod-hero::after {
        content: "";

        position: absolute;

        z-index: -1;

        right: -30px;
        bottom: -60px;

        width: 330px;
        height: 185px;

        opacity: .1;

        background: #fff;

        clip-path:
            polygon(
                0 100%,
                20% 55%,
                38% 72%,
                57% 23%,
                76% 61%,
                100% 13%,
                100% 100%
            );
    }


    .aod-hero-copy {
        position: relative;

        z-index: 2;
    }


    .aod-kicker {
        display: inline-flex;
        align-items: center;

        gap: 5px;

        padding:
            6px 10px;

        border:
            1px solid
            rgba(255,255,255,.16);

        border-radius: 999px;

        color: #ffdb91;

        background:
            rgba(255,255,255,.06);

        font-size: 10px;

        font-weight: 900;

        letter-spacing: .09em;

        text-transform: uppercase;
    }


    .aod-title {
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


    .aod-description {
        margin-top: 7px;

        color:
            rgba(255,255,255,.73);

        font-size: 12.5px;

        line-height: 1.65;
    }


    .aod-hero-side {
        position: relative;

        z-index: 2;

        display: flex;
        align-items: flex-end;
        flex-direction: column;

        gap: 9px;
    }


    .aod-current-status {
        display: inline-flex;
        align-items: center;

        gap: 6px;

        padding:
            8px 12px;

        border-radius: 999px;

        font-size: 10.5px;

        font-weight: 900;
    }


    .aod-current-status.pending {
        color: #654b11;

        background: #ffe69a;
    }


    .aod-current-status.confirmed {
        color: #195a69;

        background: #dff3f7;
    }


    .aod-current-status.shipped {
        color: #205989;

        background: #dfedff;
    }


    .aod-current-status.delivered {
        color: #315f2b;

        background: #e5f3e1;
    }


    .aod-current-status.cancelled {
        color: #913a31;

        background: #fde6e3;
    }


    .aod-back {
        min-height: 39px;

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


    .aod-back:hover {
        color: #fff;

        background:
            rgba(255,255,255,.15);
    }


    /* =========================================================
       STATS
    ========================================================= */

    .aod-stats {
        display: grid;

        grid-template-columns:
            repeat(
                4,
                minmax(0, 1fr)
            );

        gap: 11px;

        margin-bottom: 18px;
    }


    .aod-stat {
        min-height: 93px;

        display: flex;
        align-items: center;

        gap: 12px;

        padding: 14px;

        border:
            1px solid
            var(--aod-border);

        border-radius: 14px;

        background: #fff;

        box-shadow:
            var(--aod-shadow);
    }


    .aod-stat-icon {
        width: 44px;
        height: 44px;

        flex: 0 0 44px;

        display: grid;
        place-items: center;

        border-radius: 11px;

        background:
            var(--aod-gold-soft);

        font-size: 19px;
    }


    .aod-stat-label {
        color:
            var(--aod-muted);

        font-size: 9.5px;

        font-weight: 750;
    }


    .aod-stat-value {
        margin-top: 2px;

        color:
            var(--aod-brown-dark);

        font-size: 16px;

        font-weight: 950;

        line-height: 1.2;
    }


    /* =========================================================
       LAYOUT
    ========================================================= */

    .aod-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            370px;

        gap: 18px;

        align-items: start;
    }


    .aod-main {
        min-width: 0;

        display: grid;

        gap: 15px;
    }


    .aod-side {
        position: sticky;

        top: 177px;

        display: grid;

        gap: 13px;
    }


    /* =========================================================
       CARD
    ========================================================= */

    .aod-card {
        overflow: hidden;

        border:
            1px solid
            var(--aod-border);

        border-radius: 15px;

        background: #fff;

        box-shadow:
            var(--aod-shadow);
    }


    .aod-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 13px;

        padding:
            14px 16px;

        border-bottom:
            1px solid
            var(--aod-border);

        background:
            linear-gradient(
                180deg,
                #fff,
                #fffcf7
            );
    }


    .aod-card-title {
        margin: 0;

        color: #453930;

        font-size: 13.5px;

        font-weight: 950;
    }


    .aod-card-subtitle {
        margin-top: 2px;

        color:
            var(--aod-muted);

        font-size: 9.5px;
    }


    .aod-card-body {
        padding: 16px;
    }


    /* =========================================================
       CUSTOMER INFO
    ========================================================= */

    .aod-customer-grid {
        display: grid;

        grid-template-columns:
            repeat(
                2,
                minmax(0, 1fr)
            );

        gap: 12px;
    }


    .aod-info-box {
        min-width: 0;

        padding: 13px;

        border:
            1px solid #ece3d9;

        border-radius: 11px;

        background: #fbfaf8;
    }


    .aod-info-box.full {
        grid-column:
            1 / -1;
    }


    .aod-info-heading {
        display: flex;
        align-items: center;

        gap: 5px;

        margin-bottom: 10px;

        color:
            var(--aod-brown-dark);

        font-size: 11px;

        font-weight: 950;
    }


    .aod-info-row {
        margin-bottom: 9px;
    }


    .aod-info-row:last-child {
        margin-bottom: 0;
    }


    .aod-info-label {
        color: #978b83;

        font-size: 8.5px;
    }


    .aod-info-value {
        margin-top: 1px;

        color: #473b33;

        font-size: 10.5px;

        line-height: 1.5;

        font-weight: 850;

        overflow-wrap: anywhere;
    }


    .aod-note {
        margin-top: 11px;

        padding:
            10px 11px;

        border:
            1px solid #ead9b8;

        border-radius: 9px;

        color: #6c563d;

        background: #fff9e8;

        font-size: 9.5px;

        line-height: 1.55;
    }


    /* =========================================================
       TRACKING
    ========================================================= */

    .aod-tracking {
        position: relative;

        display: grid;

        grid-template-columns:
            repeat(
                4,
                1fr
            );

        margin:
            8px 0 4px;
    }


    .aod-track-line {
        position: absolute;

        z-index: 1;

        top: 22px;
        left: 12.5%;
        right: 12.5%;

        height: 4px;

        overflow: hidden;

        border-radius: 999px;

        background:
            #e7e2dc;
    }


    .aod-track-progress {
        height: 100%;

        border-radius: 999px;

        background:
            linear-gradient(
                90deg,
                var(--aod-green),
                #78a665
            );
    }


    .aod-track-step {
        position: relative;

        z-index: 2;

        text-align: center;
    }


    .aod-track-circle {
        width: 46px;
        height: 46px;

        display: grid;
        place-items: center;

        margin: 0 auto;

        border:
            4px solid #fff;

        border-radius: 50%;

        color: #948d87;

        background:
            #e9e5e1;

        box-shadow:
            0 3px 10px
            rgba(49,38,30,.08);

        font-size: 17px;

        font-weight: 950;
    }


    .aod-track-circle.done {
        color: #fff;

        background:
            var(--aod-green);
    }


    .aod-track-circle.current {
        color: #fff;

        background:
            var(--aod-red);

        box-shadow:
            0 0 0 5px
            rgba(180,62,46,.09);
    }


    .aod-track-label {
        margin-top: 7px;

        color: #91867e;

        font-size: 9px;

        line-height: 1.4;

        font-weight: 750;
    }


    .aod-track-label.done {
        color:
            var(--aod-green);

        font-weight: 900;
    }


    .aod-track-label.current {
        color:
            var(--aod-red);

        font-weight: 950;
    }


    .aod-cancelled {
        display: flex;
        align-items: flex-start;

        gap: 10px;

        padding:
            13px;

        border:
            1px solid #e9c2bc;

        border-radius: 10px;

        color: #8f3931;

        background: #fff0ee;
    }


    .aod-cancelled strong {
        font-size: 11px;
    }


    .aod-cancelled p {
        margin:
            3px 0 0;

        font-size: 9.5px;

        line-height: 1.5;
    }


    /* =========================================================
       PRODUCTS
    ========================================================= */

    .aod-products {
        display: grid;
    }


    .aod-product {
        display: grid;

        grid-template-columns:
            76px
            minmax(0, 1fr)
            120px
            130px;

        align-items: center;

        gap: 12px;

        padding:
            13px 0;

        border-bottom:
            1px solid #eee7df;
    }


    .aod-product:last-child {
        border-bottom: 0;
    }


    .aod-product-image {
        width: 76px;
        height: 76px;

        overflow: hidden;

        border:
            1px solid #e8ded3;

        border-radius: 10px;

        background: #faf8f5;
    }


    .aod-product-image img {
        width: 100%;
        height: 100%;

        padding: 4px;

        object-fit: contain;
    }


    .aod-product-fallback {
        width: 100%;
        height: 100%;

        display: grid;
        place-items: center;

        color: #9a8d82;

        font-size: 27px;
    }


    .aod-product-info {
        min-width: 0;
    }


    .aod-product-name {
        color: #38302a;

        font-size: 11.5px;

        line-height: 1.45;

        font-weight: 950;

        display: -webkit-box;

        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;

        overflow: hidden;
    }


    .aod-product-meta {
        margin-top: 4px;

        color:
            var(--aod-muted);

        font-size: 9px;
    }


    .aod-stock {
        display: inline-flex;
        align-items: center;

        gap: 4px;

        margin-top: 5px;

        padding:
            4px 6px;

        border-radius: 999px;

        color:
            var(--aod-green-dark);

        background:
            #eaf4e7;

        font-size: 8px;

        font-weight: 850;
    }


    .aod-stock.out {
        color: #963c33;

        background:
            #fae6e3;
    }


    .aod-product-price {
        color: #54463d;

        font-size: 10.5px;

        font-weight: 850;

        text-align: right;
    }


    .aod-product-total {
        color:
            var(--aod-red);

        font-size: 12.5px;

        font-weight: 950;

        text-align: right;
    }


    .aod-products-head {
        display: grid;

        grid-template-columns:
            76px
            minmax(0, 1fr)
            120px
            130px;

        gap: 12px;

        padding:
            0 0 9px;

        border-bottom:
            1px solid #dfd3c5;

        color: #8b7e74;

        font-size: 8.5px;

        font-weight: 900;

        text-transform: uppercase;
    }


    .aod-products-head span:nth-child(3),
    .aod-products-head span:nth-child(4) {
        text-align: right;
    }


    /* =========================================================
       HISTORY
    ========================================================= */

    .aod-history {
        display: grid;
    }


    .aod-history-item {
        display: grid;

        grid-template-columns:
            35px
            minmax(0, 1fr);

        gap: 10px;

        position: relative;

        padding-bottom: 17px;
    }


    .aod-history-item:last-child {
        padding-bottom: 0;
    }


    .aod-history-icon-wrap {
        position: relative;

        display: flex;
        justify-content: center;
    }


    .aod-history-icon-wrap::after {
        content: "";

        position: absolute;

        top: 31px;
        bottom: -1px;

        width: 2px;

        background:
            #e7dfd5;
    }


    .aod-history-item:last-child
    .aod-history-icon-wrap::after {
        display: none;
    }


    .aod-history-icon {
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


    .aod-history-title {
        color: #473b33;

        font-size: 10.5px;

        font-weight: 950;
    }


    .aod-history-note {
        margin-top: 2px;

        color:
            var(--aod-muted);

        font-size: 9px;

        line-height: 1.5;
    }


    .aod-history-time {
        margin-top: 4px;

        color: #9e938b;

        font-size: 8px;
    }


    /* =========================================================
       STATUS CONTROL
    ========================================================= */

    .aod-control-head {
        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--aod-brown-dark),
                var(--aod-brown)
            );
    }


    .aod-control-head
    .aod-card-title {
        color: #fff;
    }


    .aod-control-head
    .aod-card-subtitle {
        color:
            rgba(255,255,255,.67);
    }


    .aod-status-select {
        width: 100%;
        height: 44px;

        padding:
            0 11px;

        border:
            1px solid #ddcfbf;

        border-radius: 9px;

        outline: 0;

        color:
            #4b3e35;

        background: #fff;

        font-size: 10.5px;

        font-weight: 850;
    }


    .aod-status-select:focus {
        border-color:
            var(--aod-gold);

        box-shadow:
            0 0 0 3px
            rgba(229,173,66,.1);
    }


    .aod-status-button {
        width: 100%;
        min-height: 43px;

        margin-top: 8px;

        border: 0;

        border-radius: 9px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--aod-red),
                var(--aod-red-dark)
            );

        font-size: 10px;

        font-weight: 950;
    }


    .aod-status-button:hover {
        box-shadow:
            0 8px 17px
            rgba(180,62,46,.18);
    }


    .aod-stock-warning {
        margin-top: 10px;

        padding:
            9px 10px;

        border:
            1px solid #ead6a8;

        border-radius: 9px;

        color: #6d573d;

        background:
            #fff9e6;

        font-size: 9px;

        line-height: 1.5;
    }


    /* =========================================================
       PAYMENT
    ========================================================= */

    .aod-payment-status {
        display: flex;
        align-items: center;
        justify-content: center;

        gap: 5px;

        min-height: 38px;

        padding:
            7px 9px;

        border-radius: 9px;

        font-size: 9.5px;

        font-weight: 900;

        text-align: center;
    }


    .aod-payment-status.unpaid {
        color: #99453b;

        background:
            #fbe9e6;
    }


    .aod-payment-status.waiting {
        color: #765714;

        background:
            #fff1c2;
    }


    .aod-payment-status.paid {
        color:
            var(--aod-green-dark);

        background:
            #e8f4e5;
    }


    .aod-payment-status.failed {
        color: #983831;

        background:
            #f9e2df;
    }


    .aod-payment-info {
        display: grid;

        gap: 9px;

        margin-top: 12px;
    }


    .aod-payment-info-row {
        padding:
            9px 10px;

        border:
            1px solid #eee5db;

        border-radius: 9px;

        background: #fbfaf8;
    }


    .aod-payment-label {
        color: #978b83;

        font-size: 8.5px;
    }


    .aod-payment-value {
        margin-top: 2px;

        color: #473b33;

        font-size: 10.5px;

        line-height: 1.45;

        font-weight: 900;

        overflow-wrap: anywhere;
    }


    .aod-payment-code {
        color:
            var(--aod-red);

        font-size: 13px;

        font-weight: 950;

        letter-spacing: .04em;
    }


    .aod-confirm-payment {
        width: 100%;
        min-height: 43px;

        margin-top: 10px;

        border: 0;

        border-radius: 9px;

        color: #fff;

        background:
            var(--aod-green);

        font-size: 10px;

        font-weight: 950;
    }


    .aod-confirm-payment:hover {
        background:
            var(--aod-green-dark);
    }


    /* =========================================================
       SUMMARY
    ========================================================= */

    .aod-summary-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 12px;

        margin-bottom: 10px;

        color:
            var(--aod-muted);

        font-size: 10.5px;
    }


    .aod-summary-row strong {
        color: #493d35;

        font-size: 11px;

        text-align: right;
    }


    .aod-summary-discount strong {
        color:
            var(--aod-green);
    }


    .aod-summary-divider {
        height: 1px;

        margin:
            14px 0;

        background:
            #e9e0d6;
    }


    .aod-summary-total {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 10px;
    }


    .aod-summary-total-label {
        color: #40352e;

        font-size: 12px;

        font-weight: 950;
    }


    .aod-summary-total-price {
        color:
            var(--aod-red);

        font-size: 22px;

        line-height: 1;

        font-weight: 950;

        letter-spacing: -.035em;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1199.98px) {

        .aod-layout {
            grid-template-columns:
                minmax(0, 1fr)
                330px;
        }


        .aod-stats {
            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );
        }

    }


    @media (max-width: 991.98px) {

        .aod-layout {
            grid-template-columns: 1fr;
        }


        .aod-side {
            position: static;
        }

    }


    @media (max-width: 767.98px) {

        .aod-hero {
            align-items: flex-start;

            flex-direction: column;

            padding:
                24px 21px;
        }


        .aod-hero-side {
            align-items: flex-start;
        }


        .aod-customer-grid {
            grid-template-columns: 1fr;
        }


        .aod-info-box.full {
            grid-column: auto;
        }


        .aod-tracking {
            grid-template-columns: 1fr;

            gap: 9px;
        }


        .aod-track-line {
            display: none;
        }


        .aod-track-step {
            display: grid;

            grid-template-columns:
                42px
                minmax(0, 1fr);

            align-items: center;

            gap: 8px;

            text-align: left;
        }


        .aod-track-circle {
            width: 40px;
            height: 40px;

            margin: 0;

            border-width: 3px;
        }


        .aod-track-label {
            margin-top: 0;
        }


        .aod-products-head {
            display: none;
        }


        .aod-product {
            grid-template-columns:
                65px
                minmax(0, 1fr);
        }


        .aod-product-image {
            width: 65px;
            height: 65px;
        }


        .aod-product-price,
        .aod-product-total {
            grid-column: 2;

            justify-self: start;

            text-align: left;
        }

    }


    @media (max-width: 575.98px) {

        .aod-stats {
            grid-template-columns: 1fr;
        }


        .aod-card-body {
            padding: 13px;
        }

    }

    .aod-delivery-notice {
        margin-top: 14px;
        padding: 14px;
        border: 1px solid #bad5f5;
        border-left: 4px solid #2368a2;
        background: #eff6ff;
        color: #174e7a;
        font-size: 12px;
        line-height: 1.6;
    }
    .aod-delivery-notice.is-delivered {
        border-color: #bed8bf;
        border-left-color: #357443;
        background: #eff8ee;
        color: #285b32;
    }
    .aod-delivery-notice strong { display: block; font-size: 14px; }
    .aod-delivery-notice p { margin: 6px 0 0; }
    .aod-delivery-time { margin-top: 8px; }
    .aod-delivery-source { display: block; margin-top: 8px; }
    [data-theme="dark"] .aod-delivery-notice { background: #203447; color: #d3e8ff; }
    [data-theme="dark"] .aod-delivery-notice.is-delivered { background: #233d2b; color: #d8efda; }
</style>


<div class="admin-order-detail">


    {{-- =====================================================
        BREADCRUMB
    ====================================================== --}}
    <div class="aod-breadcrumb">

        <a href="{{ route('admin.dashboard') }}">
            Dashboard
        </a>

        <span>›</span>

        <a href="{{ route('admin.orders.index') }}">
            Đơn hàng
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
    <section class="aod-hero">

        <div class="aod-hero-copy">

            <div class="aod-kicker">
                • Admin · Quản lý đơn hàng
            </div>


            <h1 class="aod-title">

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


            <div class="aod-description">

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

                · Quản lý thanh toán,
                tồn kho và tiến trình giao hàng.

            </div>

        </div>


        <div class="aod-hero-side">

            <span
                class="
                    aod-current-status
                    {{ $currentStatus['class'] }}
                "
            >

                {{ $currentStatus['icon'] }}

                {{ $currentStatus['label'] }}

            </span>


            <a
                href="{{ route('admin.orders.index') }}"
                class="aod-back"
            >
                ← Danh sách đơn hàng
            </a>

        </div>

    </section>


    {{-- =====================================================
        QUICK STATS
    ====================================================== --}}
    <div class="aod-stats">


        <div class="aod-stat">

            <div class="aod-stat-icon">
                •
            </div>

            <div>

                <div class="aod-stat-label">
                    Khách hàng
                </div>

                <div class="aod-stat-value">

                    {{
                        $order->user?->name
                        ??
                        'Không xác định'
                    }}

                </div>

            </div>

        </div>


        <div class="aod-stat">

            <div class="aod-stat-icon">
                •
            </div>

            <div>

                <div class="aod-stat-label">
                    Dòng sản phẩm
                </div>

                <div class="aod-stat-value">

                    {{
                        $order
                            ->items
                            ->count()
                    }}

                </div>

            </div>

        </div>


        <div class="aod-stat">

            <div class="aod-stat-icon">
                •
            </div>

            <div>

                <div class="aod-stat-label">
                    Thanh toán
                </div>

                <div class="aod-stat-value">
                    {{ $paymentStatus['label'] }}
                </div>

            </div>

        </div>


        <div class="aod-stat">

            <div class="aod-stat-icon">
                •
            </div>

            <div>

                <div class="aod-stat-label">
                    Tổng thanh toán
                </div>

                <div class="aod-stat-value">

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

        </div>

    </div>


    {{-- =====================================================
        MAIN
    ====================================================== --}}
    <div class="aod-layout">


        {{-- =================================================
            LEFT
        ================================================== --}}
        <div class="aod-main">


            {{-- =============================================
                CUSTOMER
            ============================================== --}}
            <section class="aod-card">

                <div class="aod-card-head">

                    <div>

                        <h2 class="aod-card-title">
                            • Thông tin khách hàng
                        </h2>

                        <div class="aod-card-subtitle">
                            Tài khoản đặt hàng và người nhận.
                        </div>

                    </div>

                </div>


                <div class="aod-card-body">

                    <div class="aod-customer-grid">


                        <div class="aod-info-box">

                            <div class="aod-info-heading">
                                • Tài khoản đặt hàng
                            </div>


                            <div class="aod-info-row">

                                <div class="aod-info-label">
                                    Họ tên
                                </div>

                                <div class="aod-info-value">

                                    {{
                                        $order->user?->name
                                        ??
                                        'Không xác định'
                                    }}

                                </div>

                            </div>


                            <div class="aod-info-row">

                                <div class="aod-info-label">
                                    Email
                                </div>

                                <div class="aod-info-value">

                                    {{
                                        $order->user?->email
                                        ??
                                        'Không có'
                                    }}

                                </div>

                            </div>

                        </div>


                        <div class="aod-info-box">

                            <div class="aod-info-heading">
                                • Người nhận
                            </div>


                            <div class="aod-info-row">

                                <div class="aod-info-label">
                                    Họ và tên
                                </div>

                                <div class="aod-info-value">

                                    {{
                                        $order->customer_name
                                        ??
                                        'Không có'
                                    }}

                                </div>

                            </div>


                            <div class="aod-info-row">

                                <div class="aod-info-label">
                                    Số điện thoại
                                </div>

                                <div class="aod-info-value">

                                    {{
                                        $order->customer_phone
                                        ??
                                        'Không có'
                                    }}

                                </div>

                            </div>

                        </div>


                        <div class="aod-info-box full">

                            <div class="aod-info-heading">
                                • Giao hàng
                            </div>


                            <div class="aod-info-row">

                                <div class="aod-info-label">
                                    Địa chỉ
                                </div>

                                <div class="aod-info-value">

                                    {{
                                        $order->shipping_address
                                        ??
                                        'Chưa có địa chỉ'
                                    }}

                                </div>

                            </div>


                            <div class="aod-info-row">

                                <div class="aod-info-label">
                                    Phương thức vận chuyển
                                </div>

                                <div class="aod-info-value">
                                    {{ $shippingMethodLabel }}
                                </div>

                            </div>


                            @if($order->notes)

                                <div class="aod-note">

                                    <strong>
                                        • Ghi chú khách hàng:
                                    </strong>

                                    <br>

                                    {{ $order->notes }}

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            </section>


            {{-- =============================================
                PROGRESS
            ============================================== --}}
            <section class="aod-card">

                <div class="aod-card-head">

                    <div>

                        <h2 class="aod-card-title">
                            • Tiến trình đơn hàng
                        </h2>

                        <div class="aod-card-subtitle">
                            Trạng thái vận hành hiện tại.
                        </div>

                    </div>

                </div>


                <div class="aod-card-body">


                    @if($order->status === 'cancelled')

                        <div class="aod-cancelled">

                            <div style="font-size:26px;">
                                •
                            </div>

                            <div>

                                <strong>
                                    Đơn hàng đã bị hủy
                                </strong>

                                <p>
                                    Tồn kho của các sản phẩm
                                    trong đơn đã được hoàn lại.
                                </p>

                            </div>

                        </div>


                    @else

                        <div class="aod-tracking">

                            <div class="aod-track-line">

                                <div
                                    class="aod-track-progress"
                                    style="
                                        width:
                                        {{ $progressWidth }};
                                    "
                                >
                                </div>

                            </div>


                            <div class="aod-track-step">

                                <div
                                    class="
                                        aod-track-circle

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
                                    •
                                </div>

                                <div
                                    class="
                                        aod-track-label

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


                            <div class="aod-track-step">

                                <div
                                    class="
                                        aod-track-circle

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
                                    •
                                </div>

                                <div
                                    class="
                                        aod-track-label

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


                            <div class="aod-track-step">

                                <div
                                    class="
                                        aod-track-circle

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
                                    •
                                </div>

                                <div
                                    class="
                                        aod-track-label

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


                            <div class="aod-track-step">

                                <div
                                    class="
                                        aod-track-circle

                                        {{
                                            $statusStep >= 4
                                            ? 'done'
                                            : ''
                                        }}
                                    "
                                >
                                    •
                                </div>

                                <div
                                    class="
                                        aod-track-label

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
            <section class="aod-card">

                <div class="aod-card-head">

                    <div>

                        <h2 class="aod-card-title">
                            • Sản phẩm trong đơn
                        </h2>

                        <div class="aod-card-subtitle">

                            {{
                                $order
                                    ->items
                                    ->count()
                            }}
                            dòng sản phẩm

                        </div>

                    </div>

                </div>


                <div class="aod-card-body">


                    <div class="aod-products-head">

                        <span>
                            Ảnh
                        </span>

                        <span>
                            Sản phẩm
                        </span>

                        <span>
                            Đơn giá
                        </span>

                        <span>
                            Thành tiền
                        </span>

                    </div>


                    <div class="aod-products">


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


                                $itemTotal =
                                    $quantity
                                    *
                                    $itemPrice;


                                $stock =
                                    $product
                                    ? (float)
                                        $product->quantity
                                    : null;
                            @endphp


                            <div class="aod-product">


                                <div class="aod-product-image">

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
                                            class="aod-product-fallback"
                                            style="display:none;"
                                        >
                                            •
                                        </div>

                                    @else

                                        <div class="aod-product-fallback">
                                            •
                                        </div>

                                    @endif

                                </div>


                                <div class="aod-product-info">


                                    @if($product)

                                        <a
                                            href="{{
                                                route(
                                                    'products.show',
                                                    $product
                                                )
                                            }}"
                                            class="aod-product-name"
                                            target="_blank"
                                        >
                                            {{ $product->name }}
                                        </a>

                                    @else

                                        <div class="aod-product-name">
                                            Sản phẩm không còn tồn tại
                                        </div>

                                    @endif


                                    <div class="aod-product-meta">

                                        Số lượng đơn:

                                        <strong>

                                            {{
                                                $formatQuantity(
                                                    $quantity
                                                )
                                            }}

                                            {{ $unit }}

                                        </strong>

                                    </div>


                                    @if($product)

                                        <div
                                            class="
                                                aod-stock
                                                {{
                                                    $stock > 0
                                                    ? ''
                                                    : 'out'
                                                }}
                                            "
                                        >

                                            {{
                                                $stock > 0
                                                ? '● Tồn hiện tại: '
                                                : '● Hết tồn: '
                                            }}

                                            {{
                                                $formatQuantity(
                                                    $stock
                                                )
                                            }}

                                            {{ $unit }}

                                        </div>

                                    @endif

                                </div>


                                <div class="aod-product-price">

                                    {{
                                        number_format(
                                            $itemPrice,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}đ

                                    <div
                                        style="
                                            margin-top:3px;
                                            color:#9a8f87;
                                            font-size:8px;
                                        "
                                    >
                                        / {{ $unit }}
                                    </div>

                                </div>


                                <div class="aod-product-total">

                                    {{
                                        number_format(
                                            $itemTotal,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }}đ

                                </div>

                            </div>


                        @empty

                            <div
                                class="
                                    text-center
                                    text-muted
                                    py-4
                                "
                            >
                                Không có sản phẩm trong đơn.
                            </div>

                        @endforelse

                    </div>

                </div>

            </section>


            {{-- =============================================
                HISTORY
            ============================================== --}}
            <section class="aod-card">

                <div class="aod-card-head">

                    <div>

                        <h2 class="aod-card-title">
                            • Lịch sử xử lý
                        </h2>

                        <div class="aod-card-subtitle">
                            Ai đã cập nhật và cập nhật lúc nào.
                        </div>

                    </div>

                </div>


                <div class="aod-card-body">

                    <div class="aod-history">


                        @forelse($order->statusHistories as $history)

                            @php
                                $historyStatus =
                                    $statusConfig[
                                        $history->status
                                    ]
                                    ??
                                    [
                                        'icon' => '•',
                                    ];
                            @endphp


                            <div class="aod-history-item">

                                <div class="aod-history-icon-wrap">

                                    <div class="aod-history-icon">

                                        {{
                                            $historyStatus['icon']
                                        }}

                                    </div>

                                </div>


                                <div>

                                    <div class="aod-history-title">

                                        {{
                                            $history->title
                                            ??
                                            'Trạng thái đơn hàng thay đổi'
                                        }}

                                    </div>


                                    @if($history->note)

                                        <div class="aod-history-note">
                                            {{ $history->note }}
                                        </div>

                                    @endif


                                    <div class="aod-history-time">

                                        {{
                                            $history
                                                ->created_at
                                                ->format(
                                                    'H:i · d/m/Y'
                                                )
                                        }}


                                        @if($history->user)

                                            · bởi

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
        <aside class="aod-side">


            {{-- =============================================
                STATUS CONTROL
            ============================================== --}}
            <section class="aod-card">

                <div
                    class="
                        aod-card-head
                        aod-control-head
                    "
                >

                    <div>

                        <h2 class="aod-card-title">
                            • Cập nhật trạng thái
                        </h2>

                        <div class="aod-card-subtitle">
                            Quản lý tiến trình xử lý đơn.
                        </div>

                    </div>

                </div>


                <div class="aod-card-body">


                    <div
                        style="
                            margin-bottom:8px;
                            color:#756a62;
                            font-size:9.5px;
                        "
                    >
                        Trạng thái hiện tại
                    </div>


                    <div
                        class="
                            aod-current-status
                            {{ $currentStatus['class'] }}
                        "
                    >

                        {{ $currentStatus['icon'] }}

                        {{ $currentStatus['label'] }}

                    </div>


                    <div
                        style="
                            height:1px;
                            margin:15px 0;
                            background:#ece3d9;
                        "
                    >
                    </div>


                    @if(in_array($order->status, ['shipped', 'delivered'], true))
                        <div class="aod-delivery-notice {{ $order->status === 'delivered' ? 'is-delivered' : '' }}" role="status">
                            @if($order->status === 'delivered')
                                <strong>• Đã giao hàng · Đã khóa trạng thái</strong>
                                <p>Đơn hàng đã hoàn tất giao hàng. Không thể chuyển sang trạng thái khác.</p>
                            @else
                                <strong>• Đang giao hàng</strong>
                                <p>Đơn hàng đang trong quá trình vận chuyển. Chỉ xác nhận đã giao khi khách đã nhận hàng.</p>
                            @endif
                            <div class="aod-delivery-time">
                                Bắt đầu giao:
                                {{ $deliveryStarted?->created_at?->format('H:i · d/m/Y') ?? 'Chưa có thời điểm ghi nhận' }}
                            </div>
                            @if($order->status === 'delivered')
                                <div class="aod-delivery-time">
                                    Xác nhận đã giao:
                                    {{ $deliveryCompleted?->created_at?->format('H:i · d/m/Y') ?? 'Chưa có thời điểm ghi nhận' }}
                                </div>
                            @endif
                            <small class="aod-delivery-source">Theo lịch sử cập nhật của admin.</small>
                        </div>
                    @endif

                    @if($order->status !== 'delivered')
                    <form
                        action="{{
                            route(
                                'admin.orders.updateStatus',
                                $order
                            )
                        }}"
                        method="POST"
                        id="adminOrderStatusForm"
                        data-current-status="{{
                            $order->status
                        }}"
                    >

                        @csrf
                        @method('PATCH')


                        <label
                            for="adminOrderStatus"
                            style="
                                display:block;
                                margin-bottom:6px;
                                color:#51443b;
                                font-size:10px;
                                font-weight:900;
                            "
                        >
                            Chọn trạng thái mới
                        </label>


                        <select
                            name="status"
                            id="adminOrderStatus"
                            class="aod-status-select"
                            required
                        >

                            <option
                                value="pending"
                                {{
                                    $order->status === 'pending'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                • Chờ xác nhận
                            </option>


                            <option
                                value="confirmed"
                                {{
                                    $order->status === 'confirmed'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                • Đã xác nhận
                            </option>


                            <option
                                value="shipped"
                                {{
                                    $order->status === 'shipped'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                • Đang giao hàng
                            </option>


                            <option
                                value="delivered"
                                {{
                                    $order->status === 'delivered'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                • Đã giao hàng
                            </option>


                            <option
                                value="cancelled"
                                {{
                                    $order->status === 'cancelled'
                                    ? 'selected'
                                    : ''
                                }}
                            >
                                • Đã hủy
                            </option>

                        </select>


                        <button
                            type="submit"
                            class="aod-status-button"
                        >
                            • Lưu trạng thái
                        </button>

                    </form>


                    <div class="aod-stock-warning">

                        <strong>
                            • Lưu ý tồn kho
                        </strong>

                        <br>

                        Khi chuyển đơn sang
                        <strong>Đã hủy</strong>,
                        hệ thống sẽ hoàn lại tồn kho.

                        Nếu mở lại một đơn đã hủy,
                        hệ thống phải trừ tồn kho lại
                        và có thể từ chối nếu không đủ hàng.

                    </div>
                    @endif

                </div>

            </section>


            {{-- =============================================
                PAYMENT
            ============================================== --}}
            <section class="aod-card">

                <div class="aod-card-head">

                    <div>

                        <h2 class="aod-card-title">
                            • Thanh toán
                        </h2>

                        <div class="aod-card-subtitle">
                            Kiểm tra trạng thái thanh toán.
                        </div>

                    </div>

                </div>


                <div class="aod-card-body">


                    <div
                        class="
                            aod-payment-status
                            {{ $paymentStatus['class'] }}
                        "
                    >

                        {{ $paymentStatus['icon'] }}

                        {{ $paymentStatus['label'] }}

                    </div>


                    <div class="aod-payment-info">


                        <div class="aod-payment-info-row">

                            <div class="aod-payment-label">
                                Phương thức
                            </div>

                            <div class="aod-payment-value">
                                {{ $paymentMethodLabel }}
                            </div>

                        </div>


                        @if(
                            $order->payment_method === 'bank'
                            &&
                            $order->payment_code
                        )

                            <div class="aod-payment-info-row">

                                <div class="aod-payment-label">
                                    Mã thanh toán
                                </div>

                                <div class="aod-payment-code">
                                    {{ $order->payment_code }}
                                </div>

                            </div>

                        @endif

                    </div>


                    @if(
                        $order->payment_method === 'bank'
                        &&
                        $order->payment_status !== 'paid'
                    )

                        <form
                            action="{{
                                route(
                                    'admin.orders.confirmPayment',
                                    $order
                                )
                            }}"
                            method="POST"
                            onsubmit="
                                return confirm(
                                    'Bạn chắc chắn đã nhận được tiền cho đơn hàng này?'
                                );
                            "
                        >

                            @csrf
                            @method('PATCH')


                            <button
                                type="submit"
                                class="aod-confirm-payment"
                            >
                                • Xác nhận đã thanh toán
                            </button>

                        </form>

                    @elseif(
                        $order->payment_method === 'cod'
                    )

                        <div class="aod-stock-warning">

                            • Đơn COD sẽ được
                            khách hàng thanh toán
                            khi nhận hàng.

                        </div>

                    @endif

                </div>

            </section>


            {{-- =============================================
                SUMMARY
            ============================================== --}}
            <section class="aod-card">

                <div class="aod-card-head">

                    <div>

                        <h2 class="aod-card-title">
                            • Tổng đơn hàng
                        </h2>

                        <div class="aod-card-subtitle">

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


                <div class="aod-card-body">


                    <div class="aod-summary-row">

                        <span>
                            Tạm tính
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


                    <div class="aod-summary-row">

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
                            aod-summary-row
                            aod-summary-discount
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

                        <div class="aod-summary-row">

                            <span>
                                Voucher
                            </span>

                            <strong>
                                • {{ $order->voucher_code }}
                            </strong>

                        </div>

                    @endif


                    <div class="aod-summary-row">

                        <span>
                            Tổng số lượng
                        </span>

                        <strong>
                            {{ $formatQuantity($totalQuantity) }}
                        </strong>

                    </div>


                    <div class="aod-summary-divider">
                    </div>


                    <div class="aod-summary-total">

                        <div class="aod-summary-total-label">
                            Tổng thanh toán
                        </div>

                        <div class="aod-summary-total-price">

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

                </div>

            </section>

        </aside>

    </div>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        const form =
            document.getElementById(
                'adminOrderStatusForm'
            );


        const select =
            document.getElementById(
                'adminOrderStatus'
            );


        if (
            !form
            ||
            !select
        ) {
            return;
        }


        form.addEventListener(
            'submit',
            function (event) {

                const currentStatus =
                    form.dataset.currentStatus;


                const newStatus =
                    select.value;


                if (
                    currentStatus
                    ===
                    newStatus
                ) {

                    return;

                }


                let message =
                    'Bạn có chắc muốn đổi trạng thái đơn hàng thành "'
                    +
                    select.options[
                        select.selectedIndex
                    ].text.trim()
                    +
                    '"?';


                if (
                    newStatus
                    ===
                    'cancelled'
                ) {

                    message =
                        'Bạn chắc chắn muốn HỦY đơn hàng này? '
                        +
                        'Tồn kho sản phẩm sẽ được hoàn lại.';

                }


                if (
                    currentStatus
                    ===
                    'cancelled'
                    &&
                    newStatus
                    !==
                    'cancelled'
                ) {

                    message =
                        'Bạn muốn mở lại đơn đã hủy? '
                        +
                        'Hệ thống sẽ trừ tồn kho lại và có thể báo lỗi nếu không đủ hàng.';

                }


                if (newStatus === 'delivered') {
                    message += '\nChỉ xác nhận khi khách đã nhận hàng. Sau khi lưu, đơn hàng sẽ bị khóa trạng thái và không thể đổi lại.';
                }

                if (
                    !window.confirm(
                        message
                    )
                ) {

                    event.preventDefault();

                }

            }
        );

    }
);
</script>

@endsection