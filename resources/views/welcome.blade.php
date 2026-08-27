@extends('layouts.app')

@section('title', 'Phương Nam Shop | Thiết bị công nghệ chính hãng')

@section('content')

<style>
    .hero-tech {
        position: relative;
        overflow: hidden;
        border-radius: 28px;
        padding: 55px;
        color: white;
        background:
            radial-gradient(circle at 80% 20%, rgba(59,130,246,.45), transparent 30%),
            radial-gradient(circle at 20% 80%, rgba(99,102,241,.35), transparent 30%),
            linear-gradient(135deg, #0f172a 0%, #1e293b 45%, #312e81 100%);
        box-shadow: 0 20px 50px rgba(15, 23, 42, .2);
    }

    .hero-tech::after {
        content: '';
        position: absolute;
        width: 380px;
        height: 380px;
        border-radius: 50%;
        right: -120px;
        top: -130px;
        background: rgba(255,255,255,.05);
    }

    .hero-label {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 30px;
        border: 1px solid rgba(255,255,255,.25);
        background: rgba(255,255,255,.08);
        font-weight: 600;
    }

    .hero-title {
        font-weight: 800;
        line-height: 1.15;
        max-width: 760px;
    }

    .hero-subtitle {
        color: rgba(255,255,255,.78);
        max-width: 670px;
    }

    .hero-device {
        position: relative;
        min-height: 320px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .device-card {
        width: 290px;
        height: 250px;
        border-radius: 30px;
        background: linear-gradient(
            145deg,
            rgba(255,255,255,.17),
            rgba(255,255,255,.06)
        );
        border: 1px solid rgba(255,255,255,.18);
        backdrop-filter: blur(10px);
        box-shadow: 0 30px 50px rgba(0,0,0,.2);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        transform: rotate(-4deg);
    }

    .device-icon {
        font-size: 95px;
        line-height: 1;
    }

    .stat-box {
        background: white;
        border-radius: 18px;
        padding: 20px;
        height: 100%;
        box-shadow: 0 8px 25px rgba(0,0,0,.05);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef2ff;
        font-size: 23px;
        margin-bottom: 12px;
    }

    .category-box {
        background: white;
        border-radius: 18px;
        padding: 22px;
        height: 100%;
        text-decoration: none;
        color: #111827;
        border: 1px solid #eef2f7;
        transition: all .2s ease;
    }

    .category-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(37,99,235,.12);
        border-color: #c7d2fe;
        color: #111827;
    }

    .category-icon {
        width: 55px;
        height: 55px;
        border-radius: 16px;
        background: linear-gradient(135deg, #eef2ff, #dbeafe);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        margin-bottom: 15px;
    }

    .section-kicker {
        color: #2563eb;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .08em;
        font-size: 13px;
    }

    .tech-card {
        border-radius: 20px;
        overflow: hidden;
        border: none;
        height: 100%;
        background: white;
        box-shadow: 0 8px 25px rgba(0,0,0,.06);
        transition: all .25s ease;
    }

    .tech-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(37,99,235,.14);
    }

    .product-img-wrap {
        position: relative;
        height: 220px;
        background: linear-gradient(180deg, #f8fafc, #eef2f7);
        overflow: hidden;
    }

    .product-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 18px;
        transition: transform .25s ease;
    }

    .tech-card:hover .product-img {
        transform: scale(1.05);
    }

    .stock-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        z-index: 2;
    }

    .feature-strip {
        border-radius: 22px;
        background: linear-gradient(135deg, #eff6ff, #eef2ff);
        border: 1px solid #dbeafe;
    }

    .promo-card {
        border-radius: 24px;
        color: white;
        background: linear-gradient(135deg, #111827, #312e81);
        overflow: hidden;
    }

    .promo-badge {
        background: #fbbf24;
        color: #111827;
        font-weight: 800;
    }

    @media (max-width: 768px) {
        .hero-tech {
            padding: 30px 24px;
        }

        .hero-title {
            font-size: 36px;
        }

        .hero-device {
            min-height: 240px;
        }

        .device-card {
            width: 230px;
            height: 200px;
        }

        .device-icon {
            font-size: 70px;
        }
    }
</style>


{{-- =====================================================
    HERO
===================================================== --}}
<section class="mb-5">

    <div class="hero-tech">

        <div class="row align-items-center position-relative" style="z-index: 2;">

            <div class="col-lg-7">

                <div class="hero-label mb-3">
                    ⚡ Công nghệ mới - Giá tốt mỗi ngày
                </div>

                <h1 class="display-4 hero-title mb-3">
                    Nâng cấp trải nghiệm công nghệ cùng
                    <span class="text-warning">
                        Phương Nam Shop
                    </span>
                </h1>

                <p class="lead hero-subtitle mb-4">
                    Điện thoại, laptop, tai nghe, phụ kiện và thiết bị công nghệ
                    dành cho học tập, làm việc và giải trí.
                </p>

                <div class="d-flex gap-3 flex-wrap">

                    @auth

                        @if(Auth::user()->role === 'admin')

                            <a
                                href="{{ route('admin.products.index') }}"
                                class="btn btn-warning btn-lg px-4 fw-bold"
                            >
                                ⚙️ Quản lý sản phẩm
                            </a>

                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="btn btn-outline-light btn-lg px-4"
                            >
                                📊 Admin Dashboard
                            </a>

                        @else

                            <a
                                href="{{ route('products.index') }}"
                                class="btn btn-warning btn-lg px-4 fw-bold"
                            >
                                🛒 Mua sắm ngay
                            </a>

                            <a
                                href="{{ route('categories.index') }}"
                                class="btn btn-outline-light btn-lg px-4"
                            >
                                📂 Xem danh mục
                            </a>

                        @endif

                    @else

                        <a
                            href="{{ route('login') }}"
                            class="btn btn-warning btn-lg px-4 fw-bold"
                        >
                            🔐 Đăng nhập để mua hàng
                        </a>

                        <a
                            href="{{ route('register') }}"
                            class="btn btn-outline-light btn-lg px-4"
                        >
                            Đăng ký tài khoản
                        </a>

                    @endauth

                </div>

            </div>


            <div class="col-lg-5">

                <div class="hero-device">

                    <div class="device-card">

                        <div class="device-icon">
                            💻
                        </div>

                        <h4 class="fw-bold mt-3 mb-1">
                            Tech Store
                        </h4>

                        <small style="color: rgba(255,255,255,.7);">
                            Thiết bị công nghệ chính hãng
                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- =====================================================
    THỐNG KÊ / LỢI ÍCH
===================================================== --}}
<section class="mb-5">

    <div class="row g-3">

        <div class="col-6 col-lg-3">

            <div class="stat-box">

                <div class="stat-icon">
                    📱
                </div>

                <h4 class="fw-bold mb-1">
                    {{ number_format($totalProducts) }}+
                </h4>

                <div class="text-muted">
                    Sản phẩm công nghệ
                </div>

            </div>

        </div>


        <div class="col-6 col-lg-3">

            <div class="stat-box">

                <div class="stat-icon">
                    📂
                </div>

                <h4 class="fw-bold mb-1">
                    {{ $totalCategories }}
                </h4>

                <div class="text-muted">
                    Danh mục sản phẩm
                </div>

            </div>

        </div>


        <div class="col-6 col-lg-3">

            <div class="stat-box">

                <div class="stat-icon">
                    🚚
                </div>

                <h4 class="fw-bold mb-1">
                    Nhanh chóng
                </h4>

                <div class="text-muted">
                    Giao hàng toàn quốc
                </div>

            </div>

        </div>


        <div class="col-6 col-lg-3">

            <div class="stat-box">

                <div class="stat-icon">
                    🛡️
                </div>

                <h4 class="fw-bold mb-1">
                    An tâm
                </h4>

                <div class="text-muted">
                    Mua sắm và thanh toán
                </div>

            </div>

        </div>

    </div>

