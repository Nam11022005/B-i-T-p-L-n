@extends('layouts.app')

@section('title', 'Xác nhận OTP | Tinh Hoa Tây Bắc')

@section('content')

<style>
    /* =========================================================
       FORGOT PASSWORD OTP - TINH HOA TÂY BẮC
    ========================================================= */

    .tb-reset-otp-page {
        --otp-brown: #633820;
        --otp-green: #35562f;
        --otp-red: #b43e2e;
        --otp-gold: #e5ad42;
        --otp-muted: #76685e;

        position: relative;
        isolation: isolate;
        width: 100%;
        padding: 42px 0 72px;
    }

    .tb-reset-otp-page::before {
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

    .tb-reset-otp-shell {
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

    .tb-reset-otp-shell::before {
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
                var(--otp-gold),
                var(--otp-red),
                var(--otp-green),
                transparent
            );
    }

    /* LEFT */

    .tb-reset-otp-brand {
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

    .tb-reset-otp-brand::before {
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

    .tb-reset-otp-brand::after {
        content: "•";
        position: absolute;

        top: 28px;
        right: 36px;

        font-size: 92px;
        opacity: .055;

        transform: rotate(-10deg);
    }

    .tb-reset-otp-brand-top,
    .tb-reset-otp-steps {
        position: relative;
        z-index: 2;
    }

    .tb-reset-otp-logo {
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

    .tb-reset-otp-kicker {
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

    .tb-reset-otp-brand h1 {
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

    .tb-reset-otp-copy {
        max-width: 470px;

        margin: 19px 0 0;

        color:
            rgba(255,255,255,.76);

        font-size: 15px;
        line-height: 1.75;
    }

    /* STEPS */

    .tb-reset-otp-steps {
        display: grid;
        gap: 10px;

        margin-top: 34px;
    }

    .tb-reset-otp-step {
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

    .tb-reset-otp-step.done {
        color:
            rgba(255,255,255,.88);

        border-color:
            rgba(94,160,85,.20);

        background:
            rgba(53,86,47,.18);
    }

    .tb-reset-otp-step.active {
        color: #fff;

        border-color:
            rgba(229,173,66,.28);

        background:
            rgba(229,173,66,.11);
    }

    .tb-reset-otp-step-number {
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

    .tb-reset-otp-step.done
    .tb-reset-otp-step-number {
        color: #fff;
        background: #58784e;
    }

    .tb-reset-otp-step.active
    .tb-reset-otp-step-number {
        color: #432a18;

        background:
            linear-gradient(
                135deg,
                #f6d77f,
                #e5ad42
            );
    }

    /* RIGHT */

    .tb-reset-otp-panel {
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

    .tb-reset-otp-panel::after {
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

    .tb-reset-otp-icon {
        width: 86px;
        height: 86px;

        display: grid;
        place-items: center;

        margin-bottom: 22px;

        border:
            1px solid
            #e4c78f;

        border-radius: 26px;

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

        font-size: 39px;
    }

    .tb-reset-otp-head {
        margin-bottom: 24px;
    }

    .tb-reset-otp-head h2 {
        margin: 0;

        color: #30231c;

        font-size: 34px;

        line-height: 1.15;
        font-weight: 950;

        letter-spacing: -.7px;
    }

    .tb-reset-otp-head p {
        margin: 10px 0 0;

        color: var(--otp-muted);

        font-size: 14px;
        line-height: 1.68;
    }

    /* ALERTS */

    .tb-reset-otp-alert {
        display: flex;
        align-items: flex-start;

        gap: 10px;

        margin-bottom: 18px;
        padding: 13px 15px;

        border-radius: 13px;

        font-size: 13px;
        line-height: 1.55;
    }

    .tb-reset-otp-alert.success {
        border:
            1px solid
            #bed7b5;

        color: #405b37;
        background: #f2f8ef;
    }

    .tb-reset-otp-alert.error {
        border:
            1px solid
            #e2b7af;

        color: #8e3428;
        background: #fff4f1;
    }

    /* OTP */

    .tb-reset-otp-label {
        display: block;

        margin-bottom: 8px;

        color: #4c3529;

        font-size: 14px;
        font-weight: 850;
    }

    .tb-reset-otp-input {
        width: 100%;
        height: 72px;

        padding: 0 18px;

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

    .tb-reset-otp-input:hover {
        border-color: #d8b98e;
    }

    .tb-reset-otp-input:focus {
        border-color: #cf9f5d;
        background: #fff;

        box-shadow:
            0 0 0 .22rem
            rgba(229,173,66,.13),
            0 9px 22px
            rgba(99,56,32,.06);
    }

    .tb-reset-otp-input.is-invalid {
        border-color: #c85a4b;
    }

    .tb-reset-otp-error {
        margin-top: 7px;

        color: #b43e2e;

        font-size: 13px;
        font-weight: 700;
    }

    .tb-reset-otp-help {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 10px;

        margin-top: 8px;

        color: #918178;

        font-size: 12px;
    }

    .tb-reset-otp-help strong {
        color: #6e5a4d;
    }

    /* NOTE */

    .tb-reset-otp-note {
        display: flex;
        align-items: flex-start;

        gap: 10px;

        margin-top: 18px;

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

    /* BUTTON */

    .tb-reset-otp-submit {
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

    .tb-reset-otp-submit::before {
        content: "";

        position: absolute;

        top: 0;
        left: -120%;

        width: 60%;
        height: 100%;

        transform: skewX(-20deg);

        background:
            linear-gradient(
                90deg,
                transparent,
                rgba(255,255,255,.22),
                transparent
            );

        transition: left .45s ease;
    }

    .tb-reset-otp-submit:hover {
        transform: translateY(-2px);

        box-shadow:
            0 17px 34px
            rgba(99,56,32,.25);
    }

    .tb-reset-otp-submit:hover::before {
        left: 145%;
    }

    .tb-reset-otp-submit:disabled {
        opacity: .78;
        cursor: wait;
        transform: none;
    }

    /* BACK */

    .tb-reset-otp-separator {
        display: flex;
        align-items: center;

        gap: 13px;

        margin:
            27px 0 19px;

        color: #9a8a80;

        font-size: 12px;
        font-weight: 800;
    }

    .tb-reset-otp-separator::before,
    .tb-reset-otp-separator::after {
        content: "";

        flex: 1;
        height: 1px;

        background: #ead8bf;
    }

    .tb-reset-otp-back {
        display: flex;
        align-items: center;
        justify-content: center;

        min-height: 50px;

        padding: 10px 16px;

        border:
            1px solid
            #e6d2b2;

        border-radius: 14px;

        color: var(--otp-red);

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

    .tb-reset-otp-back:hover {
        transform: translateY(-1px);

        border-color: #d8b98e;
        color: var(--otp-brown);
    }

    /* RESPONSIVE */

    @media (max-width: 991.98px) {

        .tb-reset-otp-page {
            padding:
                30px 0 60px;
        }

        .tb-reset-otp-shell {
            max-width: 680px;
            grid-template-columns: 1fr;
        }

        .tb-reset-otp-brand {
            min-height: auto;
            padding: 38px 34px;
        }

        .tb-reset-otp-brand h1 {
            max-width: 540px;
            font-size: 40px;
        }

        .tb-reset-otp-steps {
            grid-template-columns:
                repeat(
                    3,
                    minmax(0,1fr)
                );

            margin-top: 28px;
        }

        .tb-reset-otp-step {
            align-items: flex-start;
            flex-direction: column;

            font-size: 13px;
        }

        .tb-reset-otp-panel {
            padding: 44px 38px;
        }
    }

    @media (max-width: 575.98px) {

        .tb-reset-otp-page {
            padding:
                18px 0 42px;
        }

        .tb-reset-otp-shell {
            border-radius: 22px;
        }

        .tb-reset-otp-brand {
            padding: 29px 23px;
        }

        .tb-reset-otp-logo {
            width: 50px;
            height: 50px;

            margin-bottom: 18px;

            border-radius: 15px;
        }

        .tb-reset-otp-brand h1 {
            font-size: 34px;
        }

        .tb-reset-otp-copy {
            font-size: 14px;
        }

        .tb-reset-otp-steps {
            grid-template-columns: 1fr;

            gap: 8px;

            margin-top: 24px;
        }

        .tb-reset-otp-step {
            align-items: center;
            flex-direction: row;
        }

        .tb-reset-otp-panel {
            padding: 32px 22px;
        }

        .tb-reset-otp-panel::after {
            display: none;
        }

        .tb-reset-otp-icon {
            width: 74px;
            height: 74px;

            border-radius: 22px;

            font-size: 34px;
        }

        .tb-reset-otp-head h2 {
            font-size: 29px;
        }

        .tb-reset-otp-input {
            height: 66px;

            padding: 0 8px;

            font-size: 25px;

            letter-spacing: .35em;
            text-indent: .35em;
        }
    }

    @media (prefers-reduced-motion: reduce) {

        .tb-reset-otp-page *,
        .tb-reset-otp-page *::before,
        .tb-reset-otp-page *::after {
            transition: none !important;
        }
    }
</style>


<div class="tb-reset-otp-page">

    <div class="tb-reset-otp-shell">


        {{-- LEFT --}}
        <aside class="tb-reset-otp-brand">

            <div class="tb-reset-otp-brand-top">

                <div class="tb-reset-otp-logo">
                    •
                </div>

                <div class="tb-reset-otp-kicker">
                    Bước 2 / 3
                </div>

                <h1>
                    Xác nhận mã OTP
                    trong email.
                </h1>

                <p class="tb-reset-otp-copy">

                    Nhập mã xác thực
                    bạn vừa nhận được
                    để tiếp tục sang bước
                    tạo mật khẩu mới.

                </p>

            </div>


            <div class="tb-reset-otp-steps">

                <div class="tb-reset-otp-step done">

                    <span class="tb-reset-otp-step-number">
                        •
                    </span>

                    <span>
                        Đã nhập email
                    </span>

                </div>


                <div class="tb-reset-otp-step active">

                    <span class="tb-reset-otp-step-number">
                        2
                    </span>

                    <span>
                        Xác nhận mã OTP
                    </span>

                </div>


                <div class="tb-reset-otp-step">

                    <span class="tb-reset-otp-step-number">
                        3
                    </span>

                    <span>
                        Tạo mật khẩu mới
                    </span>

                </div>

            </div>

        </aside>


        {{-- RIGHT --}}
        <section class="tb-reset-otp-panel">


            <div class="tb-reset-otp-icon">
                •
            </div>


            <div class="tb-reset-otp-head">

                <h2>
                    Nhập mã OTP
                </h2>

                <p>
                    Kiểm tra hộp thư email
                    và nhập mã OTP 6 số
                    để xác thực yêu cầu
                    khôi phục mật khẩu.
                </p>

            </div>


            @if(session('success'))

                <div class="tb-reset-otp-alert success">

                    <span>
                        •
                    </span>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            @if(session('error'))

                <div class="tb-reset-otp-alert error">

                    <span>
                        •
                    </span>

                    <span>
                        {{ session('error') }}
                    </span>

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('password.otp.verify') }}"
                id="resetOtpForm"
            >

                @csrf


                <div>

                    <label
                        for="otp"
                        class="tb-reset-otp-label"
                    >
                        Mã OTP 6 số
                    </label>


                    <input
                        id="otp"
                        type="text"
                        name="otp"
                        value="{{ old('otp') }}"
                        class="
                            tb-reset-otp-input
                            @error('otp')
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


                    @error('otp')

                        <div class="tb-reset-otp-error">
                            {{ $message }}
                        </div>

                    @enderror


                    <div class="tb-reset-otp-help">

                        <span>
                            Chỉ nhập 6 chữ số
                        </span>

                        <strong id="resetOtpCount">
                            0 / 6
                        </strong>

                    </div>

                </div>


                <div class="tb-reset-otp-note">

                    <span>
                        •
                    </span>

                    <span>
                        Nếu chưa thấy thư,
                        hãy kiểm tra cả Spam/Junk
                        và sử dụng mã OTP mới nhất
                        mà hệ thống đã gửi.
                    </span>

                </div>


                <button
                    type="submit"
                    class="tb-reset-otp-submit"
                    id="resetOtpSubmit"
                >
                    <span>
                        •
                    </span>

                    <span>
                        Xác nhận OTP
                    </span>
                </button>

            </form>


            <div class="tb-reset-otp-separator">
                NHẬP SAI EMAIL?
            </div>


            <a
                href="{{ route('password.request') }}"
                class="tb-reset-otp-back"
            >
                ← Nhập lại email
            </a>

        </section>

    </div>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        const otpInput =
            document.getElementById(
                'otp'
            );

        const otpCount =
            document.getElementById(
                'resetOtpCount'
            );

        const form =
            document.getElementById(
                'resetOtpForm'
            );

        const submitButton =
            document.getElementById(
                'resetOtpSubmit'
            );


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


        if (
            form
            &&
            submitButton
        ) {

            form.addEventListener(
                'submit',
                function (event) {

                    if (
                        otpInput
                        &&
                        otpInput.value.length !== 6
                    ) {

                        event.preventDefault();

                        otpInput.focus();

                        return;

                    }


                    submitButton.disabled =
                        true;


                    submitButton.innerHTML =
                        '<span>•</span>'
                        +
                        '<span>Đang xác nhận...</span>';

                }
            );

        }

    }
);
</script>

@endsection