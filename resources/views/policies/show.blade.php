@extends('layouts.app')

@section('title', $title . ' | Tinh Hoa Tây Bắc')

@section('content')

<style>
    /* =========================================================
       POLICY PAGE
    ========================================================= */

    .tb-policy {
        --policy-green: #35562f;
        --policy-green-dark: #294725;

        --policy-brown: #633820;
        --policy-red: #b43e2e;
        --policy-gold: #e5ad42;

        min-height: 70vh;

        padding:
            38px 0 72px;

        background:
            linear-gradient(
                180deg,
                #fffdf8 0%,
                #ffffff 100%
            );
    }


    .tb-policy-container {
        width:
            min(
                1180px,
                calc(100% - 38px)
            );

        margin:
            0 auto;
    }


    /* =========================================================
       BREADCRUMB
    ========================================================= */

    .tb-policy-breadcrumb {
        display: flex;

        align-items: center;

        flex-wrap: wrap;

        gap: 8px;

        margin-bottom: 18px;

        color:
            #8c7b70;

        font-size:
            13px;
    }


    .tb-policy-breadcrumb a {
        color:
            var(--policy-green);

        text-decoration: none;

        font-weight: 800;
    }


    .tb-policy-breadcrumb a:hover {
        color:
            var(--policy-red);
    }


    .tb-policy-breadcrumb-separator {
        color:
            #c5b9b0;
    }


    /* =========================================================
       HERO
    ========================================================= */

    .tb-policy-hero {
        position: relative;

        overflow: hidden;

        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            auto;

        align-items: center;

        gap: 32px;

        padding:
            42px;

        margin-bottom:
            28px;

        border:
            1px solid
            #e8d9c5;

        border-radius:
            28px;

        background:
            radial-gradient(
                circle at 91% 14%,
                rgba(229, 173, 66, .22),
                transparent 30%
            ),
            radial-gradient(
                circle at 4% 100%,
                rgba(53, 86, 47, .08),
                transparent 28%
            ),
            linear-gradient(
                135deg,
                #fffefb,
                #fff7e9
            );

        box-shadow:
            0 20px 48px
            rgba(82, 53, 32, .08);
    }


    .tb-policy-hero::after {
        content: "";

        position: absolute;

        width: 190px;
        height: 190px;

        right: -75px;
        bottom: -95px;

        border-radius:
            50%;

        border:
            32px solid
            rgba(229, 173, 66, .08);

        pointer-events:
            none;
    }


    .tb-policy-kicker {
        display: inline-flex;

        align-items: center;

        gap: 7px;

        width:
            fit-content;

        margin-bottom:
            15px;

        padding:
            7px 12px;

        border:
            1px solid
            #e8c983;

        border-radius:
            999px;

        color:
            #7b482b;

        background:
            #fff1c9;

        font-size:
            11px;

        font-weight:
            950;

        letter-spacing:
            .08em;
    }


    .tb-policy-title {
        margin:
            0 0 13px;

        color:
            #33241c;

        font-size:
            clamp(
                32px,
                4vw,
                48px
            );

        line-height:
            1.1;

        font-weight:
            950;

        letter-spacing:
            -.035em;
    }


    .tb-policy-subtitle {
        max-width:
            770px;

        margin:
            0;

        color:
            #76685f;

        font-size:
            15px;

        line-height:
            1.8;
    }


    .tb-policy-icon {
        position:
            relative;

        z-index:
            1;

        width:
            116px;

        height:
            116px;

        display:
            grid;

        place-items:
            center;

        flex:
            0 0 116px;

        border:
            1px solid
            rgba(99, 56, 32, .13);

        border-radius:
            29px;

        background:
            rgba(255, 255, 255, .72);

        box-shadow:
            0 14px 35px
            rgba(75, 50, 31, .08);

        font-size:
            52px;
    }


    /* =========================================================
       BODY GRID
    ========================================================= */

    .tb-policy-layout {
        display: grid;

        grid-template-columns:
            minmax(0, 1fr)
            290px;

        gap: 24px;

        align-items:
            start;
    }


    /* =========================================================
       SECTIONS
    ========================================================= */

    .tb-policy-content {
        display: grid;

        gap: 15px;
    }


    .tb-policy-card {
        position:
            relative;

        padding:
            25px 27px;

        border:
            1px solid
            #eadfd3;

        border-radius:
            18px;

        background:
            #fff;

        box-shadow:
            0 9px 26px
            rgba(70, 48, 31, .045);

        transition:
            transform .18s ease,
            box-shadow .18s ease,
            border-color .18s ease;
    }


    .tb-policy-card:hover {
        transform:
            translateY(-2px);

        border-color:
            #dfc9aa;

        box-shadow:
            0 14px 34px
            rgba(70, 48, 31, .07);
    }


    .tb-policy-card-title {
        margin:
            0 0 10px;

        color:
            var(--policy-green);

        font-size:
            18px;

        line-height:
            1.4;

        font-weight:
            950;
    }


    .tb-policy-card-text {
        margin:
            0;

        color:
            #70645c;

        font-size:
            14px;

        line-height:
            1.85;
    }


    /* =========================================================
       SIDEBAR
    ========================================================= */

    .tb-policy-sidebar {
        position:
            sticky;

        top:
            100px;

        display:
            grid;

        gap:
            16px;
    }


    .tb-policy-side-box {
        padding:
            21px;

        border:
            1px solid
            #e7d9c8;

        border-radius:
            18px;

        background:
            #fff;

        box-shadow:
            0 10px 28px
            rgba(72, 48, 30, .05);
    }


    .tb-policy-side-title {
        margin-bottom:
            12px;

        color:
            #34251d;

        font-size:
            15px;

        font-weight:
            950;
    }


    .tb-policy-side-text {
        margin:
            0 0 15px;

        color:
            #786b62;

        font-size:
            13px;

        line-height:
            1.7;
    }


    .tb-policy-side-links {
        display:
            grid;

        gap:
            8px;
    }


    .tb-policy-side-link {
        display: flex;

        align-items: center;

        justify-content:
            space-between;

        gap:
            10px;

        min-height:
            42px;

        padding:
            8px 11px;

        border:
            1px solid
            #ece2d7;

        border-radius:
            10px;

        color:
            #5e5046;

        background:
            #fffdf9;

        font-size:
            12px;

        font-weight:
            800;

        text-decoration:
            none;

        transition:
            all .16s ease;
    }


    .tb-policy-side-link:hover {
        color:
            #fff;

        border-color:
            var(--policy-green);

        background:
            var(--policy-green);

        transform:
            translateX(2px);
    }


    .tb-policy-side-link.active {
        color:
            #fff;

        border-color:
            var(--policy-green);

        background:
            var(--policy-green);
    }


    /* =========================================================
       CONTACT
    ========================================================= */

    .tb-policy-contact {
        padding:
            21px;

        border:
            1px solid
            #ddcfb9;

        border-radius:
            18px;

        background:
            linear-gradient(
                145deg,
                #f5f8f1,
                #fff7e8
            );
    }


    .tb-policy-contact-icon {
        width:
            44px;

        height:
            44px;

        display:
            grid;

        place-items:
            center;

        margin-bottom:
            13px;

        border-radius:
            13px;

        background:
            #fff;

        box-shadow:
            0 7px 17px
            rgba(70, 48, 31, .08);

        font-size:
            21px;
    }


    .tb-policy-contact-title {
        margin-bottom:
            5px;

        color:
            var(--policy-green);

        font-size:
            16px;

        font-weight:
            950;
    }


    .tb-policy-contact-text {
        color:
            #76685f;

        font-size:
            12px;

        line-height:
            1.65;
    }


    .tb-policy-actions {
        display:
            grid;

        gap:
            8px;

        margin-top:
            15px;
    }


    .tb-policy-btn {
        min-height:
            43px;

        display: flex;

        align-items: center;

        justify-content:
            center;

        gap:
            7px;

        padding:
            8px 15px;

        border-radius:
            10px;

        font-size:
            13px;

        font-weight:
            900;

        text-decoration:
            none;

        transition:
            transform .16s ease,
            filter .16s ease;
    }


    .tb-policy-btn:hover {
        transform:
            translateY(-1px);
    }


    .tb-policy-btn-primary {
        color:
            #fff;

        background:
            var(--policy-green);

        box-shadow:
            0 8px 18px
            rgba(53, 86, 47, .18);
    }


    .tb-policy-btn-primary:hover {
        color:
            #fff;

        filter:
            brightness(.94);
    }


    .tb-policy-btn-secondary {
        color:
            #55351f;

        border:
            1px solid
            #d6b878;

        background:
            #ffefc4;
    }


    .tb-policy-btn-secondary:hover {
        color:
            #55351f;

        filter:
            brightness(.98);
    }


    /* =========================================================
       BOTTOM NOTE
    ========================================================= */

    .tb-policy-note {
        margin-top:
            26px;

        padding:
            18px 21px;

        border:
            1px dashed
            #d8c8b5;

        border-radius:
            14px;

        color:
            #75675e;

        background:
            #fffdf9;

        font-size:
            12px;

        line-height:
            1.7;
    }


    .tb-policy-note strong {
        color:
            #4c3a2e;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .tb-policy-layout {
            grid-template-columns:
                1fr;
        }


        .tb-policy-sidebar {
            position:
                static;

            grid-template-columns:
                repeat(
                    2,
                    minmax(0, 1fr)
                );
        }

    }


    @media (max-width: 767.98px) {

        .tb-policy {
            padding:
                25px 0 50px;
        }


        .tb-policy-container {
            width:
                calc(100% - 24px);
        }


        .tb-policy-hero {
            grid-template-columns:
                1fr;

            padding:
                27px 22px;

            gap:
                22px;

            border-radius:
                21px;
        }


        .tb-policy-icon {
            width:
                82px;

            height:
                82px;

            border-radius:
                20px;

            font-size:
                38px;
        }


        .tb-policy-card {
            padding:
                21px;
        }


        .tb-policy-sidebar {
            grid-template-columns:
                1fr;
        }

    }
</style>


<div class="tb-policy">

    <div class="tb-policy-container">


        {{-- =====================================================
            BREADCRUMB
        ====================================================== --}}

        <div class="tb-policy-breadcrumb">

            <a href="{{ route('welcome') }}">
                Trang chủ
            </a>

            <span class="tb-policy-breadcrumb-separator">
                ›
            </span>

            <span>
                {{ $title }}
            </span>

        </div>


        {{-- =====================================================
            HERO
        ====================================================== --}}

        <section class="tb-policy-hero">

            <div>

                <div class="tb-policy-kicker">
                    🌿 TINH HOA TÂY BẮC
                </div>


                <h1 class="tb-policy-title">
                    {{ $title }}
                </h1>


                <p class="tb-policy-subtitle">
                    {{ $subtitle }}
                </p>

            </div>


            <div class="tb-policy-icon">
                {{ $icon }}
            </div>

        </section>


        {{-- =====================================================
            MAIN CONTENT
        ====================================================== --}}

        <div class="tb-policy-layout">


            {{-- =================================================
                NỘI DUNG CHÍNH SÁCH
            ================================================== --}}

            <main class="tb-policy-content">

                @foreach($sections as $section)

                    <article class="tb-policy-card">

                        <h2 class="tb-policy-card-title">
                            {{ $section['title'] }}
                        </h2>


                        <p class="tb-policy-card-text">
                            {{ $section['content'] }}
                        </p>

                    </article>

                @endforeach


                <div class="tb-policy-note">

                    <strong>
                        Lưu ý:
                    </strong>

                    Nội dung chính sách có thể được cập nhật
                    để phù hợp với hoạt động của Tinh Hoa Tây Bắc.
                    Phiên bản mới nhất luôn được hiển thị
                    trực tiếp trên website.

                </div>

            </main>


            {{-- =================================================
                SIDEBAR
            ================================================== --}}

            <aside class="tb-policy-sidebar">


                {{-- DANH SÁCH CHÍNH SÁCH --}}

                <div class="tb-policy-side-box">

                    <div class="tb-policy-side-title">
                        Chính sách & điều khoản
                    </div>


                    <div class="tb-policy-side-links">

                        <a
                            href="{{ route('policies.shipping') }}"
                            class="
                                tb-policy-side-link
                                {{ request()->routeIs('policies.shipping') ? 'active' : '' }}
                            "
                        >
                            <span>
                                🚚 Giao hàng
                            </span>

                            <span>
                                ›
                            </span>
                        </a>


                        <a
                            href="{{ route('policies.returns') }}"
                            class="
                                tb-policy-side-link
                                {{ request()->routeIs('policies.returns') ? 'active' : '' }}
                            "
                        >
                            <span>
                                🔄 Đổi trả
                            </span>

                            <span>
                                ›
                            </span>
                        </a>


                        <a
                            href="{{ route('policies.privacy') }}"
                            class="
                                tb-policy-side-link
                                {{ request()->routeIs('policies.privacy') ? 'active' : '' }}
                            "
                        >
                            <span>
                                🔒 Bảo mật
                            </span>

                            <span>
                                ›
                            </span>
                        </a>


                        <a
                            href="{{ route('policies.terms') }}"
                            class="
                                tb-policy-side-link
                                {{ request()->routeIs('policies.terms') ? 'active' : '' }}
                            "
                        >
                            <span>
                                📜 Điều khoản dịch vụ
                            </span>

                            <span>
                                ›
                            </span>
                        </a>


                        <a
                            href="{{ route('policies.payment') }}"
                            class="
                                tb-policy-side-link
                                {{ request()->routeIs('policies.payment') ? 'active' : '' }}
                            "
                        >
                            <span>
                                💳 Thanh toán
                            </span>

                            <span>
                                ›
                            </span>
                        </a>

                    </div>

                </div>


                {{-- HỖ TRỢ --}}

                <div class="tb-policy-contact">

                    <div class="tb-policy-contact-icon">
                        ☎
                    </div>


                    <div class="tb-policy-contact-title">
                        Cần hỗ trợ?
                    </div>


                    <div class="tb-policy-contact-text">

                        Nếu bạn cần thêm thông tin,
                        hãy liên hệ với Tinh Hoa Tây Bắc
                        để được hỗ trợ.

                    </div>


                    <div class="tb-policy-actions">

                        <a
                            href="tel:0385742505"
                            class="
                                tb-policy-btn
                                tb-policy-btn-primary
                            "
                        >
                            ☎ 0385 742 505
                        </a>


                        <a
                            href="https://zalo.me/0385742505"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="
                                tb-policy-btn
                                tb-policy-btn-secondary
                            "
                        >
                            Z Chat qua Zalo
                        </a>

                    </div>

                </div>

            </aside>

        </div>

    </div>

</div>

@endsection