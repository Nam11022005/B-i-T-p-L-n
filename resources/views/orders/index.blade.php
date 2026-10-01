@extends('layouts.app')

@section('title', 'Đơn hàng của tôi | Tinh Hoa Tây Bắc')

@section('content')

@php
    $statusConfig = [
        'pending' => [
            'label' => 'Chờ xác nhận',
            'icon' => '⏳',
            'class' => 'pending',
        ],

        'confirmed' => [
            'label' => 'Đã xác nhận',
            'icon' => '✓',
            'class' => 'confirmed',
        ],

        'shipped' => [
            'label' => 'Đang giao',
            'icon' => '🚚',
            'class' => 'shipped',
        ],

        'delivered' => [
            'label' => 'Đã giao',
            'icon' => '✅',
            'class' => 'delivered',
        ],

        'cancelled' => [
            'label' => 'Đã hủy',
            'icon' => '✕',
            'class' => 'cancelled',
        ],
    ];


    $paymentStatusConfig = [
        'unpaid' => [
            'label' => 'Chưa thanh toán',
            'class' => 'unpaid',
        ],

        'pending_confirmation' => [
            'label' => 'Chờ xác nhận thanh toán',
            'class' => 'pending',
        ],

        'paid' => [
            'label' => 'Đã thanh toán',
            'class' => 'paid',
        ],

        'failed' => [
            'label' => 'Thanh toán lỗi',
            'class' => 'failed',
        ],
    ];


    $shippingMethodConfig = [
        'standard' => 'Giao tiết kiệm',
        'fast' => 'Giao nhanh',
        'express' => 'Hỏa tốc',
    ];


    $paymentMethodConfig = [
        'cod' => 'Thanh toán khi nhận hàng',
        'bank' => 'Chuyển khoản ngân hàng',
    ];


    $currentStatus =
        request('status');
@endphp


<style>
    .orders-shop {
        --order-green: #35562f;
        --order-green-dark: #274522;

        --order-brown: #633820;
        --order-brown-dark: #3d2316;

        --order-red: #b43e2e;
        --order-red-dark: #8d3025;

        --order-gold: #e5ad42;

        --order-text: #302923;
        --order-muted: #776d66;

        --order-border: #e7dfd5;

        --order-shadow:
            0 8px 28px
            rgba(54, 40, 29, .07);

        --order-shadow-hover:
            0 17px 42px
            rgba(54, 40, 29, .12);

        color: var(--order-text);
    }


    .orders-shop *,
    .orders-shop *::before,
    .orders-shop *::after {
        box-sizing: border-box;
    }


    .orders-shop a {
        text-decoration: none;
    }


    /* =========================================================
       BREADCRUMB
    ========================================================= */

    .orders-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 7px;

        margin-bottom: 14px;

        color: #958b84;

        font-size: 11px;
    }


    .orders-breadcrumb a {
        color: #665349;

        font-weight: 800;
    }


    .orders-breadcrumb a:hover {
        color: var(--order-red);
    }


    /* =========================================================
       HERO
    ========================================================= */

    .orders-hero {
        position: relative;

        isolation: isolate;

        overflow: hidden;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 30px;

        min-height: 185px;

        margin-bottom: 18px;

        padding:
            30px 34px;

        border-radius: 19px;

        color: #fff;

        background:
            radial-gradient(
                circle at 88% 16%,
                rgba(229,173,66,.26),
                transparent 28%
            ),
            linear-gradient(
                125deg,
                #284525 0%,
                #3f6338 46%,
                #673a23 100%
            );

        box-shadow: var(--order-shadow);
    }


    .orders-hero::before {
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
                transparent 23px
            );
    }


    .orders-hero::after {
        content: "";

        position: absolute;

        z-index: -1;

        right: -35px;
        bottom: -55px;

        width: 330px;
        height: 180px;

        opacity: .11;

        background: #fff;

        clip-path:
            polygon(
                0 100%,
                20% 53%,
                38% 72%,
                58% 24%,
                77% 60%,
                100% 13%,
                100% 100%
            );
    }


    .orders-hero-copy {
        position: relative;

        z-index: 2;

        max-width: 760px;
    }


    .orders-kicker {
        display: inline-flex;
        align-items: center;

        gap: 5px;

        padding:
            6px 10px;

        border:
            1px solid
            rgba(255,255,255,.15);

        border-radius: 999px;

        color: #ffdc91;

        background:
            rgba(255,255,255,.06);

        font-size: 10.5px;

        font-weight: 900;

        letter-spacing: .08em;

        text-transform: uppercase;
    }


    .orders-title {
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


    .orders-hero-description {
        max-width: 650px;

        margin-top: 8px;

        color:
            rgba(255,255,255,.72);

        font-size: 12.5px;

        line-height: 1.65;
    }


    .orders-hero-art {
        position: relative;

        z-index: 2;

        width: 105px;
        height: 105px;

        flex: 0 0 105px;

        display: grid;
        place-items: center;

        border:
            1px solid
            rgba(255,255,255,.15);

        border-radius: 27px;

        background:
            rgba(255,255,255,.07);

        font-size: 50px;

        transform: rotate(4deg);
    }


    /* =========================================================
       STATS
    ========================================================= */

    .orders-stats {
        display: grid;

        grid-template-columns:
            repeat(
                3,
                minmax(0, 1fr)
            );

        gap: 12px;

        margin-bottom: 17px;
    }


    .orders-stat {
        position: relative;

        overflow: hidden;

        min-height: 106px;

        display: flex;
        align-items: center;

        gap: 13px;

        padding:
            16px;

        border:
            1px solid
            var(--order-border);

        border-radius: 14px;

        background: #fff;

        box-shadow:
            var(--order-shadow);
    }


    .orders-stat-icon {
        width: 49px;
        height: 49px;

        flex: 0 0 49px;

        display: grid;
        place-items: center;

        border-radius: 13px;

        background:
            #fff0cf;

        font-size: 22px;
    }


    .orders-stat-label {
        color:
            var(--order-muted);

        font-size: 10.5px;

        font-weight: 750;
    }


    .orders-stat-number {
        margin-top: 2px;

        color:
            var(--order-brown-dark);

        font-size: 25px;

        line-height: 1;

        font-weight: 950;
    }


    .orders-stat.shipped
    .orders-stat-icon {
        background: #edf4ff;
    }


    .orders-stat.delivered
    .orders-stat-icon {
        background: #edf6e9;
    }


    /* =========================================================
       FILTERS
    ========================================================= */

    .orders-filter {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        margin-bottom: 15px;

        padding:
            11px 12px;

        border:
            1px solid
            var(--order-border);

        border-radius: 13px;

        background: #fff;

        box-shadow:
            var(--order-shadow);
    }


    .orders-filter-title {
        flex: 0 0 auto;

        color: #55483f;

        font-size: 11px;

        font-weight: 900;
    }


    .orders-filter-list {
        flex: 1;

        display: flex;
        align-items: center;

        gap: 6px;

        overflow-x: auto;

        scrollbar-width: none;
    }


    .orders-filter-list::-webkit-scrollbar {
        display: none;
    }


    .orders-filter-link {
        min-height: 34px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 5px;

        padding:
            0 11px;

        border:
            1px solid #e0d6cc;

        border-radius: 999px;

        color: #65584f;

        background: #fff;

        font-size: 9.5px;

        font-weight: 850;

        white-space: nowrap;

        transition:
            .17s ease;
    }


    .orders-filter-link:hover {
        color:
            var(--order-red);

        border-color:
            #dbbcb3;

        background:
            #fff8f5;
    }


    .orders-filter-link.active {
        color: #fff;

        border-color:
            var(--order-brown);

        background:
            var(--order-brown);
    }


    /* =========================================================
       ORDER LIST
    ========================================================= */

    .orders-list {
        display: grid;

        gap: 13px;
    }


    .order-card {
        overflow: hidden;

        border:
            1px solid
            var(--order-border);

        border-radius: 16px;

        background: #fff;

        box-shadow:
            var(--order-shadow);

        transition:
            transform .18s ease,
            box-shadow .18s ease,
            border-color .18s ease;
    }


    .order-card:hover {
        border-color: #dbc3a5;

        transform:
            translateY(-2px);

        box-shadow:
            var(--order-shadow-hover);
    }


    /* =========================================================
       ORDER HEADER
    ========================================================= */

    .order-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        padding:
            14px 16px;

        border-bottom:
            1px solid
            var(--order-border);

        background:
            linear-gradient(
                180deg,
                #fffdf9,
                #fffaf3
            );
    }


    .order-code-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 8px;
    }


    .order-code {
        color:
            var(--order-brown-dark);

        font-size: 15px;

        font-weight: 950;

        letter-spacing: -.015em;
    }


    .order-date {
        color:
            var(--order-muted);

        font-size: 9.5px;
    }


    .order-status {
        display: inline-flex;
        align-items: center;

        gap: 5px;

        padding:
            6px 9px;

        border-radius: 999px;

        font-size: 9.5px;

        font-weight: 900;

        white-space: nowrap;
    }


    .order-status.pending {
        color: #785914;

        background: #fff1bf;
    }


    .order-status.confirmed {
        color: #266577;

        background: #e3f4f9;
    }


    .order-status.shipped {
        color: #285d91;

        background: #e8f1fc;
    }


    .order-status.delivered {
        color: #3d7035;

        background: #e9f5e6;
    }


    .order-status.cancelled {
        color: #a53e33;

        background: #fbe9e7;
    }


    /* =========================================================
       ORDER BODY
    ========================================================= */

    .order-card-body {
        padding:
            14px 16px;
    }


    .order-products {
        display: grid;

        gap: 0;
    }


    .order-product {
        display: grid;

        grid-template-columns:
            67px
            minmax(0, 1fr)
            auto;

        align-items: center;

        gap: 11px;

        padding:
            10px 0;

        border-bottom:
            1px solid #eee7df;
    }


    .order-product:last-child {
        border-bottom: 0;
    }


    .order-product-media {
        width: 67px;
        height: 67px;

        overflow: hidden;

        border:
            1px solid #e8ded3;

        border-radius: 10px;

        background:
            #faf8f5;
    }


    .order-product-media img {
        width: 100%;
        height: 100%;

        padding: 3px;

        object-fit: contain;
    }


    .order-product-fallback {
        width: 100%;
        height: 100%;

        display: grid;
        place-items: center;

        color: #9a8c80;

        font-size: 25px;
    }


    .order-product-info {
        min-width: 0;
    }


    .order-product-name {
        color: #38302a;

        font-size: 11.5px;

        line-height: 1.4;

        font-weight: 900;

        display: -webkit-box;

        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;

        overflow: hidden;
    }


    .order-product-meta {
        margin-top: 4px;

        color:
            var(--order-muted);

        font-size: 9px;
    }


    .order-product-price {
        color:
            var(--order-brown-dark);

        font-size: 11px;

        font-weight: 950;

        white-space: nowrap;
    }


    .order-more-products {
        padding-top: 7px;

        color:
            var(--order-muted);

        font-size: 9.5px;

        font-weight: 750;
    }


    /* =========================================================
       ORDER INFO STRIP
    ========================================================= */

    .order-info-strip {
        display: grid;

        grid-template-columns:
            repeat(
                3,
                minmax(0, 1fr)
            );

        gap: 8px;

        margin-top: 12px;
    }


    .order-info-item {
        min-width: 0;

        padding:
            9px 10px;

        border:
            1px solid #eee6dc;

        border-radius: 9px;

        background:
            #fbfaf8;
    }


    .order-info-label {
        color:
            #948980;

        font-size: 8.5px;
    }


    .order-info-value {
        overflow: hidden;

        margin-top: 2px;

        color: #51453d;

        font-size: 9.5px;

        font-weight: 850;

        white-space: nowrap;

        text-overflow: ellipsis;
    }


    /* =========================================================
       PAYMENT BADGE
    ========================================================= */

    .payment-status {
        display: inline-flex;
        align-items: center;

        gap: 4px;

        padding:
            4px 7px;

        border-radius: 999px;

        font-size: 8.5px;

        font-weight: 900;
    }


    .payment-status.unpaid {
        color: #9b493e;

        background: #faeae7;
    }


    .payment-status.pending {
        color: #7b5b15;

        background: #fff2c8;
    }


    .payment-status.paid {
        color: #3e7437;

        background: #e9f5e6;
    }


    .payment-status.failed {
        color: #9e3831;

        background: #f9e3e1;
    }


    /* =========================================================
       FOOTER
    ========================================================= */

    .order-card-foot {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;

        gap: 18px;

        padding:
            13px 16px;

        border-top:
            1px solid
            var(--order-border);

        background:
            #fdfbf8;
    }


    .order-foot-note {
        color:
            var(--order-muted);

        font-size: 9px;

        line-height: 1.5;
    }


    .order-total-block {
        text-align: right;
    }


    .order-total-label {
        color:
            var(--order-muted);

        font-size: 9px;
    }


    .order-total {
        margin-top: 1px;

        color:
            var(--order-red);

        font-size: 20px;

        line-height: 1.1;

        font-weight: 950;

        letter-spacing: -.025em;
    }


    .order-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 7px;

        margin-top: 8px;
    }


    .order-detail-btn {
        min-height: 37px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 5px;

        padding:
            0 12px;

        border-radius: 8px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--order-red),
                var(--order-red-dark)
            );

        font-size: 9.5px;

        font-weight: 900;

        transition:
            .17s ease;
    }


    .order-detail-btn:hover {
        color: #fff;

        transform:
            translateY(-1px);

        box-shadow:
            0 7px 15px
            rgba(180,62,46,.19);
    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .orders-empty {
        min-height: 405px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding:
            35px;

        border:
            1px dashed #ddc8aa;

        border-radius: 17px;

        background:
            radial-gradient(
                circle at 50% 0,
                rgba(229,173,66,.14),
                transparent 30%
            ),
            #fff;

        text-align: center;

        box-shadow:
            var(--order-shadow);
    }


    .orders-empty-icon {
        width: 83px;
        height: 83px;

        display: grid;
        place-items: center;

        margin:
            0 auto 13px;

        border-radius: 50%;

        background: #fff0ce;

        font-size: 35px;
    }


    .orders-empty h2 {
        margin: 0;

        color: var(--order-text);

        font-size: 21px;

        font-weight: 950;
    }


    .orders-empty p {
        max-width: 430px;

        margin:
            7px auto 16px;

        color:
            var(--order-muted);

        font-size: 10.5px;

        line-height: 1.6;
    }


    .orders-shop-btn {
        min-height: 41px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0 14px;

        border-radius: 9px;

        color: #fff;

        background:
            var(--order-green);

        font-size: 10px;

        font-weight: 900;
    }


    .orders-shop-btn:hover {
        color: #fff;

        background:
            var(--order-green-dark);
    }


    /* =========================================================
       PAGINATION
    ========================================================= */

    .orders-pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;

        gap: 5px;

        margin-top: 25px;
    }


    .orders-page-btn {
        min-width: 36px;
        height: 36px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0 9px;

        border:
            1px solid #ddd2c7;

        border-radius: 8px;

        color:
            var(--order-brown);

        background: #fff;

        font-size: 9.5px;

        font-weight: 900;
    }


    .orders-page-btn:hover {
        color: #fff;

        border-color:
            var(--order-brown);

        background:
            var(--order-brown);
    }


    .orders-page-btn.active {
        color: #fff;

        border-color:
            var(--order-red);

        background:
            var(--order-red);
    }


    .orders-page-btn.disabled {
        color: #aaa39d;

        border-color: #e8e3de;

        background: #f6f5f4;

        cursor: default;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .orders-filter {
            align-items: flex-start;

            flex-direction: column;
        }


        .orders-filter-list {
            width: 100%;
        }

    }


    @media (max-width: 767.98px) {

        .orders-hero {
            align-items: flex-start;

            flex-direction: column;

            padding:
                25px 22px;
        }


        .orders-hero-art {
            display: none;
        }


        .orders-stats {
            grid-template-columns: 1fr;
        }


        .order-info-strip {
            grid-template-columns: 1fr;
        }


        .order-card-foot {
            align-items: flex-start;

            flex-direction: column;
        }


        .order-total-block {
            width: 100%;

            text-align: left;
        }


        .order-actions {
            justify-content: flex-start;
        }

    }


    @media (max-width: 575.98px) {

        .order-card-head {
            align-items: flex-start;

            flex-direction: column;
        }


        .order-product {
            grid-template-columns:
                57px
                minmax(0, 1fr);
        }


        .order-product-media {
            width: 57px;
            height: 57px;
        }


        .order-product-price {
            grid-column: 2;

            justify-self: start;
        }


        .order-total {
            font-size: 18px;
        }

    }
