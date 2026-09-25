@extends('layouts.app')

@section('title', 'Danh mục đặc sản | Tinh Hoa Tây Bắc')

@section('content')

<style>
    .category-hero {
        border-radius: 26px;
        padding: 38px;
        color: white;
        overflow: hidden;
        position: relative;

        background:
            radial-gradient(
                circle at 85% 20%,
                rgba(242, 193, 92, .18),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #2c1810,
                #5f341d 55%,
                #48633b
            );

        box-shadow:
            0 15px 40px rgba(95, 52, 29, .18);
    }

    .category-hero::after {
        content: "";
        position: absolute;

        width: 300px;
        height: 300px;

        border-radius: 50%;

        background:
            rgba(255, 255, 255, .05);

        right: -100px;
        top: -120px;
    }

    .category-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        height: 100%;

        background: white;

        box-shadow:
            0 8px 25px rgba(0, 0, 0, .06);

        transition:
            transform .25s ease,
            box-shadow .25s ease;
    }

    .category-card:hover {
        transform: translateY(-6px);

        box-shadow:
            0 18px 40px rgba(95, 52, 29, .14);
    }

    .category-icon-box {
        height: 150px;

        display: flex;
        align-items: center;
        justify-content: center;

        background:
            linear-gradient(
                135deg,
                #eef2ff,
                #dbeafe
            );

        font-size: 70px;
    }

    .category-count {
        display: inline-block;

        padding:
            7px 12px;

        border-radius:
            20px;

        background:
            #f8efe2;

        color:
            #5f341d;

        font-weight:
            700;
    }

    .category-btn {
        border-radius:
            11px;

        font-weight:
            700;
    }

    .info-card {
        border: none;

        border-radius:
            18px;

        box-shadow:
            0 8px 25px rgba(0, 0, 0, .05);
    }

    .info-icon {
        width: 50px;
        height: 50px;

        border-radius:
            15px;

        display: flex;
        align-items: center;
        justify-content: center;

        background:
            #f8efe2;

        font-size:
            24px;
    }

    /* Theme Tinh Hoa Tây Bắc */
    .category-hero .btn-light {
        color: #3b2114;
        border: none;
        background: #f2c15c;
        box-shadow: 0 8px 20px rgba(44,24,16,.16);
    }
    .category-hero .btn-light:hover { color:#2c1810; background:#ffd77d; }
    .category-card { border:1px solid #ead8bf; }
    .category-count { background:#f8efe2; color:#5f341d; }
    .category-btn.btn-primary {
        border:none;
        background:linear-gradient(135deg,#a83b2d,#5f341d);
    }
    .category-btn.btn-primary:hover {
        background:linear-gradient(135deg,#8b3025,#3b2114);
    }
    .category-btn.btn-outline-primary { color:#5f341d; border-color:#5f341d; }
    .category-btn.btn-outline-primary:hover {
        color:#fff; background:#5f341d; border-color:#5f341d;
    }
    .section-kicker { color:#48633b !important; letter-spacing:.5px; }
    .category-total-badge { background:#5f341d !important; }



    /* =========================================================
       CATEGORY INDEX PREMIUM UI
       Chỉ nâng giao diện - không đổi route / Blade / dữ liệu.
    ========================================================= */

    .categories-premium-page {
        position: relative;
        isolation: isolate;
        padding-top: 34px !important;
        padding-bottom: 76px !important;
    }

    .categories-premium-page::before {
        content: "";
        position: absolute;
        z-index: -3;
        top: -38px;
        left: 50%;
        width: min(100vw, 1700px);
        height: 760px;
        transform: translateX(-50%);
        pointer-events: none;
        background:
            radial-gradient(circle at 7% 8%, rgba(242,193,92,.19), transparent 24%),
            radial-gradient(circle at 94% 11%, rgba(72,99,59,.14), transparent 28%),
            radial-gradient(circle at 48% 25%, rgba(168,59,45,.045), transparent 31%),
            linear-gradient(180deg, rgba(255,250,240,.98), rgba(255,255,255,0));
    }

    .categories-premium-page::after {
        content: "";
        position: absolute;
        z-index: -2;
        top: 210px;
        right: -55px;
        width: 220px;
        height: 220px;
        opacity: .105;
        pointer-events: none;
        border-radius: 50%;
        background:
            repeating-radial-gradient(
                circle at center,
                rgba(95,52,29,.36) 0 1px,
                transparent 1px 13px
            );
    }

    .categories-premium-page .category-hero {
        min-height: 245px;
        padding: 46px 44px;
        border-radius: 30px;
        border: 1px solid rgba(255,255,255,.09);
        box-shadow:
            0 25px 62px rgba(44,24,16,.19),
            inset 0 1px 0 rgba(255,255,255,.07);
        background:
            radial-gradient(circle at 86% 16%, rgba(242,193,92,.24), transparent 28%),
            radial-gradient(circle at 10% 120%, rgba(168,59,45,.28), transparent 35%),
            linear-gradient(135deg,#2c1810 0%,#5f341d 54%,#48633b 100%);
    }

    .categories-premium-page .category-hero::before {
        content: "";
        position: absolute;
        right: -40px;
        bottom: -70px;
        width: 360px;
        height: 210px;
        opacity: .11;
        clip-path: polygon(
            0 100%,
            18% 56%,
            36% 73%,
            53% 25%,
            70% 58%,
            86% 34%,
            100% 66%,
            100% 100%
        );
        background: linear-gradient(135deg,#fff,#f2c15c);
        pointer-events: none;
    }

    .categories-premium-page .category-hero::after {
        width: 260px;
        height: 260px;
        right: -85px;
        top: -95px;
        background: rgba(255,255,255,.045);
    }

    .categories-premium-page .category-hero h1 {
        font-size: clamp(34px,4vw,52px);
        letter-spacing: -.9px;
        text-shadow: 0 2px 16px rgba(0,0,0,.16);
    }

    .categories-premium-page .category-hero .lead {
        line-height: 1.7;
        max-width: 760px !important;
    }

    .categories-premium-page .category-hero .btn {
        min-height: 49px;
        padding-inline: 22px;
        border-radius: 999px;
        font-weight: 900;
        box-shadow: 0 9px 20px rgba(0,0,0,.13);
        transition:
            transform .17s ease,
            box-shadow .17s ease,
            background .17s ease;
    }

    .categories-premium-page .category-hero .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 13px 26px rgba(0,0,0,.17);
    }

    /* Thống kê */
    .categories-premium-page .info-card {
        position: relative;
        overflow: hidden;
        border: 1px solid #e6d1b5;
        border-radius: 21px;
        background:
            radial-gradient(circle at 100% 0%, rgba(242,193,92,.09), transparent 30%),
            linear-gradient(180deg,#fff,#fffdfa);
        box-shadow:
            0 14px 36px rgba(95,52,29,.07),
            inset 0 1px 0 rgba(255,255,255,.94);
        transition:
            transform .18s ease,
            box-shadow .18s ease,
            border-color .18s ease;
    }

    .categories-premium-page .info-card:hover {
        transform: translateY(-4px);
        border-color: #dec092;
        box-shadow: 0 20px 43px rgba(95,52,29,.11);
    }

    .categories-premium-page .info-icon {
        width: 56px;
        height: 56px;
        border-radius: 17px;
        border: 1px solid #ead2aa;
        background:
            radial-gradient(circle at 35% 25%,rgba(255,255,255,.9),transparent 30%),
            linear-gradient(135deg,#fff0ca,#f7dfaf);
        box-shadow:
            inset 0 1px 0 rgba(255,255,255,.9),
            0 7px 15px rgba(95,52,29,.06);
    }

    /* Tiêu đề khu danh mục */
    .categories-premium-page .section-kicker {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border: 1px solid #dbe5d5;
        border-radius: 999px;
        background: #f3f8f0;
        color: #48633b !important;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .06em;
    }

    .categories-premium-page .category-total-badge {
        padding: 8px 12px;
        border-radius: 999px;
        box-shadow: 0 5px 12px rgba(95,52,29,.10);
    }

    /* Card danh mục */
    .categories-premium-page .category-card {
        position: relative;
        border-radius: 23px;
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

    .categories-premium-page .category-card::before {
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

    .categories-premium-page .category-card:hover {
        transform: translateY(-8px);
        border-color: #ddbd8e;
        box-shadow: 0 23px 50px rgba(95,52,29,.14);
    }

    .categories-premium-page .category-card:hover::before {
        opacity: .9;
    }

    .categories-premium-page .category-icon-box {
        position: relative;
        overflow: hidden;
        height: 170px;
        background:
            radial-gradient(circle at 78% 18%, rgba(242,193,92,.22), transparent 28%),
            radial-gradient(circle at 15% 88%, rgba(72,99,59,.08), transparent 30%),
            linear-gradient(145deg,#fffdf8,#fff5e3);
        border-bottom: 1px solid #efdfca;
        font-size: 76px;
        text-shadow: 0 8px 18px rgba(95,52,29,.11);
    }

    .categories-premium-page .category-icon-box::after {
        content: "";
        position: absolute;
        inset: 18px;
        border: 1px solid rgba(95,52,29,.07);
        border-radius: 18px;
        pointer-events: none;
    }

    .categories-premium-page .category-count {
        padding: 6px 10px;
        border-radius: 999px;
        border: 1px solid #e7d0ac;
        background: linear-gradient(180deg,#fff9ed,#fff3dd);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.9);
    }

    .categories-premium-page .category-card h4 {
        color: #34251d;
        letter-spacing: -.25px;
    }

    .categories-premium-page .category-card p {
        line-height: 1.65;
        color: #73665e !important;
    }

    .categories-premium-page .category-btn {
        min-height: 43px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        transition:
            transform .16s ease,
            box-shadow .16s ease;
    }

    .categories-premium-page .category-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 7px 16px rgba(95,52,29,.10);
    }

    .categories-premium-page .pagination {
        gap: 6px;
    }

    .categories-premium-page .page-link {
        min-width: 41px;
        min-height: 41px;
        display: grid;
        place-items: center;
        border-radius: 11px !important;
        border-color: #e3ceb0;
        color: #5f341d;
    }

    .categories-premium-page .page-item.active .page-link {
        border-color: transparent;
        background: linear-gradient(135deg,#5f341d,#48633b);
    }

    @media (max-width: 767.98px) {
        .categories-premium-page {
            padding-top: 22px !important;
        }

        .categories-premium-page::after {
            display: none;
        }

        .categories-premium-page .category-hero {
            min-height: 0;
            padding: 30px 24px;
            border-radius: 22px;
        }

        .categories-premium-page .category-card {
            border-radius: 19px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .categories-premium-page *,
        .categories-premium-page *::before,
        .categories-premium-page *::after {
            transition: none !important;
            animation: none !important;
        }
    }

</style>


<div class="categories-premium-page container py-4">


    {{-- ==========================================
        HERO
    ========================================== --}}
    <section class="category-hero mb-5">

        <div
            class="row align-items-center position-relative"
            style="z-index: 2;"
        >

            <div class="col-lg-8">

                <div
                    class="fw-bold small mb-2"
                    style="
                        color:
                        rgba(255,255,255,.7);
                        letter-spacing:1px;
                    "
                >
                    🌿 TINH HOA TÂY BẮC
                </div>


                <h1 class="fw-bold display-5 mb-3">

                    🧺 Danh mục đặc sản

                </h1>


                <p
                    class="lead mb-0"
                    style="
                        color:
                        rgba(255,255,255,.75);
                        max-width:700px;
                    "
                >
                    Khám phá thịt gác bếp, lạp xưởng, mắc khén,
                    hạt dổi, trà Shan Tuyết, mật ong và nhiều
                    đặc sản đậm đà hương vị núi rừng Tây Bắc.
                </p>

            </div>


            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">


                {{-- ADMIN --}}
                @if(
                    Auth::check()
                    &&
                    Auth::user()->role === 'admin'
                )

                    <a
                        href="{{
                            route(
                                'admin.categories.index'
                            )
                        }}"
                        class="
                            btn
                            btn-warning
                            btn-lg
                            fw-bold
                        "
                    >
                        ⚙️ Quản lý danh mục
                    </a>


                {{-- CUSTOMER --}}
                @else

                    <a
                        href="{{
                            route(
                                'products.index'
                            )
                        }}"
                        class="
                            btn
                            btn-light
                            btn-lg
                            fw-bold
                        "
                    >
                        🥩 Xem tất cả đặc sản
                    </a>

                @endif

            </div>

        </div>

    </section>



    {{-- ==========================================
        THỐNG KÊ
    ========================================== --}}
    <section class="mb-5">

        <div class="row g-3">

            <div class="col-md-4">

                <div class="card info-card h-100">

                    <div class="card-body p-4">

                        <div
                            class="
                                d-flex
                                align-items-center
                                gap-3
                            "
                        >

                            <div class="info-icon">
                                🧺
                            </div>


                            <div>

                                <div
                                    class="
                                        text-muted
                                        small
                                    "
                                >
                                    Tổng danh mục
                                </div>


                                <h3 class="fw-bold mb-0">

                                    {{
                                        method_exists(
                                            $categories,
                                            'total'
                                        )
                                        ? $categories->total()
                                        : $categories->count()
                                    }}

                                </h3>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <div class="col-md-4">

                <div class="card info-card h-100">

                    <div class="card-body p-4">

                        <div
                            class="
                                d-flex
                                align-items-center
                                gap-3
                            "
                        >

                            <div class="info-icon">
                                🌿
                            </div>


                            <div>

                                <div
                                    class="
                                        text-muted
                                        small
                                    "
                                >
                                    Đặc sản Tây Bắc
                                </div>


                                <h5 class="fw-bold mb-0">
                                    Đậm vị núi rừng
                                </h5>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <div class="col-md-4">

                <div class="card info-card h-100">

                    <div class="card-body p-4">

                        <div
                            class="
                                d-flex
                                align-items-center
                                gap-3
                            "
                        >

                            <div class="info-icon">
                                🚚
                            </div>


                            <div>

                                <div
                                    class="
                                        text-muted
                                        small
                                    "
                                >
                                    Giao hàng
                                </div>


                                <h5 class="fw-bold mb-0">
                                    Toàn quốc, tận nơi
                                </h5>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- ==========================================
        TIÊU ĐỀ DANH SÁCH
    ========================================== --}}
    <div
        class="
            d-flex
            justify-content-between
            align-items-end
            flex-wrap
            gap-2
            mb-4
        "
    >

        <div>

            <div
                class="
                    section-kicker
                    fw-bold
                    small
                    mb-1
                "
            >
                KHÁM PHÁ ĐẶC SẢN
            </div>


            <h2 class="fw-bold mb-0">

                Chọn hương vị bạn yêu thích

            </h2>

        </div>


        <span
            class="
                badge
                category-total-badge
                fs-6
            "
        >

            {{
                method_exists(
                    $categories,
                    'total'
                )
                ? $categories->total()
                : $categories->count()
            }}

            danh mục

        </span>

    </div>



    {{-- ==========================================
        DANH SÁCH DANH MỤC
    ========================================== --}}
    @if($categories->isEmpty())

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <div style="font-size:70px;">
                    📭
                </div>


                <h4 class="fw-bold mt-3">

                    Chưa có danh mục đặc sản

                </h4>


                <p class="text-muted">

                    Cửa hàng hiện chưa có
                    danh mục nào để hiển thị.

                </p>


                @if(
                    Auth::check()
                    &&
                    Auth::user()->role === 'admin'
                )

                    <a
                        href="{{
                            route(
                                'admin.categories.create'
                            )
                        }}"
                        class="btn btn-primary"
                    >
                        ➕ Thêm danh mục
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

            @foreach($categories as $category)


                @php

                    $name =
                        mb_strtolower(
                            $category->name
                        );


                    $icon = '🌿';

                    if (str_contains($name, 'trâu') || str_contains($name, 'thịt') || str_contains($name, 'gác bếp')) {
                        $icon = '🥩';
                    }
                    elseif (str_contains($name, 'lạp xưởng')) {
                        $icon = '🌭';
                    }
                    elseif (str_contains($name, 'mắc khén') || str_contains($name, 'hạt dổi') || str_contains($name, 'chẩm chéo') || str_contains($name, 'gia vị')) {
                        $icon = '🌶️';
                    }
                    elseif (str_contains($name, 'trà') || str_contains($name, 'thảo mộc')) {
                        $icon = '🍵';
                    }
                    elseif (str_contains($name, 'mật ong')) {
                        $icon = '🍯';
                    }
                    elseif (str_contains($name, 'gạo') || str_contains($name, 'nếp')) {
                        $icon = '🍚';
                    }
                    elseif (str_contains($name, 'quà') || str_contains($name, 'biếu')) {
                        $icon = '🎁';
                    }
                    elseif (str_contains($name, 'khô') || str_contains($name, 'táo mèo')) {
                        $icon = '🧺';
                    }


                    $productCount =
                        $category
                            ->products()
                            ->count();

                @endphp



                <div class="col">

                    <div class="card category-card">


                        {{-- ICON --}}
                        <div class="category-icon-box">

                            {{ $icon }}

                        </div>



                        {{-- BODY --}}
                        <div
                            class="
                                card-body
                                p-4
                                d-flex
                                flex-column
                            "
                        >

                            <div class="mb-2">

                                <span class="category-count">

                                    {{ $productCount }}
                                    sản phẩm

                                </span>

                            </div>


                            <h4 class="fw-bold mb-2">

                                {{ $category->name }}

                            </h4>


                            <p
                                class="
                                    text-muted
                                    small
                                    flex-grow-1
                                "
                            >

                                Khám phá các sản phẩm
                                thuộc danh mục
                                {{ $category->name }}
                                tại Tinh Hoa Tây Bắc.

                            </p>



                            {{-- ==================================
                                ADMIN
                            ================================== --}}
                            @if(
                                Auth::check()
                                &&
                                Auth::user()->role === 'admin'
                            )

                                <a
                                    href="{{
                                        route(
                                            'admin.categories.show',
                                            $category->id
                                        )
                                    }}"
                                    class="
                                        btn
                                        btn-outline-primary
                                        category-btn
                                        w-100
                                    "
                                >
                                    ⚙️ Xem & quản lý
                                </a>


                            {{-- ==================================
                                CUSTOMER
                            ================================== --}}
                            @else

                                <a
                                    href="{{
                                        route(
                                            'categories.show',
                                            $category->id
                                        )
                                    }}"
                                    class="
                                        btn
                                        btn-primary
                                        category-btn
                                        w-100
                                    "
                                >
                                    🌿 Xem đặc sản
                                </a>

                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


    @endif



    {{-- ==========================================
        PHÂN TRANG
    ========================================== --}}
    @if(
        method_exists(
            $categories,
            'hasPages'
        )
        &&
        $categories->hasPages()
    )

        <div
            class="
                d-flex
                justify-content-center
                mt-5
            "
        >

            {{ $categories->links() }}

        </div>

    @endif


</div>

@endsection