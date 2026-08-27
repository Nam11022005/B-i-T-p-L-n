@extends('admin.layouts.app')

@section('title', 'Quản lý danh mục')

@section('content')

<style>
    .page-header {
        background: linear-gradient(135deg, #111827, #312e81);
        color: white;
        border-radius: 22px;
        padding: 28px;
        box-shadow: 0 14px 35px rgba(17, 24, 39, .15);
    }

    .stat-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef2ff;
        font-size: 24px;
    }

    .category-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
    }

    .category-table th {
        background: #111827;
        color: white;
        padding: 16px;
        white-space: nowrap;
    }

    .category-table td {
        padding: 16px;
        vertical-align: middle;
    }

    .category-icon {
        width: 46px;
        height: 46px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #eef2ff, #dbeafe);
        font-size: 22px;
        flex-shrink: 0;
    }

    .product-count {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 20px;
        background: #eef2ff;
        color: #4338ca;
        font-weight: 700;
    }

    .admin-action-btn {
        border-radius: 8px;
        min-width: 42px;
    }
</style>


<div class="container-fluid">

    {{-- ==========================================
        HEADER ADMIN
    ========================================== --}}
    <div class="page-header mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>

                <div
                    class="fw-bold small mb-1"
                    style="color: rgba(255,255,255,.7);"
                >
                    ⚙️ KHU VỰC QUẢN TRỊ
                </div>

                <h2 class="fw-bold mb-2">
                    🏷️ Quản lý danh mục
                </h2>

                <p
                    class="mb-0"
                    style="color: rgba(255,255,255,.75);"
                >
                    Admin có quyền xem, thêm, chỉnh sửa và xóa danh mục sản phẩm
                </p>

            </div>


            <a
                href="{{ route('admin.categories.create') }}"
                class="btn btn-warning btn-lg fw-bold"
            >
                ➕ Thêm danh mục
            </a>

        </div>

    </div>



    {{-- ==========================================
        THỐNG KÊ
    ========================================== --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">

            <div class="card stat-card h-100">

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
                                {{ method_exists($categories, 'total')
                                    ? $categories->total()
                                    : $categories->count() }}
                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card stat-card h-100">

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


        <div class="col-md-4">

            <div class="card stat-card h-100">

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

                                @if(method_exists($categories, 'currentPage'))

                                    {{ $categories->currentPage() }}
                                    /
                                    {{ $categories->lastPage() }}

                                @else

                                    1 / 1

                                @endif

                            </h3>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- ==========================================
        THÔNG BÁO
    ========================================== --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show shadow-sm">

            <strong>✅ Thành công!</strong>
            {{ session('success') }}

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

            <strong>❌ Lỗi!</strong>
            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            >
            </button>

        </div>

    @endif



    {{-- ==========================================
        DANH SÁCH DANH MỤC ADMIN
    ========================================== --}}
    <div class="card category-card">

        <div class="card-header bg-white border-bottom p-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                <div>

                    <h5 class="fw-bold mb-1">
                        📦 Danh sách danh mục sản phẩm
                    </h5>

                    <small class="text-muted">
                        Các thao tác bên dưới chỉ dành cho Admin
                    </small>

                </div>


                <span class="badge bg-dark fs-6">

                    {{ method_exists($categories, 'total')
                        ? $categories->total()
                        : $categories->count() }}
                    danh mục

                </span>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover category-table align-middle mb-0">

                    <thead>

                        <tr>

                            <th style="width: 80px;">
                                STT
                            </th>

                            <th>
                                Danh mục
                            </th>

                            <th class="text-center">
                                Số sản phẩm
                            </th>

                            <th>
                                Ngày tạo
                            </th>

                            <th class="text-center" style="width: 240px;">
                                Hành động Admin
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($categories as $category)

                            @php

                                $name = mb_strtolower($category->name);

                                $icon = '⚡';

                                if (str_contains($name, 'điện thoại')) {
                                    $icon = '📱';
                                } elseif (str_contains($name, 'laptop')) {
                                    $icon = '💻';
                                } elseif (str_contains($name, 'tai nghe')) {
                                    $icon = '🎧';
                                } elseif (str_contains($name, 'sạc')) {
                                    $icon = '🔌';
                                } elseif (str_contains($name, 'chuột')) {
                                    $icon = '🖱️';
                                } elseif (str_contains($name, 'bàn phím')) {
                                    $icon = '⌨️';
                                }

                                $productCount =
                                    $category->products()->count();

                            @endphp


                            <tr>

                                {{-- STT --}}
                                <td class="fw-bold">

                                    #{{ str_pad(
                                        $loop->iteration,
                                        2,
                                        '0',
                                        STR_PAD_LEFT
                                    ) }}

                                </td>


                                {{-- DANH MỤC --}}
                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        <div class="category-icon">
                                            {{ $icon }}
                                        </div>


                                        <div>

                                            <div class="fw-bold">
                                                {{ $category->name }}
                                            </div>

                                            <small class="text-muted">
                                                ID: #{{ $category->id }}
                                            </small>

                                        </div>

                                    </div>

                                </td>


                                {{-- SẢN PHẨM --}}
                                <td class="text-center">

                                    <span class="product-count">

                                        {{ $productCount }}
                                        sản phẩm

                                    </span>

                                </td>


                                {{-- NGÀY TẠO --}}
                                <td>

                                    @if($category->created_at)

                                        {{ $category->created_at->format('d/m/Y') }}

                                        <div class="small text-muted">

                                            {{ $category->created_at->format('H:i') }}

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
                                            class="btn btn-info btn-sm text-white admin-action-btn"
                                            title="Xem chi tiết"
                                        >
                                            👁️
                                        </a>


                                        {{-- SỬA --}}
                                        <a
                                            href="{{ route(
                                                'admin.categories.edit',
                                                $category->id
                                            ) }}"
                                            class="btn btn-warning btn-sm admin-action-btn"
                                            title="Chỉnh sửa"
                                        >
                                            ✏️
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
                                                'Bạn có chắc muốn xóa danh mục {{ $category->name }} không?'
                                            );"
                                        >

                                            @csrf
                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm admin-action-btn"
                                                title="Xóa danh mục"
                                                {{ $productCount > 0
                                                    ? 'disabled'
                                                    : '' }}
                                            >
                                                🗑️
                                            </button>

                                        </form>

                                    </div>


                                    @if($productCount > 0)

                                        <div class="small text-muted mt-2">
                                            Không thể xóa khi còn sản phẩm
                                        </div>

                                    @endif

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center py-5"
                                >

                                    <div style="font-size: 55px;">
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

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    {{-- ==========================================
        PHÂN TRANG
    ========================================== --}}
    @if(
        method_exists($categories, 'links')
        &&
        method_exists($categories, 'hasPages')
        &&
        $categories->hasPages()
    )

        <div class="d-flex justify-content-center mt-4">

            {{ $categories->links() }}

        </div>

    @endif

</div>

@endsection