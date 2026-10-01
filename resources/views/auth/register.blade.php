@extends('layouts.app')

@section('title', 'Đăng ký | Tinh Hoa Tây Bắc')

@section('content')

<style>
    /* =========================================================
       REGISTER - TINH HOA TÂY BẮC
    ========================================================= */

    .tb-register-page {
        --rg-brown: #633820;
        --rg-brown-dark: #2d1a11;
        --rg-green: #35562f;
        --rg-red: #b43e2e;
        --rg-gold: #e5ad42;
        --rg-cream: #fff8e9;
        --rg-border: #e7d4b7;
        --rg-text: #33261f;
        --rg-muted: #76685e;

        position: relative;
        isolation: isolate;

        width: 100%;

        padding: 42px 0 72px;
    }


    .tb-register-page::before {
        content: "";

        position: absolute;
        z-index: -2;

        inset: -30px -40px 0;

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


    .tb-register-shell {
        position: relative;

        width: min(1140px, 100%);

        margin: 0 auto;

        display: grid;

        grid-template-columns:
            minmax(0, .9fr)
            minmax(0, 1.1fr);

        overflow: hidden;

        border:
            1px solid
            rgba(222,195,158,.88);

        border-radius: 30px;

        background: #fff;

        box-shadow:
            0 32px 80px
            rgba(73,44,27,.14);
    }


    .tb-register-shell::before {
        content: "";

        position: absolute;

        z-index: 10;

        top: 0;
        left: 8%;
        right: 8%;

        height: 3px;

        border-radius: 999px;

        background:
            linear-gradient(
                90deg,
                transparent,
                var(--rg-gold),
                var(--rg-red),
                var(--rg-green),
                transparent
            );

        pointer-events: none;
    }


    /* =========================================================
       LEFT PANEL
    ========================================================= */

    .tb-register-brand {
        position: relative;

        overflow: hidden;

        min-height: 690px;

        display: flex;
        flex-direction: column;
        justify-content: space-between;

        padding: 52px 46px;

        color: #fff;

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


    .tb-register-brand::before {
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


    .tb-register-brand::after {
        content: "✦";

        position: absolute;

        top: 30px;
        right: 38px;

        color: #ffe291;

        font-size: 90px;

        opacity: .055;

        transform: rotate(18deg);
    }


    .tb-register-brand-top,
    .tb-register-benefits {
        position: relative;

        z-index: 2;
    }


    .tb-register-logo {
        width: 58px;
        height: 58px;

        display: grid;
        place-items: center;

        margin-bottom: 24px;

        border:
            1px solid
            rgba(255,255,255,.16);

        border-radius: 18px;

        color: #f5d47e;

        background:
            rgba(255,255,255,.08);

        box-shadow:
            inset 0 1px 0
            rgba(255,255,255,.12),
            0 12px 26px
            rgba(0,0,0,.14);

        font-size: 25px;
    }


    .tb-register-kicker {
        display: inline-flex;
        align-items: center;

        gap: 7px;

        margin-bottom: 18px;

        padding: 8px 12px;

        border:
            1px solid
            rgba(229,173,66,.34);

        border-radius: 999px;

        color: #f5d789;

        background:
            rgba(255,255,255,.06);

        font-size: 12px;

        font-weight: 900;

        letter-spacing: .08em;

        text-transform: uppercase;
    }


    .tb-register-brand h1 {
        max-width: 460px;

        margin: 0;

        color: #fff;

        font-size:
            clamp(
                38px,
                4vw,
                56px
            );

        line-height: 1.05;

        font-weight: 950;

        letter-spacing: -1.2px;
    }


    .tb-register-brand-copy {
        max-width: 470px;

        margin: 19px 0 0;

        color:
            rgba(255,255,255,.76);

        font-size: 15px;

        line-height: 1.75;
    }


    .tb-register-benefits {
        display: grid;

        gap: 11px;

        margin-top: 35px;
    }


    .tb-register-benefit {
        display: flex;
        align-items: center;

        gap: 11px;

        padding: 11px 13px;

        border:
            1px solid
            rgba(255,255,255,.09);

        border-radius: 14px;

        color:
            rgba(255,255,255,.84);

        background:
            rgba(255,255,255,.045);

        font-size: 14px;

        font-weight: 700;
    }


    .tb-register-benefit-icon {
        width: 36px;
        height: 36px;

        flex: 0 0 36px;

        display: grid;
        place-items: center;

        border-radius: 11px;

        background:
            rgba(255,255,255,.09);

        font-size: 17px;
    }


    /* =========================================================
       RIGHT FORM
    ========================================================= */

    .tb-register-form-panel {
        position: relative;

        display: flex;
        flex-direction: column;
        justify-content: center;

        padding: 50px 60px;

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


    .tb-register-form-panel::after {
        content: "";

        position: absolute;

        top: 25px;
        right: 27px;

        width: 90px;
        height: 90px;

        border:
            1px solid
            rgba(99,56,32,.06);

        border-left: 0;
        border-bottom: 0;

        border-radius:
            0 24px 0 0;

        pointer-events: none;
    }


    .tb-register-form-head {
        position: relative;

        z-index: 2;

        margin-bottom: 24px;
    }


    .tb-register-form-icon {
        width: 42px;
        height: 42px;

        display: grid;
        place-items: center;

        margin-bottom: 15px;

        border:
            1px solid
            #e8d1ad;

        border-radius: 13px;

        color: #7e4729;

        background:
            linear-gradient(
                135deg,
                #fff8e8,
                #f6e0b7
            );

        box-shadow:
            0 7px 15px
            rgba(99,56,32,.07);

        font-size: 18px;
    }


    .tb-register-form-head h2 {
        margin: 0;

        color: #30231c;

        font-size: 34px;

        line-height: 1.15;

        font-weight: 950;

        letter-spacing: -.7px;
    }


    .tb-register-form-head p {
        margin: 9px 0 0;

        max-width: 520px;

        color: var(--rg-muted);

        font-size: 14px;

        line-height: 1.65;
    }


    .tb-register-trust {
        display: flex;
        flex-wrap: wrap;

        gap: 8px;

        margin-bottom: 22px;
    }


    .tb-register-trust span {
        display: inline-flex;
        align-items: center;

        min-height: 34px;

        padding: 6px 11px;

        border:
            1px solid
            #e6dacb;

        border-radius: 999px;

        color: #655349;

        background: #fffdf9;

        font-size: 12px;

        font-weight: 750;
    }


    /* =========================================================
       FORM FIELD
    ========================================================= */

    .tb-register-field {
        margin-bottom: 16px;
    }


    .tb-register-label {
        display: block;

        margin-bottom: 8px;

        color: #4c3529;

        font-size: 14px;

        font-weight: 850;
    }


    .tb-register-input-wrap {
        position: relative;
    }


    .tb-register-input-icon {
        position: absolute;

        z-index: 2;

        top: 50%;
        left: 17px;

        transform:
            translateY(-50%);

        pointer-events: none;

        font-size: 17px;

        opacity: .7;
    }


    .tb-register-input {
        width: 100%;

        min-height: 53px;

        padding: 10px 48px;

        border:
            1px solid
            #dfcbae;

        border-radius: 15px;

        outline: none;

        color: #34261f;

        background:
            linear-gradient(
                180deg,
                #fffefb,
                #fffaf3
            );

        font-size: 14px;

        box-shadow:
            inset 0 1px 0
            rgba(255,255,255,.95);

        transition:
            border-color .18s ease,
            box-shadow .18s ease,
            background .18s ease;
    }


    .tb-register-input::placeholder {
        color: #a69990;
    }


    .tb-register-input:hover {
        border-color: #d8b98e;
    }


    .tb-register-input:focus {
        border-color: #cf9f5d;

        background: #fff;

        box-shadow:
            0 0 0 .22rem
            rgba(229,173,66,.13);
    }


    .tb-register-input.is-invalid {
        border-color: #c85a4b;
    }


    .tb-register-password {
        padding-right: 54px;
    }


    .tb-register-toggle {
        position: absolute;

        z-index: 3;

        top: 50%;
        right: 9px;

        transform:
            translateY(-50%);

        width: 38px;
        height: 38px;

        display: grid;
        place-items: center;

        padding: 0;

        border: 0;

        border-radius: 10px;

        color: #705a4c;

        background: transparent;

        cursor: pointer;

        font-size: 17px;
    }


    .tb-register-toggle:hover,
    .tb-register-toggle:focus {
        color: #4b2d1d;

        background: #f7eee2;

        outline: none;
    }


    .tb-register-error {
        margin-top: 7px;

        color: #b43e2e;

        font-size: 13px;

        font-weight: 700;
    }


    /* =========================================================
       PASSWORD STATUS
    ========================================================= */

    .tb-password-info {
        margin-top: 8px;

        color: #84756b;

        font-size: 12px;

        line-height: 1.5;
    }


    .tb-password-strength {
        display: grid;

        grid-template-columns:
            repeat(
                4,
                1fr
            );

        gap: 5px;

        margin-top: 9px;
    }


    .tb-password-strength span {
        height: 4px;

        border-radius: 999px;

        background: #eadfd3;

        transition: .18s ease;
    }


    .tb-password-strength.level-1 span:nth-child(1) {
        background: #b43e2e;
    }


    .tb-password-strength.level-2 span:nth-child(-n+2) {
        background: #d58a30;
    }


    .tb-password-strength.level-3 span:nth-child(-n+3) {
        background: #77914d;
    }


    .tb-password-strength.level-4 span {
        background: #35562f;
    }


    .tb-password-match {
        display: none;

        margin-top: 7px;

        font-size: 12px;

        font-weight: 750;
    }


    .tb-password-match.show {
        display: block;
    }


    .tb-password-match.ok {
        color: #35562f;
    }


    .tb-password-match.error {
        color: #b43e2e;
    }


    /* =========================================================
       OTP INFO
    ========================================================= */

    .tb-register-note {
        display: flex;

        align-items: flex-start;

        gap: 10px;

        margin-top: 4px;

        padding: 13px 14px;

        border:
            1px solid
            #ead09d;

        border-radius: 13px;

        color: #6a5333;

        background:
            linear-gradient(
                135deg,
                #fff9e6,
                #fff1ca
            );

        font-size: 13px;

        line-height: 1.55;
    }


    /* =========================================================
       SUBMIT
    ========================================================= */

    .tb-register-submit {
        position: relative;

        overflow: hidden;

        width: 100%;

        min-height: 56px;

        display: flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        margin-top: 20px;

        border: 0;

        border-radius: 16px;

        color: #fff;

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

        font-size: 15px;

        font-weight: 900;

        cursor: pointer;

        transition:
            transform .18s ease,
            box-shadow .18s ease;
    }


    .tb-register-submit::before {
        content: "";

        position: absolute;

        top: 0;
        left: -120%;

        width: 60%;
        height: 100%;

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


    .tb-register-submit:hover {
        transform:
            translateY(-2px);

        box-shadow:
            0 17px 34px
            rgba(99,56,32,.25);
    }


    .tb-register-submit:hover::before {
        left: 145%;
    }


    /* =========================================================
       BOTTOM
    ========================================================= */

    .tb-register-separator {
        display: flex;
        align-items: center;

        gap: 13px;

        margin: 25px 0 19px;

        color: #9a8a80;

        font-size: 12px;

        font-weight: 800;

        letter-spacing: .04em;
    }


    .tb-register-separator::before,
    .tb-register-separator::after {
        content: "";

        flex: 1;

        height: 1px;

        background: #ead8bf;
    }


    .tb-register-login-box {
        padding: 15px 17px;

        border:
            1px solid
            #e6d2b2;

        border-radius: 14px;

        color: #6d594d;

        background:
            linear-gradient(
                135deg,
                #fffaf1,
                #fff4e2
            );

        text-align: center;

        font-size: 14px;
    }


    .tb-register-link {
        color: var(--rg-red);

        font-weight: 850;

        text-decoration: none;
    }


    .tb-register-link:hover {
        color: var(--rg-brown);

        text-decoration: underline;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .tb-register-page {
            padding:
                30px 0 60px;
        }


        .tb-register-shell {
            max-width: 680px;

            grid-template-columns: 1fr;
        }


        .tb-register-brand {
            min-height: auto;

            padding: 38px 34px;
        }


        .tb-register-brand h1 {
            max-width: 540px;

            font-size: 40px;
        }


        .tb-register-benefits {
            grid-template-columns:
                repeat(
                    3,
                    minmax(0,1fr)
                );

            margin-top: 28px;
        }


        .tb-register-benefit {
            align-items: flex-start;

            flex-direction: column;

            font-size: 13px;
        }


        .tb-register-form-panel {
            padding: 44px 38px;
        }

    }


    @media (max-width: 575.98px) {

        .tb-register-page {
            padding:
                18px 0 42px;
        }


        .tb-register-shell {
            border-radius: 22px;
        }


        .tb-register-brand {
            padding: 29px 23px;
        }


        .tb-register-logo {
            width: 50px;
            height: 50px;

            margin-bottom: 18px;

            border-radius: 15px;
        }


        .tb-register-brand h1 {
            font-size: 34px;
        }


        .tb-register-brand-copy {
            font-size: 14px;
        }


        .tb-register-benefits {
            grid-template-columns: 1fr;

            gap: 8px;

            margin-top: 24px;
        }


        .tb-register-benefit {
            flex-direction: row;

            align-items: center;
        }


        .tb-register-form-panel {
            padding: 32px 22px;
        }


        .tb-register-form-panel::after {
            display: none;
        }


        .tb-register-form-head h2 {
            font-size: 29px;
        }


        .tb-register-trust {
            display: grid;

            grid-template-columns: 1fr;
        }


        .tb-register-trust span {
            justify-content: center;
        }


        .tb-register-input {
            min-height: 52px;
        }

    }


    @media (prefers-reduced-motion: reduce) {

        .tb-register-page *,
        .tb-register-page *::before,
        .tb-register-page *::after {
            transition: none !important;
        }

    }
</style>


<div class="tb-register-page">

    <div class="tb-register-shell">


        {{-- =====================================================
            BRAND
        ====================================================== --}}
        <aside class="tb-register-brand">

            <div class="tb-register-brand-top">

                <div class="tb-register-logo">
                    🌿
                </div>


                <div class="tb-register-kicker">
                    Tinh Hoa Tây Bắc
                </div>


                <h1>
                    Bắt đầu hành trình
                    khám phá Tây Bắc.
                </h1>


                <p class="tb-register-brand-copy">

                    Tạo tài khoản để mua sắm thuận tiện,
                    lưu địa chỉ giao hàng,
                    theo dõi đơn mua
                    và nhận những ưu đãi dành cho thành viên.

                </p>

            </div>


            <div class="tb-register-benefits">

                <div class="tb-register-benefit">

                    <span class="tb-register-benefit-icon">
                        ✉️
                    </span>

                    <span>
                        Xác thực tài khoản bằng OTP email
                    </span>

                </div>


                <div class="tb-register-benefit">

                    <span class="tb-register-benefit-icon">
                        📍
                    </span>

                    <span>
                        Lưu nhiều địa chỉ giao hàng
                    </span>

                </div>


                <div class="tb-register-benefit">

                    <span class="tb-register-benefit-icon">
                        🎁
                    </span>

                    <span>
                        Nhận voucher và ưu đãi thành viên
                    </span>

                </div>

            </div>

        </aside>


        {{-- =====================================================
            FORM
        ====================================================== --}}
        <section class="tb-register-form-panel">


            <div class="tb-register-form-head">

                <div class="tb-register-form-icon">
                    ✨
                </div>


                <h2>
                    Tạo tài khoản
                </h2>


                <p>
                    Điền thông tin bên dưới.
                    Sau khi đăng ký thành công,
                    hệ thống sẽ gửi mã OTP
                    tới email của bạn.
                </p>

            </div>


            <div class="tb-register-trust">

                <span>
                    ✓ Đăng ký nhanh
                </span>

                <span>
                    ✉️ OTP qua email
                </span>

                <span>
                    🔒 Bảo mật tài khoản
                </span>

            </div>


            <form
                method="POST"
                action="{{ route('register') }}"
                id="registerForm"
            >

                @csrf


                {{-- NAME --}}
                <div class="tb-register-field">

                    <label
                        for="name"
                        class="tb-register-label"
                    >
                        Họ và tên
                    </label>


                    <div class="tb-register-input-wrap">

                        <span class="tb-register-input-icon">
                            👤
                        </span>


                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="
                                tb-register-input
                                @error('name')
                                    is-invalid
                                @enderror
                            "
                            placeholder="Nhập họ và tên"
                            autocomplete="name"
                            required
                            autofocus
                        >

                    </div>


                    @error('name')

                        <div class="tb-register-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- EMAIL --}}
                <div class="tb-register-field">

                    <label
                        for="email"
                        class="tb-register-label"
                    >
                        Email
                    </label>


                    <div class="tb-register-input-wrap">

                        <span class="tb-register-input-icon">
                            ✉️
                        </span>


                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="
                                tb-register-input
                                @error('email')
                                    is-invalid
                                @enderror
                            "
                            placeholder="example@gmail.com"
                            autocomplete="email"
                            required
                        >

                    </div>


                    @error('email')

                        <div class="tb-register-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- PASSWORD --}}
                <div class="tb-register-field">

                    <label
                        for="password"
                        class="tb-register-label"
                    >
                        Mật khẩu
                    </label>


                    <div class="tb-register-input-wrap">

                        <span class="tb-register-input-icon">
                            🔐
                        </span>


                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="
                                tb-register-input
                                tb-register-password
                                @error('password')
                                    is-invalid
                                @enderror
                            "
                            placeholder="Tối thiểu 8 ký tự"
                            autocomplete="new-password"
                            required
                        >


                        <button
                            type="button"
                            class="tb-register-toggle"
                            data-toggle-password="password"
                            aria-label="Hiện mật khẩu"
                            title="Hiện mật khẩu"
                        >
                            👁
                        </button>

                    </div>


                    <div class="tb-password-info">
                        Nên sử dụng chữ hoa, chữ thường,
                        số và ký tự đặc biệt.
                    </div>


                    <div
                        class="tb-password-strength"
                        id="passwordStrength"
                    >
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>


                    @error('password')

                        <div class="tb-register-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- CONFIRM PASSWORD --}}
                <div class="tb-register-field">

                    <label
                        for="password_confirmation"
                        class="tb-register-label"
                    >
                        Xác nhận mật khẩu
                    </label>


                    <div class="tb-register-input-wrap">

                        <span class="tb-register-input-icon">
                            🛡️
                        </span>


                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="
                                tb-register-input
                                tb-register-password
                            "
                            placeholder="Nhập lại mật khẩu"
                            autocomplete="new-password"
                            required
                        >


                        <button
                            type="button"
                            class="tb-register-toggle"
                            data-toggle-password="password_confirmation"
                            aria-label="Hiện mật khẩu"
                            title="Hiện mật khẩu"
                        >
                            👁
                        </button>

                    </div>


                    <div
                        class="tb-password-match"
                        id="passwordMatch"
                    >
                    </div>

                </div>


                {{-- OTP NOTE --}}
                <div class="tb-register-note">

                    <span>
                        ✉️
                    </span>

                    <span>
                        Sau khi tạo tài khoản,
                        một mã OTP 6 số sẽ được gửi
                        tới email trên để xác thực tài khoản.
                    </span>

                </div>


                {{-- SUBMIT --}}
                <button
                    type="submit"
                    class="tb-register-submit"
                >
                    <span>
                        ✨
                    </span>

                    <span>
                        Tạo tài khoản
                    </span>
                </button>

            </form>


            <div class="tb-register-separator">
                ĐÃ CÓ TÀI KHOẢN?
            </div>


            <div class="tb-register-login-box">

                <a
                    href="{{ route('login') }}"
                    class="tb-register-link"
                >
                    ← Quay lại đăng nhập
                </a>

            </div>

        </section>

    </div>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        /* =============================================
           SHOW / HIDE PASSWORD
        ============================================= */

        const toggles =
            document.querySelectorAll(
                '[data-toggle-password]'
            );


        toggles.forEach(
            function (button) {

                button.addEventListener(
                    'click',
                    function () {

                        const targetId =
                            button.dataset
                                .togglePassword;


                        const input =
                            document.getElementById(
                                targetId
                            );


                        if (!input) {
                            return;
                        }


                        const isHidden =
                            input.type
                            ===
                            'password';


                        input.type =
                            isHidden
                            ? 'text'
                            : 'password';


                        button.textContent =
                            isHidden
                            ? '🙈'
                            : '👁';


                        button.setAttribute(
                            'aria-label',
                            isHidden
                            ? 'Ẩn mật khẩu'
                            : 'Hiện mật khẩu'
                        );


                        button.setAttribute(
                            'title',
                            isHidden
                            ? 'Ẩn mật khẩu'
                            : 'Hiện mật khẩu'
                        );

                    }
                );

            }
        );


        /* =============================================
           PASSWORD STRENGTH
        ============================================= */

        const password =
            document.getElementById(
                'password'
            );


        const confirmation =
            document.getElementById(
                'password_confirmation'
            );


        const strength =
            document.getElementById(
                'passwordStrength'
            );


        const match =
            document.getElementById(
                'passwordMatch'
            );


        function updateStrength() {

            if (
                !password
                ||
                !strength
            ) {
                return;
            }


            const value =
                password.value;


            let score = 0;


            if (value.length >= 8) {
                score++;
            }


            if (
                /[A-Z]/.test(value)
                &&
                /[a-z]/.test(value)
            ) {
                score++;
            }


            if (/\d/.test(value)) {
                score++;
            }


            if (
                /[^A-Za-z0-9]/.test(
                    value
                )
            ) {
                score++;
            }


            strength.className =
                'tb-password-strength';


            if (score > 0) {

                strength.classList.add(
                    'level-' + score
                );

            }

        }


        function updateMatch() {

            if (
                !password
                ||
                !confirmation
                ||
                !match
            ) {
                return;
            }


            if (
                confirmation.value
                ===
                ''
            ) {

                match.className =
                    'tb-password-match';

                match.textContent =
                    '';

                return;

            }


            if (
                password.value
                ===
                confirmation.value
            ) {

                match.className =
                    'tb-password-match show ok';

                match.textContent =
                    '✓ Mật khẩu xác nhận trùng khớp.';

            } else {

                match.className =
                    'tb-password-match show error';

                match.textContent =
                    '✕ Mật khẩu xác nhận chưa trùng khớp.';

            }

        }


        if (password) {

            password.addEventListener(
                'input',
                function () {

                    updateStrength();
                    updateMatch();

                }
            );

        }


        if (confirmation) {

            confirmation.addEventListener(
                'input',
                updateMatch
            );

        }

    }
);
</script>

@endsection