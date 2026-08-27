@extends('layouts.app')

@section('title', 'Quản lý đơn hàng')

@section('content')

<style>
    .admin-order-title {
        font-weight: 800;
        color: #111827;
    }

    .stat-card {
        border-radius: 18px;
        border: none;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
    }

    .order-table-card {
        border-radius: 18px;
        overflow: hidden;
        border: none;
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.07);
    }

    .order-table th {
        background: #111827;
        color: white;
        font-weight: 600;
        padding: 16px;
        white-space: nowrap;
    }

    .order-table td {
        padding: 15px 16px;
        vertical-align: middle;
    }

    .status-badge {
        display: inline-block;
        padding: 8px 13px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
    }

    .customer-name {
        font-weight: 700;
        color: #111827;
    }

    .customer-email {
        font-size: 13px;
        color: #6b7280;
    }

    .price-text {
        font-weight: 800;
        color: #dc3545;
    }

    .btn-view {
        border-radius: 9px;
        font-weight: 600;
    }
</style>


<div class="container-fluid">

    {{-- ==========================================
        TIÊU ĐỀ
    ========================================== --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <h2 class="admin-order-title mb-1">
                🧾 Quản lý đơn hàng
            </h2>

            <p class="text-muted mb-0">
                Quản lý tất cả đơn hàng mà khách hàng đã đặt
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="btn btn-outline-dark">

            ← Dashboard

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


    {{-- ==========================================
        THỐNG KÊ
    ========================================== --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">

            <div class="card stat-card">

                <div class="card-body p-4">

                    <div class="text-muted mb-2">
                        📋 Tổng đơn hàng
                    </div>

                    <h2 class="fw-bold mb-0">
                        {{ $totalOrders }}
                    </h2>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card stat-card">

                <div class="card-body p-4">

                    <div class="text-muted mb-2">
                        💰 Doanh thu
                    </div>

                    <h3 class="fw-bold text-success mb-0">

                        {{ number_format(
                            $totalRevenue,
                            0,
                            ',',
                            '.'
                        ) }} đ

                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card stat-card">

                <div class="card-body p-4">

                    <div class="text-muted mb-2">
                        📦 Tổng sản phẩm
                    </div>

                    <h2 class="fw-bold mb-0">
                        {{ $totalProducts }}
                    </h2>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================
        DANH SÁCH ĐƠN HÀNG
    ========================================== --}}
    <div class="card order-table-card">

        <div class="card-header bg-white p-4 border-bottom">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="fw-bold mb-1">
                        Danh sách đơn hàng
                    </h5>

                    <small class="text-muted">
                        Các đơn hàng của khách hàng
                    </small>

                </div>

                <span class="badge bg-dark fs-6">

                    {{ $orders->count() }} đơn hàng

                </span>

            </div>

        </div>


        <div class="card-body p-0">


            @if($orders->isEmpty())

                <div class="text-center py-5">

                    <div style="font-size:60px;">
                        📭
                    </div>

                    <h5 class="mt-3 text-muted">
                        Chưa có đơn hàng nào
                    </h5>

                </div>


            @else


                <div class="table-responsive">

                    <table class="table table-hover order-table mb-0">

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

                                    $statusClass = [
                                        'pending' =>
                                            'bg-warning text-dark',

                                        'confirmed' =>
                                            'bg-info text-dark',

                                        'shipped' =>
                                            'bg-primary text-white',

                                        'delivered' =>
                                            'bg-success text-white',

                                        'cancelled' =>
                                            'bg-danger text-white',

                                    ][$order->status]
                                    ?? 'bg-secondary text-white';


                                    $statusText = [
                                        'pending' =>
                                            '⏳ Chờ xác nhận',

                                        'confirmed' =>
                                            '✓ Đã xác nhận',

                                        'shipped' =>
                                            '🚚 Đang giao',

                                        'delivered' =>
                                            '✅ Đã giao',

                                        'cancelled' =>
                                            '❌ Đã hủy',

                                    ][$order->status]
                                    ?? 'Không xác định';

                                @endphp


                                <tr>


                                    {{-- MÃ ĐƠN --}}
                                    <td>

                                        <strong>

                                            #{{ str_pad(
                                                $order->id,
                                                6,
                                                '0',
                                                STR_PAD_LEFT
                                            ) }}

                                        </strong>

                                    </td>



                                    {{-- KHÁCH HÀNG --}}
                                    <td>

                                        <div class="customer-name">

                                            {{ $order->user->name
                                                ?? 'Không xác định' }}

                                        </div>


                                        <div class="customer-email">

                                            {{ $order->user->email
                                                ?? '' }}

                                        </div>

                                    </td>



                                    {{-- NGƯỜI NHẬN --}}
                                    <td>

                                        <strong>

                                            {{ $order->customer_name
                                                ?? 'Không có' }}

                                        </strong>


                                        <div class="small text-muted">

                                            {{ $order->customer_phone
                                                ?? '' }}

                                        </div>

                                    </td>



                                    {{-- NGÀY ĐẶT --}}
                                    <td>

                                        {{ $order->created_at
                                            ->format('d/m/Y') }}

                                        <div class="small text-muted">

                                            {{ $order->created_at
                                                ->format('H:i') }}

                                        </div>

                                    </td>



                                    {{-- TỔNG TIỀN --}}
                                    <td>

                                        <span class="price-text">

                                            {{ number_format(
                                                $order->total_price,
                                                0,
                                                ',',
                                                '.'
                                            ) }} đ

                                        </span>

                                    </td>



                                    {{-- TRẠNG THÁI --}}
                                    <td>

                                        <span class="
                                            status-badge
                                            {{ $statusClass }}">

                                            {{ $statusText }}

                                        </span>

                                    </td>



                                    {{-- THAO TÁC --}}
                                    <td class="text-center">

                                        <a href="{{
                                                route(
                                                    'admin.orders.show',
                                                    $order->id
                                                )
                                            }}"
                                           class="
                                                btn
                                                btn-primary
                                                btn-sm
                                                btn-view">

                                            👁 Xem chi tiết

                                        </a>

                                    </td>


                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif


        </div>

    </div>

</div>

@endsection