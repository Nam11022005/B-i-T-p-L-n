@extends('layouts.app')

@section('title', 'Quên mật khẩu | Tinh Hoa Tây Bắc')

@section('content')

<style>
    /* =========================================================
       FORGOT PASSWORD - TINH HOA TÂY BẮC
    ========================================================= */

    .tb-forgot-page {
        --fp-brown: #633820;
        --fp-brown-dark: #2d1a11;
        --fp-green: #35562f;
        --fp-red: #b43e2e;
        --fp-gold: #e5ad42;
        --fp-cream: #fff8e9;
        --fp-border: #e7d4b7;
        --fp-text: #33261f;
        --fp-muted: #76685e;

        position: relative;
        isolation: isolate;

        width: 100%;

        padding: 42px 0 72px;
    }


    .tb-forgot-page::before {
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


    .tb-forgot-shell {
        position: relative;

        width: min(1100px, 100%);

        margin: 0 auto;

        display: grid;

        grid-template-columns:
            minmax(0, .92fr)
            minmax(0, 1.08fr);

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


    .tb-forgot-shell::before {
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
                var(--fp-gold),
                var(--fp-red),
                var(--fp-green),
                transparent
            );

        pointer-events: none;
    }


    /* =========================================================
       LEFT PANEL
    ========================================================= */

    .tb-forgot-brand {
        position: relative;

        overflow: hidden;

        min-height: 620px;

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


    .tb-forgot-brand::before {
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


    .tb-forgot-brand::after {
        content: "🔐";

        position: absolute;

        top: 28px;
        right: 36px;

        font-size: 92px;

        opacity: .055;

        transform: rotate(-12deg);
    }


    .tb-forgot-brand-top,
    .tb-forgot-steps {
        position: relative;
        z-index: 2;
    }


    .tb-forgot-logo {
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


    .tb-forgot-kicker {
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


    .tb-forgot-brand h1 {
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


    .tb-forgot-brand-copy {
        max-width: 470px;

        margin: 19px 0 0;

        color:
            rgba(255,255,255,.76);

        font-size: 15px;

        line-height: 1.75;
    }


    /* =========================================================
       STEPS
    ========================================================= */

    .tb-forgot-steps {
        display: grid;

        gap: 10px;

        margin-top: 34px;
    }


    .tb-forgot-step {
        display: flex;
        align-items: center;

        gap: 11px;

        padding: 11px 13px;

        border:
            1px solid
            rgba(255,255,255,.08);

        border-radius: 14px;

        color:
            rgba(255,255,255,.72);

        background:
            rgba(255,255,255,.04);

        font-size: 14px;

        font-weight: 700;
    }


    .tb-forgot-step.active {
        color: #fff;

        border-color:
            rgba(229,173,66,.26);

        background:
            rgba(229,173,66,.10);
    }


    .tb-forgot-step-number {
        width: 36px;
        height: 36px;

        flex: 0 0 36px;

        display: grid;
        place-items: center;

        border:
            1px solid
            rgba(255,255,255,.10);

        border-radius: 11px;

        color: #f3d37d;

        background:
            rgba(255,255,255,.08);

        font-weight: 950;
    }


    .tb-forgot-step.active
    .tb-forgot-step-number {
        color: #432a18;

        background:
            linear-gradient(
                135deg,
                #f6d77f,
                #e5ad42
            );
    }


    /* =========================================================
       RIGHT PANEL
    ========================================================= */

    .tb-forgot-panel {
        position: relative;

        display: flex;
        flex-direction: column;
        justify-content: center;

        padding: 56px 62px;

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


    .tb-forgot-panel::after {
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


    .tb-forgot-icon {
        width: 82px;
        height: 82px;

        display: grid;
        place-items: center;

        margin-bottom: 22px;

        border:
            1px solid
            #e4c78f;

        border-radius: 25px;

        background:
            radial-gradient(
                circle at 30% 24%,
                rgba(255,255,255,.95),
                transparent 31%
            ),
            linear-gradient(
                135deg,
                #fff1c8,
                #efd28e
            );

        box-shadow:
            0 14px 30px
            rgba(99,56,32,.10),
            inset 0 1px 0
            rgba(255,255,255,.95);

        font-size: 37px;
    }


    .tb-forgot-head {
        margin-bottom: 25px;
    }


    .tb-forgot-head h2 {
        margin: 0;

        color: #30231c;

        font-size: 34px;

        line-height: 1.15;

        font-weight: 950;

        letter-spacing: -.7px;
    }


    .tb-forgot-head p {
        margin: 10px 0 0;

        max-width: 520px;

        color: var(--fp-muted);

        font-size: 14px;

        line-height: 1.68;
    }


    /* =========================================================
       ALERT
    ========================================================= */

    .tb-forgot-alert {
        display: flex;
        align-items: flex-start;

        gap: 10px;

        margin-bottom: 18px;

        padding: 13px 15px;

        border-radius: 13px;

        font-size: 13px;

        line-height: 1.55;
    }


    .tb-forgot-alert.success {
        border:
            1px solid
            #bed7b5;

        color: #405b37;

        background: #f2f8ef;
    }


    .tb-forgot-alert.error {
        border:
            1px solid
            #e2b7af;

        color: #8e3428;

        background: #fff4f1;
    }


    /* =========================================================
       FORM
    ========================================================= */

    .tb-forgot-field {
        margin-bottom: 18px;
    }


    .tb-forgot-label {
        display: block;

        margin-bottom: 8px;

        color: #4c3529;

        font-size: 14px;

        font-weight: 850;
    }


    .tb-forgot-input-wrap {
        position: relative;
    }


    .tb-forgot-input-icon {
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


    .tb-forgot-input {
        width: 100%;

        min-height: 54px;

        padding: 10px 16px 10px 48px;

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


    .tb-forgot-input::placeholder {
        color: #a69990;
    }


    .tb-forgot-input:hover {
        border-color: #d8b98e;
    }


    .tb-forgot-input:focus {
        border-color: #cf9f5d;

        background: #fff;

        box-shadow:
            0 0 0 .22rem
            rgba(229,173,66,.13);
    }


    .tb-forgot-input.is-invalid {
        border-color: #c85a4b;
    }


    .tb-forgot-error {
        margin-top: 7px;

        color: #b43e2e;

        font-size: 13px;

        font-weight: 700;
    }


    .tb-forgot-email-help {
        margin-top: 8px;

        color: #908078;

        font-size: 12px;

        line-height: 1.5;
    }


    /* =========================================================
       INFO NOTE
    ========================================================= */

    .tb-forgot-note {
        display: flex;
        align-items: flex-start;

        gap: 10px;

        margin-bottom: 20px;

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

    .tb-forgot-submit {
        position: relative;

        overflow: hidden;

        width: 100%;

        min-height: 56px;

        display: flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

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


    .tb-forgot-submit::before {
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

        transition: left .45s ease;
    }


    .tb-forgot-submit:hover {
        transform:
            translateY(-2px);

        box-shadow:
            0 17px 34px
            rgba(99,56,32,.25);
    }


    .tb-forgot-submit:hover::before {
        left: 145%;
    }


    .tb-forgot-submit:disabled {
        cursor: wait;

        opacity: .78;

        transform: none;
    }


    /* =========================================================
       BACK LOGIN
    ========================================================= */

    .tb-forgot-separator {
        display: flex;
        align-items: center;

        gap: 13px;

        margin:
            27px 0 19px;

        color: #9a8a80;

        font-size: 12px;

        font-weight: 800;
    }


    .tb-forgot-separator::before,
    .tb-forgot-separator::after {
        content: "";

        flex: 1;

        height: 1px;

        background: #ead8bf;
    }


    .tb-forgot-back {
        display: flex;
        align-items: center;
        justify-content: center;

        min-height: 50px;

        padding: 10px 16px;

        border:
            1px solid
            #e6d2b2;

        border-radius: 14px;

        color: var(--fp-red);

        background:
            linear-gradient(
                135deg,
                #fffaf1,
                #fff4e2
            );

        font-size: 14px;

        font-weight: 850;

        text-decoration: none;

        transition:
            transform .16s ease,
            border-color .16s ease;
    }


    .tb-forgot-back:hover {
        transform:
            translateY(-1px);

        border-color: #d8b98e;

        color: var(--fp-brown);
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .tb-forgot-page {
            padding:
                30px 0 60px;
        }


        .tb-forgot-shell {
            max-width: 680px;

            grid-template-columns: 1fr;
        }


        .tb-forgot-brand {
            min-height: auto;

            padding: 38px 34px;
        }


        .tb-forgot-brand h1 {
            max-width: 540px;

            font-size: 40px;
        }


        .tb-forgot-steps {
            grid-template-columns:
                repeat(
                    3,
                    minmax(0, 1fr)
                );

            margin-top: 28px;
        }


        .tb-forgot-step {
            align-items: flex-start;

            flex-direction: column;

            font-size: 13px;
        }


        .tb-forgot-panel {
            padding: 44px 38px;
        }

    }


    @media (max-width: 575.98px) {

        .tb-forgot-page {
            padding:
                18px 0 42px;
        }


        .tb-forgot-shell {
            border-radius: 22px;
        }


        .tb-forgot-brand {
            padding: 29px 23px;
        }


        .tb-forgot-logo {
            width: 50px;
            height: 50px;

            margin-bottom: 18px;

            border-radius: 15px;
        }


        .tb-forgot-brand h1 {
            font-size: 34px;
        }


        .tb-forgot-brand-copy {
            font-size: 14px;
        }


        .tb-forgot-steps {
            grid-template-columns: 1fr;

            gap: 8px;

            margin-top: 24px;
        }


        .tb-forgot-step {
            align-items: center;

            flex-direction: row;
        }


        .tb-forgot-panel {
            padding: 32px 22px;
        }


        .tb-forgot-panel::after {
            display: none;
        }


        .tb-forgot-icon {
            width: 72px;
            height: 72px;

            border-radius: 21px;

            font-size: 32px;
        }


        .tb-forgot-head h2 {
            font-size: 29px;
        }


        .tb-forgot-input {
            min-height: 52px;
        }

    }


    @media (prefers-reduced-motion: reduce) {

        .tb-forgot-page *,
        .tb-forgot-page *::before,
        .tb-forgot-page *::after {
            transition: none !important;
        }

    }
</style>


<div class="tb-forgot-page">

    <div class="tb-forgot-shell">


        {{-- =====================================================
            LEFT PANEL
        ====================================================== --}}
        <aside class="tb-forgot-brand">

            <div class="tb-forgot-brand-top">

                <div class="tb-forgot-logo">
                    🔐
                </div>


                <div class="tb-forgot-kicker">
                    Khôi phục tài khoản
                </div>


                <h1>
                    Lấy lại mật khẩu
                    an toàn bằng OTP.
                </h1>


                <p class="tb-forgot-brand-copy">

                    Nhập email tài khoản của bạn.
                    Hệ thống sẽ gửi mã OTP xác thực
                    để tiếp tục quá trình
                    đặt lại mật khẩu.

                </p>

            </div>


            <div class="tb-forgot-steps">

                <div class="tb-forgot-step active">

                    <span class="tb-forgot-step-number">
                        1
                    </span>

                    <span>
                        Nhập email tài khoản
                    </span>

                </div>


                <div class="tb-forgot-step">

                    <span class="tb-forgot-step-number">
                        2
                    </span>

                    <span>
                        Xác nhận mã OTP
                    </span>

                </div>


                <div class="tb-forgot-step">

                    <span class="tb-forgot-step-number">
                        3
                    </span>

                    <span>
                        Tạo mật khẩu mới
                    </span>

                </div>

            </div>

        </aside>


        {{-- =====================================================
            RIGHT PANEL
        ====================================================== --}}
        <section class="tb-forgot-panel">


            <div class="tb-forgot-icon">
                ✉️
            </div>


            <div class="tb-forgot-head">

                <h2>
                    Quên mật khẩu?
                </h2>


                <p>
                    Nhập email đã đăng ký
                    với Tinh Hoa Tây Bắc.
                    Mã OTP khôi phục tài khoản
                    sẽ được gửi đến hộp thư đó.
                </p>

            </div>


            {{-- SUCCESS --}}
            @if(session('success'))

                <div class="tb-forgot-alert success">

                    <span>
                        ✅
                    </span>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            {{-- ERROR --}}
            @if(session('error'))

                <div class="tb-forgot-alert error">

                    <span>
                        ❌
                    </span>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('password.email') }}"
                id="forgotPasswordForm"
            >

                @csrf


                <div class="tb-forgot-field">

                    <label
                        for="email"
                        class="tb-forgot-label"
                    >
                        Email tài khoản
                    </label>


                    <div class="tb-forgot-input-wrap">

                        <span class="tb-forgot-input-icon">
                            ✉️
                        </span>


                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="
                                tb-forgot-input
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

                        <div class="tb-forgot-error">
                            {{ $message }}
                        </div>

                    @enderror


                    <div class="tb-forgot-email-help">
                        Hãy nhập đúng email
                        bạn đã dùng khi đăng ký tài khoản.
                    </div>

                </div>


                <div class="tb-forgot-note">

                    <span>
                        🛡️
                    </span>

                    <span>
                        Mã OTP chỉ được sử dụng
                        cho quá trình khôi phục mật khẩu
                        của tài khoản này.
                    </span>

                </div>


                <button
                    type="submit"
                    class="tb-forgot-submit"
                    id="forgotPasswordSubmit"
                >
                    <span>
                        ✉️
                    </span>

                    <span>
                        Gửi mã OTP
                    </span>
                </button>

            </form>


            <div class="tb-forgot-separator">
                ĐÃ NHỚ MẬT KHẨU?
            </div>


            <a
                href="{{ route('login') }}"
                class="tb-forgot-back"
            >
                ← Quay lại đăng nhập
            </a>

        </section>

    </div>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        const form =
            document.getElementById(
                'forgotPasswordForm'
            );


        const submitButton =
            document.getElementById(
                'forgotPasswordSubmit'
            );


        if (
            !form
            ||
            !submitButton
        ) {
            return;
        }


        form.addEventListener(
            'submit',
            function () {

                submitButton.disabled =
                    true;


                submitButton.innerHTML =
                    '<span>⏳</span>'
                    +
                    '<span>Đang gửi mã OTP...</span>';

            }
        );

    }
);
</script>

@endsection