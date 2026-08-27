@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')

<div class="container py-4">

    {{-- ============================
        TIÊU ĐỀ
    ============================ --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                📦 Chi tiết đơn hàng
                #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
            </h2>

            <p class="text-muted mb-0">
                Quản lý thông tin và trạng thái đơn hàng
            </p>
        </div>

        <a href="{{ route('admin.orders.index') }}"
           class="btn btn-outline-secondary">
            ← Quay lại danh sách
        </a>

    </div>


    {{-- ============================
        THÔNG BÁO
    ============================ --}}
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


    <div class="row g-4">


        {{-- ======================================
            CỘT TRÁI
        ====================================== --}}
        <div class="col-lg-8">


            {{-- THÔNG TIN KHÁCH HÀNG --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-dark text-white py-3">

                    <h5 class="mb-0">
                        👤 Thông tin khách hàng
                    </h5>

                </div>

                <div class="card-body p-4">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <small class="text-muted">
                                Tài khoản đặt hàng
                            </small>

                            <div class="fw-bold">
                                {{ $order->user->name ?? 'Không xác định' }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Email
                            </small>

                            <div class="fw-bold">
                                {{ $order->user->email ?? 'Không có' }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Người nhận
                            </small>

                            <div class="fw-bold">
                                {{ $order->customer_name ?? 'Không có' }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Số điện thoại
                            </small>

                            <div class="fw-bold">
                                {{ $order->customer_phone ?? 'Không có' }}
                            </div>

                        </div>


                        <div class="col-12">

                            <small class="text-muted">
                                Địa chỉ giao hàng
                            </small>

                            <div class="fw-bold">
                                {{ $order->shipping_address ?? 'Không có' }}
                            </div>

                        </div>


                        @if($order->notes)

                            <div class="col-12">

                                <small class="text-muted">
                                    Ghi chú
                                </small>

                                <div>
                                    {{ $order->notes }}
                                </div>

                            </div>

                        @endif

                    </div>

                </div>

            </div>



            {{-- DANH SÁCH SẢN PHẨM --}}
            <div class="card shadow-sm border-0">

                <div class="card-header bg-primary text-white py-3">

                    <h5 class="mb-0">
                        🛒 Sản phẩm trong đơn hàng
                    </h5>

                </div>

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="ps-4">
                                        Sản phẩm
                                    </th>

                                    <th>
                                        Giá
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

                                            <span class="badge bg-secondary">

                                                {{ $item->quantity }}

                                            </span>

                                        </td>


                                        <td class="text-end pe-4 fw-bold text-danger">

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

                                            Không có sản phẩm.

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>



        {{-- ======================================
            CỘT PHẢI
        ====================================== --}}
        <div class="col-lg-4">


            {{-- TRẠNG THÁI HIỆN TẠI --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header py-3">

                    <h5 class="mb-0">
                        🚚 Trạng thái đơn hàng
                    </h5>

                </div>

                <div class="card-body p-4">

                    @php

                        $statusClass = [

                            'pending' => 'warning',

                            'confirmed' => 'info',

                            'shipped' => 'primary',

                            'delivered' => 'success',

                            'cancelled' => 'danger',

                        ][$order->status] ?? 'secondary';


                        $statusText = [

                            'pending' => '⏳ Chờ xác nhận',

                            'confirmed' => '✓ Đã xác nhận',

                            'shipped' => '🚚 Đang giao hàng',

                            'delivered' => '✅ Đã giao hàng',

                            'cancelled' => '❌ Đã hủy',

                        ][$order->status] ?? 'Không xác định';

                    @endphp


                    <div class="text-center mb-4">

                        <div class="text-muted mb-2">
                            Trạng thái hiện tại
                        </div>

                        <span class="badge bg-{{ $statusClass }} fs-6 px-4 py-2">

                            {{ $statusText }}

                        </span>

                    </div>


                    <form
                        action="{{ route('admin.orders.updateStatus', $order->id) }}"
                        method="POST">

                        @csrf

                        @method('PATCH')


                        <div class="mb-3">

                            <label class="form-label fw-bold">

                                Thay đổi trạng thái

                            </label>


                            <select
                                name="status"
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


                        <button
                            type="submit"
                            class="btn btn-primary btn-lg w-100">

                            💾 Cập nhật trạng thái

                        </button>

                    </form>

                </div>

            </div>



            {{-- THÔNG TIN ĐƠN --}}
            <div class="card shadow-sm border-0">

                <div class="card-header py-3">

                    <h5 class="mb-0">
                        💰 Thông tin thanh toán
                    </h5>

                </div>

                <div class="card-body p-4">


                    <div class="mb-3">

                        <small class="text-muted">
                            Mã đơn hàng
                        </small>

                        <div class="fw-bold">

                            #{{ str_pad(
                                $order->id,
                                6,
                                '0',
                                STR_PAD_LEFT
                            ) }}

                        </div>

                    </div>


                    <div class="mb-3">

                        <small class="text-muted">
                            Ngày đặt
                        </small>

                        <div class="fw-bold">

                            {{ $order->created_at->format('d/m/Y H:i') }}

                        </div>

                    </div>


                    <div class="mb-3">

                        <small class="text-muted">
                            Phương thức thanh toán
                        </small>

                        <div>

                            @if($order->payment_method === 'cod')

                                <span class="badge bg-success">
                                    💵 Thanh toán khi nhận hàng
                                </span>

                            @else

                                <span class="badge bg-secondary">

                                    {{ strtoupper(
                                        $order->payment_method ?? 'COD'
                                    ) }}

                                </span>

                            @endif

                        </div>

                    </div>


                    <hr>


                    <div>

                        <small class="text-muted">
                            Tổng thanh toán
                        </small>

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


        </div>

    </div>

</div>

@endsection