</section>



{{-- =====================================================
    DANH MỤC
===================================================== --}}
@if($categories->count() > 0)

<section class="mb-5">

    <div class="d-flex justify-content-between align-items-end mb-4">

        <div>

            <div class="section-kicker mb-1">
                Danh mục
            </div>

            <h2 class="fw-bold mb-0">
                Khám phá theo nhu cầu
            </h2>

        </div>


        @auth

            @if(Auth::user()->role !== 'admin')

                <a
                    href="{{ route('categories.index') }}"
                    class="btn btn-outline-primary"
                >
                    Xem tất cả →
                </a>

            @endif

        @endauth

    </div>


    <div class="row g-3">

        @foreach($categories as $category)

            <div class="col-6 col-md-4 col-lg-2">

                @if(Auth::check() && Auth::user()->role === 'admin')

                    <a
                        href="{{ route('admin.categories.show', $category) }}"
                        class="category-box d-block"
                    >

                @else

                    <a
                        href="{{ route('categories.show', $category) }}"
                        class="category-box d-block"
                    >

                @endif

                        <div class="category-icon">

                            @php
                                $categoryName = mb_strtolower($category->name);

                                $categoryIcon = '⚡';

                                if (str_contains($categoryName, 'điện thoại')) {
                                    $categoryIcon = '📱';
                                } elseif (str_contains($categoryName, 'laptop')) {
                                    $categoryIcon = '💻';
                                } elseif (
                                    str_contains($categoryName, 'tai nghe')
                                ) {
                                    $categoryIcon = '🎧';
                                } elseif (
                                    str_contains($categoryName, 'sạc')
                                ) {
                                    $categoryIcon = '🔌';
                                } elseif (
                                    str_contains($categoryName, 'phụ kiện')
                                ) {
                                    $categoryIcon = '⌨️';
                                }
                            @endphp

                            {{ $categoryIcon }}

                        </div>

                        <h6 class="fw-bold mb-1">
                            {{ $category->name }}
                        </h6>

                        <small class="text-muted">
                            {{ $category->products_count }} sản phẩm
                        </small>

                    </a>

            </div>

        @endforeach

    </div>

</section>

@endif



{{-- =====================================================
    BANNER KHUYẾN MÃI
===================================================== --}}
<section class="mb-5">

    <div class="promo-card p-4 p-lg-5">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <span class="badge promo-badge mb-3">
                    🔥 ƯU ĐÃI CÔNG NGHỆ
                </span>

                <h2 class="fw-bold mb-3">
                    Săn thiết bị công nghệ với mức giá hấp dẫn
                </h2>

                <p class="mb-0" style="color: rgba(255,255,255,.75);">
                    Sử dụng voucher tại bước thanh toán để nhận thêm ưu đãi
                    cho đơn hàng của bạn.
                </p>

            </div>


            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                @if(Auth::check() && Auth::user()->role !== 'admin')

                    <a
                        href="{{ route('products.index') }}"
                        class="btn btn-warning btn-lg fw-bold"
                    >
                        Xem sản phẩm →
                    </a>

                @elseif(!Auth::check())

                    <a
                        href="{{ route('register') }}"
                        class="btn btn-warning btn-lg fw-bold"
                    >
                        Bắt đầu mua sắm →
                    </a>

                @endif

            </div>

        </div>

    </div>

</section>



{{-- =====================================================
    SẢN PHẨM MỚI
===================================================== --}}
<section class="mb-5">

    <div class="d-flex justify-content-between align-items-end mb-4">

        <div>

            <div class="section-kicker mb-1">
                Sản phẩm mới
            </div>

            <h2 class="fw-bold mb-0">
                Công nghệ mới dành cho bạn
            </h2>

        </div>


        @auth

            @if(Auth::user()->role === 'admin')

                <a
                    href="{{ route('admin.products.index') }}"
                    class="btn btn-outline-primary"
                >
                    Quản lý sản phẩm →
                </a>

            @else

                <a
                    href="{{ route('products.index') }}"
                    class="btn btn-outline-primary"
                >
                    Xem tất cả →
                </a>

            @endif

        @endauth

    </div>


    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">

        @forelse($products as $product)

            <div class="col">

                <div class="tech-card">


                    {{-- ẢNH --}}
                    <div class="product-img-wrap">

                        @if($product->quantity > 0)

                            <span class="badge bg-success stock-badge">
                                Còn hàng
                            </span>

                        @else

                            <span class="badge bg-danger stock-badge">
                                Hết hàng
                            </span>

                        @endif


                        @if(
                            $product->image &&
                            Storage::disk('public')->exists($product->image)
                        )

                            <img
                                src="{{ Storage::disk('public')->url($product->image) }}"
                                alt="{{ $product->name }}"
                                class="product-img"
                            >

                        @else

                            <div
                                class="h-100 d-flex align-items-center justify-content-center"
                                style="font-size: 65px;"
                            >
                                💻
                            </div>

                        @endif

                    </div>


                    <div class="card-body p-4 d-flex flex-column">


                        {{-- DANH MỤC --}}
                        <div class="mb-2">

                            <span class="badge rounded-pill bg-light text-dark border">

                                {{ $product->category->name ?? 'Chưa phân loại' }}

                            </span>

                        </div>


                        {{-- TÊN --}}
                        <h5 class="fw-bold mb-2">

                            {{ $product->name }}

                        </h5>


                        {{-- MÔ TẢ --}}
                        <p class="text-muted small flex-grow-1">

                            {{ \Illuminate\Support\Str::limit(
                                $product->description
                                ?? 'Thiết bị công nghệ chất lượng dành cho bạn.',
                                75
                            ) }}

                        </p>


                        {{-- GIÁ --}}
                        <div class="mb-3">

                            <div class="text-danger fw-bold fs-5">

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


                        {{-- NÚT --}}
                        @if(Auth::check() && Auth::user()->role === 'admin')

                            <a
                                href="{{ route(
                                    'products.show',
                                    $product
                                ) }}"
                                class="btn btn-outline-primary mt-auto"
                            >
                                👁 Xem chi tiết
                            </a>

                        @elseif(Auth::check())

                            <div class="d-grid gap-2">

                                <a
                                    href="{{ route(
                                        'products.show',
                                        $product
                                    ) }}"
                                    class="btn btn-outline-primary"
                                >
                                    Xem chi tiết
                                </a>


                                @if($product->quantity > 0)

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
                                            class="btn btn-primary w-100"
                                        >
                                            🛒 Thêm vào giỏ
                                        </button>

                                    </form>

                                @endif

                            </div>

                        @else

                            <a
                                href="{{ route('login') }}"
                                class="btn btn-primary mt-auto"
                            >
                                Đăng nhập để mua
                            </a>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="text-center py-5">

                    <div style="font-size: 65px;">
                        📦
                    </div>

                    <h5 class="text-muted mt-3">
                        Hiện chưa có sản phẩm nào.
                    </h5>

                </div>

            </div>

        @endforelse

    </div>


    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>

