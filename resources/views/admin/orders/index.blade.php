@extends('layouts.app')

@section('title', 'Quản lý đơn hàng | Tinh Hoa Tây Bắc')

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
        'unpaid' => [
            'label' => 'Chưa thanh toán',
            'class' => 'unpaid',
        ],

        'pending_confirmation' => [
            'label' => 'Chờ xác nhận',
            'class' => 'waiting',
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
@endphp


<style>
    .admin-orders-page {
        --ao-green: #35562f;
        --ao-green-dark: #274522;

        --ao-brown: #633820;
        --ao-brown-dark: #3d2316;

        --ao-red: #b43e2e;
        --ao-red-dark: #8d3025;

        --ao-gold: #e5ad42;

        --ao-text: #302923;
        --ao-muted: #776d66;

        --ao-border: #e7dfd5;

        --ao-shadow:
            0 8px 28px
            rgba(54, 40, 29, .07);

        --ao-shadow-hover:
            0 17px 42px
            rgba(54, 40, 29, .12);

        color: var(--ao-text);
    }


    .admin-orders-page *,
    .admin-orders-page *::before,
    .admin-orders-page *::after {
        box-sizing: border-box;
    }


    .admin-orders-page a {
        text-decoration: none;
    }


    /* =========================================================
       BREADCRUMB
    ========================================================= */

    .ao-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;

        gap: 7px;

        margin-bottom: 14px;

        color: #958b84;

        font-size: 11px;
    }


    .ao-breadcrumb a {
        color: #665349;

        font-weight: 800;
    }


    .ao-breadcrumb a:hover {
        color: var(--ao-red);
    }


    /* =========================================================
       HERO
    ========================================================= */

    .ao-hero {
        position: relative;

        isolation: isolate;

        overflow: hidden;

        min-height: 180px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 25px;

        margin-bottom: 18px;

        padding:
            29px 32px;

        border-radius: 19px;

        color: #fff;

        background:
            radial-gradient(
                circle at 88% 14%,
                rgba(229,173,66,.25),
                transparent 27%
            ),
            linear-gradient(
                125deg,
                #2d1a11 0%,
                #643820 52%,
                #395633 100%
            );

        box-shadow: var(--ao-shadow-hover);
    }


    .ao-hero::before {
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


    .ao-hero::after {
        content: "";

        position: absolute;

        z-index: -1;

        right: -35px;
        bottom: -60px;

        width: 330px;
        height: 190px;

        opacity: .1;

        background: #fff;

        clip-path:
            polygon(
                0 100%,
                19% 54%,
                37% 73%,
                57% 23%,
                76% 61%,
                100% 13%,
                100% 100%
            );
    }


    .ao-hero-copy {
        position: relative;

        z-index: 2;
    }


    .ao-kicker {
        display: inline-flex;
        align-items: center;

        gap: 5px;

        padding:
            6px 10px;

        border:
            1px solid rgba(255,255,255,.16);

        border-radius: 999px;

        color: #ffdb91;

        background:
            rgba(255,255,255,.06);

        font-size: 10px;

        font-weight: 900;

        letter-spacing: .09em;

        text-transform: uppercase;
    }


    .ao-title {
        margin:
            10px 0 0;

        color: #fff;

        font-size:
            clamp(
                30px,
                3vw,
                41px
            );

        line-height: 1.08;

        font-weight: 950;

        letter-spacing: -.045em;
    }


    .ao-description {
        max-width: 650px;

        margin-top: 7px;

        color:
            rgba(255,255,255,.72);

        font-size: 12.5px;

        line-height: 1.65;
    }


    .ao-dashboard-btn {
        position: relative;

        z-index: 2;

        min-height: 42px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding:
            0 14px;

        border:
            1px solid rgba(255,255,255,.23);

        border-radius: 10px;

        color: #fff;

        background:
            rgba(255,255,255,.08);

        font-size: 10px;

        font-weight: 900;
    }


    .ao-dashboard-btn:hover {
        color: #fff;

        background:
            rgba(255,255,255,.16);
    }


    /* =========================================================
       STATS
    ========================================================= */

    .ao-stats {
        display: grid;

        grid-template-columns:
            repeat(
                3,
                minmax(0, 1fr)
            );

        gap: 12px;

        margin-bottom: 18px;
    }


    .ao-stat {
        position: relative;

        overflow: hidden;

        min-height: 112px;

        display: flex;
        align-items: center;

        gap: 14px;

        padding:
            17px;

        border:
            1px solid var(--ao-border);

        border-radius: 15px;

        background: #fff;

        box-shadow: var(--ao-shadow);

        transition:
            transform .18s ease,
            box-shadow .18s ease;
    }


    .ao-stat:hover {
        transform:
            translateY(-3px);

        box-shadow:
            var(--ao-shadow-hover);
    }


    .ao-stat::after {
        content: "";

        position: absolute;

        top: -33px;
        right: -33px;

        width: 105px;
        height: 105px;

        border-radius: 50%;

        background:
            rgba(229,173,66,.08);
    }


    .ao-stat-icon {
        width: 52px;
        height: 52px;

        flex: 0 0 52px;

        display: grid;
        place-items: center;

        border-radius: 14px;

        background:
            #fff0cf;

        font-size: 23px;
    }


    .ao-stat.revenue
    .ao-stat-icon {
        background:
            #eaf5e7;
    }


    .ao-stat.product
    .ao-stat-icon {
        background:
            #edf3ff;
    }


    .ao-stat-label {
        color: var(--ao-muted);

        font-size: 10.5px;

        font-weight: 750;
    }


    .ao-stat-number {
        margin-top: 3px;

        color:
            var(--ao-brown-dark);

        font-size: 26px;

        line-height: 1;

        font-weight: 950;

        letter-spacing: -.025em;
    }


    .ao-stat.revenue
    .ao-stat-number {
        color:
            var(--ao-green-dark);

        font-size: 23px;
    }


    /* =========================================================
       LIST CARD
    ========================================================= */

    .ao-list-card {
        overflow: hidden;

        border:
            1px solid
            var(--ao-border);

        border-radius: 17px;

        background: #fff;

        box-shadow:
            var(--ao-shadow);
    }


    .ao-list-head {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        padding:
            16px 18px;

        border-bottom:
            1px solid
            var(--ao-border);

        background:
            linear-gradient(
                180deg,
                #fff,
                #fffcf7
            );
    }


    .ao-list-title {
        margin: 0;

        color: #453930;

        font-size: 15px;

        font-weight: 950;
    }


    .ao-list-subtitle {
        margin-top: 2px;

        color: var(--ao-muted);

        font-size: 10px;
    }


    .ao-list-count {
        flex: 0 0 auto;

        padding:
            6px 9px;

        border-radius: 999px;

        color:
            var(--ao-brown-dark);

        background:
            #fff0ce;

        font-size: 9px;

        font-weight: 900;
    }


    /* =========================================================
       TABLE
    ========================================================= */

    .ao-table-wrap {
        overflow-x: auto;
    }


    .ao-table {
        width: 100%;

        margin: 0;

        border-collapse: collapse;
    }


    .ao-table thead th {
        padding:
            12px 14px;

        border-bottom:
            1px solid
            #ddcfbd;

        color:
            #66452f;

        background:
            #fff6e7;

        font-size: 9px;

        font-weight: 950;

        letter-spacing: .04em;

        text-transform: uppercase;

        white-space: nowrap;
    }


    .ao-table tbody td {
        padding:
            14px;

        border-bottom:
            1px solid
            #eee7df;

        vertical-align: middle;
    }


    .ao-table tbody tr {
        transition:
            background .16s ease;
    }


    .ao-table tbody tr:hover {
        background:
            #fffaf3;
    }


    .ao-table tbody tr:last-child td {
        border-bottom: 0;
    }


    /* =========================================================
       ORDER CODE
    ========================================================= */

    .ao-order-code {
        color:
            var(--ao-brown-dark);

        font-size: 12px;

        font-weight: 950;

        white-space: nowrap;
    }


    .ao-order-date-mobile {
        display: none;

        margin-top: 3px;

        color:
            var(--ao-muted);

        font-size: 8.5px;
    }


    /* =========================================================
       CUSTOMER
    ========================================================= */

    .ao-customer {
        min-width: 145px;
    }


    .ao-customer-name {
        overflow: hidden;

        max-width: 185px;

        color: #40352e;

        font-size: 10.5px;

        font-weight: 900;

        white-space: nowrap;

        text-overflow: ellipsis;
    }


    .ao-customer-email {
        overflow: hidden;

        max-width: 185px;

        margin-top: 2px;

        color:
            var(--ao-muted);

        font-size: 8.5px;

        white-space: nowrap;

        text-overflow: ellipsis;
    }


    .ao-receiver {
        min-width: 135px;
    }


    .ao-receiver strong {
        display: block;

        color: #483c34;

        font-size: 10px;
    }


    .ao-receiver span {
        display: block;

        margin-top: 2px;

        color:
            var(--ao-muted);

        font-size: 8.5px;
    }


    /* =========================================================
       PRODUCT COUNT
    ========================================================= */

    .ao-product-count {
        display: inline-flex;
        align-items: center;

        gap: 5px;

        padding:
            5px 8px;

        border-radius: 8px;

        color:
            #66564b;

        background:
            #f7f4ef;

        font-size: 9px;

        font-weight: 850;

        white-space: nowrap;
    }


    /* =========================================================
       PRICE
    ========================================================= */

    .ao-price {
        color:
            var(--ao-red);

        font-size: 13px;

        font-weight: 950;

        white-space: nowrap;
    }


    /* =========================================================
       STATUS
    ========================================================= */

    .ao-status {
        display: inline-flex;
        align-items: center;

        gap: 4px;

        padding:
            6px 8px;

        border-radius: 999px;

        font-size: 8.5px;

        font-weight: 900;

        white-space: nowrap;
    }


    .ao-status.pending {
        color: #765714;

        background:
            #fff0bd;
    }


    .ao-status.confirmed {
        color: #256072;

        background:
            #e2f3f7;
    }


    .ao-status.shipped {
        color: #275f91;

        background:
            #e5f0fc;
    }


    .ao-status.delivered {
        color: #3b6d34;

        background:
            #e7f4e4;
    }


    .ao-status.cancelled {
        color: #9c4036;

        background:
            #fae8e5;
    }


    /* =========================================================
       PAYMENT
    ========================================================= */

    .ao-payment {
        display: inline-flex;
        align-items: center;

        gap: 4px;

        margin-top: 5px;

        padding:
            4px 7px;

        border-radius: 999px;

        font-size: 8px;

        font-weight: 850;

        white-space: nowrap;
    }


    .ao-payment.unpaid {
        color: #9c4a40;

        background:
            #fbeae7;
    }


    .ao-payment.waiting {
        color: #775914;

        background:
            #fff1c4;
    }


    .ao-payment.paid {
        color:
            var(--ao-green-dark);

        background:
            #e7f3e4;
    }


    .ao-payment.failed {
        color: #9b3932;

        background:
            #fae2df;
    }


    /* =========================================================
       VIEW BUTTON
    ========================================================= */

    .ao-view-btn {
        min-height: 36px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 4px;

        padding:
            0 10px;

        border-radius: 8px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                var(--ao-red),
                var(--ao-red-dark)
            );

        font-size: 8.5px;

        font-weight: 900;

        white-space: nowrap;

        transition:
            transform .16s ease,
            box-shadow .16s ease;
    }


    .ao-view-btn:hover {
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

    .ao-empty {
        min-height: 360px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 35px;

        text-align: center;
    }


    .ao-empty-icon {
        width: 83px;
        height: 83px;

        display: grid;
        place-items: center;

        margin:
            0 auto 12px;

        border-radius: 50%;

        background:
            #fff0ce;

        font-size: 36px;
    }


    .ao-empty h3 {
        margin: 0;

        color: var(--ao-text);

        font-size: 19px;

        font-weight: 950;
    }


    .ao-empty p {
        margin:
            6px 0 0;

        color:
            var(--ao-muted);

        font-size: 10px;
    }


    /* =========================================================
       PAGINATION
    ========================================================= */

    .ao-pagination {
        display: flex;
        justify-content: center;

        padding:
            18px;

        border-top:
            1px solid
            var(--ao-border);

        background:
            #fdfbf8;
    }


    .ao-pagination
    .pagination {
        margin-bottom: 0;

        gap: 4px;
    }


    .ao-pagination
    .page-link {
        min-width: 35px;
        height: 35px;

        display: flex;
        align-items: center;
        justify-content: center;

        border:
            1px solid
            #dfd3c6;

        border-radius: 8px !important;

        color:
            var(--ao-brown);

        background: #fff;

        font-size: 9px;

        font-weight: 850;
    }


    .ao-pagination
    .page-item.active
    .page-link {
        color: #fff;

        border-color:
            var(--ao-red);

        background:
            var(--ao-red);
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .ao-stats {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 767.98px) {

        .ao-hero {
            align-items: flex-start;

            flex-direction: column;

            padding:
                24px 21px;
        }


        .ao-table thead {
            display: none;
        }


        .ao-table,
        .ao-table tbody,
        .ao-table tr,
        .ao-table td {
            display: block;

            width: 100%;
        }


        .ao-table tbody tr {
            padding:
                13px;

            border-bottom:
                1px solid
                var(--ao-border);
        }


        .ao-table tbody td {
            padding:
                5px 0;

            border: 0;
        }


        .ao-order-date-mobile {
            display: block;
        }


        .ao-table tbody td:nth-child(5) {
            margin-top: 7px;
        }


        .ao-table tbody td:last-child {
            margin-top: 8px;

            text-align: left !important;
        }

    }
</style>


<div class="admin-orders-page">


    {{-- =====================================================
        BREADCRUMB
    ====================================================== --}}
    <div class="ao-breadcrumb">

        <a href="{{ route('admin.dashboard') }}">
            Dashboard
        </a>

        <span>›</span>

        <span>
            Quản lý đơn hàng
        </span>

    </div>


    {{-- =====================================================
        HERO
    ====================================================== --}}
    <section class="ao-hero">

        <div class="ao-hero-copy">

            <div class="ao-kicker">
                • Khu vực quản trị
            </div>


            <h1 class="ao-title">
                Quản lý đơn hàng
            </h1>


            <div class="ao-description">

                Theo dõi toàn bộ đơn hàng,
                kiểm tra khách hàng,
                thanh toán và cập nhật tiến trình
                xử lý đơn tại Tinh Hoa Tây Bắc.

            </div>

        </div>


        <a
            href="{{ route('admin.dashboard') }}"
            class="ao-dashboard-btn"
        >
            ← Dashboard
        </a>

    </section>


    {{-- =====================================================
        STATS
    ====================================================== --}}
    <div class="ao-stats">


        <div class="ao-stat">

            <div class="ao-stat-icon">
                •
            </div>


            <div>

                <div class="ao-stat-label">
                    Tổng đơn hàng
                </div>

                <div class="ao-stat-number">
                    {{ number_format($totalOrders) }}
                </div>

            </div>

        </div>


        <div class="ao-stat revenue">

            <div class="ao-stat-icon">
                •
            </div>


            <div>

                <div class="ao-stat-label">
                    Doanh thu đơn đã giao
                </div>

                <div class="ao-stat-number">

                    {{
                        number_format(
                            (float) $totalRevenue,
                            0,
                            ',',
                            '.'
                        )
                    }}đ

                </div>

            </div>

        </div>


        <div class="ao-stat product">

            <div class="ao-stat-icon">
                •
            </div>


            <div>

                <div class="ao-stat-label">
                    Tổng sản phẩm
                </div>

                <div class="ao-stat-number">
                    {{ number_format($totalProducts) }}
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
        ORDER LIST
    ====================================================== --}}
    <section class="ao-list-card">


        <div class="ao-list-head">

            <div>

                <h2 class="ao-list-title">
                    Danh sách đơn hàng
                </h2>

                <div class="ao-list-subtitle">

                    Hiển thị

                    {{ $orders->firstItem() ?? 0 }}

                    –

                    {{ $orders->lastItem() ?? 0 }}

                    trong

                    {{ $orders->total() }}

                    đơn hàng

                </div>

            </div>


            <span class="ao-list-count">

                Trang
                {{ $orders->currentPage() }}
                /
                {{ $orders->lastPage() }}

            </span>

        </div>


        @if($orders->isEmpty())

            <div class="ao-empty">

                <div>

                    <div class="ao-empty-icon">
                        •
                    </div>


                    <h3>
                        Chưa có đơn hàng
                    </h3>


                    <p>
                        Đơn hàng của khách hàng
                        sẽ xuất hiện tại đây.
                    </p>

                </div>

            </div>


        @else

            <div class="ao-table-wrap">

                <table class="ao-table">

                    <thead>

                        <tr>

                            <th>
                                Mã đơn
                            </th>

                            <th>
                                Khách hàng
                            </th>

                            <th>
                                Người nhận
                            </th>

                            <th>
                                Ngày đặt
                            </th>

                            <th>
                                Sản phẩm
                            </th>

                            <th>
                                Tổng tiền
                            </th>

                            <th>
                                Trạng thái
                            </th>

                            <th class="text-center">
                                Thao tác
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        @foreach($orders as $order)

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
                                            '•',

                                        'class'
                                            =>
                                            'pending',
                                    ];


                                $payment =
                                    $paymentConfig[
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
                            @endphp


                            <tr>


                                {{-- =================================
                                    ORDER CODE
                                ================================== --}}
                                <td>

                                    <div class="ao-order-code">

                                        #{{
                                            str_pad(
                                                $order->id,
                                                6,
                                                '0',
                                                STR_PAD_LEFT
                                            )
                                        }}

                                    </div>


                                    <div class="ao-order-date-mobile">

                                        {{
                                            $order
                                                ->created_at
                                                ->format(
                                                    'd/m/Y H:i'
                                                )
                                        }}

                                    </div>

                                </td>


                                {{-- =================================
                                    CUSTOMER
                                ================================== --}}
                                <td>

                                    <div class="ao-customer">

                                        <div class="ao-customer-name">

                                            {{
                                                $order->user?->name
                                                ??
                                                'Không xác định'
                                            }}

                                        </div>


                                        <div class="ao-customer-email">

                                            {{
                                                $order->user?->email
                                                ??
                                                'Không có email'
                                            }}

                                        </div>

                                    </div>

                                </td>


                                {{-- =================================
                                    RECEIVER
                                ================================== --}}
                                <td>

                                    <div class="ao-receiver">

                                        <strong>

                                            {{
                                                $order
                                                    ->customer_name
                                                ??
                                                'Không có'
                                            }}

                                        </strong>


                                        <span>

                                            {{
                                                $order
                                                    ->customer_phone
                                                ??
                                                'Không có SĐT'
                                            }}

                                        </span>

                                    </div>

                                </td>


                                {{-- =================================
                                    DATE
                                ================================== --}}
                                <td>

                                    <div
                                        style="
                                            color:#493d35;
                                            font-size:10px;
                                            font-weight:850;
                                            white-space:nowrap;
                                        "
                                    >

                                        {{
                                            $order
                                                ->created_at
                                                ->format(
                                                    'd/m/Y'
                                                )
                                        }}

                                    </div>


                                    <div
                                        style="
                                            margin-top:2px;
                                            color:#8f837b;
                                            font-size:8.5px;
                                        "
                                    >

                                        {{
                                            $order
                                                ->created_at
                                                ->format(
                                                    'H:i'
                                                )
                                        }}

                                    </div>

                                </td>


                                {{-- =================================
                                    PRODUCTS
                                ================================== --}}
                                <td>

                                    <span class="ao-product-count">

                                        •

                                        {{
                                            $order
                                                ->items
                                                ->count()
                                        }}

                                        dòng

                                    </span>

                                </td>


                                {{-- =================================
                                    TOTAL
                                ================================== --}}
                                <td>

                                    <div class="ao-price">

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


                                    <div
                                        class="
                                            ao-payment
                                            {{
                                                $payment['class']
                                            }}
                                        "
                                    >

                                        •

                                        {{ $payment['label'] }}

                                    </div>

                                </td>


                                {{-- =================================
                                    STATUS
                                ================================== --}}
                                <td>

                                    <span
                                        class="
                                            ao-status
                                            {{
                                                $status['class']
                                            }}
                                        "
                                    >

                                        {{ $status['icon'] }}

                                        {{ $status['label'] }}

                                    </span>

                                </td>


                                {{-- =================================
                                    ACTION
                                ================================== --}}
                                <td class="text-center">

                                    <a
                                        href="{{
                                            route(
                                                'admin.orders.show',
                                                $order
                                            )
                                        }}"
                                        class="ao-view-btn"
                                    >
                                        👁 Chi tiết
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            @if($orders->hasPages())

                <div class="ao-pagination">

                    {{
                        $orders->links()
                    }}

                </div>

            @endif

        @endif

    </section>

</div>

@endsection
