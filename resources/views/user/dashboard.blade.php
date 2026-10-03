@extends('layouts.app')

@section('title', 'Tổng quan tài khoản | Tinh Hoa Tây Bắc')

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


    $paymentConfig = [
        'unpaid' => 'Chưa thanh toán',

        'pending_confirmation' =>
            'Chờ thanh toán',

        'paid' =>
            'Đã thanh toán',

        'failed' =>
            'Thanh toán lỗi',
    ];


    $avatarUrl =
        $user->avatar
            ? (
                str_starts_with(
                    $user->avatar,
                    'http'
                )

                ? $user->avatar

                : asset(
                    'storage/'
                    .
                    ltrim(
                        $user->avatar,
                        '/'
                    )
                )
            )
            : null;


    $initial =
        mb_strtoupper(
            mb_substr(
                trim($user->name),
                0,
                1
            )
        );
@endphp


<style>
    .customer-dashboard {
        --cd-green: #35562f;
        --cd-green-dark: #274522;

        --cd-brown: #633820;
        --cd-brown-dark: #3d2316;

        --cd-red: #b43e2e;
        --cd-red-dark: #8d3025;

        --cd-gold: #e5ad42;
        --cd-gold-soft: #fff0c9;

        --cd-text: #302923;
        --cd-muted: #776d66;

        --cd-border: #e7dfd5;

        --cd-shadow:
            0 8px 28px
            rgba(54, 40, 29, .07);

        --cd-shadow-lg:
            0 18px 48px
            rgba(54, 40, 29, .12);

        color: var(--cd-text);
    }


    .customer-dashboard *,
    .customer-dashboard *::before,
    .customer-dashboard *::after {
        box-sizing: border-box;
    }


    .customer-dashboard a {
        text-decoration: none;
    }


    .cd-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 7px;

        margin-bottom: 14px;

        color: #958b84;

        font-size: 11px;
    }


    .cd-breadcrumb a {
        color: #665349;

        font-weight: 800;
    }


    .cd-breadcrumb a:hover {
        color: var(--cd-red);
    }


    /* =========================================================
       HERO
    ========================================================= */

    .cd-hero {
        position: relative;

        isolation: isolate;

        overflow: hidden;

        min-height: 205px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 30px;

        margin-bottom: 18px;

        padding:
            32px 35px;

        border-radius: 20px;

        color: #fff;

        background:
            radial-gradient(
                circle at 88% 14%,
                rgba(229,173,66,.28),
                transparent 28%
            ),
            linear-gradient(
                125deg,
                #284525 0%,
                #42663b 48%,
                #673920 100%
            );

        box-shadow:
            var(--cd-shadow-lg);
    }


    .cd-hero::before {
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


    .cd-hero::after {
        content: "";

        position: absolute;

        z-index: -1;

        right: -35px;
        bottom: -65px;

        width: 360px;
        height: 195px;

        opacity: .1;

        background: #fff;

        clip-path:
            polygon(
                0 100%,
                20% 55%,
                39% 72%,
                58% 23%,
                77% 61%,
                100% 13%,
                100% 100%
            );
    }


    .cd-hero-copy {
        position: relative;

        z-index: 2;

        max-width: 730px;
    }


    .cd-kicker {
        display: inline-flex;
        align-items: center;

        gap: 6px;

        padding:
            6px 10px;

        border:
            1px solid
            rgba(255,255,255,.16);

        border-radius: 999px;

        color: #ffdc90;

        background:
            rgba(255,255,255,.06);

        font-size: 10.5px;

        font-weight: 900;

        letter-spacing: .08em;

        text-transform: uppercase;
    }


    .cd-title {
        margin:
            11px 0 0;

        color: #fff;

        font-size:
            clamp(
                31px,
                3vw,
                43px
            );

        line-height: 1.08;

        font-weight: 950;

        letter-spacing: -.045em;
    }


    .cd-description {
        margin-top: 8px;

        color:
            rgba(255,255,255,.74);

        font-size: 13px;

        line-height: 1.65;
    }


    .cd-hero-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 8px;

        margin-top: 16px;
    }


    .cd-hero-btn {
        min-height: 41px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 5px;

        padding:
            0 13px;

        border-radius: 9px;

        font-size: 10px;

        font-weight: 900;
    }


    .cd-hero-btn.primary {
        color:
            var(--cd-brown-dark);

        background:
            #ffdc88;
    }


    .cd-hero-btn.secondary {
        color: #fff;

        border:
            1px solid
            rgba(255,255,255,.24);

        background:
            rgba(255,255,255,.07);
    }


    .cd-hero-profile {
        position: relative;

        z-index: 2;

        min-width: 215px;

        padding: 17px;

        border:
            1px solid
            rgba(255,255,255,.16);

        border-radius: 17px;

        background:
            rgba(255,255,255,.08);

        backdrop-filter:
            blur(10px);

        text-align: center;
    }


    .cd-avatar,
    .cd-avatar-fallback {
        width: 75px;
        height: 75px;

        margin:
            0 auto 10px;

        border:
            3px solid
            rgba(255,255,255,.7);

        border-radius: 50%;

        object-fit: cover;

        background:
            rgba(255,255,255,.13);
    }


    .cd-avatar-fallback {
        display: grid;
        place-items: center;

        color: #fff;

        font-size: 28px;

        font-weight: 950;
    }


    .cd-profile-name {
        color: #fff;

        font-size: 13px;

        font-weight: 950;
    }


    .cd-profile-email {
        overflow-wrap: anywhere;

        margin-top: 3px;

        color:
            rgba(255,255,255,.68);

        font-size: 9.5px;
    }


    /* =========================================================
       STATS
    ========================================================= */

    .cd-stats {
        display: grid;

        grid-template-columns:
            repeat(
                4,
                minmax(0, 1fr)
            );

        gap: 11px;

        margin-bottom: 18px;
    }


    .cd-stat {
        min-height: 105px;

        display: flex;
        align-items: center;

        gap: 12px;

        padding: 15px;

        border:
            1px solid
            var(--cd-border);

        border-radius: 15px;

        background: #fff;

        box-shadow:
            var(--cd-shadow);
    }


    .cd-stat-icon {
        width: 48px;
        height: 48px;

        flex: 0 0 48px;

        display: grid;
        place-items: center;

        border-radius: 12px;

        background:
            var(--cd-gold-soft);

        font-size: 21px;
    }


    .cd-stat:nth-child(2)
    .cd-stat-icon {
        background: #fff1c6;
    }


    .cd-stat:nth-child(3)
    .cd-stat-icon {
        background: #e8f4e5;
    }


    .cd-stat:nth-child(4)
    .cd-stat-icon {
        background: #fbe8e4;
    }


    .cd-stat-label {
        color:
            var(--cd-muted);

        font-size: 10px;

        font-weight: 750;
    }


    .cd-stat-number {
        margin-top: 3px;

        color:
            var(--cd-brown-dark);

        font-size: 23px;

        line-height: 1.05;

        font-weight: 950;

        letter-spacing: -.025em;
    }


    .cd-stat-number.money {
        color:
            var(--cd-red);

        font-size: 19px;
    }


    /* =========================================================
       MAIN GRID
    ========================================================= */

    .cd-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            315px;

        gap: 17px;

        align-items: start;
    }


    .cd-main,
    .cd-side {
        min-width: 0;

        display: grid;

        gap: 14px;
    }


    /* =========================================================
       CARD
    ========================================================= */

    .cd-card {
        overflow: hidden;

        border:
            1px solid
            var(--cd-border);

        border-radius: 16px;

        background: #fff;

        box-shadow:
            var(--cd-shadow);
    }


    .cd-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 14px;

        padding:
            15px 17px;

        border-bottom:
            1px solid
            var(--cd-border);

        background:
            linear-gradient(
                180deg,
                #fff,
                #fffcf8
            );
    }


    .cd-card-title {
        margin: 0;

        color: #453930;

        font-size: 14px;

        font-weight: 950;
    }


    .cd-card-subtitle {
        margin-top: 2px;

        color:
            var(--cd-muted);

        font-size: 9.5px;
    }


    .cd-card-link {
        color:
            var(--cd-red);

        font-size: 9.5px;

        font-weight: 900;
    }


    .cd-card-body {
        padding: 16px;
    }


    /* =========================================================
       RECENT ORDER
    ========================================================= */

    .cd-orders {
        display: grid;

        gap: 9px;
    }


    .cd-order {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            auto;

        gap: 15px;

        padding: 13px;

        border:
            1px solid #ece3da;

        border-radius: 11px;

        background:
            #fbfaf8;

        transition:
            .17s ease;
    }


    .cd-order:hover {
        border-color:
            #dbc3a4;

        background:
            #fffaf2;

        transform:
            translateY(-1px);
    }


    .cd-order-head {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 7px;
    }


    .cd-order-code {
        color:
            var(--cd-brown-dark);

        font-size: 11.5px;

        font-weight: 950;
    }


    .cd-order-date {
        color: #968a82;

        font-size: 8.5px;
    }


    .cd-status {
        display: inline-flex;
        align-items: center;

        gap: 4px;

        padding:
            5px 7px;

        border-radius: 999px;

        font-size: 8.5px;

        font-weight: 900;
    }


    .cd-status.pending {
        color: #765813;

        background: #fff0bd;
    }


    .cd-status.confirmed {
        color: #266071;

        background: #e2f3f8;
    }


    .cd-status.shipped {
        color: #285d8e;

        background: #e6effb;
    }


    .cd-status.delivered {
        color: #3b6d35;

        background: #e8f4e5;
    }


    .cd-status.cancelled {
        color: #994138;

        background: #fae8e5;
    }


    .cd-order-products {
        margin-top: 7px;

        color:
            var(--cd-muted);

        font-size: 9px;

        line-height: 1.55;
    }


    .cd-order-side {
        min-width: 125px;

        text-align: right;
    }


    .cd-order-total {
        color:
            var(--cd-red);

        font-size: 14px;

        font-weight: 950;
    }


    .cd-order-payment {
        margin-top: 3px;

        color:
            var(--cd-muted);

        font-size: 8px;
    }


    .cd-order-btn {
        min-height: 32px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        margin-top: 7px;

        padding:
            0 9px;

        border-radius: 7px;

        color: #fff;

        background:
            var(--cd-brown);

        font-size: 8.5px;

        font-weight: 900;
    }


    .cd-order-btn:hover {
        color: #fff;

        background:
            var(--cd-brown-dark);
    }


    /* =========================================================
       QUICK LINKS
    ========================================================= */

    .cd-links {
        display: grid;

        gap: 7px;
    }


    .cd-link {
        min-height: 58px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 9px;

        padding:
            10px 11px;

        border:
            1px solid #e9e1d8;

        border-radius: 10px;

        color: #52463e;

        background:
            #fbfaf8;

        transition:
            .17s ease;
    }


    .cd-link:hover {
        color:
            var(--cd-red);

        border-color:
            #ddc4a6;

        background:
            #fff9f0;

        transform:
            translateX(2px);
    }


    .cd-link-left {
        display: flex;
        align-items: center;

        gap: 9px;
    }


    .cd-link-icon {
        width: 35px;
        height: 35px;

        flex: 0 0 35px;

        display: grid;
        place-items: center;

        border-radius: 9px;

        background:
            var(--cd-gold-soft);

        font-size: 15px;
    }


    .cd-link-title {
        font-size: 10.5px;

        font-weight: 900;
    }


    .cd-link-sub {
        margin-top: 2px;

        color:
            var(--cd-muted);

        font-size: 8.5px;
    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .cd-empty {
        padding:
            38px 20px;

        text-align: center;
    }


    .cd-empty-icon {
        font-size: 42px;
    }


    .cd-empty-title {
        margin-top: 8px;

        color:
            var(--cd-brown-dark);

        font-size: 15px;

        font-weight: 950;
    }


    .cd-empty-text {
        margin:
            4px 0 13px;

        color:
            var(--cd-muted);

        font-size: 10px;
    }


    /* =========================================================
       ACCOUNT
    ========================================================= */

    .cd-account-info {
        display: grid;

        gap: 9px;
    }


    .cd-account-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;

        gap: 10px;

        padding-bottom: 9px;

        border-bottom:
            1px solid #eee7df;

        font-size: 9.5px;
    }


    .cd-account-row:last-child {
        padding-bottom: 0;

        border-bottom: 0;
    }


    .cd-account-row span {
        color:
            var(--cd-muted);
    }


    .cd-account-row strong {
        color: #493d35;

        text-align: right;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1099.98px) {

        .cd-stats {
            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );
        }


        .cd-layout {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 767.98px) {

        .cd-hero {
            align-items: flex-start;

            flex-direction: column;

            padding:
                25px 22px;
        }


        .cd-hero-profile {
            width: 100%;
        }


        .cd-stats {
            grid-template-columns: 1fr;
        }


        .cd-order {
            grid-template-columns: 1fr;
        }


        .cd-order-side {
            text-align: left;
        }

    }
</style>


<div class="customer-dashboard">


    <div class="cd-breadcrumb">

        <a href="{{ url('/') }}">
            Trang chủ
        </a>

        <span>›</span>

        <span>
            Tổng quan
        </span>

    </div>


    {{-- =====================================================
        HERO
    ====================================================== --}}
    <section class="cd-hero">


        <div class="cd-hero-copy">

            <div class="cd-kicker">
                🌿 Tài khoản Tinh Hoa Tây Bắc
            </div>


            <h1 class="cd-title">

                Xin chào,
                {{ $user->name }}

            </h1>


            <div class="cd-description">

                Theo dõi đơn hàng,
                quản lý địa chỉ,
                hồ sơ cá nhân
                và tiếp tục khám phá
                những đặc sản Tây Bắc
                bạn yêu thích.

            </div>


            <div class="cd-hero-actions">

                <a
                    href="{{ route('products.index') }}"
                    class="
                        cd-hero-btn
                        primary
                    "
                >
                    🛍 Mua sắm ngay
                </a>


                <a
                    href="{{ route('orders.index') }}"
                    class="
                        cd-hero-btn
                        secondary
                    "
                >
                    📦 Đơn hàng của tôi
                </a>

            </div>

        </div>


        <div class="cd-hero-profile">


            @if($avatarUrl)

                <img
                    src="{{ $avatarUrl }}"
                    alt="{{ $user->name }}"
                    class="cd-avatar"
                >

            @else

                <div class="cd-avatar-fallback">
                    {{ $initial }}
                </div>

            @endif


            <div class="cd-profile-name">
                {{ $user->name }}
            </div>


            <div class="cd-profile-email">
                {{ $user->email }}
            </div>

        </div>

    </section>


    {{-- =====================================================
        STATS
    ====================================================== --}}
    <div class="cd-stats">


        <div class="cd-stat">

            <div class="cd-stat-icon">
                📦
            </div>

            <div>

                <div class="cd-stat-label">
                    Tổng đơn hàng
                </div>

                <div class="cd-stat-number">
                    {{ number_format($totalOrders) }}
                </div>

            </div>

        </div>


        <div class="cd-stat">

            <div class="cd-stat-icon">
                ⏳
            </div>

            <div>

                <div class="cd-stat-label">
                    Chờ xử lý
                </div>

                <div class="cd-stat-number">
                    {{ number_format($pendingOrders) }}
                </div>

            </div>

        </div>


        <div class="cd-stat">

            <div class="cd-stat-icon">
                ✅
            </div>

            <div>

                <div class="cd-stat-label">
                    Đã giao
                </div>

                <div class="cd-stat-number">
                    {{ number_format($deliveredOrders) }}
                </div>

            </div>

        </div>


        <div class="cd-stat">

            <div class="cd-stat-icon">
                💰
            </div>

            <div>

                <div class="cd-stat-label">
                    Tổng đã mua
                </div>

                <div class="cd-stat-number money">

                    {{
                        number_format(
                            (float) $totalSpent,
                            0,
                            ',',
                            '.'
                        )
                    }}đ

                </div>

            </div>

        </div>

    </div>


    <div class="cd-layout">


        {{-- =================================================
            MAIN
        ================================================== --}}
        <main class="cd-main">


            <section class="cd-card">

                <div class="cd-card-head">

                    <div>

                        <h2 class="cd-card-title">
                            📦 Đơn hàng gần đây
                        </h2>

                        <div class="cd-card-subtitle">
                            Những đơn hàng mới nhất của bạn.
                        </div>

                    </div>


                    <a
                        href="{{ route('orders.index') }}"
                        class="cd-card-link"
                    >
                        Xem tất cả →
                    </a>

                </div>


                <div class="cd-card-body">


                    @if($recentOrders->isEmpty())

                        <div class="cd-empty">

                            <div class="cd-empty-icon">
                                📭
                            </div>


                            <div class="cd-empty-title">
                                Bạn chưa có đơn hàng
                            </div>


                            <div class="cd-empty-text">

                                Khám phá đặc sản Tây Bắc
                                và tạo đơn hàng đầu tiên.

                            </div>


                            <a
                                href="{{ route('products.index') }}"
                                class="
                                    cd-hero-btn
                                    primary
                                "
                            >
                                🛍 Mua sắm ngay
                            </a>

                        </div>


                    @else

                        <div class="cd-orders">


                            @foreach($recentOrders as $order)

                                @php
                                    $status =
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


                                    $paymentLabel =
                                        $paymentConfig[
                                            $order
                                                ->payment_status
                                        ]
                                        ??
                                        'Chưa xác định';
                                @endphp


                                <article class="cd-order">


                                    <div>


                                        <div class="cd-order-head">

                                            <span class="cd-order-code">

                                                #{{
                                                    str_pad(
                                                        $order->id,
                                                        6,
                                                        '0',
                                                        STR_PAD_LEFT
                                                    )
                                                }}

                                            </span>


                                            <span
                                                class="
                                                    cd-status
                                                    {{
                                                        $status['class']
                                                    }}
                                                "
                                            >

                                                {{ $status['icon'] }}

                                                {{ $status['label'] }}

                                            </span>


                                            <span class="cd-order-date">

                                                {{
                                                    $order
                                                        ->created_at
                                                        ->format(
                                                            'H:i · d/m/Y'
                                                        )
                                                }}

                                            </span>

                                        </div>


                                        <div class="cd-order-products">


                                            @foreach($order->items->take(2) as $item)

                                                <div>

                                                    📦
                                                    {{
                                                        $item
                                                            ->product
                                                            ?->name
                                                        ??
                                                        'Sản phẩm'
                                                    }}

                                                    ×

                                                    {{
                                                        rtrim(
                                                            rtrim(
                                                                number_format(
                                                                    (float)
                                                                    $item
                                                                        ->quantity,
                                                                    2,
                                                                    '.',
                                                                    ''
                                                                ),
                                                                '0'
                                                            ),
                                                            '.'
                                                        )
                                                    }}

                                                </div>

                                            @endforeach


                                            @if($order->items->count() > 2)

                                                <div>

                                                    +
                                                    {{
                                                        $order
                                                            ->items
                                                            ->count()
                                                        -
                                                        2
                                                    }}
                                                    sản phẩm khác

                                                </div>

                                            @endif

                                        </div>

                                    </div>


                                    <div class="cd-order-side">

                                        <div class="cd-order-total">

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


                                        <div class="cd-order-payment">
                                            {{ $paymentLabel }}
                                        </div>


                                        <a
                                            href="{{
                                                route(
                                                    'orders.show',
                                                    $order
                                                )
                                            }}"
                                            class="cd-order-btn"
                                        >
                                            Xem chi tiết →
                                        </a>

                                    </div>

                                </article>

                            @endforeach

                        </div>

                    @endif

                </div>

            </section>

        </main>


        {{-- =================================================
            SIDE
        ================================================== --}}
        <aside class="cd-side">


            <section class="cd-card">

                <div class="cd-card-head">

                    <div>

                        <h2 class="cd-card-title">
                            ⚡ Truy cập nhanh
                        </h2>

                    </div>

                </div>


                <div class="cd-card-body">

                    <div class="cd-links">


                        <a
                            href="{{ route('profile') }}"
                            class="cd-link"
                        >

                            <span class="cd-link-left">

                                <span class="cd-link-icon">
                                    👤
                                </span>

                                <span>

                                    <span class="cd-link-title">
                                        Hồ sơ cá nhân
                                    </span>

                                    <span class="cd-link-sub">
                                        Tên, avatar, mật khẩu
                                    </span>

                                </span>

                            </span>

                            <span>›</span>

                        </a>


                        <a
                            href="{{ route('profile') . '#shipping-addresses' }}"
                            class="cd-link"
                        >

                            <span class="cd-link-left">

                                <span class="cd-link-icon">
                                    📍
                                </span>

                                <span>

                                    <span class="cd-link-title">
                                        Địa chỉ giao hàng
                                    </span>

                                    <span class="cd-link-sub">
                                        Quản lý nơi nhận hàng
                                    </span>

                                </span>

                            </span>

                            <span>›</span>

                        </a>


                        <a
                            href="{{ route('cart.index') }}"
                            class="cd-link"
                        >

                            <span class="cd-link-left">

                                <span class="cd-link-icon">
                                    🛒
                                </span>

                                <span>

                                    <span class="cd-link-title">
                                        Giỏ hàng
                                    </span>

                                    <span class="cd-link-sub">
                                        Xem sản phẩm đã chọn
                                    </span>

                                </span>

                            </span>

                            <span>›</span>

                        </a>


                        <a
                            href="{{ route('products.promotions') }}"
                            class="cd-link"
                        >

                            <span class="cd-link-left">

                                <span class="cd-link-icon">
                                    🔥
                                </span>

                                <span>

                                    <span class="cd-link-title">
                                        Khuyến mãi
                                    </span>

                                    <span class="cd-link-sub">
                                        Sản phẩm đang giảm giá
                                    </span>

                                </span>

                            </span>

                            <span>›</span>

                        </a>

                    </div>

                </div>

            </section>


            <section class="cd-card">

                <div class="cd-card-head">

                    <div>

                        <h2 class="cd-card-title">
                            👤 Tài khoản
                        </h2>

                    </div>

                </div>


                <div class="cd-card-body">

                    <div class="cd-account-info">


                        <div class="cd-account-row">

                            <span>
                                Email
                            </span>

                            <strong>
                                {{ $user->email }}
                            </strong>

                        </div>


                        <div class="cd-account-row">

                            <span>
                                Xác thực
                            </span>

                            <strong>

                                {{
                                    $user
                                        ->email_verified_at
                                    ? '✓ Đã xác thực'
                                    : '⚠️ Chưa xác thực'
                                }}

                            </strong>

                        </div>


                        <div class="cd-account-row">

                            <span>
                                Thành viên từ
                            </span>

                            <strong>

                                {{
                                    $user
                                        ->created_at
                                        ->format(
                                            'd/m/Y'
                                        )
                                }}

                            </strong>

                        </div>

                    </div>

                </div>

            </section>

        </aside>

    </div>

</div>

@endsection