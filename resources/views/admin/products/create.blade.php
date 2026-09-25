@extends('admin.layouts.app')

@section('title', 'Thêm Sản phẩm')

@section('content')

<style>
    .product-form-card {
        border: 1px solid #ead8bf;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 28px rgba(95, 52, 29, 0.08);
    }

    .product-form-header {
        background: linear-gradient(90deg, #5f341d 0%, #48633b 100%);
        color: #fff;
        padding: 18px 22px;
    }

    .unit-help {
        background: #fffaf0;
        border: 1px solid #ead8bf;
        border-radius: 12px;
        padding: 12px 14px;
        color: #5f341d;
    }

    .image-drop-area {
        cursor: pointer;
        min-height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fffaf0;
        border: 2px dashed #d8c5ac !important;
    }

    .btn-tb {
        border: 0;
        background: linear-gradient(135deg, #48633b, #2f4b2b);
        color: #fff;
    }

    .btn-tb:hover {
        color: #fff;
        background: linear-gradient(135deg, #3e5634, #253d22);
    }


    /* =========================================================
       ADMIN PRODUCT FORM - LUXURY UI
       Chỉ nâng giao diện, giữ nguyên form/route/JS/Blade logic.
    ========================================================= */

    .admin-product-form-page {
        position: relative;
        isolation: isolate;
        padding: 34px 0 78px;
    }

    .admin-product-form-page::before {
        content: "";
        position: absolute;
        z-index: -3;
        top: -35px;
        left: 50%;
        width: min(100vw, 1760px);
        height: 780px;
        transform: translateX(-50%);
        pointer-events: none;
        background:
            radial-gradient(circle at 8% 8%, rgba(242,193,92,.18), transparent 24%),
            radial-gradient(circle at 94% 11%, rgba(72,99,59,.13), transparent 28%),
            radial-gradient(circle at 52% 24%, rgba(168,59,45,.045), transparent 30%),
            linear-gradient(180deg, rgba(255,250,240,.96), rgba(255,255,255,0));
    }

    .admin-product-form-page::after {
        content: "";
        position: absolute;
        z-index: -2;
        top: 135px;
        right: -55px;
        width: 220px;
        height: 220px;
        opacity: .095;
        pointer-events: none;
        border-radius: 50%;
        background:
            repeating-radial-gradient(
                circle at center,
                rgba(95,52,29,.34) 0 1px,
                transparent 1px 13px
            );
    }

    .admin-product-form-page .product-form-card {
        position: relative;
        overflow: hidden;
        border: 1px solid #e3cdae !important;
        border-radius: 30px !important;
        background:
            linear-gradient(180deg,#fff 0%,#fffdfa 100%);
        box-shadow:
            0 28px 70px rgba(72,43,27,.12),
            0 5px 18px rgba(72,43,27,.05) !important;
    }

    .admin-product-form-page .product-form-card::before {
        content: "";
        position: absolute;
        z-index: 4;
        top: 0;
        left: 7%;
        right: 7%;
        height: 3px;
        border-radius: 999px;
        background:
            linear-gradient(90deg,transparent,#f2c15c 24%,#d97706 50%,#48633b 76%,transparent);
        opacity: .8;
    }

    .admin-product-form-page .product-form-header {
        position: relative;
        overflow: hidden;
        min-height: 185px;
        display: flex;
        align-items: center;
        padding: 34px 38px !important;
        background:
            radial-gradient(circle at 87% 13%, rgba(242,193,92,.24), transparent 28%),
            radial-gradient(circle at 12% 120%, rgba(168,59,45,.30), transparent 36%),
            linear-gradient(135deg,#28150d 0%,#5f341d 53%,#48633b 100%) !important;
    }

    .admin-product-form-page .product-form-header::before {
        content: "";
        position: absolute;
        right: -35px;
        bottom: -65px;
        width: 350px;
        height: 210px;
        opacity: .11;
        clip-path: polygon(
            0 100%,18% 56%,36% 73%,53% 25%,70% 58%,86% 34%,100% 66%,100% 100%
        );
        background: linear-gradient(135deg,#fff,#f2c15c);
        pointer-events: none;
    }

    .admin-product-form-page .product-form-header::after {
        content: "🌿";
        position: absolute;
        right: 38px;
        top: 16px;
        font-size: 88px;
        opacity: .055;
        transform: rotate(-13deg);
        pointer-events: none;
    }

    .admin-product-form-page .product-form-header h2 {
        position: relative;
        z-index: 2;
        max-width: 760px;
        color: #fff;
        font-size: clamp(31px,3vw,44px);
        font-weight: 900;
        letter-spacing: -.7px;
        text-shadow: 0 2px 14px rgba(0,0,0,.18);
    }

    .admin-product-form-page .product-form-header h2::before {
        content: "QUẢN TRỊ SẢN PHẨM";
        display: block;
        width: fit-content;
        margin-bottom: 10px;
        padding: 6px 11px;
        border: 1px solid rgba(242,193,92,.30);
        border-radius: 999px;
        color: #f5d98e;
        background: rgba(255,255,255,.055);
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .09em;
    }

    .admin-product-form-page .card-body {
        position: relative;
        padding: 34px !important;
        background:
            radial-gradient(circle at 100% 0%, rgba(242,193,92,.06), transparent 24%),
            linear-gradient(180deg,#fff,#fffdf9);
    }

    /* chia visual giữa 2 cột */
    .admin-product-form-page .col-lg-8 {
        position: relative;
        padding-right: 28px;
    }

    .admin-product-form-page .col-lg-8::after {
        content: "";
        position: absolute;
        top: 4px;
        right: 3px;
        bottom: 4px;
        width: 1px;
        background: linear-gradient(180deg,transparent,#ead8bf 12%,#ead8bf 88%,transparent);
    }

    .admin-product-form-page .col-lg-4 {
        padding-left: 28px;
    }

    .admin-product-form-page .form-label {
        margin-bottom: 8px;
        color: #51372a;
        font-size: 13px;
        letter-spacing: .01em;
    }

    .admin-product-form-page .form-control,
    .admin-product-form-page .form-select {
        min-height: 49px;
        border-radius: 13px;
        border-color: #dfcbae;
        background:
            linear-gradient(180deg,#fffefb,#fffaf3);
        color: #34251d;
        box-shadow:
            inset 0 1px 0 rgba(255,255,255,.95),
            0 4px 12px rgba(95,52,29,.025);
        transition:
            border-color .18s ease,
            box-shadow .18s ease,
            background .18s ease,
            transform .18s ease;
    }

    .admin-product-form-page textarea.form-control {
        min-height: 135px;
        resize: vertical;
        line-height: 1.65;
    }

    .admin-product-form-page .form-control:hover,
    .admin-product-form-page .form-select:hover {
        border-color: #d6b88d;
    }

    .admin-product-form-page .form-control:focus,
    .admin-product-form-page .form-select:focus {
        border-color: #d0a05d;
        background: #fff;
        box-shadow:
            0 0 0 .2rem rgba(217,119,6,.09),
            0 8px 20px rgba(95,52,29,.045);
        transform: translateY(-1px);
    }

    .admin-product-form-page .input-group .form-control {
        border-radius: 13px 0 0 13px;
    }

    .admin-product-form-page .input-group-text {
        border-color: #dfcbae;
        border-radius: 0 13px 13px 0;
        background: #fff4df;
        color: #5f341d;
        font-weight: 800;
    }

    .admin-product-form-page .unit-help {
        position: relative;
        overflow: hidden;
        padding: 16px 18px !important;
        border: 1px solid #e9cf9e !important;
        border-radius: 16px !important;
        background:
            radial-gradient(circle at 95% 10%, rgba(242,193,92,.14), transparent 26%),
            linear-gradient(135deg,#fff9e7,#fff2cf) !important;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.9);
        line-height: 1.65;
    }

    .admin-product-form-page .unit-help::after {
        content: "💡";
        position: absolute;
        right: 14px;
        bottom: -8px;
        font-size: 52px;
        opacity: .055;
        pointer-events: none;
    }

    /* IMAGE AREA */
    .admin-product-form-page .image-drop-area {
        position: relative;
        min-height: 290px !important;
        overflow: hidden;
        border: 2px dashed #d2b487 !important;
        border-radius: 20px !important;
        background:
            radial-gradient(circle at 78% 16%, rgba(242,193,92,.20), transparent 29%),
            radial-gradient(circle at 14% 88%, rgba(72,99,59,.07), transparent 30%),
            linear-gradient(145deg,#fffdf8,#fff5e4) !important;
        box-shadow:
            inset 0 1px 0 rgba(255,255,255,.95),
            0 9px 24px rgba(95,52,29,.05);
        transition:
            transform .18s ease,
            border-color .18s ease,
            box-shadow .18s ease,
            background .18s ease;
    }

    .admin-product-form-page .image-drop-area::before {
        content: "";
        position: absolute;
        inset: 16px;
        border: 1px solid rgba(95,52,29,.065);
        border-radius: 15px;
        pointer-events: none;
    }

    .admin-product-form-page .image-drop-area:hover {
        transform: translateY(-2px);
        border-color: #bd9257 !important;
        background:
            radial-gradient(circle at 78% 16%, rgba(242,193,92,.26), transparent 29%),
            linear-gradient(145deg,#fffdf8,#fff2da) !important;
        box-shadow: 0 14px 30px rgba(95,52,29,.08);
    }

    .admin-product-form-page #image-preview img,
    .admin-product-form-page .col-lg-4 img {
        border-radius: 16px !important;
        border: 1px solid #e3cdae !important;
        box-shadow: 0 10px 24px rgba(95,52,29,.09);
    }

    /* Edit: khung ảnh hiện tại */
    .admin-product-form-page .col-lg-4 .rounded-3 {
        border-radius: 18px !important;
        border-color: #e1caaa !important;
        background:
            radial-gradient(circle at 80% 15%, rgba(242,193,92,.16), transparent 27%),
            linear-gradient(145deg,#fffdf8,#fff5e6);
    }

    /* ALERT */
    .admin-product-form-page .alert {
        border-radius: 15px;
        border-width: 1px;
        box-shadow: 0 8px 22px rgba(95,52,29,.055);
    }

    /* ACTIONS */
    .admin-product-form-page .btn {
        min-height: 44px;
        border-radius: 12px;
        font-weight: 800;
        transition:
            transform .16s ease,
            box-shadow .16s ease,
            filter .16s ease;
    }

    .admin-product-form-page .btn:hover {
        transform: translateY(-1px);
    }

    .admin-product-form-page .btn-tb {
        min-width: 170px;
        border: 0;
        background:
            linear-gradient(135deg,#a83b2d 0%,#5f341d 50%,#48633b 100%) !important;
        box-shadow: 0 10px 22px rgba(95,52,29,.17);
    }

    .admin-product-form-page .btn-tb:hover {
        background:
            linear-gradient(135deg,#b64637 0%,#6d4028 50%,#527148 100%) !important;
        box-shadow: 0 13px 28px rgba(95,52,29,.22);
    }

    .admin-product-form-page .btn-outline-secondary {
        border-color: #cdb493;
        color: #5f341d;
        background: rgba(255,255,255,.7);
    }

    .admin-product-form-page .btn-outline-secondary:hover,
    .admin-product-form-page .btn-secondary:hover {
        color: #fff;
        background: #5f341d;
        border-color: #5f341d;
    }

    /* Danger zone ở trang sửa */
    .admin-product-form-page .border-top {
        border-color: #ead8bf !important;
    }

    .admin-product-form-page .border-top h6.text-danger {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        background: #fff0ed;
        border: 1px solid #f0c5bd;
    }

    .admin-product-form-page .btn-outline-danger {
        border-radius: 12px;
        background: #fffafa;
    }

    /* nhỏ hơn trên tablet/mobile */
    @media (max-width: 991.98px) {
        .admin-product-form-page {
            padding-top: 22px;
        }

        .admin-product-form-page::after {
            display: none;
        }

        .admin-product-form-page .product-form-card {
            border-radius: 24px !important;
        }

        .admin-product-form-page .product-form-header {
            min-height: 155px;
            padding: 28px !important;
        }

        .admin-product-form-page .card-body {
            padding: 26px !important;
        }

        .admin-product-form-page .col-lg-8 {
            padding-right: calc(var(--bs-gutter-x) * .5);
        }

        .admin-product-form-page .col-lg-8::after {
            display: none;
        }

        .admin-product-form-page .col-lg-4 {
            padding-left: calc(var(--bs-gutter-x) * .5);
        }
    }

    @media (max-width: 575.98px) {
        .admin-product-form-page .product-form-card {
            border-radius: 20px !important;
        }

        .admin-product-form-page .product-form-header {
            min-height: 135px;
            padding: 24px 20px !important;
        }

        .admin-product-form-page .product-form-header h2 {
            font-size: 29px;
        }

        .admin-product-form-page .card-body {
            padding: 20px !important;
        }

        .admin-product-form-page .mt-4.d-flex {
            flex-direction: column-reverse;
        }

        .admin-product-form-page .mt-4.d-flex .btn {
            width: 100%;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .admin-product-form-page *,
        .admin-product-form-page *::before,
        .admin-product-form-page *::after {
            transition: none !important;
            animation: none !important;
        }
    }

</style>

<div class="admin-product-form-page"><div class="card product-form-card">
    <div class="product-form-header">
        <h2 class="mb-0">➕ Thêm Sản phẩm Mới</h2>
    </div>

    <div class="card-body p-4">

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <strong class="d-block mb-2">⚠️ Lỗi xảy ra:</strong>

                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>
            </div>
        @endif

        <form
            action="{{ route('admin.products.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="row g-4">

                <div class="col-lg-8">

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">
                            Tên sản phẩm <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Ví dụ: Thịt trâu gác bếp"
                            required
                            autofocus
                        >

                        @error('name')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-bold">
                            Danh mục <span class="text-danger">*</span>
                        </label>

                        <select
                            id="category_id"
                            name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror"
                            required
                        >
                            <option value="">-- Chọn danh mục --</option>

                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @selected(old('category_id') == $category->id)
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">
                            Mô tả
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            class="form-control @error('description') is-invalid @enderror"
                            rows="4"
                            placeholder="Mô tả đặc sản, nguồn gốc, cách dùng..."
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="unit" class="form-label fw-bold">
                                    Đơn vị bán <span class="text-danger">*</span>
                                </label>

                                <select
                                    id="unit"
                                    name="unit"
                                    class="form-select @error('unit') is-invalid @enderror"
                                    required
                                >
                                    <option value="kg" @selected(old('unit', 'kg') === 'kg')>kg</option>
                                    <option value="g" @selected(old('unit') === 'g')>g</option>
                                    <option value="gói" @selected(old('unit') === 'gói')>gói</option>
                                    <option value="túi" @selected(old('unit') === 'túi')>túi</option>
                                    <option value="hộp" @selected(old('unit') === 'hộp')>hộp</option>
                                    <option value="chai" @selected(old('unit') === 'chai')>chai</option>
                                    <option value="lọ" @selected(old('unit') === 'lọ')>lọ</option>
                                    <option value="bó" @selected(old('unit') === 'bó')>bó</option>
                                    <option value="sản phẩm" @selected(old('unit') === 'sản phẩm')>sản phẩm</option>
                                </select>

                                @error('unit')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label
                                    for="quantity"
                                    id="quantityLabel"
                                    class="form-label fw-bold"
                                >
                                    Tồn kho
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    id="quantity"
                                    name="quantity"
                                    class="form-control @error('quantity') is-invalid @enderror"
                                    value="{{ old('quantity', 0) }}"
                                    required
                                    min="0"
                                >

                                @error('quantity')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label
                                    for="price"
                                    id="priceLabel"
                                    class="form-label fw-bold"
                                >
                                    Giá / kg (VNĐ)
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="number"
                                    step="1000"
                                    id="price"
                                    name="price"
                                    class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price') }}"
                                    placeholder="Ví dụ: 600000"
                                    required
                                    min="0"
                                >

                                @error('price')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="min_quantity"
                                    id="minQuantityLabel"
                                    class="form-label fw-bold"
                                >
                                    Mua tối thiểu
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    id="min_quantity"
                                    name="min_quantity"
                                    class="form-control @error('min_quantity') is-invalid @enderror"
                                    value="{{ old('min_quantity', 0.25) }}"
                                    required
                                    min="0.01"
                                >

                                @error('min_quantity')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="quantity_step"
                                    id="quantityStepLabel"
                                    class="form-label fw-bold"
                                >
                                    Bước tăng
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    id="quantity_step"
                                    name="quantity_step"
                                    class="form-control @error('quantity_step') is-invalid @enderror"
                                    value="{{ old('quantity_step', 0.25) }}"
                                    required
                                    min="0.01"
                                >

                                @error('quantity_step')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="unit-help">
                        <strong>💡 Gợi ý:</strong>
                        <span id="unitHelpText">
                            Với sản phẩm bán theo kg, có thể đặt tối thiểu 0.25 kg
                            và bước tăng 0.25 kg.
                        </span>
                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">
                            Ảnh minh họa
                        </label>

                        <div
                            class="border rounded-3 p-3 text-center image-drop-area"
                            id="image-drop-area"
                        >
                            <div id="image-placeholder">
                                <div class="fs-3 mb-2">🖼️</div>
                                <p class="text-muted mb-0">
                                    Click hoặc kéo ảnh vào đây
                                </p>
                                <small class="text-muted d-block">
                                    PNG, JPG, GIF, SVG (Max 2MB)
                                </small>
                            </div>
                        </div>

                        <input
                            type="file"
                            id="image"
                            name="image"
                            class="form-control @error('image') is-invalid @enderror d-none"
                            accept="image/*"
                        >

                        <div id="image-preview" class="mt-2"></div>

                        @error('image')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

            </div>

            <div class="mt-4 d-flex justify-content-between gap-2">
                <a
                    href="{{ route('admin.products.index') }}"
                    class="btn btn-outline-secondary"
                >
                    ← Quay lại
                </a>

                <button type="submit" class="btn btn-tb">
                    💾 Thêm sản phẩm
                </button>
            </div>

        </form>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const unitSelect = document.getElementById('unit');
    const quantityLabel = document.getElementById('quantityLabel');
    const priceLabel = document.getElementById('priceLabel');
    const minQuantityLabel = document.getElementById('minQuantityLabel');
    const quantityStepLabel = document.getElementById('quantityStepLabel');

    const minInput = document.getElementById('min_quantity');
    const stepInput = document.getElementById('quantity_step');
    const quantityInput = document.getElementById('quantity');

    const unitHelpText = document.getElementById('unitHelpText');

    const fractionalUnits = ['kg', 'g'];

    function updateUnitUI(changeDefaults = true) {
        const unit = unitSelect.value;

        quantityLabel.innerHTML =
            `Tồn kho (${unit}) <span class="text-danger">*</span>`;

        priceLabel.innerHTML =
            `Giá / ${unit} (VNĐ) <span class="text-danger">*</span>`;

        minQuantityLabel.innerHTML =
            `Mua tối thiểu (${unit}) <span class="text-danger">*</span>`;

        quantityStepLabel.innerHTML =
            `Bước tăng (${unit}) <span class="text-danger">*</span>`;

        if (fractionalUnits.includes(unit)) {
            quantityInput.step = '0.01';
            minInput.step = '0.01';
            stepInput.step = '0.01';

            unitHelpText.textContent =
                `Sản phẩm bán theo ${unit} có thể mua số lẻ. Ví dụ: tối thiểu 0.25 ${unit}, tăng mỗi lần 0.25 ${unit}.`;

            if (changeDefaults) {
                minInput.value = '0.25';
                stepInput.value = '0.25';
            }
        } else {
            quantityInput.step = '1';
            minInput.step = '1';
            stepInput.step = '1';

            unitHelpText.textContent =
                `Sản phẩm bán theo ${unit} thường mua theo số nguyên: 1, 2, 3...`;

            if (changeDefaults) {
                minInput.value = '1';
                stepInput.value = '1';
            }
        }
    }

    unitSelect.addEventListener('change', function () {
        updateUnitUI(true);
    });

    updateUnitUI(false);

    const imageInput = document.getElementById('image');
    const dropArea = document.getElementById('image-drop-area');
    const preview = document.getElementById('image-preview');
    const placeholder = document.getElementById('image-placeholder');

    dropArea.addEventListener('click', () => imageInput.click());

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => {
            dropArea.style.backgroundColor = '#f8efe2';
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => {
            dropArea.style.backgroundColor = '#fffaf0';
        });
    });

    dropArea.addEventListener('drop', function (e) {
        const files = e.dataTransfer.files;

        if (files.length) {
            imageInput.files = files;
            handleImageSelection();
        }
    });

    imageInput.addEventListener('change', handleImageSelection);

    function handleImageSelection() {
        const file = imageInput.files[0];

        if (!file || !file.type.startsWith('image/')) {
            return;
        }

        const reader = new FileReader();

        reader.onload = function (e) {
            placeholder.style.display = 'none';

            preview.innerHTML =
                `<img src="${e.target.result}"
                    class="img-fluid rounded border"
                    alt="Ảnh xem trước"
                    style="max-height:220px;">`;
        };

        reader.readAsDataURL(file);
    }
});
</script>
@endpush

</div>

@endsection