</style>


<div class="orders-shop">


    {{-- =====================================================
        BREADCRUMB
    ====================================================== --}}
    <div class="orders-breadcrumb">

        <a href="{{ url('/') }}">
            Trang chủ
        </a>

        <span>›</span>

        <span>
            Đơn hàng của tôi
        </span>

    </div>


    {{-- =====================================================
        HERO
    ====================================================== --}}
    <section class="orders-hero">

        <div class="orders-hero-copy">

            <div class="orders-kicker">
                🌿 Tinh Hoa Tây Bắc
            </div>


            <h1 class="orders-title">
                Đơn hàng của tôi
            </h1>


            <div class="orders-hero-description">

                Theo dõi trạng thái xác nhận,
                vận chuyển, thanh toán
                và xem lại những đặc sản
                bạn đã đặt mua.

            </div>

        </div>


        <div
            class="orders-hero-art"
            aria-hidden="true"
        >
            📦
        </div>

    </section>


    {{-- =====================================================
        STATS
    ====================================================== --}}
    <div class="orders-stats">


        <div class="orders-stat">

            <div class="orders-stat-icon">
                📋
            </div>


            <div>

                <div class="orders-stat-label">
                    Tổng đơn hàng
                </div>


                <div class="orders-stat-number">
                    {{ number_format($totalOrders) }}
                </div>

            </div>

        </div>


        <div class="orders-stat shipped">

            <div class="orders-stat-icon">
                🚚
            </div>


            <div>

                <div class="orders-stat-label">
                    Đang giao
                </div>


                <div class="orders-stat-number">
                    {{ number_format($totalShipped) }}
                </div>

            </div>

        </div>


        <div class="orders-stat delivered">

            <div class="orders-stat-icon">
                ✅
            </div>


            <div>

                <div class="orders-stat-label">
                    Đã giao thành công
                </div>


                <div class="orders-stat-number">
                    {{ number_format($totalDelivered) }}
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
        FILTERS
    ====================================================== --}}
    <div class="orders-filter">

        <div class="orders-filter-title">
            Lọc đơn hàng:
        </div>


        <div class="orders-filter-list">


            <a
                href="{{ route('orders.index') }}"
                class="
                    orders-filter-link
                    {{
                        !$currentStatus
                        ? 'active'
                        : ''
                    }}
                "
            >
                📋 Tất cả
            </a>


            <a
                href="{{
                    route(
                        'orders.index',
                        [
                            'status'
                            =>
                            'pending'
                        ]
                    )
                }}"
                class="
                    orders-filter-link
                    {{
                        $currentStatus
                        ===
                        'pending'
                        ? 'active'
                        : ''
                    }}
                "
            >
                ⏳ Chờ xác nhận
            </a>


            <a
                href="{{
                    route(
                        'orders.index',
                        [
                            'status'
                            =>
                            'confirmed'
                        ]
                    )
                }}"
                class="
                    orders-filter-link
                    {{
                        $currentStatus
                        ===
                        'confirmed'
                        ? 'active'
                        : ''
                    }}
                "
            >
                ✓ Đã xác nhận
            </a>


            <a
                href="{{
                    route(
                        'orders.index',
                        [
                            'status'
                            =>
                            'shipped'
                        ]
                    )
                }}"
                class="
                    orders-filter-link
                    {{
                        $currentStatus
                        ===
                        'shipped'
                        ? 'active'
                        : ''
                    }}
                "
            >
                🚚 Đang giao
            </a>


            <a
                href="{{
                    route(
                        'orders.index',
                        [
                            'status'
                            =>
                            'delivered'
                        ]
                    )
                }}"
                class="
                    orders-filter-link
                    {{
                        $currentStatus
                        ===
                        'delivered'
                        ? 'active'
                        : ''
                    }}
                "
            >
                ✅ Đã giao
            </a>


            <a
                href="{{
                    route(
                        'orders.index',
                        [
                            'status'
                            =>
                            'cancelled'
                        ]
                    )
                }}"
                class="
                    orders-filter-link
                    {{
                        $currentStatus
                        ===
                        'cancelled'
                        ? 'active'
                        : ''
                    }}
                "
            >
                ✕ Đã hủy
            </a>

        </div>

    </div>


    {{-- =====================================================
        EMPTY
    ====================================================== --}}
    @if($orders->isEmpty())

        <div class="orders-empty">

            <div>

                <div class="orders-empty-icon">

                    {{
                        $currentStatus
                        ? '🔎'
                        : '📦'
                    }}

                </div>


                <h2>

                    {{
                        $currentStatus
                        ? 'Không có đơn hàng phù hợp'
                        : 'Bạn chưa có đơn hàng'
                    }}

                </h2>


                <p>

                    @if($currentStatus)

                        Hiện không có đơn hàng
                        trong trạng thái bạn đang chọn.
                        Hãy thử xem tất cả đơn hàng.

                    @else

                        Giỏ hàng đang chờ những
                        đặc sản Tây Bắc bạn yêu thích.
                        Hãy khám phá sản phẩm
                        và tạo đơn hàng đầu tiên.

                    @endif

                </p>


                @if($currentStatus)

                    <a
                        href="{{ route('orders.index') }}"
                        class="orders-shop-btn"
                    >
                        📋 Xem tất cả đơn hàng
                    </a>

                @else

                    <a
                        href="{{ route('products.index') }}"
                        class="orders-shop-btn"
                    >
                        🌿 Mua sắm ngay →
                    </a>

                @endif

            </div>

        </div>


    {{-- =====================================================
        ORDERS
    ====================================================== --}}
    @else

        <div class="orders-list">


            @foreach($orders as $order)

                @php
                    $orderStatus =
                        $statusConfig[
                            $order->status
                        ]
                        ??
                        [
                            'label'
                                =>
                                'Không xác định',

                            'icon'
                                =>
                                '📦',

                            'class'
                                =>
                                'pending',
                        ];


                    $paymentStatus =
                        $paymentStatusConfig[
                            $order
                                ->payment_status
                        ]
                        ??
                        [
                            'label'
                                =>
                                $order
                                    ->payment_status
                                ??
                                'Chưa xác định',

                            'class'
                                =>
                                'unpaid',
                        ];


                    $firstItems =
                        $order
                            ->items
                            ->take(2);


                    $remainingItems =
                        max(
                            $order
                                ->items
                                ->count()
                            -
                            $firstItems
                                ->count(),
                            0
                        );


                    $shippingLabel =
                        $shippingMethodConfig[
                            $order
                                ->shipping_method
                        ]
                        ??
                        (
                            $order
                                ->shipping_method
                            ??
                            'Chưa xác định'
                        );


                    $paymentLabel =
                        $paymentMethodConfig[
                            $order
                                ->payment_method
                        ]
                        ??
                        (
                            $order
                                ->payment_method
                            ??
                            'Chưa xác định'
                        );
                @endphp


                <article class="order-card">


                    {{-- =========================================
                        HEADER
                    ========================================== --}}
                    <div class="order-card-head">


                        <div>

                            <div class="order-code-row">

                                <span class="order-code">

                                    Đơn hàng
                                    #{{ str_pad(
                                        $order->id,
                                        6,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}

                                </span>


                                <span
                                    class="
                                        payment-status
                                        {{
                                            $paymentStatus['class']
                                        }}
                                    "
                                >
                                    💳
                                    {{ $paymentStatus['label'] }}
                                </span>

                            </div>


                            <div class="order-date">

                                🕐 Đặt lúc

                                {{
                                    $order
                                        ->created_at
                                        ->format(
                                            'H:i · d/m/Y'
                                        )
                                }}

                            </div>

                        </div>


                        <span
                            class="
                                order-status
                                {{
                                    $orderStatus['class']
                                }}
                            "
                        >

                            {{ $orderStatus['icon'] }}

                            {{ $orderStatus['label'] }}

                        </span>

                    </div>


                    {{-- =========================================
                        BODY
                    ========================================== --}}
                    <div class="order-card-body">


                        <div class="order-products">


                            @foreach($firstItems as $item)

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


                                    $itemUnit =
                                        $product?->unit
                                        ??
                                        'sản phẩm';


                                    $itemTotal =
                                        (float)
                                        $item->price
                                        *
                                        (float)
                                        $item->quantity;
                                @endphp


                                <div class="order-product">


                                    <div class="order-product-media">

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
                                                class="order-product-fallback"
                                                style="display:none;"
                                            >
                                                🧺
                                            </div>

                                        @else

                                            <div class="order-product-fallback">
                                                🧺
                                            </div>

                                        @endif

                                    </div>


                                    <div class="order-product-info">

                                        <div class="order-product-name">

                                            {{
                                                $product?->name
                                                ??
                                                'Sản phẩm không còn tồn tại'
                                            }}

                                        </div>


                                        <div class="order-product-meta">

                                            {{
                                                rtrim(
                                                    rtrim(
                                                        number_format(
                                                            (float)
                                                            $item->quantity,
                                                            2,
                                                            '.',
                                                            ''
                                                        ),
                                                        '0'
                                                    ),
                                                    '.'
                                                )
                                            }}

                                            {{ $itemUnit }}

                                            ×

                                            {{
                                                number_format(
                                                    (float)
                                                    $item->price,
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }}đ

                                        </div>

                                    </div>


                                    <div class="order-product-price">

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

                            @endforeach

                        </div>


                        @if($remainingItems > 0)

                            <div class="order-more-products">

                                ＋ Còn
                                {{ $remainingItems }}
                                dòng sản phẩm khác
                                trong đơn hàng.

                            </div>

                        @endif


                        {{-- =========================================
                            INFO STRIP
                        ========================================== --}}
                        <div class="order-info-strip">


                            <div class="order-info-item">

                                <div class="order-info-label">
                                    🚚 Vận chuyển
                                </div>

                                <div class="order-info-value">
                                    {{ $shippingLabel }}
                                </div>

                            </div>


                            <div class="order-info-item">

                                <div class="order-info-label">
                                    💳 Thanh toán
                                </div>

                                <div class="order-info-value">
                                    {{ $paymentLabel }}
                                </div>

                            </div>


                            <div class="order-info-item">

                                <div class="order-info-label">
                                    📦 Số dòng sản phẩm
                                </div>

                                <div class="order-info-value">

                                    {{
                                        $order
                                            ->items
                                            ->count()
                                    }}
                                    sản phẩm

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =========================================
                        FOOT
                    ========================================== --}}
                    <div class="order-card-foot">


                        <div class="order-foot-note">

                            Cập nhật gần nhất:

                            <strong>

                                {{
                                    $order
                                        ->updated_at
                                        ->format(
                                            'H:i · d/m/Y'
                                        )
                                }}

                            </strong>


                            @if($order->voucher_code)

                                <br>

                                🎟 Voucher:

                                <strong>
                                    {{ $order->voucher_code }}
                                </strong>

                            @endif

                        </div>


                        <div class="order-total-block">

                            <div class="order-total-label">
                                Tổng thanh toán
                            </div>


                            <div class="order-total">

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


                            <div class="order-actions">

                                <a
                                    href="{{
                                        route(
                                            'orders.show',
                                            $order
                                        )
                                    }}"
                                    class="order-detail-btn"
                                >
                                    Xem chi tiết →
                                </a>

                            </div>

                        </div>

                    </div>

                </article>

            @endforeach

        </div>


        {{-- =================================================
            PAGINATION
        ================================================== --}}
        @if($orders->hasPages())

            <div class="orders-pagination">


                @if($orders->onFirstPage())

                    <span
                        class="
                            orders-page-btn
                            disabled
                        "
                    >
                        ‹
                    </span>

                @else

                    <a
                        href="{{ $orders->previousPageUrl() }}"
                        class="orders-page-btn"
                    >
                        ‹
                    </a>

                @endif


                @for($page = 1; $page <= $orders->lastPage(); $page++)

                    @if($page === $orders->currentPage())

                        <span
                            class="
                                orders-page-btn
                                active
                            "
                        >
                            {{ $page }}
                        </span>

                    @else

                        <a
                            href="{{ $orders->url($page) }}"
                            class="orders-page-btn"
                        >
                            {{ $page }}
                        </a>

                    @endif

                @endfor


                @if($orders->hasMorePages())

                    <a
                        href="{{ $orders->nextPageUrl() }}"
                        class="orders-page-btn"
                    >
                        ›
                    </a>

                @else

                    <span
                        class="
                            orders-page-btn
                            disabled
                        "
                    >
                        ›
                    </span>

                @endif

            </div>

        @endif

    @endif

</div>

@endsection