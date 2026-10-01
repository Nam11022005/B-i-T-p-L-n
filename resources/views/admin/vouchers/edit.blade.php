@extends('admin.layouts.app') 

@section('title', 'Sửa Voucher | Tinh Hoa Tây Bắc') 

@section('content')

<style>

    /* =========================================================
       VOUCHER ADMIN - PREMIUM UI ONLY
       Chỉ nâng giao diện, không đổi route/form/Blade logic.
    ========================================================= */
    :root {
        --vc-brown: #5f341d;
        --vc-dark: #2c1810;
        --vc-red: #a83b2d;
        --vc-gold: #f2c15c;
        --vc-green: #48633b;
        --vc-cream: #fffaf0;
        --vc-border: #ead8bf;
    }

    .voucher-premium-page {
        position: relative;
        isolation: isolate;
        padding: 34px 0 78px;
    }

    .voucher-premium-page::before {
        content: "";
        position: absolute;
        z-index: -3;
        top: -36px;
        left: 50%;
        width: min(100vw,1760px);
        height: 760px;
        transform: translateX(-50%);
        pointer-events: none;
        background:
            radial-gradient(circle at 7% 8%,rgba(242,193,92,.20),transparent 24%),
            radial-gradient(circle at 94% 10%,rgba(72,99,59,.14),transparent 28%),
            radial-gradient(circle at 50% 24%,rgba(168,59,45,.05),transparent 30%),
            linear-gradient(180deg,rgba(255,250,240,.96),rgba(255,255,255,0));
    }

    .voucher-premium-page::after {
        content: "";
        position: absolute;
        z-index: -2;
        top: 155px;
        right: -60px;
        width: 230px;
        height: 230px;
        border-radius: 50%;
        opacity: .09;
        pointer-events: none;
        background:
            repeating-radial-gradient(circle at center,rgba(95,52,29,.34) 0 1px,transparent 1px 13px);
    }

    .voucher-premium-hero {
        position: relative;
        overflow: hidden;
        min-height: 185px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 28px;
        padding: 34px 38px;
        margin-bottom: 26px;
        border-radius: 28px;
        color: #fff;
        background:
            radial-gradient(circle at 88% 14%,rgba(242,193,92,.25),transparent 29%),
            radial-gradient(circle at 12% 120%,rgba(168,59,45,.28),transparent 35%),
            linear-gradient(135deg,#28150d 0%,#5f341d 53%,#48633b 100%);
        box-shadow: 0 24px 58px rgba(44,24,16,.16);
    }

    .voucher-premium-hero::before {
        content: "";
        position: absolute;
        right: -38px;
        bottom: -64px;
        width: 350px;
        height: 205px;
        opacity: .11;
        clip-path: polygon(0 100%,18% 56%,35% 73%,53% 25%,70% 58%,86% 34%,100% 66%,100% 100%);
        background: linear-gradient(135deg,#fff,#f2c15c);
    }

    .voucher-premium-hero::after {
        content: "🎟️";
        position: absolute;
        right: 46px;
        top: 20px;
        font-size: 92px;
        opacity: .07;
        transform: rotate(-9deg);
    }

    .voucher-premium-hero > * {
        position: relative;
        z-index: 2;
    }

    .voucher-premium-kicker {
        display: inline-flex;
        padding: 6px 11px;
        margin-bottom: 9px;
        border: 1px solid rgba(242,193,92,.31);
        border-radius: 999px;
        color: #f5d98e;
        background: rgba(255,255,255,.055);
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .09em;
    }

    .voucher-premium-hero h2,
    .voucher-premium-hero h1 {
        color: #fff !important;
        font-size: clamp(31px,3vw,44px);
        font-weight: 900;
        letter-spacing: -.8px;
        text-shadow: 0 2px 14px rgba(0,0,0,.18);
    }

    .voucher-premium-hero p {
        color: rgba(255,255,255,.76) !important;
        line-height: 1.7;
    }

    .voucher-premium-page .btn-taybac,
    .voucher-premium-page .voucher-main-btn {
        min-height: 45px;
        border: 0;
        border-radius: 12px;
        color: #fff;
        background: linear-gradient(135deg,#a83b2d,#5f341d 52%,#48633b);
        font-weight: 850;
        box-shadow: 0 10px 22px rgba(95,52,29,.19);
        transition: transform .16s ease,box-shadow .16s ease;
    }

    .voucher-premium-page .btn-taybac:hover,
    .voucher-premium-page .voucher-main-btn:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(95,52,29,.24);
    }

    .voucher-premium-page .voucher-card,
    .voucher-premium-page .form-card,
    .voucher-premium-page .voucher-form-shell {
        overflow: hidden;
        border: 1px solid #e3cdae !important;
        border-radius: 24px !important;
        background: linear-gradient(180deg,#fff,#fffdfa);
        box-shadow:
            0 20px 50px rgba(72,43,27,.09),
            inset 0 1px 0 rgba(255,255,255,.95) !important;
    }

    .voucher-premium-page .voucher-card {
        border-radius: 22px !important;
    }

    .voucher-premium-page .table > :not(caption) > * > * {
        padding: 15px 14px;
        border-color: #f0e4d5;
        vertical-align: middle;
    }

    .voucher-premium-page thead th {
        border-bottom-color: #dfc9a7 !important;
        background: linear-gradient(180deg,#fff8e9,#f8efe2) !important;
        color: var(--vc-brown);
        font-size: 12px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .025em;
        white-space: nowrap;
    }

    .voucher-premium-page tbody tr {
        transition: background .16s ease;
    }

    .voucher-premium-page tbody tr:hover {
        background: #fffaf2;
    }

    .voucher-premium-page .voucher-code {
        padding: 7px 12px;
        border: 1px solid #e5c888;
        border-radius: 10px;
        background: linear-gradient(135deg,#fff5d7,#f7e3aa);
        color: #704616;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.9);
    }

    .voucher-premium-page .status-active,
    .voucher-premium-page .status-inactive {
        padding: 6px 10px;
        border-radius: 999px;
        font-weight: 800;
    }

    .voucher-premium-page .status-active {
        border: 1px solid #b9d8bf;
        background: #eaf7ec;
        color: #286038;
    }

    .voucher-premium-page .status-inactive {
        border: 1px solid #efc2bc;
        background: #fff0ed;
        color: #9a3d32;
    }

    .voucher-premium-page .badge.bg-primary {
        background: #5c6f90 !important;
    }

    .voucher-premium-page .badge.bg-warning {
        background: #f3d990 !important;
        color: #624414 !important;
    }

    .voucher-premium-page .badge.bg-success {
        background: #62825a !important;
    }

    .voucher-premium-page .btn-sm {
        min-width: 38px;
        min-height: 36px;
        border-radius: 10px;
        font-weight: 800;
    }

    .voucher-premium-page .btn-outline-primary {
        border-color: #c9aa80;
        color: #5f341d;
        background: #fffdf9;
    }

    .voucher-premium-page .btn-outline-primary:hover {
        border-color: #5f341d;
        color: #fff;
        background: #5f341d;
    }

    .voucher-premium-page .btn-outline-danger {
        background: #fffafa;
    }

    .voucher-premium-page .alert {
        border-radius: 15px;
        box-shadow: 0 8px 22px rgba(95,52,29,.055);
    }

    .voucher-premium-page .page-link {
        margin: 0 3px;
        border-color: #dfc8a8;
        border-radius: 10px !important;
        color: #5f341d;
    }

    .voucher-premium-page .page-item.active .page-link {
        border-color: transparent;
        background: linear-gradient(135deg,#5f341d,#48633b);
    }

    /* Form + partial fields */
    .voucher-premium-page .voucher-form-shell {
        max-width: 1040px;
        margin: 0 auto;
    }

    .voucher-premium-page .voucher-form-content {
        padding: 34px;
    }

    .voucher-premium-page form .form-label {
        margin-bottom: 7px;
        color: #51372a;
        font-size: 13px;
        font-weight: 850;
    }

    .voucher-premium-page form .form-control,
    .voucher-premium-page form .form-select {
        min-height: 50px;
        border: 1px solid #dfcbae;
        border-radius: 13px;
        background: linear-gradient(180deg,#fffefb,#fffaf3);
        color: #34251d;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.95);
        transition: border-color .18s ease,box-shadow .18s ease,transform .18s ease;
    }

    .voucher-premium-page form textarea.form-control {
        min-height: 120px;
    }

    .voucher-premium-page form .form-control:focus,
    .voucher-premium-page form .form-select:focus {
        border-color: #d0a05d;
        background: #fff;
        box-shadow: 0 0 0 .2rem rgba(217,119,6,.09);
        transform: translateY(-1px);
    }

    .voucher-premium-page form .form-check-input:checked {
        border-color: #48633b;
        background-color: #48633b;
    }

    .voucher-premium-page .voucher-form-actions {
        padding-top: 22px;
        margin-top: 28px !important;
        border-top: 1px solid #ead8bf;
    }

    .voucher-premium-page .voucher-form-actions .btn {
        min-height: 45px;
        padding-inline: 18px;
        border-radius: 12px;
        font-weight: 850;
    }

    .voucher-premium-page .btn-outline-secondary {
        border-color: #ccb28e;
        color: #5f341d;
        background: #fff;
    }

    .voucher-premium-page .btn-outline-secondary:hover {
        color: #fff;
        border-color: #5f341d;
        background: #5f341d;
    }

    @media (max-width: 767.98px) {
        .voucher-premium-page {
            padding-top: 22px;
        }

        .voucher-premium-page::after {
            display: none;
        }

        .voucher-premium-hero {
            min-height: 0;
            flex-direction: column;
            align-items: flex-start;
            padding: 26px 22px;
            border-radius: 22px;
        }

        .voucher-premium-page .voucher-form-content {
            padding: 22px;
        }

        .voucher-premium-page .voucher-form-actions {
            flex-direction: column;
        }

        .voucher-premium-page .voucher-form-actions .btn {
            width: 100%;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .voucher-premium-page *,
        .voucher-premium-page *::before,
        .voucher-premium-page *::after {
            transition: none !important;
            animation: none !important;
        }
    }

</style>
 

<div class="voucher-premium-page"><section class="voucher-premium-hero"><div><div class="voucher-premium-kicker">⚙️ QUẢN TRỊ VOUCHER</div><h2 class="mb-2">✏️ Sửa Voucher</h2><p class="mb-0">Cập nhật chương trình ưu đãi hiện có.</p></div></section><div class="card voucher-form-shell"> 

    <div class="card-body p-4 p-md-5 voucher-form-content"> 

        <div class="mb-4">
            <h3 class="fw-bold mb-1" style="color:#2c1810;">Thông tin Voucher</h3>
            <p class="text-muted mb-0">Mã hiện tại: <strong>{{ $voucher->code }}</strong></p>
        </div> 


        @if($errors->any()) 

            <div class="alert alert-danger"> 

                <ul class="mb-0"> 

                    @foreach($errors->all() as $error) 
                        <li>{{ $error }}</li> 
                    @endforeach 

                </ul> 

            </div> 

        @endif 


        <form 
            action="{{ route('admin.vouchers.update', $voucher) }}" 
            method="POST" 
        > 

            @csrf 
            @method('PUT') 


            @include('admin.vouchers.partials.form') 


            <div class="d-flex gap-2 mt-4 voucher-form-actions"> 

                <button 
                    type="submit" 
                    class="btn voucher-main-btn" 
                > 
                    💾 Cập nhật 
                </button> 

                <a 
                    href="{{ route('admin.vouchers.index') }}" 
                    class="btn btn-outline-secondary" 
                > 
                    Quay lại 
                </a> 

            </div> 

        </form> 

    </div> 

</div> 

@endsection