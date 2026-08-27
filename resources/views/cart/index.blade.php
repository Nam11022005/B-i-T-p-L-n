@extends('layouts.app')

@section('title', 'Giỏ hàng của bạn')

@section('content')

<style>
    .cart-page-title {
        font-weight: 800;
        color: #111827;
    }

    .cart-card,
    .summary-card,
    .continue-card {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    }

    .cart-table th {
        white-space: nowrap;
        background: #f8f9fa;
        font-weight: 700;
    }

    .cart-table td {
        vertical-align: middle;
    }

    .product-name {
        font-weight: 700;
        color: #111827;
    }

    .money {
        font-weight: 700;
        color: #dc3545;
    }

    .summary-total {
        font-size: 30px;
        font-weight: 800;
        color: #dc3545;
    }

    .checkout-btn {
        border-radius: 12px;
        font-weight: 700;
        padding-top: 13px;
        padding-bottom: 13px;
    }

    .continue-btn {
        border-radius: 10px;
    }
</style>


<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-xl-11 col-lg-12">

            {{-- ==========================================
                TIÊU ĐỀ
            ========================================== --}}
            <div class="mb-4">

                <h2 class="cart-page-title mb-1">
                    🛒 Giỏ hàng của bạn
                </h2>

                <p class="text-muted mb-0">
                    Kiểm tra sản phẩm trước khi tiến hành đặt hàng
                </p>

            </div>


            {{-- ==========================================
                THÔNG BÁO
            ========================================== --}}
            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show shadow-sm">

                    ✅ {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>

                </div>

            @endif


            @if(session('error'))

                <div class="alert alert-danger alert-dismissible fade show shadow-sm">

                    ❌ {{ session('error') }}

                    <button
                        type="button"
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


            @if(count($cart) > 0)

                @php
                    $total = 0;
                @endphp


                {{-- ==========================================
                    DANH SÁCH SẢN PHẨM
                ========================================== --}}
                <div class="card cart-card mb-4">

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-hover cart-table align-middle mb-0">

                                <thead>

                                    <tr>

                                        <th class="ps-4">
                                            Tên sản phẩm
                                        </th>

                                        <th>
                                            Danh mục
                                        </th>

                                        <th>
                                            Giá
                                        </th>

                                        <th style="width: 200px;">
                                            Số lượng
                                        </th>

                                        <th>
                                            Thành tiền
                                        </th>

                                        <th class="text-center pe-4">
                                            Hành động
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @foreach($cart as $id => $details)

                                        @php
                                            $price = (float) $details['price'];
                                            $quantity = (int) $details['quantity'];
                                            $subtotal = $price * $quantity;
                                            $total += $subtotal;
                                        @endphp


                                        <tr>

                                            {{-- TÊN SẢN PHẨM --}}
                                            <td class="ps-4">

                                                <div class="product-name">
                                                    {{ $details['name'] }}
                                                </div>

                                            </td>


                                            {{-- DANH MỤC --}}
                                            <td>

                                                <span class="badge bg-secondary">

                                                    {{ $details['category'] ?? 'Chưa phân loại' }}

                                                </span>

                                            </td>


                                            {{-- GIÁ --}}
                                            <td>

                                                {{ number_format(
                                                    $price,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }} đ

                                            </td>


                                            {{-- SỐ LƯỢNG --}}
                                            <td>

                                                <form
                                                    action="{{ route('cart.update', ['id' => $id]) }}"
                                                    method="POST"
                                                    class="d-flex align-items-center"
                                                >

                                                    @csrf
                                                    @method('PATCH')


                                                    <input
                                                        type="number"
                                                        name="quantity"
                                                        value="{{ $quantity }}"
                                                        min="1"
                                                        required
                                                        class="form-control form-control-sm me-2"
                                                        style="width: 80px;"
                                                    >


                                                    <button
                                                        type="submit"
                                                        class="btn btn-primary btn-sm"
                                                    >
                                                        Cập nhật
                                                    </button>

                                                </form>

                                            </td>


                                            {{-- THÀNH TIỀN --}}
                                            <td class="money">

                                                {{ number_format(
                                                    $subtotal,
                                                    0,
                                                    ',',
                                                    '.'
                                                ) }} đ

                                            </td>


                                            {{-- XÓA --}}
                                            <td class="text-center pe-4">

                                                <form
                                                    action="{{ route('cart.destroy', ['product' => $id]) }}"
                                                    method="POST"
                                                    class="d-inline"
                                                >

                                                    @csrf
                                                    @method('DELETE')


                                                    <button
                                                        type="submit"
                                                        class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')"
                                                    >
                                                        🗑 Xóa
                                                    </button>

                                                </form>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>


                {{-- ==========================================
                    PHẦN DƯỚI GIỎ HÀNG
                ========================================== --}}
                <div class="row g-4 align-items-stretch">


                    {{-- ======================================
                        TIẾP TỤC MUA SẮM
                    ====================================== --}}
                    <div class="col-lg-5">

                        <div class="card continue-card h-100">

                            <div class="card-body p-4 d-flex flex-column justify-content-center">

                                <div style="font-size: 40px;" class="mb-2">
                                    🛍️
                                </div>

                                <h5 class="fw-bold mb-2">
                                    Muốn mua thêm sản phẩm?
                                </h5>

                                <p class="text-muted mb-4">
                                    Bạn có thể tiếp tục mua sắm và thêm sản phẩm
                                    trước khi tiến hành đặt hàng.
                                </p>


                                <div>

                                    <a
                                        href="{{ route('products.index') }}"
                                        class="btn btn-outline-secondary continue-btn"
                                    >
                                        ← Tiếp tục mua sắm
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ======================================
                        TỔNG ĐƠN HÀNG
                    ====================================== --}}
                    <div class="col-lg-7">

                        <div class="card summary-card h-100">

                            <div class="card-body p-4">

                                <h5 class="fw-bold mb-4">
                                    🧾 Tổng đơn hàng
                                </h5>


                                <div class="d-flex justify-content-between mb-3">

                                    <span class="text-muted">
                                        Tổng tiền sản phẩm
                                    </span>

                                    <strong>
                                        {{ number_format($total, 0, ',', '.') }} đ
                                    </strong>

                                </div>


                                <div class="d-flex justify-content-between mb-3">

                                    <span class="text-muted">
                                        Phí vận chuyển
                                    </span>

                                    <span class="text-muted">
                                        Chọn ở bước thanh toán
                                    </span>

                                </div>


                                <div class="d-flex justify-content-between mb-3">

                                    <span class="text-muted">
                                        Voucher
                                    </span>

                                    <span class="text-muted">
                                        Áp dụng ở bước thanh toán
                                    </span>

                                </div>


                                <div class="d-flex justify-content-between mb-3">

                                    <span class="text-muted">
                                        Phương thức thanh toán
                                    </span>

                                    <span class="text-muted">
                                        Chọn ở bước thanh toán
                                    </span>

                                </div>


                                <hr>


                                <div class="d-flex justify-content-between align-items-end mb-4">

                                    <div>

                                        <div class="fw-bold fs-5">
                                            Tạm tính
                                        </div>

                                        <small class="text-muted">
                                            Chưa bao gồm phí vận chuyển và giảm giá
                                        </small>

                                    </div>


                                    <div class="summary-total">

                                        {{ number_format(
                                            $total,
                                            0,
                                            ',',
                                            '.'
                                        ) }} đ

                                    </div>

                                </div>


                                {{-- ==================================
                                    TIẾN HÀNH ĐẶT HÀNG
                                ================================== --}}
                                <a
                                    href="{{ route('checkout') }}"
                                    class="btn btn-success btn-lg w-100 checkout-btn"
                                >
                                    🛒 Tiến hành đặt hàng
                                </a>


                                <div class="text-center mt-3">

                                    <small class="text-muted">

                                        

                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


            @else


                {{-- ==========================================
                    GIỎ HÀNG TRỐNG
                ========================================== --}}
                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center py-5">

                        <div style="font-size: 65px;" class="mb-3">
                            🛒
                        </div>

                        <h4 class="fw-bold">
                            Giỏ hàng đang trống
                        </h4>

                        <p class="text-muted">
                            Bạn chưa thêm sản phẩm nào vào giỏ hàng.
                        </p>


                        <a
                            href="{{ route('products.index') }}"
                            class="btn btn-primary btn-lg"
                        >
                            🛍️ Mua sắm ngay
                        </a>

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection