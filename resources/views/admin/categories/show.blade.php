@extends('layouts.app')

@section('title', 'Chi tiết danh mục')

@section('content')

<style>
    .category-card {
        border-radius: 18px;
        overflow: hidden;
        border: none;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
    }

    .product-image {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #dee2e6;
        background: #f8f9fa;
    }

    .no-image {
        width: 90px;
        height: 90px;
        border-radius: 12px;
        background: #f1f3f5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 12px;
        text-align: center;
    }

    .category-info-box {
        background: #f8f9fa;
        border-radius: 14px;
        padding: 18px;
    }

    .product-name {
        font-weight: 700;
        color: #111827;
    }

    .product-price {
        font-weight: 700;
        color: #dc3545;
    }
</style>


<div class="container py-4">

    {{-- ==========================================
        HEADER
    ========================================== --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                🏷️ Chi tiết danh mục
            </h2>

            <p class="text-muted mb-0">
                Xem thông tin danh mục và các sản phẩm thuộc danh mục
            </p>

        </div>

        <a
            href="{{ route('admin.categories.index') }}"
            class="btn btn-outline-secondary"
        >
            ← Quay lại
        </a>

    </div>


    {{-- ==========================================
        THÔNG TIN DANH MỤC
    ========================================== --}}
    <div class="card category-card mb-4">

        <div class="card-header bg-dark text-white p-3">

            <h5 class="mb-0">
                📂 Thông tin danh mục
            </h5>

        </div>


        <div class="card-body p-4">

            <div class="row g-4">

                <div class="col-md-3">

                    <div class="category-info-box">

                        <div class="text-muted small">
                            ID danh mục
                        </div>

                        <div class="fw-bold fs-5">
                            #{{ $category->id }}
                        </div>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="category-info-box">

                        <div class="text-muted small">
                            Tên danh mục
                        </div>

                        <div class="fw-bold fs-5">
                            {{ $category->name }}
                        </div>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="category-info-box">

                        <div class="text-muted small">
                            Số sản phẩm
                        </div>

                        <div class="fw-bold fs-5 text-primary">
                            {{ $category->products->count() }}
                        </div>

                    </div>

                </div>


                <div class="col-md-3">

                    <div class="category-info-box">

                        <div class="text-muted small">
                            Ngày tạo
                        </div>

                        <div class="fw-bold">
                            {{ $category->created_at->format('d/m/Y') }}
                        </div>

                    </div>

                </div>

            </div>


            <div class="d-flex gap-2 flex-wrap mt-4">

                <a
                    href="{{ route(
                        'admin.categories.edit',
                        $category->id
                    ) }}"
                    class="btn btn-warning"
                >
                    ✏️ Chỉnh sửa danh mục
                </a>


                <form
                    action="{{ route(
                        'admin.categories.destroy',
                        $category->id
                    ) }}"
                    method="POST"
                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');"
                >

                    @csrf
                    @method('DELETE')


                    <button
                        type="submit"
                        class="btn btn-danger"
                        {{ $category->products->count() > 0 ? 'disabled' : '' }}
                    >
                        🗑️ Xóa danh mục
                    </button>

                </form>

            </div>


            @if($category->products->count() > 0)

                <div class="alert alert-warning mt-3 mb-0">

                    ⚠️ Danh mục đang có
                    <strong>{{ $category->products->count() }}</strong>
                    sản phẩm nên không thể xóa.

                </div>

            @endif

        </div>

    </div>



    {{-- ==========================================
        DANH SÁCH SẢN PHẨM
    ========================================== --}}
    <div class="card category-card">

        <div class="card-header bg-primary text-white p-3">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    📦 Sản phẩm thuộc danh mục
                </h5>

                <span class="badge bg-light text-dark fs-6">

                    {{ $category->products->count() }}
                    sản phẩm

                </span>

            </div>

        </div>


        <div class="card-body p-0">

            @if($category->products->isEmpty())

                <div class="text-center py-5">

                    <div style="font-size: 60px;">
                        📭
                    </div>

                    <h5 class="text-muted mt-3">
                        Danh mục này chưa có sản phẩm
                    </h5>

                    <a
                        href="{{ route('admin.products.create') }}"
                        class="btn btn-primary mt-2"
                    >
                        ➕ Thêm sản phẩm
                    </a>

                </div>

            @else

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="ps-4">
                                    Ảnh
                                </th>

                                <th>
                                    Tên sản phẩm
                                </th>

                                <th>
                                    Mô tả
                                </th>

                                <th>
                                    Giá
                                </th>

                                <th class="text-center">
                                    Số lượng
                                </th>

                                <th class="text-center">
                                    Hành động
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($category->products as $product)

                                <tr>

                                    {{-- =========================
                                        ẢNH SẢN PHẨM
                                    ========================= --}}
                                    <td class="ps-4">

                                        @if($product->image)

                                            <img
                                                src="{{ asset(
                                                    'storage/' .
                                                    $product->image
                                                ) }}"
                                                alt="{{ $product->name }}"
                                                class="product-image"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                            >

                                            <div
                                                class="no-image"
                                                style="display:none;"
                                            >
                                                Không tìm thấy ảnh
                                            </div>

                                        @else

                                            <div class="no-image">
                                                Chưa có ảnh
                                            </div>

                                        @endif

                                    </td>


                                    {{-- TÊN --}}
                                    <td>

                                        <div class="product-name">
                                            {{ $product->name }}
                                        </div>

                                        <small class="text-muted">
                                            ID: #{{ $product->id }}
                                        </small>

                                    </td>


                                    {{-- MÔ TẢ --}}
                                    <td style="max-width: 300px;">

                                        @if($product->description)

                                            {{ \Illuminate\Support\Str::limit(
                                                $product->description,
                                                80
                                            ) }}

                                        @else

                                            <span class="text-muted">
                                                Chưa có mô tả
                                            </span>

                                        @endif

                                    </td>


                                    {{-- GIÁ --}}
                                    <td>

                                        <span class="product-price">

                                            {{ number_format(
                                                $product->price,
                                                0,
                                                ',',
                                                '.'
                                            ) }} đ

                                        </span>

                                    </td>


                                    {{-- SỐ LƯỢNG --}}
                                    <td class="text-center">

                                        @if($product->quantity > 0)

                                            <span class="badge bg-success">

                                                {{ $product->quantity }}

                                            </span>

                                        @else

                                            <span class="badge bg-danger">

                                                Hết hàng

                                            </span>

                                        @endif

                                    </td>


                                    {{-- HÀNH ĐỘNG --}}
                                    <td class="text-center">

                                        <div class="btn-group">

                                            {{-- XEM CHI TIẾT --}}
                                            <a
                                                href="{{ route(
                                                    'admin.products.show',
                                                    $product->id
                                                ) }}"
                                                class="btn btn-info btn-sm"
                                                title="Xem chi tiết"
                                            >
                                                👁
                                            </a>


                                            {{-- CHỈNH SỬA --}}
                                            <a
                                                href="{{ route(
                                                    'admin.products.edit',
                                                    $product->id
                                                ) }}"
                                                class="btn btn-warning btn-sm"
                                                title="Chỉnh sửa"
                                            >
                                                ✏️
                                            </a>


                                            {{-- XÓA --}}
                                            <form
                                                action="{{ route(
                                                    'admin.products.destroy',
                                                    $product->id
                                                ) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');"
                                            >

                                                @csrf
                                                @method('DELETE')


                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    title="Xóa"
                                                >
                                                    🗑️
                                                </button>

                                            </form>

                                        </div>

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