</section>



{{-- =====================================================
    LỢI ÍCH
===================================================== --}}
<section class="mb-4">

    <div class="feature-strip p-4">

        <div class="row g-4 text-center">

            <div class="col-md-3">

                <div class="fs-2 mb-2">
                    ✅
                </div>

                <h6 class="fw-bold">
                    Sản phẩm chất lượng
                </h6>

                <small class="text-muted">
                    Thiết bị và phụ kiện công nghệ
                </small>

            </div>


            <div class="col-md-3">

                <div class="fs-2 mb-2">
                    🚚
                </div>

                <h6 class="fw-bold">
                    Giao hàng linh hoạt
                </h6>

                <small class="text-muted">
                    Tiết kiệm, nhanh và hỏa tốc
                </small>

            </div>


            <div class="col-md-3">

                <div class="fs-2 mb-2">
                    💳
                </div>

                <h6 class="fw-bold">
                    Thanh toán tiện lợi
                </h6>

                <small class="text-muted">
                    COD hoặc chuyển khoản QR
                </small>

            </div>


            <div class="col-md-3">

                <div class="fs-2 mb-2">
                    📦
                </div>

                <h6 class="fw-bold">
                    Theo dõi đơn hàng
                </h6>

                <small class="text-muted">
                    Cập nhật trạng thái trực tiếp
                </small>

            </div>

        </div>

    </div>

</section>

@endsection