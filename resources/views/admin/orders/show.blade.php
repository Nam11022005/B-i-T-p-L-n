@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')

<style>
    .order-detail-card {
        border-radius: 18px;
        overflow: hidden;
        border: none;
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.07);
    }

    .section-title {
        font-weight: 700;
        margin-bottom: 18px;
    }

    .info-item {
        margin-bottom: 14px;
    }

    .info-label {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 3px;
    }

    .info-value {
        font-weight: 600;
        color: #111827;
    }

    .status-current {
        padding: 10px 18px;
        border-radius: 30px;
        font-weight: 700;
        display: inline-block;
    }

    .timeline-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
    }

    .timeline-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        flex-shrink: 0;
    }

    .timeline-active {
        background: #198754;
        color: white;
    }

    .timeline-current {
        background: #0d6efd;
        color: white;
    }

    .timeline-inactive {
        background: #e9ecef;
        color: #6c757d;
    }

    .product-table th {
        white-space: nowrap;
    }
</style>


<div class="container-fluid">

    {{-- ==========================================
        HEADER
    ========================================== --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                🧾 Chi tiết đơn hàng
                #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}

            </h2>

            <p class="text-muted mb-0">

                Đặt lúc:
                {{ $order->created_at->format('d/m/Y H:i:s') }}

            </p>

        </div>


        <a href="{{ route('admin.orders.index') }}"
           class="btn btn-outline-secondary">

            ← Quay lại danh sách

        </a>

    </div>


    {{-- ==========================================
        THÔNG BÁO
    ========================================== --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show shadow-sm">

            ✅ {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-danger shadow-sm">

            <strong>❌ Có lỗi xảy ra:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif



    @php

        /*
        |--------------------------------------------------------------------------
        | TRẠNG THÁI
        |--------------------------------------------------------------------------
        */

        $statusClass = [
            'pending'   => 'bg-warning text-dark',
            'confirmed' => 'bg-info text-dark',
            'shipped'   => 'bg-primary text-white',
            'delivered' => 'bg-success text-white',
            'cancelled' => 'bg-danger text-white',
        ][$order->status] ?? 'bg-secondary text-white';


        $statusText = [
            'pending'   => '⏳ Chờ xác nhận',
            'confirmed' => '✓ Đã xác nhận',
            'shipped'   => '🚚 Đang giao hàng',
            'delivered' => '✅ Đã giao hàng',
            'cancelled' => '❌ Đã hủy',
        ][$order->status] ?? 'Không xác định';


        /*
        |--------------------------------------------------------------------------
        | BƯỚC TRẠNG THÁI
        |--------------------------------------------------------------------------
        */

        $statusStep = [
            'pending'   => 1,
            'confirmed' => 2,
            'shipped'   => 3,
            'delivered' => 4,
        ][$order->status] ?? 0;

    @endphp



    <div class="row g-4">


        {{-- ==========================================
            CỘT TRÁI
        ========================================== --}}
        <div class="col-lg-8">


            {{-- ======================================
                THÔNG TIN KHÁCH HÀNG
            ====================================== --}}
            <div class="card order-detail-card mb-4">

                <div class="card-header bg-dark text-white p-3">

                    <h5 class="mb-0">
                        👤 Thông tin khách hàng
                    </h5>

                </div>


                <div class="card-body p-4">

                    <div class="row g-4">


                        {{-- TÀI KHOẢN --}}
                        <div class="col-md-6">

                            <h6 class="fw-bold mb-3">
                                👤 Tài khoản đặt hàng
                            </h6>


                            <div class="info-item">

                                <div class="info-label">
                                    Tên tài khoản
                                </div>

                                <div class="info-value">

                                    {{ $order->user->name ?? 'Không xác định' }}

                                </div>

                            </div>


                            <div class="info-item">

                                <div class="info-label">
                                    Email
                                </div>

                                <div class="info-value">

                                    {{ $order->user->email ?? 'Không có' }}

                                </div>

                            </div>

                        </div>



                        {{-- NGƯỜI NHẬN --}}
                        <div class="col-md-6">

                            <h6 class="fw-bold mb-3">
                                📦 Người nhận hàng
                            </h6>


                            <div class="info-item">

                                <div class="info-label">
                                    Họ và tên
                                </div>

                                <div class="info-value">

                                    {{ $order->customer_name ?? 'Không có' }}

                                </div>

                            </div>


                            <div class="info-item">

                                <div class="info-label">
                                    Số điện thoại
                                </div>

                                <div class="info-value">

                                    {{ $order->customer_phone ?? 'Không có' }}

                                </div>

                            </div>

                        </div>

                    </div>


                    <hr>


                    {{-- ĐỊA CHỈ --}}
                    <div>

                        <h6 class="fw-bold mb-3">
                            📍 Địa chỉ giao hàng
                        </h6>

                        <p class="mb-2">

                            {{ $order->shipping_address ?? 'Chưa có địa chỉ' }}

                        </p>


                        @if($order->notes)

                            <div class="alert alert-light mb-0">

                                <strong>📝 Ghi chú:</strong>

                                {{ $order->notes }}

                            </div>

                        @endif

                    </div>

                </div>

            </div>



            {{-- ======================================
                DANH SÁCH SẢN PHẨM
            ====================================== --}}
            <div class="card order-detail-card">

                <div class="card-header bg-primary text-white p-3">

                    <h5 class="mb-0">
                        📦 Sản phẩm trong đơn hàng
                    </h5>

                </div>


                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover product-table align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="ps-4">
                                        Sản phẩm
                                    </th>

                                    <th>
                                        Đơn giá
                                    </th>

                                    <th class="text-center">
                                        Số lượng
                                    </th>

                                    <th class="text-end pe-4">
                                        Thành tiền
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($order->items as $item)

                                    <tr>

                                        <td class="ps-4">

                                            <strong>

                                                {{ $item->product->name ?? 'Sản phẩm không tồn tại' }}

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

                                            <span class="badge bg-light text-dark border">

                                                {{ $item->quantity }}

                                            </span>

                                        </td>


                                        <td class="text-end pe-4 text-danger fw-bold">

                                            {{ number_format(
                                                $item->price * $item->quantity,
                                                0,
                                                ',',
                                                '.'
                                            ) }} đ

                                        </td>

                                    </tr>


                                @empty

                                    <tr>

                                        <td colspan="4"
                                            class="text-center py-4 text-muted">

                                            Không có sản phẩm trong đơn hàng.

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>



        {{-- ==========================================
            CỘT PHẢI
        ========================================== --}}
        <div class="col-lg-4">


            {{-- ======================================
                QUẢN LÝ TRẠNG THÁI
            ====================================== --}}
            <div class="card order-detail-card mb-4">

                <div class="card-header bg-dark text-white p-3">

                    <h5 class="mb-0">
                        🚚 Quản lý trạng thái
                    </h5>

                </div>


                <div class="card-body p-4">


                    {{-- TRẠNG THÁI HIỆN TẠI --}}
                    <div class="text-center mb-4">

                        <div class="text-muted mb-2">

                            Trạng thái hiện tại

                        </div>


                        <span class="status-current {{ $statusClass }}">

                            {{ $statusText }}

                        </span>

                    </div>



                    {{-- ==================================
                        FORM CẬP NHẬT
                    ================================== --}}
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}"
                          method="POST">

                        @csrf

                        @method('PATCH')


                        <div class="mb-3">

                            <label class="form-label fw-bold">

                                Thay đổi trạng thái đơn hàng

                            </label>


                            <select name="status"
                                    class="form-select form-select-lg"
                                    required>


                                <option value="pending"
                                    {{ $order->status === 'pending' ? 'selected' : '' }}>

                                    ⏳ Chờ xác nhận

                                </option>


                                <option value="confirmed"
                                    {{ $order->status === 'confirmed' ? 'selected' : '' }}>

                                    ✓ Đã xác nhận

                                </option>


                                <option value="shipped"
                                    {{ $order->status === 'shipped' ? 'selected' : '' }}>

                                    🚚 Đang giao hàng

                                </option>


                                <option value="delivered"
                                    {{ $order->status === 'delivered' ? 'selected' : '' }}>

                                    ✅ Đã giao hàng

                                </option>


                                <option value="cancelled"
                                    {{ $order->status === 'cancelled' ? 'selected' : '' }}>

                                    ❌ Đã hủy

                                </option>

                            </select>

                        </div>


                        <button type="submit"
                                class="btn btn-primary btn-lg w-100">

                            💾 Cập nhật trạng thái

                        </button>

                    </form>



                    <hr class="my-4">



                    {{-- ==================================
                        TIẾN TRÌNH
                    ================================== --}}
                    <h6 class="fw-bold mb-3">

                        📍 Tiến trình đơn hàng

                    </h6>


                    @if($order->status === 'cancelled')


                        <div class="alert alert-danger mb-0">

                            ❌ Đơn hàng này đã bị hủy.

                        </div>


                    @else


                        {{-- PENDING --}}
                        <div class="timeline-item">

                            <div class="
                                timeline-circle
                                {{ $statusStep === 1
                                    ? 'timeline-current'
                                    : 'timeline-active' }}">

                                ✓

                            </div>


                            <div>

                                <strong>
                                    Chờ xác nhận
                                </strong>

                                <div class="small text-muted">

                                    Khách hàng đã đặt hàng

                                </div>

                            </div>

                        </div>



                        {{-- CONFIRMED --}}
                        <div class="timeline-item">

                            <div class="
                                timeline-circle
                                {{ $statusStep === 2
                                    ? 'timeline-current'
                                    : ($statusStep > 2
                                        ? 'timeline-active'
                                        : 'timeline-inactive') }}">

                                ✓

                            </div>


                            <div>

                                <strong>
                                    Đã xác nhận
                                </strong>

                                <div class="small text-muted">

                                    Cửa hàng xác nhận đơn

                                </div>

                            </div>

                        </div>



                        {{-- SHIPPED --}}
                        <div class="timeline-item">

                            <div class="
                                timeline-circle
                                {{ $statusStep === 3
                                    ? 'timeline-current'
                                    : ($statusStep > 3
                                        ? 'timeline-active'
                                        : 'timeline-inactive') }}">

                                🚚

                            </div>


                            <div>

                                <strong>
                                    Đang giao hàng
                                </strong>

                                <div class="small text-muted">

                                    Đơn đang được vận chuyển

                                </div>

                            </div>

                        </div>



                        {{-- DELIVERED --}}
                        <div class="timeline-item mb-0">

                            <div class="
                                timeline-circle
                                {{ $statusStep >= 4
                                    ? 'timeline-active'
                                    : 'timeline-inactive' }}">

                                ✅

                            </div>


                            <div>

                                <strong>
                                    Đã giao hàng
                                </strong>

                                <div class="small text-muted">

                                    Khách hàng đã nhận đơn

                                </div>

                            </div>

                        </div>


                    @endif

                </div>

            </div>



            {{-- ======================================
                THANH TOÁN
            ====================================== --}}
            <div class="card order-detail-card">

                <div class="card-header bg-success text-white p-3">

                    <h5 class="mb-0">
                        💰 Thanh toán
                    </h5>

                </div>


                <div class="card-body p-4">


                    <div class="mb-3">

                        <div class="text-muted small mb-1">

                            Phương thức thanh toán

                        </div>


                        @if($order->payment_method === 'cod')

    <span class="badge bg-secondary">
        💵 Thanh toán khi nhận hàng
    </span>

@elseif($order->payment_method === 'bank')

    <span class="badge bg-primary">
        🏦 Chuyển khoản ngân hàng
        @if(
    $order->payment_method === 'bank'
    &&
    $order->payment_code
)

    <div class="mt-3">

        <div class="text-muted small mb-1">
            Mã thanh toán
        </div>

        <div
            class="fw-bold fs-5 text-primary"
            style="letter-spacing: 1px;"
        >
            {{ $order->payment_code }}
        </div>

    </div>

@endif
    </span>

@endif
<div class="mt-4">

    <div class="text-muted small mb-2">
        Trạng thái thanh toán
    </div>


    @if($order->payment_status === 'paid')

        <div class="alert alert-success">

            <strong>
                ✅ Đã thanh toán
            </strong>

            <div class="small mt-1">
                Shop đã xác nhận nhận được tiền.
            </div>

        </div>


    @elseif(
        $order->payment_status
        === 'pending_confirmation'
    )

        <div class="alert alert-warning">

            <strong>
                ⏳ Chờ xác nhận chuyển khoản
            </strong>

            <div class="small mt-1">
                Khách hàng đã báo chuyển khoản.
                Vui lòng kiểm tra tài khoản ngân hàng.
            </div>

        </div>


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


    @else

        <div class="alert alert-secondary">

            💵 Chưa thanh toán

            @if($order->payment_method === 'cod')

                <div class="small mt-1">
                    Khách hàng sẽ thanh toán khi nhận hàng.
                </div>

            @endif

        </div>

    @endif

</div>

                    </div>


                    <hr>


                    <div class="d-flex justify-content-between mb-2">

                        <span class="text-muted">
                            Tạm tính:
                        </span>

                        <strong>

                            {{ number_format(
                                max($order->total_price - 30000, 0),
                                0,
                                ',',
                                '.'
                            ) }} đ

                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Phí vận chuyển:
                        </span>

                        <strong>
                            30.000 đ
                        </strong>

                    </div>


                    <hr>


                    <div class="d-flex justify-content-between align-items-center">

                        <strong>
                            Tổng cộng:
                        </strong>

                        <h4 class="text-danger fw-bold mb-0">

                            {{ number_format(
                                $order->total_price,
                                0,
                                ',',
                                '.'
                            ) }} đ

                        </h4>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection