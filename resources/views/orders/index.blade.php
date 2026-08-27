@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')

<style>
    .order-card {
        border-radius: 18px;
        overflow: hidden;
        transition: all 0.25s ease;
    }

    .order-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08) !important;
    }

    .order-header {
        background: linear-gradient(90deg, #f8f9ff, #eef2ff);
        border-bottom: 1px solid #e5e7eb;
    }

    .status-badge {
        font-size: 14px;
        padding: 9px 15px;
        border-radius: 30px;
    }

    .tracking-wrapper {
        position: relative;
        margin-top: 25px;
        margin-bottom: 30px;
    }

    .tracking-line {
        position: absolute;
        top: 23px;
        left: 12.5%;
        right: 12.5%;
        height: 4px;
        background: #e5e7eb;
        z-index: 1;
    }

    .tracking-progress {
        position: absolute;
        top: 23px;
        left: 12.5%;
        height: 4px;
        background: #198754;
        z-index: 2;
        transition: width 0.4s ease;
    }

    .tracking-step {
        position: relative;
        z-index: 3;
        text-align: center;
    }

    .tracking-circle {
        width: 48px;
        height: 48px;
        margin: auto;
        border-radius: 50%;
        background: #e5e7eb;
        color: #6c757d;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        font-weight: bold;
        border: 4px solid white;
        box-shadow: 0 2px 8px rgba(0,0,0,.08);
    }

    .tracking-circle.active {
        background: #198754;
        color: white;
    }

    .tracking-circle.current {
        background: #0d6efd;
        color: white;
    }

    .tracking-label {
        margin-top: 8px;
        font-size: 13px;
        color: #6c757d;
    }

    .tracking-label.active {
        color: #198754;
        font-weight: bold;
    }

    .tracking-label.current {
        color: #0d6efd;
        font-weight: bold;
    }

    .info-box {
        background: #f8f9fa;
        border-radius: 14px;
        padding: 18px;
        height: 100%;
    }

    .product-table th {
        white-space: nowrap;
    }

    .filter-btn {
        border-radius: 25px;
        padding-left: 15px;
        padding-right: 15px;
    }

    @media (max-width: 768px) {
        .tracking-label {
            font-size: 11px;
        }

        .tracking-circle {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .tracking-line,
        .tracking-progress {
            top: 19px;
        }
    }
</style>


<div class="row justify-content-center">

    <div class="col-xl-11 col-lg-12">

        {{-- ==============================
            TIÊU ĐỀ
        ============================== --}}
        <div class="mb-4">

            <h2 class="fw-bold mb-1">
                📋 Đơn hàng của tôi
            </h2>

            <p class="text-muted mb-0">
                Theo dõi trạng thái và lịch sử tất cả đơn hàng của bạn
            </p>

        </div>


        {{-- ==============================
            BỘ LỌC TRẠNG THÁI
        ============================== --}}
        <div class="d-flex flex-wrap gap-2 mb-4">

            <a href="{{ route('orders.index') }}"
               class="btn filter-btn
               {{ !request('status') ? 'btn-dark' : 'btn-outline-dark' }}">

                📋 Tất cả

            </a>


            <a href="{{ route('orders.index', ['status' => 'pending']) }}"
               class="btn filter-btn
               {{ request('status') === 'pending'
                    ? 'btn-warning'
                    : 'btn-outline-warning' }}">

                ⏳ Chờ xác nhận

            </a>


            <a href="{{ route('orders.index', ['status' => 'confirmed']) }}"
               class="btn filter-btn
               {{ request('status') === 'confirmed'
                    ? 'btn-info'
                    : 'btn-outline-info' }}">

                ✓ Đã xác nhận

            </a>


            <a href="{{ route('orders.index', ['status' => 'shipped']) }}"
               class="btn filter-btn
               {{ request('status') === 'shipped'
                    ? 'btn-primary'
                    : 'btn-outline-primary' }}">

                🚚 Đang giao

            </a>


            <a href="{{ route('orders.index', ['status' => 'delivered']) }}"
               class="btn filter-btn
               {{ request('status') === 'delivered'
                    ? 'btn-success'
                    : 'btn-outline-success' }}">

                ✅ Đã giao

            </a>


            <a href="{{ route('orders.index', ['status' => 'cancelled']) }}"
               class="btn filter-btn
               {{ request('status') === 'cancelled'
                    ? 'btn-danger'
                    : 'btn-outline-danger' }}">

                ❌ Đã hủy

            </a>

        </div>


        {{-- ==============================
            KHÔNG CÓ ĐƠN HÀNG
        ============================== --}}
        @if($orders->isEmpty())

            <div class="card shadow-sm border-0">

                <div class="card-body text-center py-5">

                    <div style="font-size: 65px;">
                        📭
                    </div>

                    <h4 class="fw-bold mt-3">

                        @if(request('status'))

                            Không có đơn hàng nào

                        @else

                            Bạn chưa có đơn hàng

                        @endif

                    </h4>


                    <p class="text-muted">

                        @if(request('status'))

                            Không tìm thấy đơn hàng với trạng thái này.

                        @else

                            Hãy lựa chọn sản phẩm và đặt đơn hàng đầu tiên.

                        @endif

                    </p>


                    <a href="{{ route('products.index') }}"
                       class="btn btn-primary btn-lg">

                        🛍️ Mua sắm ngay

                    </a>

                </div>

            </div>


        @else


            {{-- ==============================
                DANH SÁCH ĐƠN
            ============================== --}}
            @foreach($orders as $order)

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | TRẠNG THÁI
                    |--------------------------------------------------------------------------
                    */

                    $statusClass = [
                        'pending'   => 'warning',
                        'confirmed' => 'info',
                        'shipped'   => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                    ][$order->status] ?? 'secondary';


                    $statusText = [
                        'pending'   => '⏳ Chờ xác nhận',
                        'confirmed' => '✓ Đã xác nhận',
                        'shipped'   => '🚚 Đang giao hàng',
                        'delivered' => '✅ Đã giao hàng',
                        'cancelled' => '❌ Đã hủy',
                    ][$order->status] ?? 'Không xác định';


                    /*
                    |--------------------------------------------------------------------------
                    | BƯỚC GIAO HÀNG
                    |--------------------------------------------------------------------------
                    */

                    $statusStep = [
                        'pending'   => 1,
                        'confirmed' => 2,
                        'shipped'   => 3,
                        'delivered' => 4,
                    ][$order->status] ?? 0;


                    /*
                    |--------------------------------------------------------------------------
                    | ĐỘ DÀI THANH TIẾN TRÌNH
                    |--------------------------------------------------------------------------
                    */

                    $progressWidth = match($statusStep) {
                        1 => '0%',
                        2 => '33.33%',
                        3 => '66.66%',
                        4 => '75%',
                        default => '0%',
                    };

                @endphp


                <div class="card order-card shadow-sm border-0 mb-4">


                    {{-- ==============================
                        HEADER ĐƠN HÀNG
                    ============================== --}}
                    <div class="card-header order-header p-4">

                        <div class="row align-items-center">


                            <div class="col-md-6">

                                <div class="text-muted small mb-1">
                                    Mã đơn hàng
                                </div>

                                <h5 class="fw-bold mb-1">

                                    #{{ str_pad(
                                        $order->id,
                                        6,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}

                                </h5>


                                <small class="text-muted">

                                    🕐 Đặt lúc:

                                    {{ $order->created_at
                                        ->format('d/m/Y H:i') }}

                                </small>

                            </div>


                            <div class="col-md-6 text-md-end mt-3 mt-md-0">

                                <div class="text-muted small mb-2">

                                    Trạng thái hiện tại

                                </div>


                                <span class="
                                    badge
                                    bg-{{ $statusClass }}
                                    status-badge">

                                    {{ $statusText }}

                                </span>

                            </div>


                        </div>

                    </div>



                    <div class="card-body p-4">


                        {{-- ==============================
                            ĐƠN HÀNG BỊ HỦY
                        ============================== --}}
                        @if($order->status === 'cancelled')

                            <div class="alert alert-danger">

                                <div class="d-flex align-items-center">

                                    <div class="fs-2 me-3">
                                        ❌
                                    </div>

                                    <div>

                                        <strong>
                                            Đơn hàng đã bị hủy
                                        </strong>

                                        <div class="small mt-1">

                                            Đơn hàng này hiện không còn
                                            trong quá trình giao hàng.

                                        </div>

                                    </div>

                                </div>

                            </div>


                        @else


                            {{-- ==============================
                                THEO DÕI ĐƠN HÀNG
                            ============================== --}}
                            <div class="mb-5">


                                <h5 class="fw-bold mb-1">

                                    🚚 Theo dõi đơn hàng

                                </h5>


                                <p class="text-muted small">

                                    Trạng thái được cập nhật bởi cửa hàng

                                </p>



                                <div class="tracking-wrapper">


                                    {{-- Đường xám --}}
                                    <div class="tracking-line"></div>


                                    {{-- Đường xanh --}}
                                    <div class="tracking-progress"
                                         style="width: {{ $progressWidth }};">
                                    </div>



                                    <div class="row g-0">


                                        {{-- =====================
                                            BƯỚC 1
                                        ===================== --}}
                                        <div class="col tracking-step">


                                            <div class="
                                                tracking-circle
                                                {{ $statusStep > 1
                                                    ? 'active'
                                                    : '' }}

                                                {{ $statusStep === 1
                                                    ? 'current'
                                                    : '' }}
                                            ">

                                                🛒

                                            </div>


                                            <div class="
                                                tracking-label
                                                {{ $statusStep > 1
                                                    ? 'active'
                                                    : '' }}

                                                {{ $statusStep === 1
                                                    ? 'current'
                                                    : '' }}
                                            ">

                                                Chờ xác nhận

                                            </div>

                                        </div>



                                        {{-- =====================
                                            BƯỚC 2
                                        ===================== --}}
                                        <div class="col tracking-step">


                                            <div class="
                                                tracking-circle

                                                {{ $statusStep > 2
                                                    ? 'active'
                                                    : '' }}

                                                {{ $statusStep === 2
                                                    ? 'current'
                                                    : '' }}
                                            ">

                                                ✓

                                            </div>


                                            <div class="
                                                tracking-label

                                                {{ $statusStep > 2
                                                    ? 'active'
                                                    : '' }}

                                                {{ $statusStep === 2
                                                    ? 'current'
                                                    : '' }}
                                            ">

                                                Đã xác nhận

                                            </div>

                                        </div>



                                        {{-- =====================
                                            BƯỚC 3
                                        ===================== --}}
                                        <div class="col tracking-step">


                                            <div class="
                                                tracking-circle

                                                {{ $statusStep > 3
                                                    ? 'active'
                                                    : '' }}

                                                {{ $statusStep === 3
                                                    ? 'current'
                                                    : '' }}
                                            ">

                                                🚚

                                            </div>


                                            <div class="
                                                tracking-label

                                                {{ $statusStep > 3
                                                    ? 'active'
                                                    : '' }}

                                                {{ $statusStep === 3
                                                    ? 'current'
                                                    : '' }}
                                            ">

                                                Đang giao

                                            </div>

                                        </div>



                                        {{-- =====================
                                            BƯỚC 4
                                        ===================== --}}
                                        <div class="col tracking-step">


                                            <div class="
                                                tracking-circle

                                                {{ $statusStep >= 4
                                                    ? 'active'
                                                    : '' }}
                                            ">

                                                ✅

                                            </div>


                                            <div class="
                                                tracking-label

                                                {{ $statusStep >= 4
                                                    ? 'active'
                                                    : '' }}
                                            ">

                                                Đã giao

                                            </div>

                                        </div>


                                    </div>

                                </div>

                            </div>

                        @endif



                        {{-- ==============================
                            THÔNG TIN ĐƠN HÀNG
                        ============================== --}}
                        <div class="row g-4 mb-4">


                            {{-- GIAO HÀNG --}}
                            <div class="col-md-7">

                                <div class="info-box">

                                    <h5 class="fw-bold mb-3">

                                        📍 Thông tin giao hàng

                                    </h5>


                                    <div class="mb-2">

                                        <span class="text-muted">

                                            Người nhận:

                                        </span>

                                        <strong>

                                            {{ $order->customer_name
                                                ?? 'Chưa cập nhật' }}

                                        </strong>

                                    </div>


                                    <div class="mb-2">

                                        <span class="text-muted">

                                            Số điện thoại:

                                        </span>

                                        <strong>

                                            {{ $order->customer_phone
                                                ?? 'Chưa cập nhật' }}

                                        </strong>

                                    </div>


                                    <div class="mb-2">

                                        <span class="text-muted">

                                            Địa chỉ:

                                        </span>

                                        <strong>

                                            {{ $order->shipping_address
                                                ?? 'Chưa cập nhật' }}

                                        </strong>

                                    </div>


                                    @if($order->notes)

                                        <div class="mt-3">

                                            <span class="text-muted">

                                                Ghi chú:

                                            </span>

                                            {{ $order->notes }}

                                        </div>

                                    @endif


                                </div>

                            </div>



{{-- THANH TOÁN --}}
<div class="col-md-5">

    <div class="info-box">

        <h5 class="fw-bold mb-3">
            💳 Thanh toán
        </h5>


        {{-- PHƯƠNG THỨC THANH TOÁN --}}
        <div class="mb-3">

            <div class="text-muted small mb-1">
                Phương thức
            </div>

            @if($order->payment_method === 'cod')

                <span class="badge bg-secondary">
                    💵 Thanh toán khi nhận hàng
                </span>

            @elseif($order->payment_method === 'bank')

                <span class="badge bg-primary">
                    🏦 Chuyển khoản ngân hàng
                </span>

            @else

                <span class="badge bg-secondary">
                    {{ strtoupper(
                        $order->payment_method ?? 'Không xác định'
                    ) }}
                </span>

            @endif

        </div>


        <hr>


        {{-- TRẠNG THÁI THANH TOÁN --}}
        <div class="mb-3">

            <div class="text-muted small mb-2">
                Trạng thái thanh toán
            </div>


            {{-- ĐÃ THANH TOÁN --}}
            @if($order->payment_status === 'paid')

                <div class="alert alert-success mb-0">

                    <strong>
                        ✅ Đã thanh toán
                    </strong>

                    <div class="small mt-1">
                        Shop đã xác nhận nhận được tiền.
                    </div>

                </div>


            {{-- CHỜ ADMIN XÁC NHẬN --}}
            @elseif($order->payment_status === 'pending_confirmation')

                <div class="alert alert-warning">

                    <strong>
                        ⏳ Chờ xác nhận chuyển khoản
                    </strong>

                    <div class="small mt-1">
                        Khách hàng đã báo chuyển khoản.
                        Vui lòng kiểm tra tài khoản ngân hàng
                        trước khi xác nhận.
                    </div>

                </div>


                {{-- NÚT ADMIN XÁC NHẬN ĐÃ NHẬN TIỀN --}}
                <form
                    action="{{ route(
                        'admin.orders.confirmPayment',
                        $order->id
                    ) }}"
                    method="POST"
                    onsubmit="return confirm('Bạn xác nhận đã nhận được tiền của đơn hàng này?');"
                >

                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="btn btn-success w-100"
                    >
                        ✅ Xác nhận đã thanh toán
                    </button>

                </form>


            {{-- CHƯA THANH TOÁN --}}
            @else

                <div class="alert alert-secondary mb-0">

                    <strong>
                        💵 Chưa thanh toán
                    </strong>

                    @if($order->payment_method === 'cod')

                        <div class="small mt-1">
                            Khách hàng sẽ thanh toán khi nhận hàng.
                        </div>

                    @endif

                </div>

            @endif

        </div>


        <hr>


        {{-- TỔNG THANH TOÁN --}}
        <div class="text-muted small">
            Tổng thanh toán
        </div>

        <h3 class="text-danger fw-bold mb-0">

            {{ number_format(
                $order->total_price,
                0,
                ',',
                '.'
            ) }} đ

        </h3>

    </div>

</div>


                        </div>



                        {{-- ==============================
                            DANH SÁCH SẢN PHẨM
                        ============================== --}}
                        <div>

                            <h5 class="fw-bold mb-3">

                                📦 Sản phẩm trong đơn hàng

                            </h5>


                            <div class="table-responsive">

                                <table class="
                                    table
                                    table-hover
                                    product-table
                                    align-middle
                                    mb-0">


                                    <thead class="table-light">

                                        <tr>

                                            <th>
                                                Sản phẩm
                                            </th>

                                            <th>
                                                Đơn giá
                                            </th>

                                            <th class="text-center">
                                                Số lượng
                                            </th>

                                            <th class="text-end">
                                                Thành tiền
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>


                                        @forelse(
                                            $order->items
                                            as $item
                                        )

                                            <tr>

                                                <td>

                                                    <strong>

                                                        {{ $item->product->name
                                                            ?? 'Sản phẩm' }}

                                                    </strong>

                                                </td>


                                                <td>

                                                    {{ number_format(
                                                        $item->price,
                                                        0,
                                                        ',',
                                                        '.'
                                                    ) }} đ

                                                </td>


                                                <td class="text-center">

                                                    <span class="
                                                        badge
                                                        bg-light
                                                        text-dark
                                                        border">

                                                        {{ $item->quantity }}

                                                    </span>

                                                </td>


                                                <td class="
                                                    fw-bold
                                                    text-danger
                                                    text-end">

                                                    {{ number_format(
                                                        $item->price
                                                        *
                                                        $item->quantity,
                                                        0,
                                                        ',',
                                                        '.'
                                                    ) }} đ

                                                </td>

                                            </tr>


                                        @empty


                                            <tr>

                                                <td colspan="4"
                                                    class="
                                                        text-center
                                                        text-muted
                                                        py-4">

                                                    Không có sản phẩm
                                                    trong đơn hàng.

                                                </td>

                                            </tr>


                                        @endforelse


                                    </tbody>

                                </table>

                            </div>

                        </div>


                    </div>



                    {{-- ==============================
                        FOOTER
                    ============================== --}}
                    <div class="
                        card-footer
                        bg-light
                        border-top
                        p-3">


                        <div class="
                            d-flex
                            justify-content-between
                            align-items-center
                            flex-wrap
                            gap-3">


                            <small class="text-muted">

                                🔄 Cập nhật gần nhất:

                                <strong>

                                    {{ $order->updated_at
                                        ->format('d/m/Y H:i') }}

                                </strong>

                            </small>


                            <a href="{{ route('products.index') }}"
                               class="btn btn-primary">

                                🛍️ Tiếp tục mua sắm

                            </a>


                        </div>

                    </div>


                </div>


            @endforeach


        @endif


    </div>

</div>

@endsection