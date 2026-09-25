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

    /* =========================================================
       ADMIN ORDERS INDEX PREMIUM UI
       Chỉ nâng giao diện, không đổi route/data/Blade logic.
    ========================================================= */

    .admin-orders-premium {
        position: relative;
        isolation: isolate;
        padding-top: 30px;
        padding-bottom: 72px;
    }

    .admin-orders-premium::before {
        content: "";
        position: absolute;
        z-index: -2;
        top: -35px;
        left: 50%;
        width: min(100vw,1760px);
        height: 690px;
        transform: translateX(-50%);
        pointer-events: none;
        background:
            radial-gradient(circle at 7% 8%, rgba(242,193,92,.17), transparent 23%),
            radial-gradient(circle at 94% 12%, rgba(72,99,59,.12), transparent 28%),
            linear-gradient(180deg,rgba(255,250,240,.92),rgba(255,255,255,0));
    }

    .admin-orders-head {
        position: relative;
        overflow: hidden;
        min-height: 170px;
        padding: 30px 34px;
        border: 1px solid rgba(255,255,255,.10);
        border-radius: 27px;
        color: #fff;
        background:
            radial-gradient(circle at 88% 15%, rgba(242,193,92,.22), transparent 29%),
            radial-gradient(circle at 12% 120%, rgba(168,59,45,.27), transparent 35%),
            linear-gradient(135deg,#2c1810 0%,#5f341d 54%,#48633b 100%);
        box-shadow:
            0 22px 56px rgba(44,24,16,.18),
            inset 0 1px 0 rgba(255,255,255,.07);
    }

    .admin-orders-head::before {
        content: "";
        position: absolute;
        right: -30px;
        bottom: -56px;
        width: 320px;
        height: 180px;
        opacity: .10;
        clip-path: polygon(0 100%,18% 56%,36% 73%,53% 25%,70% 58%,86% 34%,100% 66%,100% 100%);
        background: linear-gradient(135deg,#fff,#f2c15c);
        pointer-events: none;
    }

    .admin-orders-head > * {
        position: relative;
        z-index: 2;
    }

    .admin-orders-head .admin-order-title {
        color: #fff;
        font-size: clamp(30px,3vw,42px);
        letter-spacing: -.7px;
        text-shadow: 0 2px 14px rgba(0,0,0,.16);
    }

    .admin-orders-head .text-muted {
        color: rgba(255,255,255,.74) !important;
    }

    .admin-orders-head .btn-outline-dark {
        min-height: 44px;
        padding-inline: 17px;
        border-radius: 999px;
        border-color: rgba(255,255,255,.26);
        color: #fff;
        background: rgba(255,255,255,.08);
        font-weight: 800;
        backdrop-filter: blur(10px);
    }

    .admin-orders-head .btn-outline-dark:hover {
        color: #fff;
        border-color: rgba(255,255,255,.4);
        background: rgba(255,255,255,.15);
    }

    .admin-orders-premium .stat-card {
        position: relative;
        overflow: hidden;
        border: 1px solid #e5d0b3;
        border-radius: 20px;
        background:
            linear-gradient(180deg,#fff,#fffdfa);
        box-shadow:
            0 14px 36px rgba(95,52,29,.075),
            inset 0 1px 0 rgba(255,255,255,.94);
        transition:
            transform .18s ease,
            box-shadow .18s ease;
    }

    .admin-orders-premium .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 19px 42px rgba(95,52,29,.11);
    }

    .admin-orders-premium .stat-card::after {
        content: "";
        position: absolute;
        right: -30px;
        top: -35px;
        width: 105px;
        height: 105px;
        border-radius: 50%;
        background: rgba(242,193,92,.10);
        pointer-events: none;
    }

    .admin-orders-premium .order-table-card {
        border: 1px solid #e5d0b3;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 18px 44px rgba(95,52,29,.08);
    }

    .admin-orders-premium .order-table th {
        padding: 15px 16px;
        border-bottom-color: #e3ceb0;
        background: linear-gradient(180deg,#fff8e9,#f8efe2);
        color: #5f341d;
        font-size: 12px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .02em;
    }

    .admin-orders-premium .order-table td {
        padding: 16px;
        border-color: #f0e4d5;
    }

    .admin-orders-premium .order-table tbody tr {
        transition: background .16s ease;
    }

    .admin-orders-premium .order-table tbody tr:hover {
        background: #fffaf2;
    }

    .admin-orders-premium .customer-name {
        color: #392820;
    }

    .admin-orders-premium .price-text {
        color: #a83b2d;
        font-size: 16px;
    }

    .admin-orders-premium .status-badge {
        box-shadow: 0 5px 12px rgba(0,0,0,.07);
    }

    .admin-orders-premium .btn-view {
        min-height: 38px;
        border-radius: 10px;
        font-weight: 800;
        transition: transform .16s ease, box-shadow .16s ease;
    }

    .admin-orders-premium .btn-view:hover {
        transform: translateY(-1px);
        box-shadow: 0 7px 15px rgba(95,52,29,.08);
    }

    .admin-orders-premium .alert {
        border-radius: 15px;
        box-shadow: 0 8px 22px rgba(95,52,29,.06) !important;
    }

    .admin-orders-premium .pagination {
        gap: 6px;
    }

    .admin-orders-premium .page-link {
        border-radius: 10px !important;
        border-color: #dfc8a8;
        color: #5f341d;
    }

    @media (max-width: 767.98px) {
        .admin-orders-head {
            flex-direction: column;
            align-items: flex-start !important;
            padding: 25px 22px;
            border-radius: 22px;
        }

        .admin-orders-premium .order-table-card {
            border-radius: 18px;
        }
    }

</style>


<div class="container-fluid admin-orders-premium">

    {{-- ==========================================
        TIÊU ĐỀ
    ========================================== --}}
    <div class="admin-orders-head d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

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