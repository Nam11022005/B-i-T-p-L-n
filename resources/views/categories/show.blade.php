@extends('layouts.app')

@section('title', 'Đặc sản - ' . $category->name . ' | Tinh Hoa Tây Bắc')

@section('content')

<style>
    .category-header {
        border-radius: 24px;
        padding: 32px;
        color: white;
        background:
            radial-gradient(
                circle at 85% 20%,
                rgba(242,193,92,.18),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #2c1810,
                #5f341d 55%,
                #48633b
            );

        box-shadow:
            0 15px 40px rgba(95,52,29,.18);
    }

    .category-icon {
        width: 75px;
        height: 75px;

        border-radius: 20px;

        display: flex;
        align-items: center;
        justify-content: center;

        background:
            rgba(255,255,255,.12);

        border:
            1px solid rgba(255,255,255,.2);

        font-size: 36px;
    }

    .product-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        height: 100%;

        background: white;

        box-shadow:
            0 8px 25px rgba(0,0,0,.06);

        transition:
            transform .25s ease,
            box-shadow .25s ease;
    }

    .product-card:hover {
        transform: translateY(-6px);

        box-shadow:
            0 18px 40px rgba(95,52,29,.14);
    }

    .product-image-wrapper {
        position: relative;
        height: 230px;

        background:
            linear-gradient(
                180deg,
                #f8fafc,
                #eef2f7
            );
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 18px;
    }

    .stock-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        z-index: 2;
    }

    .price {
        font-size: 22px;
        font-weight: 800;
        color: #dc3545;
    }

    .category-count-box {
        background:
            rgba(255,255,255,.1);

        border-radius: 18px;

        padding:
            14px 22px;
    }

    /* =====================================================
       THEME TINH HOA TÂY BẮC
    ===================================================== */
    .product-card {
        border: 1px solid #ead8bf;
    }

    .product-image-wrapper {
        background: linear-gradient(180deg, #fffaf0, #f8efe2);
    }

    .price {
        color: #a83b2d;
    }

    .btn-primary {
        border: none;
        background: linear-gradient(135deg, #a83b2d, #5f341d);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #8b3025, #3b2114);
    }

    .btn-outline-primary {
        color: #5f341d;
        border-color: #5f341d;
    }

    .btn-outline-primary:hover {
        color: #fff;
        background: #5f341d;
        border-color: #5f341d;
    }

    .btn-warning {
        color: #3b2114;
        border-color: #f2c15c;
        background: #f2c15c;
    }

    .btn-warning:hover {
        color: #2c1810;
        border-color: #ffd77d;
        background: #ffd77d;
    }

    .btn-outline-secondary {
        color: #5f341d;
        border-color: #b99a77;
    }

    .btn-outline-secondary:hover {
        color: #fff;
        border-color: #5f341d;
        background: #5f341d;
    }

    .product-card .badge.bg-light {
        color: #5f341d !important;
        border-color: #ead8bf !important;
        background: #f8efe2 !important;
    }

</style>


<div class="container py-4">

    @php

        $name =
            mb_strtolower(
                $category->name
            );

        $icon = '🌿';

        if (
            str_contains($name, 'trâu')
            || str_contains($name, 'thịt')
            || str_contains($name, 'gác bếp')
        ) {
            $icon = '🥩';
        }
        elseif (str_contains($name, 'lạp xưởng')) {
            $icon = '🌭';
        }
        elseif (
            str_contains($name, 'mắc khén')
            || str_contains($name, 'hạt dổi')
            || str_contains($name, 'chẩm chéo')
            || str_contains($name, 'gia vị')
        ) {
            $icon = '🌶️';
        }
        elseif (
            str_contains($name, 'trà')
            || str_contains($name, 'thảo mộc')
        ) {
            $icon = '🍵';
        }
        elseif (str_contains($name, 'mật ong')) {
            $icon = '🍯';
        }
        elseif (
            str_contains($name, 'gạo')
            || str_contains($name, 'nếp')
        ) {
            $icon = '🍚';
        }
        elseif (
            str_contains($name, 'quà')
            || str_contains($name, 'biếu')
        ) {
            $icon = '🎁';
        }
        elseif (
            str_contains($name, 'khô')
            || str_contains($name, 'táo mèo')
        ) {
            $icon = '🧺';
        }

    @endphp


    {{-- ==========================================
        HEADER DANH MỤC
    ========================================== --}}
    <div class="category-header mb-4">

        <div class="row align-items-center">

            <div class="col-md-auto mb-3 mb-md-0">

                <div class="category-icon">

                    {{ $icon }}

                </div>

            </div>


            <div class="col">

                <div
                    class="small fw-bold mb-1"
                    style="
                        color:
                        rgba(255,255,255,.65);
                        letter-spacing:1px;
                    "
                >
                    DANH MỤC ĐẶC SẢN
                </div>


                <h1 class="fw-bold mb-2">

                    {{ $category->name }}

                </h1>


                <p
                    class="mb-0"
                    style="
                        color:
                        rgba(255,255,255,.75);
                    "
                >
                    Khám phá những đặc sản thuộc danh mục
                    {{ $category->name }}
                    tại Tinh Hoa Tây Bắc.
                </p>

            </div>


            <div class="col-md-auto mt-3 mt-md-0">

                <div class="category-count-box text-center">

                    <div class="fs-3 fw-bold">

                        {{ $category->products->count() }}

                    </div>

                    <small>
                        sản phẩm
                    </small>

                </div>

            </div>

        </div>

    </div>



    {{-- ==========================================
        NÚT QUAY LẠI + PHÂN QUYỀN
    ========================================== --}}
    <div
        class="
            d-flex
            justify-content-between
            align-items-center
            flex-wrap
            gap-2
            mb-4
        "
    >

        <a
            href="{{ route('categories.index') }}"
            class="btn btn-outline-secondary"
        >
            ← Quay lại danh mục
        </a>


        {{-- ADMIN CHỈ CÓ NÚT CHUYỂN SANG KHU QUẢN TRỊ --}}
        @if(
            Auth::check()
            &&
            Auth::user()->role === 'admin'
        )

            <a
                href="{{ route(
                    'admin.categories.show',
                    $category->id
                ) }}"
                class="btn btn-warning"
            >
                ⚙️ Mở trang quản trị danh mục
            </a>

        @endif

    </div>



    {{-- ==========================================
        DANH SÁCH SẢN PHẨM
    ========================================== --}}
    @if($category->products->isEmpty())

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <div style="font-size:70px;">
                    📭
                </div>


                <h4 class="fw-bold mt-3">

                    Chưa có sản phẩm

                </h4>


                <p class="text-muted">

                    Danh mục
                    <strong>{{ $category->name }}</strong>
                    hiện chưa có sản phẩm nào.

                </p>


                @if(
                    Auth::check()
                    &&
                    Auth::user()->role === 'admin'
                )

                    <a
                        href="{{ route(
                            'admin.products.create'
                        ) }}"
                        class="btn btn-primary"
                    >
                        ➕ Thêm sản phẩm
                    </a>

                @else

                    <a
                        href="{{ route(
                            'products.index'
                        ) }}"
                        class="btn btn-primary"
                    >
                        🌿 Xem đặc sản khác
                    </a>

                @endif

            </div>

        </div>


    @else


        <div
            class="
                row
                row-cols-1
                row-cols-sm-2
                row-cols-lg-3
                row-cols-xl-4
                g-4
            "
        >

            @foreach(
                $category->products
                as $product
            )

                <div class="col">

                    <div class="card product-card">


                        {{-- ==================================
                            ẢNH
                        ================================== --}}
                        <div class="product-image-wrapper">

                            @if(
                                $product->quantity > 0
                            )

                                <span
                                    class="
                                        badge
                                        bg-success
                                        stock-badge
                                    "
                                >
                                    Còn hàng
                                </span>

                            @else

                                <span
                                    class="
                                        badge
                                        bg-danger
                                        stock-badge
                                    "
                                >
                                    Hết hàng
                                </span>

                            @endif



                            @if($product->image)

                                <img
                                    src="{{ asset(
                                        'storage/' .
                                        $product->image
                                    ) }}"
                                    alt="{{ $product->name }}"
                                    class="product-image"
                                    onerror="
                                        this.style.display='none';
                                        this.nextElementSibling.style.display='flex';
                                    "
                                >


                                <div
                                    style="
                                        display:none;
                                        height:100%;
                                        align-items:center;
                                        justify-content:center;
                                        font-size:65px;
                                    "
                                >
                                    🧺
                                </div>

                            @else

                                <div
                                    class="
                                        h-100
                                        d-flex
                                        align-items-center
                                        justify-content-center
                                    "
                                    style="font-size:65px;"
                                >
                                    🧺
                                </div>

                            @endif

                        </div>



                        {{-- ==================================
                            THÔNG TIN
                        ================================== --}}
                        <div
                            class="
                                card-body
                                p-4
                                d-flex
                                flex-column
                            "
                        >

                            <span
                                class="
                                    badge
                                    bg-light
                                    text-dark
                                    border
                                    align-self-start
                                    mb-2
                                "
                            >
                                {{ $category->name }}
                            </span>


                            <h5 class="fw-bold mb-2">

                                {{ $product->name }}

                            </h5>


                            <p
                                class="
                                    text-muted
                                    small
                                    flex-grow-1
                                "
                            >

                                {{ \Illuminate\Support\Str::limit(
                                    $product->description
                                    ?? 'Sản phẩm công nghệ chất lượng tại Tinh Hoa Tây Bắc.',
                                    80
                                ) }}

                            </p>



                            <div class="mb-3">

                                <div class="price">

                                    {{ number_format(
                                        $product->price,
                                        0,
                                        ',',
                                        '.'
                                    ) }} đ

                                </div>


                                <small class="text-muted">

                                    Kho:
                                    {{ $product->quantity }}
                                    sản phẩm

                                </small>

                            </div>



                            {{-- ==================================
                                ADMIN
                            ================================== --}}
                            @if(
                                Auth::check()
                                &&
                                Auth::user()->role === 'admin'
                            )

                                <div class="d-grid gap-2">


                                    <a
                                        href="{{ route(
                                            'admin.products.show',
                                            $product->id
                                        ) }}"
                                        class="btn btn-outline-primary"
                                    >
                                        👁 Xem chi tiết
                                    </a>


                                    <a
                                        href="{{ route(
                                            'admin.products.edit',
                                            $product->id
                                        ) }}"
                                        class="btn btn-warning"
                                    >
                                        ✏️ Chỉnh sửa sản phẩm
                                    </a>

                                </div>


                            {{-- ==================================
                                CUSTOMER
                            ================================== --}}
                            @elseif(Auth::check())

                                <div class="d-grid gap-2">


                                    <a
                                        href="{{ route(
                                            'products.show',
                                            $product->id
                                        ) }}"
                                        class="btn btn-outline-primary"
                                    >
                                        👁 Xem chi tiết
                                    </a>


                                    @if(
                                        $product->quantity > 0
                                    )

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
                                                class="
                                                    btn
                                                    btn-primary
                                                    w-100
                                                "
                                            >
                                                🧺 Thêm vào giỏ hàng
                                            </button>

                                        </form>


                                    @else

                                        <button
                                            type="button"
                                            class="
                                                btn
                                                btn-secondary
                                            "
                                            disabled
                                        >
                                            ❌ Sản phẩm đã hết hàng
                                        </button>

                                    @endif

                                </div>


                            {{-- ==================================
                                CHƯA ĐĂNG NHẬP
                            ================================== --}}
                            @else

                                <div class="d-grid gap-2">


                                    <a
                                        href="{{ route(
                                            'login'
                                        ) }}"
                                        class="btn btn-primary"
                                    >
                                        🔐 Đăng nhập để mua
                                    </a>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection