@extends('layouts.app')

@section('title', $product->name)

@section('content')

<style>
    .product-detail-card {
        border-radius: 18px;
        overflow: hidden;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .product-image-wrapper {
        background: #f8f9fa;
        border-radius: 16px;
        overflow: hidden;
        min-height: 380px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image {
        width: 100%;
        max-height: 460px;
        object-fit: contain;
    }

    .no-image {
        min-height: 380px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        font-size: 18px;
    }

    .price-box {
        background: #f8f9fa;
        border-radius: 14px;
    }

    .admin-box {
        background: #fff8e1;
        border: 1px solid #ffe69c;
        border-radius: 14px;
        padding: 16px;
    }
</style>


<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-11">


            {{-- ==========================================
                NÚT QUAY LẠI
            ========================================== --}}
            <div class="mb-3">

                @if(Auth::check() && Auth::user()->role === 'admin')

                    <a
                        href="{{ route('admin.products.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        ← Quay lại quản lý sản phẩm
                    </a>

                @else

                    <a
                        href="{{ route('products.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        ← Quay lại danh sách sản phẩm
                    </a>

                @endif

            </div>



            {{-- ==========================================
                CHI TIẾT SẢN PHẨM
            ========================================== --}}
            <div class="card product-detail-card">

                <div class="card-body p-4 p-lg-5">

                    <div class="row g-5">


                        {{-- ==================================
                            ẢNH SẢN PHẨM
                        ================================== --}}
                        <div class="col-lg-5">

                            <div class="product-image-wrapper">

                                @if($product->image)

                                    <img
                                        src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="product-image"
                                        onerror="
                                            this.style.display='none';
                                            this.nextElementSibling.style.display='flex';
                                        "
                                    >

                                    <div
                                        class="no-image"
                                        style="display:none;"
                                    >
                                        🖼️ Không tìm thấy ảnh sản phẩm
                                    </div>

                                @else

                                    <div class="no-image">
                                        🖼️ Sản phẩm chưa có ảnh
                                    </div>

                                @endif

                            </div>

                        </div>



                        {{-- ==================================
                            THÔNG TIN SẢN PHẨM
                        ================================== --}}
                        <div class="col-lg-7">


                            {{-- DANH MỤC --}}
                            <div class="mb-3">

                                <span class="badge bg-primary fs-6">

                                    {{ $product->category?->name ?? 'Chưa phân loại' }}

                                </span>

                            </div>



                            {{-- TÊN --}}
                            <h2 class="fw-bold mb-3">

                                {{ $product->name }}

                            </h2>



                            {{-- ADMIN BADGE --}}
                            @if(Auth::check() && Auth::user()->role === 'admin')

                                <div class="admin-box mb-4">

                                    <strong>
                                        👑 Chế độ quản trị
                                    </strong>

                                    <div class="small text-muted mt-1">

                                        Bạn đang xem sản phẩm với quyền Admin.
                                        Admin có thể chỉnh sửa hoặc xóa sản phẩm.

                                    </div>

                                </div>

                            @endif



                            {{-- GIÁ + TỒN KHO --}}
                            <div class="price-box p-4 mb-4">

                                <div class="row align-items-center">

                                    <div class="col-md-6">

                                        <small class="text-muted d-block">
                                            Giá bán
                                        </small>

                                        <span class="text-danger fw-bold fs-2">

                                            {{ number_format(
                                                $product->price,
                                                0,
                                                ',',
                                                '.'
                                            ) }} đ

                                        </span>

                                    </div>


                                    <div class="col-md-6 text-md-end mt-3 mt-md-0">

                                        <small class="text-muted d-block">
                                            Tồn kho
                                        </small>

                                        <span
                                            class="fw-bold fs-5
                                            {{ $product->quantity > 0
                                                ? 'text-success'
                                                : 'text-danger' }}"
                                        >

                                            @if($product->quantity > 0)

                                                {{ $product->quantity }} sản phẩm

                                            @else

                                                Hết hàng

                                            @endif

                                        </span>

                                    </div>

                                </div>

                            </div>



                            {{-- MÔ TẢ --}}
                            <div class="mb-4">

                                <h5 class="fw-bold border-bottom pb-2">

                                    📝 Mô tả sản phẩm

                                </h5>

                                <p
                                    class="text-secondary lh-lg mb-0"
                                    style="white-space: pre-line;"
                                >
                                    {{ $product->description ?? 'Chưa có mô tả cho sản phẩm này.' }}
                                </p>

                            </div>



                            {{-- ==================================
                                ACTION THEO PHÂN QUYỀN
                            ================================== --}}

                            @if(Auth::check() && Auth::user()->role === 'admin')


                                {{-- ===========================
                                    ADMIN
                                =========================== --}}
                                <div class="d-flex gap-3 flex-wrap">


                                    {{-- CHỈNH SỬA --}}
                                    <a
                                        href="{{ route(
                                            'admin.products.edit',
                                            $product->id
                                        ) }}"
                                        class="btn btn-warning btn-lg flex-fill"
                                    >
                                        ✏️ Chỉnh sửa sản phẩm
                                    </a>


                                    {{-- XÓA --}}
                                    <form
                                        action="{{ route(
                                            'admin.products.destroy',
                                            $product->id
                                        ) }}"
                                        method="POST"
                                        class="flex-fill"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');"
                                    >

                                        @csrf
                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-lg w-100"
                                        >
                                            🗑️ Xóa sản phẩm
                                        </button>

                                    </form>

                                </div>


                            @elseif(Auth::check())


                                {{-- ===========================
                                    CUSTOMER
                                =========================== --}}

                                <form
                                    action="{{ route(
                                        'cart.add',
                                        $product->id
                                    ) }}"
                                    method="POST"
                                >

                                    @csrf


                                    <button
                                        type="submit"
                                        class="btn btn-success btn-lg w-100"
                                        {{ $product->quantity <= 0
                                            ? 'disabled'
                                            : '' }}
                                    >

                                        @if($product->quantity > 0)

                                            🛒 Thêm vào giỏ hàng

                                        @else

                                            ❌ Sản phẩm đã hết hàng

                                        @endif

                                    </button>

                                </form>


                            @else


                                {{-- ===========================
                                    CHƯA ĐĂNG NHẬP
                                =========================== --}}
                                <a
                                    href="{{ route('login') }}"
                                    class="btn btn-warning btn-lg w-100"
                                >
                                    🔐 Đăng nhập để mua sản phẩm
                                </a>


                            @endif


                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection