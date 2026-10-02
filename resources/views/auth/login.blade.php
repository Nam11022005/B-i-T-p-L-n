@extends('layouts.app')

@section('title', 'Đăng nhập | Tinh Hoa Tây Bắc')

@section('hide-store-header', '1')

@section('content')

<style>
    /* =========================================================
       LOGIN - TINH HOA TÂY BẮC
    ========================================================= */

    .tb-login-page {
        --login-brown: #633820;
        --login-brown-dark: #2d1a11;
        --login-green: #35562f;
        --login-red: #b43e2e;
        --login-gold: #e5ad42;
        --login-cream: #fff8e9;
        --login-border: #e7d4b7;
        --login-text: #33261f;
        --login-muted: #76685e;

        position: relative;

        isolation: isolate;

        width: 100%;

        padding:
            42px 0 72px;
    }


    .tb-login-page::before {
        content: "";

        position: absolute;

        z-index: -2;

        inset:
            -30px -40px 0;

        pointer-events: none;

        background:
            radial-gradient(
                circle at 7% 13%,
                rgba(229,173,66,.19),
                transparent 25%
            ),
            radial-gradient(
                circle at 92% 9%,
                rgba(53,86,47,.13),
                transparent 28%
            ),
            radial-gradient(
                circle at 50% 46%,
                rgba(180,62,46,.05),
                transparent 30%
            ),
            linear-gradient(
                180deg,
                #fff9ed 0%,
                #fdfbf7 52%,
                #faf9f7 100%
            );
    }


    .tb-login-shell {
        position: relative;

        width:
            min(
                1100px,
                100%
            );

        margin:
            0 auto;

        display: grid;

        grid-template-columns:
            minmax(0, .92fr)
            minmax(0, 1.08fr);

        overflow: hidden;

        border:
            1px solid
            rgba(222,195,158,.88);

        border-radius:
            30px;

        background:
            #fff;

        box-shadow:
            0 32px 80px
            rgba(73,44,27,.14);
    }


    .tb-login-shell::before {
        content: "";

        position: absolute;

        z-index: 10;

        top: 0;
        left: 8%;
        right: 8%;

        height: 3px;

        border-radius:
            999px;

        background:
            linear-gradient(
                90deg,
                transparent,
                var(--login-gold),
                var(--login-red),
                var(--login-green),
                transparent
            );

        pointer-events: none;
    }


    /* =========================================================
       LEFT PANEL
    ========================================================= */

    .tb-login-brand {
        position: relative;

        overflow: hidden;

        min-height: 620px;

        display: flex;
        flex-direction: column;
        justify-content: space-between;

        padding:
            52px 46px;

        color:
            #fff;

        background:
            radial-gradient(
                circle at 82% 14%,
                rgba(229,173,66,.27),
                transparent 28%
            ),
            radial-gradient(
                circle at 12% 112%,
                rgba(180,62,46,.32),
                transparent 35%
            ),
            linear-gradient(
                145deg,
                #26140d 0%,
                #56301d 49%,
                #35562f 100%
            );
    }


    .tb-login-brand::before {
        content: "";

        position: absolute;

        right: -70px;
        bottom: -55px;

        width: 420px;
        height: 250px;

        opacity: .13;

        clip-path:
            polygon(
                0 100%,
                18% 58%,
                34% 73%,
                53% 23%,
                70% 58%,
                85% 34%,
                100% 65%,
                100% 100%
            );

        background:
            linear-gradient(
                135deg,
                #fff,
                #f0bf5c
            );
    }


    .tb-login-brand::after {
        content: "•";

        position: absolute;

        top: 30px;
        right: 38px;

        color:
            #ffe291;

        font-size:
            90px;

        opacity: .055;

        transform:
            rotate(18deg);
    }


    .tb-login-brand-top,
    .tb-login-benefits {
        position: relative;

        z-index: 2;
    }


    .tb-login-logo {
        width: 58px;
        height: 58px;

        display: grid;
        place-items: center;

        margin-bottom:
            24px;

        border:
            1px solid
            rgba(255,255,255,.16);

        border-radius:
            18px;

        color:
            #f5d47e;

        background:
            rgba(255,255,255,.08);

        box-shadow:
            inset 0 1px 0
            rgba(255,255,255,.12),
            0 12px 26px
            rgba(0,0,0,.14);

        font-size:
            25px;
    }


    .tb-login-kicker {
        display:
            inline-flex;

        align-items:
            center;

        gap:
            7px;

        margin-bottom:
            18px;

        padding:
            8px 12px;

        border:
            1px solid
            rgba(229,173,66,.34);

        border-radius:
            999px;

        color:
            #f5d789;

        background:
            rgba(255,255,255,.06);

        font-size:
            12px;

        font-weight:
            900;

        letter-spacing:
            .08em;

        text-transform:
            uppercase;
    }


    .tb-login-brand h1 {
        max-width:
            450px;

        margin:
            0;

        color:
            #fff;

        font-size:
            clamp(
                38px,
                4vw,
                56px
            );

        line-height:
            1.05;

        font-weight:
            950;

        letter-spacing:
            -1.2px;
    }


    .tb-login-brand-copy {
        max-width:
            465px;

        margin:
            19px 0 0;

        color:
            rgba(255,255,255,.76);

        font-size:
            15px;

        line-height:
            1.75;
    }


    .tb-login-benefits {
        display:
            grid;

        gap:
            11px;

        margin-top:
            34px;
    }


    .tb-login-benefit {
        display:
            flex;

        align-items:
            center;

        gap:
            11px;

        padding:
            11px 13px;

        border:
            1px solid
            rgba(255,255,255,.09);

        border-radius:
            14px;

        color:
            rgba(255,255,255,.84);

        background:
            rgba(255,255,255,.045);

        font-size:
            14px;

        font-weight:
            700;
    }


    .tb-login-benefit-icon {
        width: 36px;
        height: 36px;

        flex:
            0 0 36px;

        display:
            grid;

        place-items:
            center;

        border-radius:
            11px;

        background:
            rgba(255,255,255,.09);

        font-size:
            17px;
    }


    /* =========================================================
       FORM PANEL
    ========================================================= */

    .tb-login-form-panel {
        position:
            relative;

        display:
            flex;

        flex-direction:
            column;

        justify-content:
            center;

        padding:
            58px 62px;

        background:
            radial-gradient(
                circle at 100% 0%,
                rgba(229,173,66,.10),
                transparent 26%
            ),
            radial-gradient(
                circle at 0% 100%,
                rgba(53,86,47,.045),
                transparent 25%
            ),
            #fff;
    }


    .tb-login-form-panel::after {
        content: "";

        position:
            absolute;

        top:
            25px;

        right:
            27px;

        width:
            90px;

        height:
            90px;

        border:
            1px solid
            rgba(99,56,32,.06);

        border-left:
            0;

        border-bottom:
            0;

        border-radius:
            0 24px 0 0;

        pointer-events:
            none;
    }


    .tb-login-form-head {
        position:
            relative;

        z-index:
            2;

        margin-bottom:
            28px;
    }


    .tb-login-form-icon {
        width:
            42px;

        height:
            42px;

        display:
            grid;

        place-items:
            center;

        margin-bottom:
            15px;

        border:
            1px solid
            #e8d1ad;

        border-radius:
            13px;

        color:
            #7e4729;

        background:
            linear-gradient(
                135deg,
                #fff8e8,
                #f6e0b7
            );

        box-shadow:
            0 7px 15px
            rgba(99,56,32,.07);

        font-size:
            18px;
    }


    .tb-login-form-head h2 {
        margin:
            0;

        color:
            #30231c;

        font-size:
            34px;

        line-height:
            1.15;

        font-weight:
            950;

        letter-spacing:
            -.7px;
    }


    .tb-login-form-head p {
        margin:
            9px 0 0;

        color:
            var(--login-muted);

        font-size:
            14px;

        line-height:
            1.65;
    }


    .tb-login-trust {
        display:
            flex;

        flex-wrap:
            wrap;

        gap:
            8px;

        margin-bottom:
            24px;
    }


    .tb-login-trust span {
        display:
            inline-flex;

        align-items:
            center;

        min-height:
            34px;

        padding:
            6px 11px;

        border:
            1px solid
            #e6dacb;

        border-radius:
            999px;

        color:
            #655349;

        background:
            #fffdf9;

        font-size:
            12px;

        font-weight:
            750;
    }


    /* =========================================================
       FORM
    ========================================================= */

    .tb-login-field {
        margin-bottom:
            18px;
    }


    .tb-login-field-head {
        display:
            flex;

        align-items:
            center;

        justify-content:
            space-between;

        gap:
            15px;

        margin-bottom:
            8px;
    }


    .tb-login-label {
        margin:
            0;

        color:
            #4c3529;

        font-size:
            14px;

        font-weight:
            850;
    }


    .tb-login-link {
        color:
            var(--login-red);

        font-size:
            13px;

        font-weight:
            800;

        text-decoration:
            none;
    }


    .tb-login-link:hover {
        color:
            var(--login-brown);

        text-decoration:
            underline;
    }


    .tb-login-input-wrap {
        position:
            relative;
    }


    .tb-login-input-icon {
        position:
            absolute;

        z-index:
            2;

        top:
            50%;

        left:
            17px;

        transform:
            translateY(-50%);

        pointer-events:
            none;

        font-size:
            17px;

        opacity:
            .7;
    }


    .tb-login-input {
        min-height:
            54px;

        width:
            100%;

        padding:
            10px 48px;

        border:
            1px solid
            #dfcbae;

        border-radius:
            15px;

        outline:
            none;

        color:
            #34261f;

        background:
            linear-gradient(
                180deg,
                #fffefb,
                #fffaf3
            );

        font-size:
            14px;

        box-shadow:
            inset 0 1px 0
            rgba(255,255,255,.95);

        transition:
            border-color .18s ease,
            box-shadow .18s ease,
            background .18s ease;
    }


    .tb-login-input::placeholder {
        color:
            #a69990;
    }


    .tb-login-input:hover {
        border-color:
            #d8b98e;
    }


    .tb-login-input:focus {
        border-color:
            #cf9f5d;

        background:
            #fff;

        box-shadow:
            0 0 0 .22rem
            rgba(229,173,66,.13);
    }


    .tb-login-input.is-invalid {
        border-color:
            #c85a4b;
    }


    .tb-login-password-input {
        padding-right:
            54px;
    }


    .tb-password-toggle {
        position:
            absolute;

        z-index:
            3;

        top:
            50%;

        right:
            9px;

        transform:
            translateY(-50%);

        width:
            38px;

        height:
            38px;

        display:
            grid;

        place-items:
            center;

        padding:
            0;

        border:
            0;

        border-radius:
            10px;

        color:
            #705a4c;

        background:
            transparent;

        cursor:
            pointer;

        font-size:
            17px;
    }


    .tb-password-toggle:hover,
    .tb-password-toggle:focus {
        color:
            #4b2d1d;

        background:
            #f7eee2;

        outline:
            none;
    }


    .tb-login-error {
        margin-top:
            7px;

        color:
            #b43e2e;

        font-size:
            13px;

        font-weight:
            700;
    }


    /* =========================================================
       BUTTON
    ========================================================= */

    .tb-login-submit {
        position:
            relative;

        overflow:
            hidden;

        width:
            100%;

        min-height:
            56px;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        gap:
            8px;

        margin-top:
            8px;

        border:
            0;

        border-radius:
            16px;

        color:
            #fff;

        background:
            linear-gradient(
                135deg,
                #b43e2e 0%,
                #633820 50%,
                #35562f 100%
            );

        box-shadow:
            0 13px 28px
            rgba(99,56,32,.21);

        font-size:
            15px;

        font-weight:
            900;

        cursor:
            pointer;

        transition:
            transform .18s ease,
            box-shadow .18s ease;
    }


    .tb-login-submit::before {
        content: "";

        position:
            absolute;

        top:
            0;

        left:
            -120%;

        width:
            60%;

        height:
            100%;

        transform:
            skewX(-20deg);

        background:
            linear-gradient(
                90deg,
                transparent,
                rgba(255,255,255,.22),
                transparent
            );

        transition:
            left .45s ease;
    }


    .tb-login-submit:hover {
        transform:
            translateY(-2px);

        box-shadow:
            0 17px 34px
            rgba(99,56,32,.25);
    }


    .tb-login-submit:hover::before {
        left:
            145%;
    }


    /* =========================================================
       BOTTOM
    ========================================================= */

    .tb-login-separator {
        display:
            flex;

        align-items:
            center;

        gap:
            13px;

        margin:
            27px 0 20px;

        color:
            #9a8a80;

        font-size:
            12px;

        font-weight:
            800;

        letter-spacing:
            .04em;
    }


    .tb-login-separator::before,
    .tb-login-separator::after {
        content:
            "";

        flex:
            1;

        height:
            1px;

        background:
            #ead8bf;
    }


    .tb-login-register-box {
        padding:
            15px 17px;

        border:
            1px solid
            #e6d2b2;

        border-radius:
            14px;

        color:
            #6d594d;

        background:
            linear-gradient(
                135deg,
                #fffaf1,
                #fff4e2
            );

        text-align:
            center;

        font-size:
            14px;
    }


    .tb-login-security {
        display:
            flex;

        align-items:
            flex-start;

        gap:
            10px;

        margin-top:
            17px;

        padding:
            13px 14px;

        border:
            1px solid
            #dce7d7;

        border-radius:
            13px;

        color:
            #52634c;

        background:
            #f5faf2;

        font-size:
            13px;

        line-height:
            1.55;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .tb-login-page {
            padding:
                30px 0 60px;
        }


        .tb-login-shell {
            max-width:
                680px;

            grid-template-columns:
                1fr;
        }


        .tb-login-brand {
            min-height:
                auto;

            padding:
                38px 34px;
        }


        .tb-login-brand h1 {
            max-width:
                520px;

            font-size:
                40px;
        }


        .tb-login-benefits {
            grid-template-columns:
                repeat(
                    3,
                    minmax(0,1fr)
                );

            margin-top:
                28px;
        }


        .tb-login-benefit {
            align-items:
                flex-start;

            flex-direction:
                column;

            font-size:
                13px;
        }


        .tb-login-form-panel {
            padding:
                44px 38px;
        }

    }


    @media (max-width: 575.98px) {

        .tb-login-page {
            padding:
                18px 0 42px;
        }


        .tb-login-shell {
            border-radius:
                22px;
        }


        .tb-login-brand {
            padding:
                29px 23px;
        }


        .tb-login-logo {
            width:
                50px;

            height:
                50px;

            margin-bottom:
                18px;

            border-radius:
                15px;
        }


        .tb-login-brand h1 {
            font-size:
                34px;
        }


        .tb-login-brand-copy {
            font-size:
                14px;
        }


        .tb-login-benefits {
            grid-template-columns:
                1fr;

            gap:
                8px;

            margin-top:
                24px;
        }


        .tb-login-benefit {
            flex-direction:
                row;

            align-items:
                center;
        }


        .tb-login-form-panel {
            padding:
                32px 22px;
        }


        .tb-login-form-panel::after {
            display:
                none;
        }


        .tb-login-form-head h2 {
            font-size:
                29px;
        }


        .tb-login-trust {
            display:
                grid;

            grid-template-columns:
                1fr;
        }


        .tb-login-trust span {
            justify-content:
                center;
        }


        .tb-login-input {
            min-height:
                52px;
        }

    }


    @media (prefers-reduced-motion: reduce) {

        .tb-login-page *,
        .tb-login-page *::before,
        .tb-login-page *::after {
            transition:
                none !important;
        }

    }

    .tb-login-return {
        width: min(1100px, 100%);
        margin: 0 auto 16px;
    }
    .tb-login-home-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        min-height: 44px;
        padding: 10px 18px;
        border: 1px solid #bdaa88;
        background: #fffaf0;
        color: #35562f;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
    }
    .tb-login-home-link:hover {
        background: #35562f;
        border-color: #35562f;
        color: #fff;
    }
    .tb-login-home-link:focus-visible {
        outline: 3px solid #e5ad42;
        outline-offset: 3px;
    }
    .tb-login-logo {
        border-color: #d1a64d;
        background: linear-gradient(145deg, #fff6d5, #e9bd61);
    }
    .tb-login-logo .tb-brand-mark { width: 38px; height: 38px; }
    @media (max-width: 991.98px) {
        .tb-login-return { max-width: 680px; }
    }
</style>


<div class="tb-login-page">
    <nav class="tb-login-return" aria-label="Quay lại trang chủ">
        <a class="tb-login-home-link" href="{{ url('/') }}">
            <span aria-hidden="true">←</span> Quay lại trang chủ
        </a>
    </nav>

    <div class="tb-login-shell">


        {{-- =====================================================
            BRAND PANEL
        ====================================================== --}}
        <aside class="tb-login-brand">

            <div class="tb-login-brand-top">

                <div class="tb-login-logo">
                    @include('layouts.partials.brand-mark', ['variant' => 'header'])
                </div>


                <div class="tb-login-kicker">
                    Tinh Hoa Tây Bắc
                </div>


                <h1>
                    Đậm vị núi rừng,
                    trọn tình Tây Bắc.
                </h1>


                <p class="tb-login-brand-copy">

                    Đăng nhập để mua sắm nhanh hơn,
                    lưu địa chỉ giao hàng,
                    sử dụng voucher
                    và theo dõi toàn bộ hành trình đơn hàng
                    ngay trên Tinh Hoa Tây Bắc.

                </p>

            </div>


            <div class="tb-login-benefits">

                <div class="tb-login-benefit">

                    <span class="tb-login-benefit-icon">
                        •
                    </span>

                    <span>
                        Khám phá đặc sản Tây Bắc chọn lọc
                    </span>

                </div>


                <div class="tb-login-benefit">

                    <span class="tb-login-benefit-icon">
                        •
                    </span>

                    <span>
                        Theo dõi trạng thái đơn hàng thuận tiện
                    </span>

                </div>


                <div class="tb-login-benefit">

                    <span class="tb-login-benefit-icon">
                        •
                    </span>

                    <span>
                        Sử dụng voucher và ưu đãi dễ dàng
                    </span>

                </div>

            </div>

        </aside>


        {{-- =====================================================
            LOGIN FORM
        ====================================================== --}}
        <section class="tb-login-form-panel">


            <div class="tb-login-form-head">

                <div class="tb-login-form-icon">
                    •
                </div>


                <h2>
                    Chào mừng trở lại
                </h2>


                <p>
                    Đăng nhập vào tài khoản của bạn
                    để tiếp tục mua sắm.
                </p>

            </div>


            <div class="tb-login-trust">

                <span>
                    • Đặc sản chọn lọc
                </span>

                <span>
                    • Bảo mật tài khoản
                </span>

            </div>


            <form
                method="POST"
                action="{{ route('login') }}"
            >

                @csrf


                {{-- EMAIL --}}
                <div class="tb-login-field">

                    <div class="tb-login-field-head">

                        <label
                            for="email"
                            class="tb-login-label"
                        >
                            Email
                        </label>

                    </div>


                    <div class="tb-login-input-wrap">

                        <span class="tb-login-input-icon">
                            •
                        </span>


                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="
                                tb-login-input
                                @error('email')
                                    is-invalid
                                @enderror
                            "
                            placeholder="example@gmail.com"
                            autocomplete="email"
                            required
                            autofocus
                        >

                    </div>


                    @error('email')

                        <div class="tb-login-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- PASSWORD --}}
                <div class="tb-login-field">

                    <div class="tb-login-field-head">

                        <label
                            for="password"
                            class="tb-login-label"
                        >
                            Mật khẩu
                        </label>


                        <a
                            href="{{ route('password.request') }}"
                            class="tb-login-link"
                        >
                            Quên mật khẩu?
                        </a>

                    </div>


                    <div class="tb-login-input-wrap">

                        <span class="tb-login-input-icon">
                            •
                        </span>


                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="
                                tb-login-input
                                tb-login-password-input
                                @error('password')
                                    is-invalid
                                @enderror
                            "
                            placeholder="Nhập mật khẩu"
                            autocomplete="current-password"
                            required
                        >


                        <button
                            type="button"
                            class="tb-password-toggle"
                            id="toggleLoginPassword"
                            aria-label="Hiện mật khẩu"
                            title="Hiện mật khẩu"
                        >
                            👁
                        </button>

                    </div>


                    @error('password')

                        <div class="tb-login-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- SUBMIT --}}
                <button
                    type="submit"
                    class="tb-login-submit"
                >
                    <span>
                        •
                    </span>

                    <span>
                        Đăng nhập
                    </span>
                </button>

            </form>


            <div class="tb-login-separator">
                HOẶC
            </div>


            <div class="tb-login-register-box">

                Chưa có tài khoản?

                <a
                    href="{{ route('register') }}"
                    class="tb-login-link ms-1"
                >
                    Đăng ký ngay
                </a>

            </div>


            <div class="tb-login-security">

                <span>
                    •
                </span>

                <span>
                    Thông tin đăng nhập của bạn
                    được sử dụng để bảo vệ tài khoản
                    và các đơn hàng trên hệ thống.
                </span>

            </div>

        </section>

    </div>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        const passwordInput =
            document.getElementById(
                'password'
            );

        const toggleButton =
            document.getElementById(
                'toggleLoginPassword'
            );


        if (
            !passwordInput
            ||
            !toggleButton
        ) {
            return;
        }


        toggleButton.addEventListener(
            'click',
            function () {

                const isHidden =
                    passwordInput.type
                    ===
                    'password';


                passwordInput.type =
                    isHidden
                    ? 'text'
                    : 'password';


                toggleButton.textContent =
                    isHidden
                    ? '🙈'
                    : '👁';


                toggleButton.setAttribute(
                    'aria-label',
                    isHidden
                    ? 'Ẩn mật khẩu'
                    : 'Hiện mật khẩu'
                );


                toggleButton.setAttribute(
                    'title',
                    isHidden
                    ? 'Ẩn mật khẩu'
                    : 'Hiện mật khẩu'
                );

            }
        );

    }
);
</script>

@endsection