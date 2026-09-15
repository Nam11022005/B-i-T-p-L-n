@extends('layouts.app')

@section('title', 'Giỏ hàng | Tinh Hoa Tây Bắc')

@section('content')

<style>
    .cart-page-title {
        font-weight: 800;
        color: #2f241e;
    }

    .cart-card,
    .summary-card,
    .continue-card {
        border: 1px solid #ead8bf;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(95,52,29,.06);
    }

    .cart-table th {
        white-space: nowrap;
        background: #f8efe2;
        color: #5f341d;
        font-weight: 700;
    }

    .cart-table td {
        vertical-align: middle;
    }

    .product-name {
        font-weight: 700;
        color: #2f241e;
    }

    .money {
        font-weight: 800;
        color: #a83b2d;
    }

    .summary-total {
        font-size: 30px;
        font-weight: 900;
        color: #a83b2d;
    }

    .checkout-btn {
        border: 0;
        border-radius: 12px;
        font-weight: 700;
        padding-top: 13px;
        padding-bottom: 13px;
        background: linear-gradient(135deg,#48633b,#2f4b2b);
    }

    .checkout-btn:hover {
        background: linear-gradient(135deg,#3e5634,#253d22);
    }

    .continue-btn {
        border-radius: 10px;
    }

    .unit-pill {
        display: inline-block;
        padding: 4px 9px;
        border-radius: 999px;
        color: #5f341d;
        background: #fffaf0;
        border: 1px solid #ead8bf;
        font-size: 12px;
        font-weight: 700;
    }
</style>

<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-xl-11 col-lg-12">

            <div class="mb-4">
                <h2 class="cart-page-title mb-1">
                    🛒 Giỏ hàng của bạn
                </h2>

                <p class="text-muted mb-0">
                    Kiểm tra số lượng hoặc khối lượng
                    trước khi tiến hành đặt hàng
                </p>
            </div>

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
                                            Đơn giá
                                        </th>

                                        <th style="width: 245px;">
                                            Số lượng / Khối lượng
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
                                            $quantity = (float) $details['quantity'];
                                            $unit = $details['unit'] ?? 'sản phẩm';
                                            $minQty = (float) ($details['min_quantity'] ?? 1);
                                            $stepQty = (float) ($details['quantity_step'] ?? 1);

                                            $subtotal =
                                                $price * $quantity;

                                            $total += $subtotal;

                                            $displayQty =
                                                rtrim(
                                                    rtrim(
                                                        number_format(
                                                            $quantity,
                                                            2,
                                                            '.',
                                                            ''
                                                        ),
                                                        '0'
                                                    ),
                                                    '.'
                                                );
                                        @endphp

                                        <tr>

                                            <td class="ps-4">
                                                <div class="product-name">
                                                    {{ $details['name'] }}
                                                </div>

                                                <span class="unit-pill mt-1">
                                                    Bán theo {{ $unit }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $details['category'] ?? 'Chưa phân loại' }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="fw-bold">
                                                    {{
                                                        number_format(
                                                            $price,
                                                            0,
                                                            ',',
                                                            '.'
                                                        )
                                                    }} đ
                                                </div>

                                                <small class="text-muted">
                                                    / {{ $unit }}
                                                </small>
                                            </td>

                                            <td>

                                                <form
                                                    action="{{ route(
                                                        'cart.update',
                                                        ['id' => $id]
                                                    ) }}"
                                                    method="POST"
                                                    class="d-flex align-items-center flex-wrap gap-2"
                                                >
                                                    @csrf
                                                    @method('PATCH')

                                                    <div class="input-group input-group-sm"
                                                         style="width:145px;">

                                                        <input
                                                            type="number"
                                                            name="quantity"
                                                            value="{{ $displayQty }}"
                                                            min="{{ $minQty }}"
                                                            step="{{ $stepQty }}"
                                                            required
                                                            class="form-control"
                                                        >

                                                        <span class="input-group-text">
                                                            {{ $unit }}
                                                        </span>

                                                    </div>

                                                    <button
                                                        type="submit"
                                                        class="btn btn-primary btn-sm"
                                                    >
                                                        Cập nhật
                                                    </button>
                                                </form>

                                                <small class="text-muted d-block mt-1">
                                                    Bước tăng:
                                                    {{ $stepQty }}
                                                    {{ $unit }}
                                                </small>
                                            </td>

                                            <td class="money">
                                                {{
                                                    number_format(
                                                        $subtotal,
                                                        0,
                                                        ',',
                                                        '.'
                                                    )
                                                }} đ
                                            </td>

                                            <td class="text-center pe-4">

                                                <form
                                                    action="{{ route(
                                                        'cart.destroy',
                                                        ['product' => $id]
                                                    ) }}"
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

                <div class="row g-4 align-items-stretch">

                    <div class="col-lg-5">

                        <div class="card continue-card h-100">

                            <div class="card-body p-4 d-flex flex-column justify-content-center">

                                <div style="font-size:40px;" class="mb-2">
                                    🌿
                                </div>

                                <h5 class="fw-bold mb-2">
                                    Muốn mua thêm đặc sản?
                                </h5>

                                <p class="text-muted mb-4">
                                    Bạn có thể tiếp tục mua sắm trước
                                    khi tiến hành đặt hàng.
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
                                        {{
                                            number_format(
                                                $total,
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }} đ
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

                                <hr>

                                <div class="d-flex justify-content-between align-items-end mb-4">

                                    <div>
                                        <div class="fw-bold fs-5">
                                            Tạm tính
                                        </div>

                                        <small class="text-muted">
                                            Chưa bao gồm phí vận chuyển
                                            và giảm giá
                                        </small>
                                    </div>

                                    <div class="summary-total">
                                        {{
                                            number_format(
                                                $total,
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }} đ
                                    </div>

                                </div>

                                <a
                                    href="{{ route('checkout') }}"
                                    class="btn btn-success btn-lg w-100 checkout-btn"
                                >
                                    🛒 Tiến hành đặt hàng
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            @else

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center py-5">

                        <div style="font-size:65px;" class="mb-3">
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
                            🌿 Mua sắm ngay
                        </a>

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection
