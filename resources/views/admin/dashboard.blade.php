@extends('admin.layouts.app')

@section('title', 'Dashboard | Tinh Hoa Tây Bắc')

@section('content')


<style>

    :root {

        --tb-brown: #5f341d;

        --tb-brown-dark: #2c1810;

        --tb-red: #a83b2d;

        --tb-gold: #f2c15c;

        --tb-green: #48633b;

        --tb-cream: #fffaf0;

        --tb-soft: #f8efe2;

        --tb-border: #ead8bf;

        --tb-text: #2f241e;

    }


    .dashboard-title {

        color:
            var(--tb-brown-dark);

        font-weight: 900;

    }


    .dashboard-subtitle {

        color: #77675d;

    }


    /* ==========================================
        CARD THỐNG KÊ
    ========================================== */

    .stat-card {

        border:
            1px solid
            var(--tb-border);

        border-radius: 18px;

        background: white;

        height: 100%;

        box-shadow:
            0 8px 24px
            rgba(
                95,
                52,
                29,
                0.06
            );

        transition:
            0.2s;

    }


    .stat-card:hover {

        transform:
            translateY(-3px);

        box-shadow:
            0 12px 28px
            rgba(
                95,
                52,
                29,
                0.12
            );

    }


    .stat-icon {

        width: 50px;

        height: 50px;

        border-radius: 14px;

        display: flex;

        align-items: center;

        justify-content: center;

        font-size: 24px;

        background:
            var(--tb-soft);

    }


    .stat-label {

        color: #7b6c62;

        font-size: 13px;

        font-weight: 700;

        text-transform:
            uppercase;

    }


    .stat-number {

        color:
            var(--tb-brown-dark);

        font-size: 28px;

        font-weight: 900;

    }


    /* ==========================================
        CARD CHUNG
    ========================================== */

    .dashboard-card {

        border:
            1px solid
            var(--tb-border);

        border-radius: 18px;

        overflow: hidden;

        height: 100%;

        box-shadow:
            0 8px 24px
            rgba(
                95,
                52,
                29,
                0.05
            );

    }


    .dashboard-card
    .card-header {

        background: white;

        border-bottom:
            1px solid
            var(--tb-border);

        padding:
            17px 20px;

    }


    .dashboard-card
    .card-header
    h5 {

        margin: 0;

        color:
            var(--tb-brown-dark);

        font-weight: 800;

    }


    /* ==========================================
        TRẠNG THÁI
    ========================================== */

    .order-status-card {

        border:
            1px solid
            var(--tb-border);

        border-radius: 15px;

        background:
            var(--tb-cream);

        padding: 15px;

        height: 100%;

    }


    .status-number {

        font-size: 26px;

        font-weight: 900;

        color:
            var(--tb-brown-dark);

    }


    /* ==========================================
        TOP SẢN PHẨM
    ========================================== */

    .product-rank {

        width: 36px;

        height: 36px;

        min-width: 36px;

        border-radius: 50%;

        background:
            var(--tb-soft);

        color:
            var(--tb-brown);

        display: flex;

        align-items: center;

        justify-content: center;

        font-weight: 900;

    }


    /* ==========================================
        SẮP HẾT HÀNG
    ========================================== */

    .stock-warning {

        background: #fff8e8;

        border:
            1px solid #f3d39b;

        border-radius: 12px;

        padding:
            12px 14px;

    }


    /* ==========================================
        QUICK LINK
    ========================================== */

    .quick-link {

        display: block;

        text-decoration: none;

        border:
            1px solid
            var(--tb-border);

        border-radius: 14px;

        padding: 16px;

        height: 100%;

        color:
            var(--tb-text);

        transition:
            0.2s;

    }


    .quick-link:hover {

        color:
            var(--tb-brown);

        background:
            var(--tb-cream);

        transform:
            translateY(-2px);

    }


    /* ==========================================
        TABLE
    ========================================== */

    .table-dashboard th {

        background:
            var(--tb-cream);

        white-space:
            nowrap;

        font-size: 13px;

        color: #6d5f56;

    }


    .table-dashboard td {

        vertical-align:
            middle;

    }


    /* ==========================================
        CHART
    ========================================== */

    .chart-wrap {

        position: relative;

        height: 330px;

    }


    /* STATUS */

    .badge-pending {

        background: #fff3cd;

        color: #8a6500;

    }


    .badge-confirmed {

        background: #dbeafe;

        color: #1d4ed8;

    }


    .badge-shipped {

        background: #e0e7ff;

        color: #4338ca;

    }


    .badge-delivered {

        background: #dcfce7;

        color: #166534;

    }


    .badge-cancelled {

        background: #fee2e2;

        color: #991b1b;

    }



    /* =========================================================
       ADMIN DASHBOARD PREMIUM UI
       CHỈ NÂNG GIAO DIỆN - KHÔNG ĐỔI DATA / ROUTE / CHART / JS
    ========================================================= */

    .admin-dashboard-premium {
        position: relative;
        isolation: isolate;
        padding: 12px 0 70px;
    }

    .admin-dashboard-premium::before {
        content: "";
        position: absolute;
        z-index: -2;
        top: -35px;
        left: 50%;
        width: min(100vw,1800px);
        height: 720px;
        transform: translateX(-50%);
        pointer-events: none;
        background:
            radial-gradient(circle at 7% 7%, rgba(242,193,92,.16), transparent 23%),
            radial-gradient(circle at 94% 10%, rgba(72,99,59,.11), transparent 27%),
            linear-gradient(180deg,rgba(255,250,240,.88),rgba(255,255,255,0));
    }

    .admin-dashboard-premium > .d-flex:first-child {
        position: relative;
        overflow: hidden;
        min-height: 180px;
        align-items: center !important;
        padding: 30px 34px;
        border-radius: 26px;
        border: 1px solid rgba(255,255,255,.10);
        color: #fff;
        background:
            radial-gradient(circle at 88% 15%, rgba(242,193,92,.22), transparent 28%),
            radial-gradient(circle at 12% 120%, rgba(168,59,45,.26), transparent 35%),
            linear-gradient(135deg,#2c1810 0%,#5f341d 54%,#48633b 100%);
        box-shadow:
            0 22px 56px rgba(44,24,16,.18),
            inset 0 1px 0 rgba(255,255,255,.07);
    }

    .admin-dashboard-premium > .d-flex:first-child::before {
        content: "";
        position: absolute;
        right: -30px;
        bottom: -55px;
        width: 320px;
        height: 180px;
        opacity: .10;
        clip-path: polygon(0 100%,18% 56%,36% 73%,53% 25%,70% 58%,86% 34%,100% 66%,100% 100%);
        background: linear-gradient(135deg,#fff,#f2c15c);
        pointer-events: none;
    }

    .admin-dashboard-premium > .d-flex:first-child > * {
        position: relative;
        z-index: 2;
    }

    .admin-dashboard-premium .breadcrumb-item,
    .admin-dashboard-premium .breadcrumb-item.active {
        color: rgba(255,255,255,.68);
    }

    .admin-dashboard-premium .breadcrumb-item a {
        color: #f5d889;
    }

    .admin-dashboard-premium .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,.45);
    }

    .admin-dashboard-premium .dashboard-title {
        color: #fff;
        font-size: clamp(30px,3vw,42px);
        letter-spacing: -.7px;
        text-shadow: 0 2px 14px rgba(0,0,0,.16);
    }

    .admin-dashboard-premium .dashboard-subtitle {
        color: rgba(255,255,255,.74);
    }

    .admin-dashboard-premium > .d-flex:first-child > .text-md-end {
        min-width: 220px;
        padding: 15px 18px;
        border: 1px solid rgba(255,255,255,.16);
        border-radius: 17px;
        background: rgba(255,255,255,.075);
        backdrop-filter: blur(10px);
    }

    .admin-dashboard-premium > .d-flex:first-child > .text-md-end .text-muted {
        color: rgba(255,255,255,.68) !important;
    }

    .admin-dashboard-premium > .d-flex:first-child > .text-md-end .fw-bold {
        color: #f5d06f !important;
        font-size: 1.7rem !important;
    }

    /* STATS */
    .admin-dashboard-premium .stat-card {
        position: relative;
        overflow: hidden;
        border-radius: 21px;
        border-color: #e5d0b3;
        background:
            linear-gradient(180deg,#fff,#fffdfa);
        box-shadow:
            0 14px 36px rgba(95,52,29,.075),
            inset 0 1px 0 rgba(255,255,255,.94);
        transition:
            transform .20s ease,
            box-shadow .20s ease,
            border-color .20s ease;
    }

    .admin-dashboard-premium .stat-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 16%;
        right: 16%;
        height: 2px;
        border-radius: 999px;
        background: linear-gradient(90deg,transparent,#f2c15c,#48633b,transparent);
        opacity: .55;
    }

    .admin-dashboard-premium .stat-card:hover {
        transform: translateY(-5px);
        border-color: #dec092;
        box-shadow: 0 20px 44px rgba(95,52,29,.12);
    }

    .admin-dashboard-premium .stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        background:
            radial-gradient(circle at 35% 25%,rgba(255,255,255,.9),transparent 30%),
            linear-gradient(135deg,#fff1cf,#f8e4bd);
        box-shadow:
            inset 0 1px 0 rgba(255,255,255,.9),
            0 7px 16px rgba(95,52,29,.07);
    }

    .admin-dashboard-premium .stat-number {
        letter-spacing: -.6px;
    }

    /* COMMON DASHBOARD CARDS */
    .admin-dashboard-premium .dashboard-card {
        border-radius: 21px;
        border-color: #e5d0b3;
        background:
            linear-gradient(180deg,#fff,#fffdfa);
        box-shadow:
            0 14px 38px rgba(95,52,29,.07),
            inset 0 1px 0 rgba(255,255,255,.94);
    }

    .admin-dashboard-premium .dashboard-card .card-header {
        padding: 18px 20px;
        background:
            radial-gradient(circle at 96% 0%,rgba(242,193,92,.10),transparent 26%),
            linear-gradient(180deg,#fffdf8,#fff9ef);
        border-bottom-color: #ead8bf;
    }

    .admin-dashboard-premium .dashboard-card .card-header h5 {
        color: #392820;
        letter-spacing: -.2px;
    }

    /* ORDER STATUS */
    .admin-dashboard-premium .order-status-card {
        position: relative;
        overflow: hidden;
        border-radius: 17px;
        border-color: #e4d0b3;
        background:
            linear-gradient(145deg,#fffaf0,#fff6e6);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.9);
        transition: transform .18s ease, box-shadow .18s ease;
    }

    .admin-dashboard-premium .order-status-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 22px rgba(95,52,29,.08);
    }

    /* PRODUCT RANK */
    .admin-dashboard-premium .product-rank {
        background: linear-gradient(135deg,#f8efe2,#fff0cc);
        border: 1px solid #ead1aa;
        box-shadow: 0 5px 12px rgba(95,52,29,.05);
    }

    .admin-dashboard-premium .stock-warning {
        border-radius: 14px;
        border-color: #edcf94;
        background:
            linear-gradient(135deg,#fff8e8,#fff2cf);
    }

    /* QUICK LINKS */
    .admin-dashboard-premium .quick-link {
        border-radius: 17px;
        border-color: #e4cfb1;
        background:
            linear-gradient(180deg,#fff,#fffdf9);
        box-shadow: 0 8px 20px rgba(95,52,29,.045);
        transition:
            transform .18s ease,
            box-shadow .18s ease,
            border-color .18s ease,
            background .18s ease;
    }

    .admin-dashboard-premium .quick-link:hover {
        transform: translateY(-4px);
        border-color: #d8b47f;
        background: linear-gradient(145deg,#fffaf0,#fff5e5);
        box-shadow: 0 14px 28px rgba(95,52,29,.09);
    }

    /* TABLES */
    .admin-dashboard-premium .table-responsive {
        border-radius: 14px;
    }

    .admin-dashboard-premium .table-dashboard th {
        padding: 13px 14px;
        background: linear-gradient(180deg,#fff8ea,#f8efe2);
        color: #5f341d;
        border-bottom-color: #e6d2b6;
    }

    .admin-dashboard-premium .table-dashboard td {
        padding: 14px;
        border-color: #f0e4d5;
    }

    .admin-dashboard-premium .table-dashboard tbody tr {
        transition: background .16s ease;
    }

    .admin-dashboard-premium .table-dashboard tbody tr:hover {
        background: #fffaf2;
    }

    /* BADGES */
    .admin-dashboard-premium [class*="badge-"] {
        border-radius: 999px;
        padding: 6px 10px;
        font-weight: 800;
    }

    /* CHART */
    .admin-dashboard-premium .chart-wrap {
        padding: 8px 4px 0;
    }

    @media (max-width: 767.98px) {
        .admin-dashboard-premium > .d-flex:first-child {
            padding: 25px 22px;
            border-radius: 22px;
        }

        .admin-dashboard-premium > .d-flex:first-child > .text-md-end {
            width: 100%;
            text-align: left !important;
        }

        .admin-dashboard-premium .stat-card,
        .admin-dashboard-premium .dashboard-card {
            border-radius: 18px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .admin-dashboard-premium *,
        .admin-dashboard-premium *::before,
        .admin-dashboard-premium *::after {
            transition: none !important;
            animation: none !important;
        }
    }



    /* =========================================================
       CUSTOMER STAT LINK
    ========================================================= */
    .customer-stat-link {
        display: block;
        height: 100%;
        color: inherit;
        text-decoration: none;
    }

    .customer-stat-link:hover {
        color: inherit;
    }

    .customer-stat-card {
        cursor: pointer;
    }

    .customer-stat-link:hover .customer-stat-card {
        border-color: rgba(72,99,59,.42);
        box-shadow:
            0 22px 46px rgba(72,99,59,.14),
            inset 0 1px 0 rgba(255,255,255,.94);
    }

    .customer-stat-link:hover .stat-icon {
        transform: scale(1.06);
    }

    .customer-stat-card .stat-icon {
        transition: transform .18s ease;
    }

</style>



{{-- ==========================================
    HEADER
=========================================== --}}

<div class="admin-dashboard-premium">

<div
    class="
        d-flex
        justify-content-between
        align-items-start
        flex-wrap
        gap-3
        mb-4
    "
>

    <div>

        <nav
            aria-label="breadcrumb"
            class="mb-2"
        >

            <ol
                class="
                    breadcrumb
                    mb-0
                "
            >

                <li
                    class="
                        breadcrumb-item
                    "
                >

                    <a
                        href="{{ url('/') }}"
                        class="
                            text-decoration-none
                        "
                    >

                        Trang chủ

                    </a>

                </li>


                <li
                    class="
                        breadcrumb-item
                        active
                    "
                >

                    Dashboard

                </li>

            </ol>

        </nav>


        <h1
            class="
                dashboard-title
                mb-1
            "
        >

            🌿 Dashboard
            Tinh Hoa Tây Bắc

        </h1>


        <p
            class="
                dashboard-subtitle
                mb-0
            "
        >

            Tổng quan hoạt động
            kinh doanh và tình trạng
            cửa hàng.

        </p>

    </div>



    <div
        class="
            text-md-end
        "
    >

        <div
            class="
                small
                text-muted
            "
        >

            Doanh thu hôm nay

        </div>


        <div
            class="
                fw-bold
                fs-4
            "
            style="
                color:
                var(--tb-red);
            "
        >

            {{
                number_format(
                    $todayRevenue,
                    0,
                    ',',
                    '.'
                )
            }}
            đ

        </div>

    </div>

</div>



{{-- ==========================================
    THỐNG KÊ CHÍNH
=========================================== --}}

<div
    class="
        row
        g-3
        mb-4
    "
>


    {{-- DOANH THU --}}
    <div
        class="
            col-xl-3
            col-md-6
        "
    >

        <div
            class="
                stat-card
                p-4
            "
        >

            <div
                class="
                    d-flex
                    justify-content-between
                    gap-3
                "
            >

                <div>

                    <div
                        class="
                            stat-label
                            mb-2
                        "
                    >

                        Tổng doanh thu

                    </div>


                    <div
                        class="
                            stat-number
                        "
                        style="
                            color:
                            var(--tb-red);
                        "
                    >

                        {{
                            number_format(
                                $totalRevenue,
                                0,
                                ',',
                                '.'
                            )
                        }}
                        đ

                    </div>


                    <small
                        class="
                            text-muted
                        "
                    >

                        Chỉ tính đơn đã giao

                    </small>

                </div>


                <div
                    class="
                        stat-icon
                    "
                >

                    💰

                </div>

            </div>

        </div>

    </div>



    {{-- ĐƠN HÀNG --}}
    <div
        class="
            col-xl-3
            col-md-6
        "
    >

        <div
            class="
                stat-card
                p-4
            "
        >

            <div
                class="
                    d-flex
                    justify-content-between
                "
            >

                <div>

                    <div
                        class="
                            stat-label
                            mb-2
                        "
                    >

                        Tổng đơn hàng

                    </div>


                    <div
                        class="
                            stat-number
                        "
                    >

                        {{ $totalOrders }}

                    </div>


                    <small
                        class="
                            text-muted
                        "
                    >

                        {{ $pendingOrders }}
                        đơn đang chờ

                    </small>

                </div>


                <div
                    class="
                        stat-icon
                    "
                >

                    📦

                </div>

            </div>

        </div>

    </div>



    {{-- KHÁCH HÀNG - BẤM ĐỂ XEM DANH SÁCH --}}
    <div
        class="
            col-xl-3
            col-md-6
        "
    >

        <a
            href="{{ route('admin.customers.index') }}"
            class="customer-stat-link"
            title="Xem danh sách khách hàng"
        >
            <div
                class="
                    stat-card
                    customer-stat-card
                    p-4
                "
            >

                <div
                    class="
                        d-flex
                        justify-content-between
                    "
                >

                    <div>

                        <div
                            class="
                                stat-label
                                mb-2
                            "
                        >

                            Khách hàng

                        </div>


                        <div
                            class="
                                stat-number
                            "
                        >

                            {{ $totalCustomers }}

                        </div>


                        <small
                            class="
                                text-muted
                            "
                        >

                            Bấm để xem chi tiết →

                        </small>

                    </div>


                    <div
                        class="
                            stat-icon
                        "
                    >

                        👥

                    </div>

                </div>

            </div>
        </a>

    </div>



    {{-- SẢN PHẨM --}}
    <div
        class="
            col-xl-3
            col-md-6
        "
    >

        <div
            class="
                stat-card
                p-4
            "
        >

            <div
                class="
                    d-flex
                    justify-content-between
                "
            >

                <div>

                    <div
                        class="
                            stat-label
                            mb-2
                        "
                    >

                        Sản phẩm

                    </div>


                    <div
                        class="
                            stat-number
                        "
                    >

                        {{ $totalProducts }}

                    </div>


                    <small
                        class="
                            text-muted
                        "
                    >

                        {{ $totalCategories }}
                        danh mục

                        ·

                        {{ $outOfStockProducts }}
                        hết hàng

                    </small>

                </div>


                <div
                    class="
                        stat-icon
                    "
                >

                    🥩

                </div>

            </div>

        </div>

    </div>

</div>



{{-- ==========================================
    TRẠNG THÁI ĐƠN HÀNG
=========================================== --}}

<div
    class="
        card
        dashboard-card
        mb-4
    "
>

    <div
        class="
            card-header
        "
    >

        <h5>

            📋 Trạng thái đơn hàng

        </h5>

    </div>


    <div
        class="
            card-body
        "
    >

        <div
            class="
                row
                g-3
            "
        >


            <div
                class="
                    col-lg
                    col-md-4
                    col-6
                "
            >

                <div
                    class="
                        order-status-card
                    "
                >

                    <div
                        class="
                            small
                            text-muted
                        "
                    >

                        ⏳ Chờ xác nhận

                    </div>

                    <div
                        class="
                            status-number
                        "
                    >

                        {{ $pendingOrders }}

                    </div>

                </div>

            </div>


            <div
                class="
                    col-lg
                    col-md-4
                    col-6
                "
            >

                <div
                    class="
                        order-status-card
                    "
                >

                    <div
                        class="
                            small
                            text-muted
                        "
                    >

                        ✅ Đã xác nhận

                    </div>

                    <div
                        class="
                            status-number
                        "
                    >

                        {{ $confirmedOrders }}

                    </div>

                </div>

            </div>


            <div
                class="
                    col-lg
                    col-md-4
                    col-6
                "
            >

                <div
                    class="
                        order-status-card
                    "
                >

                    <div
                        class="
                            small
                            text-muted
                        "
                    >

                        🚚 Đang giao

                    </div>

                    <div
                        class="
                            status-number
                        "
                    >

                        {{ $shippingOrders }}

                    </div>

                </div>

            </div>


            <div
                class="
                    col-lg
                    col-md-4
                    col-6
                "
            >

                <div
                    class="
                        order-status-card
                    "
                >

                    <div
                        class="
                            small
                            text-muted
                        "
                    >

                        🎉 Đã giao

                    </div>

                    <div
                        class="
                            status-number
                        "
                        style="
                            color:
                            var(--tb-green);
                        "
                    >

                        {{ $deliveredOrders }}

                    </div>

                </div>

            </div>


            <div
                class="
                    col-lg
                    col-md-4
                    col-6
                "
            >

                <div
                    class="
                        order-status-card
                    "
                >

                    <div
                        class="
                            small
                            text-muted
                        "
                    >

                        ❌ Đã hủy

                    </div>

                    <div
                        class="
                            status-number
                        "
                        style="
                            color:
                            var(--tb-red);
                        "
                    >

                        {{ $cancelledOrders }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- ==========================================
    BIỂU ĐỒ + TOP SẢN PHẨM
=========================================== --}}

<div
    class="
        row
        g-4
        mb-4
    "
>


    {{-- BIỂU ĐỒ --}}
    <div
        class="
            col-xl-8
        "
    >

        <div
            class="
                card
                dashboard-card
            "
        >

            <div
                class="
                    card-header
                    d-flex
                    justify-content-between
                    align-items-center
                "
            >

                <h5>

                    📈 Doanh thu
                    7 ngày gần nhất

                </h5>


                <small
                    class="
                        text-muted
                    "
                >

                    Đơn đã giao thành công

                </small>

            </div>


            <div
                class="
                    card-body
                "
            >

                <div
                    class="
                        chart-wrap
                    "
                >

                    <canvas
                        id="revenueChart"
                    >
                    </canvas>

                </div>

            </div>

        </div>

    </div>



    {{-- TOP SẢN PHẨM --}}
    <div
        class="
            col-xl-4
        "
    >

        <div
            class="
                card
                dashboard-card
            "
        >

            <div
                class="
                    card-header
                "
            >

                <h5>

                    🏆 Top sản phẩm
                    bán chạy

                </h5>

            </div>


            <div
                class="
                    card-body
                "
            >

                @forelse($topProducts as $index => $item)


                    @php

                        $unit =
                            $item
                                ->product
                                ?->unit
                            ?? 'sản phẩm';


                        $sold =
                            rtrim(
                                rtrim(
                                    number_format(
                                        $item
                                            ->total_sold,
                                        2,
                                        '.',
                                        ''
                                    ),
                                    '0'
                                ),
                                '.'
                            );

                    @endphp


                    <div
                        class="
                            d-flex
                            align-items-center
                            gap-3

                            {{
                                !$loop->last
                                ?
                                'border-bottom pb-3 mb-3'
                                :
                                ''
                            }}
                        "
                    >

                        <div
                            class="
                                product-rank
                            "
                        >

                            {{ $index + 1 }}

                        </div>


                        <div
                            class="
                                flex-grow-1
                            "
                        >

                            <div
                                class="
                                    fw-bold
                                "
                            >

                                {{
                                    $item
                                        ->product
                                        ?->name
                                    ??
                                    'Sản phẩm đã xóa'
                                }}

                            </div>


                            <small
                                class="
                                    text-muted
                                "
                            >

                                Đã bán:

                                <strong>

                                    {{ $sold }}
                                    {{ $unit }}

                                </strong>

                            </small>

                        </div>


                        <div
                            class="
                                fw-bold
                                text-end
                            "
                            style="
                                color:
                                var(--tb-red);
                            "
                        >

                            {{
                                number_format(
                                    $item
                                        ->total_sales,
                                    0,
                                    ',',
                                    '.'
                                )
                            }}
                            đ

                        </div>

                    </div>


                @empty


                    <div
                        class="
                            text-center
                            py-4
                        "
                    >

                        <div
                            style="
                                font-size:
                                42px;
                            "
                        >

                            🧺

                        </div>


                        <div
                            class="
                                fw-bold
                                mt-2
                            "
                        >

                            Chưa có dữ liệu
                            bán hàng

                        </div>


                        <small
                            class="
                                text-muted
                            "
                        >

                            Khi đơn được giao
                            thành công, dữ liệu
                            sẽ xuất hiện ở đây.

                        </small>

                    </div>


                @endforelse

            </div>

        </div>

    </div>

</div>



{{-- ==========================================
    SẮP HẾT HÀNG
=========================================== --}}

<div
    class="
        row
        g-4
        mb-4
    "
>


    <div
        class="
            col-xl-6
        "
    >

        <div
            class="
                card
                dashboard-card
            "
        >

            <div
                class="
                    card-header
                    d-flex
                    justify-content-between
                    align-items-center
                "
            >

                <h5>

                    ⚠️ Sản phẩm
                    sắp hết hàng

                </h5>


                <a
                    href="{{
                        route(
                            'admin.products.index'
                        )
                    }}"
                    class="
                        btn
                        btn-sm
                        btn-outline-secondary
                    "
                >

                    Xem sản phẩm

                </a>

            </div>


            <div
                class="
                    card-body
                "
            >

              @forelse($lowStockProducts as $product)


                    @php

                        $qty =
                            rtrim(
                                rtrim(
                                    number_format(
                                        $product
                                            ->quantity,
                                        2,
                                        '.',
                                        ''
                                    ),
                                    '0'
                                ),
                                '.'
                            );


                        $min =
                            rtrim(
                                rtrim(
                                    number_format(
                                        $product
                                            ->min_quantity,
                                        2,
                                        '.',
                                        ''
                                    ),
                                    '0'
                                ),
                                '.'
                            );

                    @endphp


                    <div
                        class="
                            stock-warning
                            d-flex
                            justify-content-between
                            align-items-center
                            gap-3

                            {{
                                !$loop->last
                                ?
                                'mb-2'
                                :
                                ''
                            }}
                        "
                    >

                        <div>

                            <div
                                class="
                                    fw-bold
                                "
                            >

                                {{
                                    $product
                                        ->name
                                }}

                            </div>


                            <small
                                class="
                                    text-muted
                                "
                            >

                                Mua tối thiểu:

                                {{ $min }}

                                {{
                                    $product
                                        ->unit
                                }}

                            </small>

                        </div>


                        <div
                            class="
                                text-end
                            "
                        >

                            <small
                                class="
                                    text-muted
                                    d-block
                                "
                            >

                                Còn lại

                            </small>


                            <strong
                                style="
                                    color:
                                    var(--tb-red);
                                "
                            >

                                {{ $qty }}

                                {{
                                    $product
                                        ->unit
                                }}

                            </strong>

                        </div>

                    </div>


                @empty


                    <div
                        class="
                            text-center
                            py-4
                        "
                    >

                        <div
                            style="
                                font-size:
                                40px;
                            "
                        >

                            ✅

                        </div>


                        <div
                            class="
                                fw-bold
                            "
                        >

                            Kho hàng
                            đang ổn định

                        </div>

                    </div>


                @endforelse

            </div>

        </div>

    </div>



    {{-- ======================================
        TRUY CẬP NHANH
    ======================================= --}}

    <div
        class="
            col-xl-6
        "
    >

        <div
            class="
                card
                dashboard-card
            "
        >

            <div
                class="
                    card-header
                "
            >

                <h5>

                    ⚡ Truy cập nhanh

                </h5>

            </div>


            <div
                class="
                    card-body
                "
            >

                <div
                    class="
                        row
                        g-3
                    "
                >


                    <div
                        class="
                            col-md-6
                        "
                    >

                        <a
                            href="{{
                                route(
                                    'admin.products.index'
                                )
                            }}"
                            class="
                                quick-link
                            "
                        >

                            <div
                                class="
                                    fs-3
                                    mb-2
                                "
                            >

                                🥩

                            </div>

                            <strong>
                                Quản lý sản phẩm
                            </strong>

                        </a>

                    </div>


                    <div
                        class="
                            col-md-6
                        "
                    >

                        <a
                            href="{{
                                route(
                                    'admin.categories.index'
                                )
                            }}"
                            class="
                                quick-link
                            "
                        >

                            <div
                                class="
                                    fs-3
                                    mb-2
                                "
                            >

                                🧺

                            </div>

                            <strong>
                                Quản lý danh mục
                            </strong>

                        </a>

                    </div>


                    <div
                        class="
                            col-md-6
                        "
                    >

                        <a
                            href="{{
                                route(
                                    'admin.orders.index'
                                )
                            }}"
                            class="
                                quick-link
                            "
                        >

                            <div
                                class="
                                    fs-3
                                    mb-2
                                "
                            >

                                📦

                            </div>

                            <strong>
                                Quản lý đơn hàng
                            </strong>

                        </a>

                    </div>


                    <div
                        class="
                            col-md-6
                        "
                    >

                        <a
                            href="{{
                                route(
                                    'admin.profile'
                                )
                            }}"
                            class="
                                quick-link
                            "
                        >

                            <div
                                class="
                                    fs-3
                                    mb-2
                                "
                            >

                                👑

                            </div>

                            <strong>
                                Hồ sơ Admin
                            </strong>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- ==========================================
    ĐƠN HÀNG MỚI
=========================================== --}}

<div
    class="
        card
        dashboard-card
        mb-4
    "
>

    <div
        class="
            card-header
            d-flex
            justify-content-between
            align-items-center
        "
    >

        <h5>

            🧾 Đơn hàng mới nhất

        </h5>


        <a
            href="{{
                route(
                    'admin.orders.index'
                )
            }}"
            class="
                btn
                btn-sm
                btn-outline-secondary
            "
        >

            Xem tất cả

        </a>

    </div>


    <div
        class="
            card-body
            p-0
        "
    >

        <div
            class="
                table-responsive
            "
        >

            <table
                class="
                    table
                    table-hover
                    table-dashboard
                    mb-0
                "
            >

                <thead>

                    <tr>

                        <th class="ps-4">
                            Mã đơn
                        </th>

                        <th>
                            Khách hàng
                        </th>

                        <th>
                            Tổng tiền
                        </th>

                        <th>
                            Thanh toán
                        </th>

                        <th>
                            Trạng thái
                        </th>

                        <th>
                            Ngày đặt
                        </th>

                    </tr>

                </thead>


                <tbody>

                  @forelse($recentOrders as $order)

                        @php

                            $statusClass =
                                match(
                                    $order->status
                                ) {

                                    'pending'
                                    =>
                                    'badge-pending',

                                    'confirmed'
                                    =>
                                    'badge-confirmed',

                                    'shipped'
                                    =>
                                    'badge-shipped',

                                    'delivered'
                                    =>
                                    'badge-delivered',

                                    'cancelled'
                                    =>
                                    'badge-cancelled',

                                    default
                                    =>
                                    'bg-secondary text-white'

                                };


                            $statusText =
                                match(
                                    $order->status
                                ) {

                                    'pending'
                                    =>
                                    'Chờ xác nhận',

                                    'confirmed'
                                    =>
                                    'Đã xác nhận',

                                    'shipped'
                                    =>
                                    'Đang giao',

                                    'delivered'
                                    =>
                                    'Đã giao',

                                    'cancelled'
                                    =>
                                    'Đã hủy',

                                    default
                                    =>
                                    $order->status

                                };

                        @endphp


                        <tr>

                            <td
                                class="
                                    ps-4
                                    fw-bold
                                "
                            >

                                #{{ $order->id }}

                            </td>


                            <td>

                                {{
                                    $order
                                        ->customer_name
                                    ??
                                    $order
                                        ->user
                                        ?->name
                                    ??
                                    'Khách hàng'
                                }}

                            </td>


                            <td
                                class="
                                    fw-bold
                                "
                            >

                                {{
                                    number_format(
                                        $order
                                            ->total_price,
                                        0,
                                        ',',
                                        '.'
                                    )
                                }}
                                đ

                            </td>


                            <td>

                                {{
                                    $order
                                        ->payment_method
                                    ===
                                    'bank'
                                    ?
                                    '🏦 Chuyển khoản'
                                    :
                                    '💵 COD'
                                }}

                            </td>


                            <td>

                                <span
                                    class="
                                        badge
                                        {{
                                            $statusClass
                                        }}
                                    "
                                >

                                    {{
                                        $statusText
                                    }}

                                </span>

                            </td>


                            <td>

                                {{
                                    $order
                                        ->created_at
                                    ?
                                    $order
                                        ->created_at
                                        ->format(
                                            'd/m/Y H:i'
                                        )
                                    :
                                    'N/A'
                                }}

                            </td>

                        </tr>


                    @empty


                        <tr>

                            <td
                                colspan="6"
                                class="
                                    text-center
                                    py-5
                                    text-muted
                                "
                            >

                                Chưa có đơn hàng.

                            </td>

                        </tr>


                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>



{{-- ==========================================
    CHART.JS
=========================================== --}}

<script
    src="
    https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js
    "
>
</script>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const canvas =
            document.getElementById(
                'revenueChart'
            );


        if (
            !canvas
            ||
            typeof Chart
            ===
            'undefined'
        ) {

            return;

        }


        new Chart(

            canvas,

            {

                type:
                    'bar',


                data: {

                    labels:
                        @json(
                            $revenueLabels
                        ),


                    datasets: [

                        {

                            label:
                                'Doanh thu',


                            data:
                                @json(
                                    $revenueData
                                ),


                            backgroundColor:
                                'rgba(95,52,29,0.75)',


                            borderColor:
                                '#5f341d',


                            borderWidth:
                                1,


                            borderRadius:
                                8,


                            maxBarThickness:
                                58

                        }

                    ]

                },


                options: {

                    responsive:
                        true,


                    maintainAspectRatio:
                        false,


                    plugins: {

                        legend: {

                            display:
                                false

                        },


                        tooltip: {

                            callbacks: {

                                label:
                                    function (
                                        context
                                    ) {

                                        const value =
                                            Number(
                                                context
                                                    .raw
                                                ||
                                                0
                                            );


                                        return (

                                            new Intl
                                                .NumberFormat(
                                                    'vi-VN'
                                                )
                                                .format(
                                                    value
                                                )

                                            +

                                            ' đ'

                                        );

                                    }

                            }

                        }

                    },


                    scales: {

                        x: {

                            grid: {

                                display:
                                    false

                            }

                        },


                        y: {

                            beginAtZero:
                                true,


                            ticks: {

                                callback:
                                    function (
                                        value
                                    ) {

                                        if (
                                            value
                                            >=
                                            1000000
                                        ) {

                                            return (

                                                value
                                                /
                                                1000000

                                            )
                                            +
                                            'tr';

                                        }


                                        if (
                                            value
                                            >=
                                            1000
                                        ) {

                                            return (

                                                value
                                                /
                                                1000

                                            )
                                            +
                                            'k';

                                        }


                                        return value;

                                    }

                            }

                        }

                    }

                }

            }

        );

    }

);

</script>


</div>

@endsection