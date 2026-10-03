@extends('layouts.app')

@section('title', 'Xác thực email | Tinh Hoa Tây Bắc')

@section('content')

<style>
    /* =========================================================
       EMAIL OTP VERIFY - TINH HOA TÂY BẮC
    ========================================================= */

    .tb-verify-page {
        --verify-brown: #633820;
        --verify-brown-dark: #2d1a11;
        --verify-green: #35562f;
        --verify-red: #b43e2e;
        --verify-gold: #e5ad42;
        --verify-cream: #fff8e9;
        --verify-border: #e7d4b7;
        --verify-text: #33261f;
        --verify-muted: #76685e;

        position: relative;
        isolation: isolate;

        width: 100%;

        padding: 42px 0 72px;
    }


    .tb-verify-page::before {
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


    .tb-verify-shell {
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


    .tb-verify-shell::before {
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
                var(--verify-gold),
                var(--verify-red),
                var(--verify-green),
                transparent
            );

        pointer-events: none;
    }


    /* =========================================================
       LEFT
    ========================================================= */

    .tb-verify-brand {
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


    .tb-verify-brand::before {
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


    .tb-verify-brand::after {
        content: "✦";

        position: absolute;

        top: 30px;
        right: 38px;

        color: #ffe291;

        font-size: 90px;

        opacity: .055;

        transform: rotate(18deg);
    }


    .tb-verify-brand-top,
    .tb-verify-benefits {
        position: relative;

        z-index: 2;
    }


    .tb-verify-logo {
        width: 58px;
        height: 58px;

        display: grid;
        place-items: center;

        margin-bottom: 24px;

        border:
            1px solid
            rgba(255,255,255,.16);

        border-radius: 18px;

        background:
            rgba(255,255,255,.08);

        box-shadow:
            inset 0 1px 0
            rgba(255,255,255,.12),
            0 12px 26px
            rgba(0,0,0,.14);

        font-size: 25px;
    }


    .tb-verify-kicker {
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


    .tb-verify-brand h1 {
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


    .tb-verify-brand-copy {
        max-width: 470px;

        margin: 19px 0 0;

        color:
            rgba(255,255,255,.76);

        font-size: 15px;

        line-height: 1.75;
    }


    .tb-verify-benefits {
        display: grid;

        gap: 11px;

        margin-top: 34px;
    }


    .tb-verify-benefit {
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


    .tb-verify-benefit-icon {
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
       RIGHT PANEL
    ========================================================= */

    .tb-verify-form-panel {
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


    .tb-verify-form-panel::after {
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


    .tb-verify-mail-icon {
        width: 96px;
        height: 96px;

        display: grid;
        place-items: center;

        margin:
            0 auto 22px;

        border:
            1px solid
            #e4c78f;

        border-radius: 28px;

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
            0 16px 34px
            rgba(99,56,32,.11),
            inset 0 1px 0
            rgba(255,255,255,.95);

        font-size: 44px;
    }


    .tb-verify-head {
        text-align: center;

        margin-bottom: 22px;
    }


    .tb-verify-head h2 {
        margin: 0;

        color: #30231c;

        font-size: 34px;

        line-height: 1.15;

        font-weight: 950;

        letter-spacing: -.7px;
    }


    .tb-verify-head p {
        margin:
            10px 0 13px;

        color: var(--verify-muted);

        font-size: 14px;

        line-height: 1.65;
    }


    .tb-verify-email {
        display: inline-flex;
        align-items: center;

        max-width: 100%;

        gap: 7px;

        padding: 8px 14px;

        border:
            1px solid
            #e2c791;

        border-radius: 999px;

        color: #633820;

        background:
            linear-gradient(
                180deg,
                #fffaf0,
                #fff2d9
            );

        font-size: 13px;

        font-weight: 850;

        overflow-wrap: anywhere;
    }


    .tb-verify-badges {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;

        gap: 8px;

        margin-bottom: 23px;
    }


    .tb-verify-badges span {
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
       OTP INPUT
    ========================================================= */

    .tb-verify-label {
        display: block;

        margin-bottom: 8px;

        color: #4c3529;

        font-size: 14px;

        font-weight: 850;
    }


    .tb-verify-otp {
        width: 100%;

        height: 72px;

        padding:
            0 18px;

        border:
            1px solid
            #dfcbae;

        border-radius: 18px;

        outline: none;

        color: #422b20;

        background:
            linear-gradient(
                180deg,
                #fffefb,
                #fff8ed
            );

        text-align: center;

        font-size: 29px;

        font-weight: 950;

        letter-spacing: .48em;

        text-indent: .48em;

        font-variant-numeric:
            tabular-nums;

        box-shadow:
            inset 0 1px 0
            rgba(255,255,255,.95),
            0 8px 20px
            rgba(99,56,32,.05);

        transition:
            border-color .18s ease,
            box-shadow .18s ease,
            background .18s ease;
    }


    .tb-verify-otp:hover {
        border-color: #d8b98e;
    }


    .tb-verify-otp:focus {
        border-color: #cf9f5d;

        background: #fff;

        box-shadow:
            0 0 0 .22rem
            rgba(229,173,66,.13),
            0 9px 22px
            rgba(99,56,32,.06);
    }


    .tb-verify-otp.is-invalid {
        border-color: #c85a4b;
    }


    .tb-verify-error {
        margin-top: 7px;

        color: #b43e2e;

        font-size: 13px;

        font-weight: 700;

        text-align: left;
    }


    .tb-verify-input-help {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 10px;

        margin-top: 8px;

        color: #918178;

        font-size: 12px;
    }


    .tb-verify-input-help strong {
        color: #6e5a4d;
    }


    /* =========================================================
       VERIFY BUTTON
    ========================================================= */

    .tb-verify-submit {
        position: relative;

        overflow: hidden;

        width: 100%;

        min-height: 56px;

        display: flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        margin-top: 21px;

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


    .tb-verify-submit::before {
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


    .tb-verify-submit:hover {
        transform:
            translateY(-2px);

        box-shadow:
            0 17px 34px
            rgba(99,56,32,.25);
    }


    .tb-verify-submit:hover::before {
        left: 145%;
    }


    /* =========================================================
       RESEND
    ========================================================= */

    .tb-verify-separator {
        display: flex;
        align-items: center;

        gap: 13px;

        margin:
            27px 0 19px;

        color: #9a8a80;

        font-size: 12px;

        font-weight: 800;

        letter-spacing: .04em;
    }


    .tb-verify-separator::before,
    .tb-verify-separator::after {
        content: "";

        flex: 1;

        height: 1px;

        background: #ead8bf;
    }


    .tb-verify-resend {
        width: 100%;

        min-height: 50px;

        border:
            1px solid
            #d9c19f;

        border-radius: 14px;

        color: #633820;

        background:
            linear-gradient(
                180deg,
                #fff,
                #fff9ef
            );

        font-size: 14px;

        font-weight: 850;

        cursor: pointer;

        transition:
            transform .16s ease,
            box-shadow .16s ease,
            border-color .16s ease;
    }


    .tb-verify-resend:hover {
        transform:
            translateY(-1px);

        border-color: #cda873;

        box-shadow:
            0 8px 18px
            rgba(99,56,32,.07);
    }


    .tb-verify-note {
        display: flex;
        align-items: flex-start;

        gap: 10px;

        margin-top: 17px;

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
       PROGRESS
    ========================================================= */

    .tb-verify-progress {
        display: grid;

        grid-template-columns:
            repeat(3,1fr);

        gap: 8px;

        margin-bottom: 25px;
    }


    .tb-verify-step {
        text-align: center;
    }


    .tb-verify-step-line {
        height: 4px;

        margin-bottom: 6px;

        border-radius: 999px;

        background: #e8ddd0;
    }


    .tb-verify-step.done
    .tb-verify-step-line {
        background: #79965e;
    }


    .tb-verify-step.active
    .tb-verify-step-line {
        background:
            linear-gradient(
                90deg,
                #e5ad42,
                #b43e2e
            );
    }


    .tb-verify-step span {
        color: #998a80;

        font-size: 11px;

        font-weight: 750;
    }


    .tb-verify-step.done span,
    .tb-verify-step.active span {
        color: #654939;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 991.98px) {

        .tb-verify-page {
            padding:
                30px 0 60px;
        }


        .tb-verify-shell {
            max-width: 680px;

            grid-template-columns: 1fr;
        }


        .tb-verify-brand {
            min-height: auto;

            padding: 38px 34px;
        }


        .tb-verify-brand h1 {
            max-width: 540px;

            font-size: 40px;
        }


        .tb-verify-benefits {
            grid-template-columns:
                repeat(
                    3,
                    minmax(0,1fr)
                );

            margin-top: 28px;
        }


        .tb-verify-benefit {
            align-items: flex-start;

            flex-direction: column;

            font-size: 13px;
        }


        .tb-verify-form-panel {
            padding: 44px 38px;
        }

    }


    @media (max-width: 575.98px) {

        .tb-verify-page {
            padding:
                18px 0 42px;
        }


        .tb-verify-shell {
            border-radius: 22px;
        }


        .tb-verify-brand {
            padding: 29px 23px;
        }


        .tb-verify-logo {
            width: 50px;
            height: 50px;

            margin-bottom: 18px;

            border-radius: 15px;
        }


        .tb-verify-brand h1 {
            font-size: 34px;
        }


        .tb-verify-brand-copy {
            font-size: 14px;
        }


        .tb-verify-benefits {
            grid-template-columns: 1fr;

            gap: 8px;

            margin-top: 24px;
        }


        .tb-verify-benefit {
            flex-direction: row;

            align-items: center;
        }


        .tb-verify-form-panel {
            padding: 32px 22px;
        }


        .tb-verify-form-panel::after {
            display: none;
        }


        .tb-verify-mail-icon {
            width: 82px;
            height: 82px;

            border-radius: 24px;

            font-size: 38px;
        }


        .tb-verify-head h2 {
            font-size: 29px;
        }


        .tb-verify-badges {
            display: grid;

            grid-template-columns: 1fr;
        }


        .tb-verify-badges span {
            justify-content: center;
        }


        .tb-verify-otp {
            height: 66px;

            padding: 0 8px;

            font-size: 25px;

            letter-spacing: .35em;

            text-indent: .35em;
        }

    }


    @media (prefers-reduced-motion: reduce) {

        .tb-verify-page *,
        .tb-verify-page *::before,
        .tb-verify-page *::after {
            transition: none !important;
        }

    }
</style>


<div class="tb-verify-page">

    <div class="tb-verify-shell">


        {{-- =====================================================
            LEFT
        ====================================================== --}}
        <aside class="tb-verify-brand">

            <div class="tb-verify-brand-top">

                <div class="tb-verify-logo">
                    🔒
                </div>


                <div class="tb-verify-kicker">
                    Bảo mật tài khoản
                </div>


                <h1>
                    Xác thực email
                    để bảo vệ tài khoản.
                </h1>


                <p class="tb-verify-brand-copy">

                    Mã OTP gồm 6 chữ số
                    đã được gửi đến email đăng ký.
                    Hoàn tất bước này để sử dụng
                    đầy đủ các chức năng mua sắm
                    trên Tinh Hoa Tây Bắc.

                </p>

            </div>


            <div class="tb-verify-benefits">

                <div class="tb-verify-benefit">

                    <span class="tb-verify-benefit-icon">
                        ✉
                    </span>

                    <span>
                        Mã xác thực được gửi qua email
                    </span>

                </div>


                <div class="tb-verify-benefit">

                    <span class="tb-verify-benefit-icon">
                        🛡️
                    </span>

                    <span>
                        Giúp bảo vệ thông tin tài khoản
                    </span>

                </div>


                <div class="tb-verify-benefit">

                    <span class="tb-verify-benefit-icon">
                        🛍
                    </span>

                    <span>
                        Xác thực trước khi mua sắm đầy đủ
                    </span>

                </div>

            </div>

        </aside>


        {{-- =====================================================
            OTP FORM
        ====================================================== --}}
        <section class="tb-verify-form-panel">


            <div class="tb-verify-mail-icon">
                ✉
            </div>


            <div class="tb-verify-head">

                <h2>
                    Nhập mã xác thực
                </h2>


                <p>
                    Chúng tôi đã gửi mã OTP đến:
                </p>


                <div class="tb-verify-email">
                    ✉ {{ $user->email }}
                </div>

            </div>


            {{-- PROGRESS --}}
            <div class="tb-verify-progress">

                <div class="tb-verify-step done">

                    <div class="tb-verify-step-line">
                    </div>

                    <span>
                        Đăng ký
                    </span>

                </div>


                <div class="tb-verify-step active">

                    <div class="tb-verify-step-line">
                    </div>

                    <span>
                        Xác thực OTP
                    </span>

                </div>


                <div class="tb-verify-step">

                    <div class="tb-verify-step-line">
                    </div>

                    <span>
                        Hoàn tất
                    </span>

                </div>

            </div>


            <div class="tb-verify-badges">

                <span>
                    🔢 OTP 6 số
                </span>

                <span>
                    ✅ Xác thực email
                </span>

            </div>


            {{-- VERIFY FORM --}}
            <form
                method="POST"
                action="{{ route('verification.verify.code') }}"
                id="verifyEmailForm"
            >

                @csrf


                <div>

                    <label
                        for="verification_code"
                        class="tb-verify-label"
                    >
                        Mã OTP 6 số
                    </label>


                    <input
                        id="verification_code"
                        type="text"
                        name="verification_code"
                        value="{{ old('verification_code') }}"
                        class="
                            tb-verify-otp
                            @error('verification_code')
                                is-invalid
                            @enderror
                        "
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        maxlength="6"
                        pattern="[0-9]{6}"
                        placeholder="••••••"
                        required
                        autofocus
                    >


                    @error('verification_code')

                        <div class="tb-verify-error">
                            {{ $message }}
                        </div>

                    @enderror


                    <div class="tb-verify-input-help">

                        <span>
                            Chỉ nhập số
                        </span>

                        <strong id="otpCount">
                            0 / 6
                        </strong>

                    </div>

                </div>


                <button
                    type="submit"
                    class="tb-verify-submit"
                    id="verifySubmit"
                >
                    <span>
                        ✅
                    </span>

                    <span>
                        Xác thực email
                    </span>
                </button>

            </form>


            <div class="tb-verify-separator">
                CHƯA NHẬN ĐƯỢC MÃ?
            </div>


            {{-- RESEND --}}
            <form
                method="POST"
                action="{{ route('verification.resend') }}"
                id="resendOtpForm"
            >

                @csrf


                <button
                    type="submit"
                    class="tb-verify-resend"
                    id="resendOtpButton"
                >
                    🔄 Gửi lại mã xác thực
                </button>

            </form>


            <div class="tb-verify-note">

                <span>
                    ℹ️
                </span>

                <span>
                    Nếu chưa thấy email,
                    hãy kiểm tra thư mục Spam/Junk.
                    Khi yêu cầu gửi mã mới,
                    hãy sử dụng mã OTP mới nhất
                    được gửi tới hộp thư.
                </span>

            </div>

        </section>

    </div>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        const otpInput =
            document.getElementById(
                'verification_code'
            );


        const otpCount =
            document.getElementById(
                'otpCount'
            );


        const verifyForm =
            document.getElementById(
                'verifyEmailForm'
            );


        const verifySubmit =
            document.getElementById(
                'verifySubmit'
            );


        const resendForm =
            document.getElementById(
                'resendOtpForm'
            );


        const resendButton =
            document.getElementById(
                'resendOtpButton'
            );


        /* =============================================
           CHỈ CHO NHẬP 6 CHỮ SỐ
        ============================================= */

        function updateOtp() {

            if (!otpInput) {
                return;
            }


            otpInput.value =
                otpInput.value
                    .replace(/\D/g, '')
                    .slice(0, 6);


            if (otpCount) {

                otpCount.textContent =
                    otpInput.value.length
                    + ' / 6';

            }

        }


        if (otpInput) {

            updateOtp();


            otpInput.addEventListener(
                'input',
                updateOtp
            );


            otpInput.addEventListener(
                'paste',
                function () {

                    window.setTimeout(
                        updateOtp,
                        0
                    );

                }
            );

        }


        /* =============================================
           CHỐNG BẤM XÁC THỰC NHIỀU LẦN
        ============================================= */

        if (
            verifyForm
            &&
            verifySubmit
        ) {

            verifyForm.addEventListener(
                'submit',
                function () {

                    if (
                        otpInput
                        &&
                        otpInput.value.length !== 6
                    ) {
                        return;
                    }


                    verifySubmit.disabled =
                        true;


                    verifySubmit.innerHTML =
                        '<span>✅</span>'
                        +
                        '<span>Đang xác thực...</span>';

                }
            );

        }


        /* =============================================
           CHỐNG BẤM GỬI LẠI NHIỀU LẦN
        ============================================= */

        if (
            resendForm
            &&
            resendButton
        ) {

            resendForm.addEventListener(
                'submit',
                function () {

                    resendButton.disabled =
                        true;


                    resendButton.textContent =
                        '📩 Đang gửi mã...';

                }
            );

        }

    }
);
</script>

@endsection