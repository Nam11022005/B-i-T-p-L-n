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



    /* =========================================================
       CATEGORY SHOW PREMIUM UI
       Chỉ nâng giao diện - không đổi route / Blade / dữ liệu.
    ========================================================= */

    .category-show-premium-page {
        position: relative;
        isolation: isolate;
        padding-top: 34px !important;
        padding-bottom: 76px !important;
    }

    .category-show-premium-page::before {
        content: "";
        position: absolute;
        z-index: -3;
        top: -38px;
        left: 50%;
        width: min(100vw,1700px);
        height: 760px;
        transform: translateX(-50%);
        pointer-events: none;
        background:
            radial-gradient(circle at 7% 8%, rgba(242,193,92,.19), transparent 24%),
            radial-gradient(circle at 94% 11%, rgba(72,99,59,.14), transparent 28%),
            linear-gradient(180deg,rgba(255,250,240,.98),rgba(255,255,255,0));
    }

    .category-show-premium-page::after {
        content: "";
        position: absolute;
        z-index: -2;
        top: 220px;
        right: -55px;
        width: 220px;
        height: 220px;
        opacity: .10;
        pointer-events: none;
        border-radius: 50%;
        background:
            repeating-radial-gradient(circle at center,rgba(95,52,29,.36) 0 1px,transparent 1px 13px);
    }

    .category-show-premium-page .category-header {
        position: relative;
        overflow: hidden;
        min-height: 205px;
        padding: 38px 40px;
        border-radius: 29px;
        border: 1px solid rgba(255,255,255,.10);
        box-shadow:
            0 24px 60px rgba(44,24,16,.18),
            inset 0 1px 0 rgba(255,255,255,.07);
        background:
            radial-gradient(circle at 87% 17%, rgba(242,193,92,.23), transparent 28%),
            radial-gradient(circle at 10% 120%, rgba(168,59,45,.27), transparent 35%),
            linear-gradient(135deg,#2c1810 0%,#5f341d 54%,#48633b 100%);
    }

    .category-show-premium-page .category-header::before {
        content: "";
        position: absolute;
        right: -35px;
        bottom: -62px;
        width: 330px;
        height: 190px;
        opacity: .10;
        clip-path: polygon(0 100%,18% 56%,36% 73%,53% 25%,70% 58%,86% 34%,100% 66%,100% 100%);
        background: linear-gradient(135deg,#fff,#f2c15c);
        pointer-events: none;
    }

    .category-show-premium-page .category-header > .row {
        position: relative;
        z-index: 2;
    }

    .category-show-premium-page .category-icon {
        width: 82px;
        height: 82px;
        border-radius: 23px;
        border-color: rgba(255,255,255,.18);
        background: rgba(255,255,255,.08);
        box-shadow:
            inset 0 1px 0 rgba(255,255,255,.08),
            0 10px 24px rgba(0,0,0,.12);
        backdrop-filter: blur(10px);
    }

    .category-show-premium-page .category-header h1 {
        font-size: clamp(32px,3.8vw,48px);
        letter-spacing: -.8px;
        text-shadow: 0 2px 15px rgba(0,0,0,.16);
    }

    .category-show-premium-page .category-count-box {
        min-width: 118px;
        padding: 16px 22px;
        border: 1px solid rgba(255,255,255,.15);
        border-radius: 18px;
        background: rgba(255,255,255,.075);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.07);
        backdrop-filter: blur(10px);
    }

    /* Thanh thao tác */
    .category-show-premium-page > .d-flex.justify-content-between {
        padding: 10px 12px;
        border: 1px solid #ead8bf;
        border-radius: 16px;
        background: rgba(255,255,255,.80);
        box-shadow: 0 9px 24px rgba(95,52,29,.05);
        backdrop-filter: blur(10px);
    }

    .category-show-premium-page > .d-flex.justify-content-between .btn {
        min-height: 41px;
        border-radius: 999px;
        padding-inline: 16px;
        font-weight: 800;
    }

    /* Empty state */
    .category-show-premium-page > .card.border-0.shadow-sm {
        overflow: hidden;
        border: 1px dashed #dcbf95 !important;
        border-radius: 25px !important;
        background:
            radial-gradient(circle at 50% 0%, rgba(242,193,92,.14), transparent 31%),
            linear-gradient(180deg,#fffdf9,#fff9ee);
        box-shadow: 0 16px 38px rgba(95,52,29,.065) !important;
    }

    /* Product card */
    .category-show-premium-page .product-card {
        position: relative;
        border-radius: 22px;
        border-color: #e6d1b5;
        background:
            linear-gradient(180deg,#fff 0%,#fffdfa 100%);
        box-shadow:
            0 10px 28px rgba(95,52,29,.065),
            inset 0 1px 0 rgba(255,255,255,.94);
        transition:
            transform .24s ease,
            box-shadow .24s ease,
            border-color .24s ease;
    }

    .category-show-premium-page .product-card::before {
        content: "";
        position: absolute;
        z-index: 3;
        top: 0;
        left: 18%;
        right: 18%;
        height: 2px;
        border-radius: 999px;
        background: linear-gradient(90deg,transparent,#f2c15c,#48633b,transparent);
        opacity: 0;
        transition: opacity .20s ease;
    }

    .category-show-premium-page .product-card:hover {
        transform: translateY(-8px);
        border-color: #ddbd8e;
        box-shadow: 0 23px 50px rgba(95,52,29,.14);
    }

    .category-show-premium-page .product-card:hover::before {
        opacity: .9;
    }

    .category-show-premium-page .product-image-wrapper {
        height: 245px;
        overflow: hidden;
        border-bottom: 1px solid #efdfca;
        background:
            radial-gradient(circle at 82% 18%, rgba(242,193,92,.19), transparent 27%),
            linear-gradient(145deg,#fffdf8,#fff6e6);
    }

    .category-show-premium-page .product-image {
        transition:
            transform .34s ease,
            filter .34s ease;
        filter: drop-shadow(0 8px 14px rgba(95,52,29,.08));
    }

    .category-show-premium-page .product-card:hover .product-image {
        transform: scale(1.055);
        filter: drop-shadow(0 12px 18px rgba(95,52,29,.12));
    }

    .category-show-premium-page .stock-badge {
        top: 13px;
        right: 13px;
        padding: 7px 10px;
        border-radius: 999px;
        box-shadow: 0 5px 12px rgba(0,0,0,.09);
    }

    .category-show-premium-page .product-card .badge.bg-light {
        padding: 6px 10px;
        border-radius: 999px;
        background: linear-gradient(180deg,#fff9ed,#fff3dd) !important;
        border-color: #e6ceaa !important;
    }

    .category-show-premium-page .product-card h5 {
        color: #34251d;
        line-height: 1.35;
        letter-spacing: -.15px;
    }

    .category-show-premium-page .product-card p {
        line-height: 1.65;
        color: #74665e !important;
    }

    .category-show-premium-page .price {
        font-size: 24px;
        letter-spacing: -.45px;
        color: #a83b2d;
    }

    .category-show-premium-page .product-card .btn {
        min-height: 42px;
        border-radius: 11px;
        font-weight: 800;
        transition:
            transform .16s ease,
            box-shadow .16s ease;
    }

    .category-show-premium-page .product-card .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 7px 16px rgba(95,52,29,.10);
    }

    @media (max-width: 767.98px) {
        .category-show-premium-page {
            padding-top: 22px !important;
        }

        .category-show-premium-page::after {
            display: none;
        }

        .category-show-premium-page .category-header {
            min-height: 0;
            padding: 29px 23px;
            border-radius: 22px;
        }

        .category-show-premium-page > .d-flex.justify-content-between {
            align-items: stretch !important;
        }

        .category-show-premium-page > .d-flex.justify-content-between .btn {
            width: 100%;
        }

        .category-show-premium-page .product-card {
            border-radius: 19px;
        }

        .category-show-premium-page .product-image-wrapper {
            height: 220px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .category-show-premium-page *,
        .category-show-premium-page *::before,
        .category-show-premium-page *::after {
            transition: none !important;
            animation: none !important;
        }
    }

</style>


<div class="category-show-premium-page container py-4">

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