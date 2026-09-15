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


    .stat-card-link {
        display: block;
        height: 100%;
        color: inherit;
        text-decoration: none;
    }

    .stat-card-link:hover {
        color: inherit;
    }

    .metric-mini-card {
        height: 100%;
        padding: 16px 18px;
        border: 1px solid var(--tb-border);
        border-radius: 15px;
        background: linear-gradient(135deg, #fff, var(--tb-cream));
    }

    .metric-mini-label {
        color: #7b6c62;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .metric-mini-value {
        margin-top: 5px;
        color: var(--tb-brown-dark);
        font-size: 21px;
        font-weight: 900;
    }

    .chart-period-select {
        width: auto;
        min-width: 135px;
        border-color: var(--tb-border);
        color: var(--tb-brown-dark);
        font-weight: 700;
    }

    .order-id-link {
        color: var(--tb-brown);
        font-weight: 900;
        text-decoration: none;
    }

    .order-id-link:hover {
        color: var(--tb-red);
        text-decoration: underline;
    }


</style>



{{-- ==========================================
    HEADER
=========================================== --}}

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



    {{-- KHÁCH HÀNG --}}
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

                        Tài khoản Customer

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
    CHỈ SỐ KINH DOANH NHANH
=========================================== --}}
<div class="row g-3 mb-4">

    <div class="col-xl-3 col-md-6">
        <div class="metric-mini-card">
            <div class="metric-mini-label">📅 Doanh thu tháng này</div>
            <div class="metric-mini-value" style="color: var(--tb-red);">
                {{ number_format($monthRevenue, 0, ',', '.') }} đ
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="metric-mini-card">
            <div class="metric-mini-label">🧾 Đơn tạo hôm nay</div>
            <div class="metric-mini-value">
                {{ $todayOrders }} đơn
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="metric-mini-card">
            <div class="metric-mini-label">💳 Giá trị đơn trung bình</div>
            <div class="metric-mini-value">
                {{ number_format($averageOrderValue, 0, ',', '.') }} đ
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="metric-mini-card">
            <div class="metric-mini-label">❌ Tỷ lệ hủy đơn</div>
            <div
                class="metric-mini-value"
                style="color: {{ $cancelRate >= 20 ? 'var(--tb-red)' : 'var(--tb-green)' }};"
            >
                {{ number_format($cancelRate, 1, ',', '.') }}%
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


                <div class="d-flex align-items-center gap-2">
                    <small class="text-muted d-none d-md-inline">
                        Đơn đã giao thành công
                    </small>

                    <select
                        id="revenuePeriod"
                        class="form-select form-select-sm chart-period-select"
                        aria-label="Khoảng thời gian biểu đồ"
                    >
                        <option value="7" selected>7 ngày</option>
                        <option value="30">30 ngày</option>
                        <option value="12">12 tháng</option>
                    </select>
                </div>

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

                                <a
                                    href="{{ route('admin.orders.show', $order) }}"
                                    class="order-id-link"
                                >
                                    #{{ $order->id }}
                                </a>

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


        const revenueSets = {
            '7': {
                labels: @json($revenueLabels),
                data: @json($revenueData)
            },
            '30': {
                labels: @json($revenue30Labels),
                data: @json($revenue30Data)
            },
            '12': {
                labels: @json($revenue12Labels),
                data: @json($revenue12Data)
            }
        };

        const revenueChart = new Chart(

            canvas,

            {

                type:
                    'bar',


                data: {

                    labels:
                        revenueSets['7'].labels,


                    datasets: [

                        {

                            label:
                                'Doanh thu',


                            data:
                                revenueSets['7'].data,


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

        const periodSelect =
            document.getElementById('revenuePeriod');

        if (periodSelect) {
            periodSelect.addEventListener(
                'change',
                function () {
                    const selected =
                        revenueSets[this.value]
                        ?? revenueSets['7'];

                    revenueChart.data.labels =
                        selected.labels;

                    revenueChart.data.datasets[0].data =
                        selected.data;

                    revenueChart.update();
                }
            );
        }

    }

);

</script>


@endsection