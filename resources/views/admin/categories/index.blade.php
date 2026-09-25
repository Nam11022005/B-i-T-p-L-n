@extends('layouts.app')

@section('title', 'Quản lý danh mục')

@section('content')

<style>
    .page-title {
        font-weight: 800;
        color: #111827;
    }

    .category-stat {
        border: none;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
    }

    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 16px;
        background: #eef2ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
    }

    .category-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
    }

    .category-table th {
        background: #111827;
        color: white;
        font-weight: 600;
        padding: 16px;
        white-space: nowrap;
    }

    .category-table td {
        padding: 16px;
        vertical-align: middle;
    }

    .category-name {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .category-icon {
        width: 45px;
        height: 45px;
        border-radius: 13px;
        background: linear-gradient(
            135deg,
            #eef2ff,
            #dbeafe
        );
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .action-btn {
        border-radius: 8px;
        font-weight: 600;
    }

    .add-btn {
        border-radius: 12px;
        font-weight: 700;
        padding: 10px 18px;
    }

    .product-count {
        padding: 7px 12px;
        border-radius: 20px;
        background: #eef2ff;
        color: #4338ca;
        font-weight: 700;
        display: inline-block;
    }

    /* =========================================================
       ADMIN CATEGORIES PREMIUM UI
       Chỉ nâng giao diện, không đổi route/form/Blade logic.
    ========================================================= */

    .admin-categories-premium {
        position: relative;
        isolation: isolate;
        padding-top: 30px !important;
        padding-bottom: 72px !important;
    }

    .admin-categories-premium::before {
        content: "";
        position: absolute;
        z-index: -2;
        top: -35px;
        left: 50%;
        width: min(100vw,1760px);
        height: 680px;
        transform: translateX(-50%);
        pointer-events: none;
        background:
            radial-gradient(circle at 7% 8%, rgba(242,193,92,.17), transparent 23%),
            radial-gradient(circle at 94% 12%, rgba(72,99,59,.12), transparent 28%),
            linear-gradient(180deg,rgba(255,250,240,.92),rgba(255,255,255,0));
    }

    .admin-categories-head {
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

    .admin-categories-head::before {
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

    .admin-categories-head > * {
        position: relative;
        z-index: 2;
    }

    .admin-categories-head .text-primary {
        color: #f5d884 !important;
        font-size: 12px;
        letter-spacing: .08em;
    }

    .admin-categories-head .page-title {
        color: #fff;
        font-size: clamp(30px,3vw,42px);
        letter-spacing: -.7px;
        text-shadow: 0 2px 14px rgba(0,0,0,.16);
    }

    .admin-categories-head .text-muted {
        color: rgba(255,255,255,.74) !important;
    }

    .admin-categories-head .add-btn {
        min-height: 47px;
        padding-inline: 19px;
        border: 1px solid rgba(255,255,255,.16);
        border-radius: 999px;
        color: #3b2114;
        background: linear-gradient(135deg,#f8d984,#f2c15c);
        font-weight: 900;
        box-shadow: 0 9px 20px rgba(0,0,0,.13);
    }

    .admin-categories-head .add-btn:hover {
        color: #3b2114;
        background: linear-gradient(135deg,#ffe29c,#f5cb69);
    }

    .admin-categories-premium .category-stat {
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

    .admin-categories-premium .category-stat:hover {
        transform: translateY(-4px);
        box-shadow: 0 19px 42px rgba(95,52,29,.11);
    }

    .admin-categories-premium .stat-icon {
        width: 57px;
        height: 57px;
        border-radius: 17px;
        background:
            radial-gradient(circle at 35% 25%,rgba(255,255,255,.9),transparent 30%),
            linear-gradient(135deg,#fff0cb,#f6dfb1);
        box-shadow:
            inset 0 1px 0 rgba(255,255,255,.9),
            0 7px 16px rgba(95,52,29,.07);
    }

    .admin-categories-premium .category-card {
        border: 1px solid #e5d0b3;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 18px 44px rgba(95,52,29,.08);
    }

    .admin-categories-premium .category-table th {
        padding: 15px 16px;
        border-bottom-color: #e3ceb0;
        background: linear-gradient(180deg,#fff8e9,#f8efe2);
        color: #5f341d;
        font-size: 12px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .02em;
    }

    .admin-categories-premium .category-table td {
        padding: 16px;
        border-color: #f0e4d5;
    }

    .admin-categories-premium .category-table tbody tr {
        transition: background .16s ease;
    }

    .admin-categories-premium .category-table tbody tr:hover {
        background: #fffaf2;
    }

    .admin-categories-premium .category-icon {
        width: 49px;
        height: 49px;
        border-radius: 15px;
        border: 1px solid #e6cfab;
        background:
            linear-gradient(135deg,#fff8e9,#f6e7cd);
        box-shadow: 0 6px 14px rgba(95,52,29,.06);
    }

    .admin-categories-premium .product-count {
        border: 1px solid #d8e4d2;
        background: #eef6ea;
        color: #48633b;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.9);
    }

    .admin-categories-premium .action-btn {
        min-height: 36px;
        border-radius: 10px;
        font-weight: 800;
        transition: transform .16s ease;
    }

    .admin-categories-premium .action-btn:hover {
        transform: translateY(-1px);
    }

    .admin-categories-premium .pagination {
        gap: 6px;
    }

    .admin-categories-premium .page-link {
        border-radius: 10px !important;
        border-color: #dfc8a8;
        color: #5f341d;
    }

    @media (max-width: 767.98px) {
        .admin-categories-head {
            flex-direction: column;
            align-items: flex-start !important;
            padding: 25px 22px;
            border-radius: 22px;
        }

        .admin-categories-premium .category-card {
            border-radius: 18px;
        }
    }

</style>


<div class="container-fluid py-3 admin-categories-premium">

    {{-- =====================================================
        HEADER ADMIN
    ===================================================== --}}
    <div class="admin-categories-head d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <div class="text-primary fw-bold mb-1">
                ⚙️ KHU VỰC QUẢN TRỊ
            </div>

            <h2 class="page-title mb-1">
                📂 Quản lý danh mục
            </h2>

            <p class="text-muted mb-0">
                Quản lý các nhóm sản phẩm của Tinh Hoa Tây Bắc
            </p>

        </div>


        {{-- CHỈ ADMIN MỚI THẤY NÚT NÀY --}}
        <a
            href="{{ route('admin.categories.create') }}"
            class="btn btn-primary add-btn"
        >
            ➕ Thêm danh mục
        </a>

    </div>



    {{-- =====================================================
        THỐNG KÊ
    ===================================================== --}}
    <div class="row g-3 mb-4">


        {{-- TỔNG DANH MỤC --}}
        <div class="col-md-4">

            <div class="card category-stat h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="stat-icon">
                            📂
                        </div>

                        <div>

                            <div class="text-muted small">
                                Tổng danh mục
                            </div>

                            <h3 class="fw-bold mb-0">
                                {{ $categories->total() }}
                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- DANH MỤC TRÊN TRANG --}}
        <div class="col-md-4">

            <div class="card category-stat h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="stat-icon">
                            📋
                        </div>

                        <div>

                            <div class="text-muted small">
                                Đang hiển thị
                            </div>

                            <h3 class="fw-bold mb-0">
                                {{ $categories->count() }}
                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- TRANG HIỆN TẠI --}}
        <div class="col-md-4">

            <div class="card category-stat h-100">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="stat-icon">
                            📄
                        </div>

                        <div>

                            <div class="text-muted small">
                                Trang hiện tại
                            </div>

                            <h3 class="fw-bold mb-0">
                                {{ $categories->currentPage() }}
                                /
                                {{ $categories->lastPage() }}
                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- =====================================================
        THÔNG BÁO
    ===================================================== --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show shadow-sm">

            ✅ {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            >
            </button>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show shadow-sm">

            ❌ {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            >
            </button>

        </div>

    @endif



    {{-- =====================================================
        DANH SÁCH DANH MỤC ADMIN
    ===================================================== --}}
    <div class="card category-card">

        <div class="card-header bg-white border-bottom p-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                <div>

                    <h5 class="fw-bold mb-1">
                        Danh sách danh mục sản phẩm
                    </h5>

                    <small class="text-muted">
                        Admin có thể xem, chỉnh sửa hoặc xóa danh mục
                    </small>

                </div>


                <span class="badge bg-dark fs-6">

                    {{ $categories->total() }} danh mục

                </span>

            </div>

        </div>


        <div class="card-body p-0">

            @if($categories->isEmpty())

                <div class="text-center py-5">

                    <div style="font-size: 65px;">
                        📭
                    </div>

                    <h5 class="text-muted mt-3">
                        Chưa có danh mục nào
                    </h5>


                    <a
                        href="{{ route('admin.categories.create') }}"
                        class="btn btn-primary mt-2"
                    >
                        ➕ Thêm danh mục đầu tiên
                    </a>

                </div>

            @else

                <div class="table-responsive">

                    <table class="table table-hover category-table mb-0">

                        <thead>

                            <tr>

                                <th style="width: 90px;">
                                    ID
                                </th>

                                <th>
                                    Danh mục
                                </th>

                                <th class="text-center">
                                    Sản phẩm
                                </th>

                                <th>
                                    Ngày tạo
                                </th>

                                <th class="text-center">
                                    Hành động Admin
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($categories as $category)

                                @php

                                    $name =
                                        mb_strtolower(
                                            $category->name
                                        );

                                    $icon = '⚡';

                                    if (
                                        str_contains(
                                            $name,
                                            'laptop'
                                        )
                                    ) {
                                        $icon = '💻';
                                    }
                                    elseif (
                                        str_contains(
                                            $name,
                                            'điện thoại'
                                        )
                                    ) {
                                        $icon = '📱';
                                    }
                                    elseif (
                                        str_contains(
                                            $name,
                                            'tai nghe'
                                        )
                                    ) {
                                        $icon = '🎧';
                                    }
                                    elseif (
                                        str_contains(
                                            $name,
                                            'sạc'
                                        )
                                    ) {
                                        $icon = '🔌';
                                    }
                                    elseif (
                                        str_contains(
                                            $name,
                                            'chuột'
                                        )
                                    ) {
                                        $icon = '🖱️';
                                    }
                                    elseif (
                                        str_contains(
                                            $name,
                                            'bàn phím'
                                        )
                                    ) {
                                        $icon = '⌨️';
                                    }

                                @endphp


                                <tr>


                                    {{-- ID --}}
                                    <td>

                                        <strong>
                                            #{{ str_pad(
                                                $category->id,
                                                2,
                                                '0',
                                                STR_PAD_LEFT
                                            ) }}
                                        </strong>

                                    </td>



                                    {{-- TÊN DANH MỤC --}}
                                    <td>

                                        <div class="category-name">

                                            <div class="category-icon">
                                                {{ $icon }}
                                            </div>


                                            <div>

                                                <div class="fw-bold">
                                                    {{ $category->name }}
                                                </div>

                                                <small class="text-muted">
                                                    Danh mục sản phẩm
                                                </small>

                                            </div>

                                        </div>

                                    </td>



                                    {{-- SỐ SẢN PHẨM --}}
                                    <td class="text-center">

                                        <span class="product-count">

                                            {{ $category->products()->count() }}
                                            sản phẩm

                                        </span>

                                    </td>



                                    {{-- NGÀY TẠO --}}
                                    <td>

                                        @if($category->created_at)

                                            {{ $category->created_at->format(
                                                'd/m/Y'
                                            ) }}

                                            <div class="small text-muted">

                                                {{ $category->created_at->format(
                                                    'H:i'
                                                ) }}

                                            </div>

                                        @else

                                            <span class="text-muted">
                                                Không xác định
                                            </span>

                                        @endif

                                    </td>



                                    {{-- ==================================
                                        QUYỀN ADMIN
                                    ================================== --}}
                                    <td class="text-center">

                                        <div class="d-flex justify-content-center gap-2 flex-wrap">


                                            {{-- XEM --}}
                                            <a
                                                href="{{ route(
                                                    'admin.categories.show',
                                                    $category->id
                                                ) }}"
                                                class="btn btn-info btn-sm text-white action-btn"
                                            >
                                                👁 Xem
                                            </a>



                                            {{-- SỬA --}}
                                            <a
                                                href="{{ route(
                                                    'admin.categories.edit',
                                                    $category->id
                                                ) }}"
                                                class="btn btn-warning btn-sm action-btn"
                                            >
                                                ✏️ Sửa
                                            </a>



                                            {{-- XÓA --}}
                                            <form
                                                action="{{ route(
                                                    'admin.categories.destroy',
                                                    $category->id
                                                ) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm(
                                                    'Bạn có chắc chắn muốn xóa danh mục {{ $category->name }} không?'
                                                );"
                                            >

                                                @csrf
                                                @method('DELETE')


                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-sm action-btn"
                                                    {{ $category->products()->count() > 0
                                                        ? 'disabled'
                                                        : '' }}
                                                >
                                                    🗑 Xóa
                                                </button>

                                            </form>

                                        </div>


                                        {{-- KHÔNG CHO XÓA KHI CÒN SẢN PHẨM --}}
                                        @if($category->products()->count() > 0)

                                            <div class="small text-muted mt-2">
                                                Có sản phẩm nên không thể xóa
                                            </div>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    </div>



    {{-- =====================================================
        PHÂN TRANG
    ===================================================== --}}
    @if($categories->hasPages())

        <div class="d-flex justify-content-center mt-4">

            {{ $categories->links() }}

        </div>

    @endif

</div>

@endsection