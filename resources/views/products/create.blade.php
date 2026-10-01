@extends('admin.layouts.app')

@section('title', 'Thêm Sản phẩm')

@section('content')

<style>
    .product-form-page {
        --brown: #5f341d;
        --green: #48633b;
        --red: #a83b2d;
        --gold: #e3ad4a;
        --border: #ead8bf;
        --ink: #35261d;
        --muted: #76685e;

        padding: 28px 0 48px;
    }

    .product-form-shell {
        overflow: hidden;
        border: 1px solid var(--border);
        border-radius: 26px;
        background: #fff;
        box-shadow: 0 18px 48px rgba(77,47,28,.09);
    }

    .product-form-hero {
        position: relative;
        overflow: hidden;

        padding: 32px 34px;

        color: #fff;

        background:
            radial-gradient(
                circle at 88% 12%,
                rgba(242,193,92,.22),
                transparent 28%
            ),
            linear-gradient(
                135deg,
                #2b170f,
                #5f341d 56%,
                #48633b
            );
    }

    .product-form-hero::after {
        content: "🌿";

        position: absolute;

        right: 34px;
        top: 8px;

        font-size: 90px;

        opacity: .08;

        transform: rotate(-12deg);
    }

    .product-form-eyebrow {
        color: #f6d88c;

        font-size: 11px;

        font-weight: 900;

        letter-spacing: .12em;

        text-transform: uppercase;
    }

    .product-form-hero h1 {
        position: relative;
        z-index: 2;

        margin: 7px 0 0;

        font-size:
            clamp(28px,3vw,40px);

        font-weight: 950;

        letter-spacing: -.04em;
    }

    .product-form-hero p {
        position: relative;
        z-index: 2;

        max-width: 700px;

        margin: 8px 0 0;

        color:
            rgba(255,255,255,.7);
    }

    .product-form-body {
        padding: 32px;

        background:
            radial-gradient(
                circle at 100% 0%,
                rgba(242,193,92,.06),
                transparent 25%
            ),
            #fff;
    }

    .form-section {
        padding: 22px;

        border:
            1px solid #eee0cd;

        border-radius: 18px;

        background:
            linear-gradient(
                180deg,
                #fff,
                #fffdf9
            );
    }

    .form-section + .form-section {
        margin-top: 18px;
    }

    .form-section-title {
        margin-bottom: 18px;

        color: var(--ink);

        font-size: 15px;

        font-weight: 900;
    }

    .form-label {
        color: #51372a;

        font-size: 13px;

        font-weight: 800;
    }

    .form-control,
    .form-select {
        min-height: 48px;

        border-color:
            #dfcbae;

        border-radius: 12px;

        background:
            #fffefb;
    }

    textarea.form-control {
        min-height: 135px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color:
            #cf9e5d;

        box-shadow:
            0 0 0 .2rem
            rgba(217,119,6,.08);
    }

    .unit-help {
        padding: 12px 14px;

        border:
            1px dashed #dfc397;

        border-radius: 12px;

        color: #70513a;

        background:
            #fff8e9;

        font-size: 12px;

        line-height: 1.6;
    }

    .upload-card {
        padding: 18px;

        border:
            1px dashed #d9bd94;

        border-radius: 16px;

        background:
            linear-gradient(
                180deg,
                #fffdf8,
                #fff8ec
            );
    }

    .upload-card-title {
        color: var(--ink);

        font-size: 14px;

        font-weight: 900;
    }

    .upload-note {
        margin-top: 5px;

        color: var(--muted);

        font-size: 11px;

        line-height: 1.55;
    }

    .main-preview {
        min-height: 230px;

        display: grid;

        place-items: center;

        margin-top: 14px;

        overflow: hidden;

        border:
            1px solid #ead8bf;

        border-radius: 15px;

        background: #fff;
    }

    .main-preview img {
        width: 100%;

        max-height: 300px;

        object-fit: contain;

        padding: 12px;
    }

    .main-preview-placeholder {
        color: #8a786c;

        text-align: center;

        font-size: 12px;
    }

    .main-preview-placeholder strong {
        display: block;

        margin-top: 7px;

        color: #684229;

        font-size: 14px;
    }

    .gallery-preview {
        display: grid;

        grid-template-columns:
            repeat(
                4,
                minmax(0,1fr)
            );

        gap: 10px;

        margin-top: 14px;
    }

    .gallery-preview-item {
        position: relative;

        aspect-ratio: 1 / 1;

        overflow: hidden;

        border:
            1px solid #ead8bf;

        border-radius: 12px;

        background: #fff;
    }

    .gallery-preview-item img {
        width: 100%;
        height: 100%;

        object-fit: cover;
    }

    .gallery-preview-index {
        position: absolute;

        right: 6px;
        bottom: 6px;

        min-width: 24px;
        height: 24px;

        display: grid;
        place-items: center;

        padding:
            0 6px;

        border-radius: 999px;

        color: #fff;

        background:
            rgba(46,31,22,.78);

        font-size: 10px;

        font-weight: 900;
    }

    .gallery-empty {
        grid-column:
            1 / -1;

        padding: 18px;

        border:
            1px dashed #e3ceb0;

        border-radius: 12px;

        color: #8b796c;

        text-align: center;

        font-size: 11px;
    }

    .form-actions {
        display: flex;

        flex-wrap: wrap;

        gap: 10px;

        margin-top: 24px;
    }

    .btn-save-product {
        min-height: 46px;

        padding:
            0 20px;

        border: 0;

        border-radius: 12px;

        color: #fff;

        background:
            linear-gradient(
                135deg,
                #a83b2d,
                #5f341d
            );

        font-weight: 900;

        box-shadow:
            0 10px 22px
            rgba(168,59,45,.18);
    }

    .btn-save-product:hover {
        color: #fff;

        transform:
            translateY(-1px);
    }

    @media (max-width: 991.98px) {

        .product-form-body {
            padding: 24px;
        }

        .gallery-preview {
            grid-template-columns:
                repeat(
                    3,
                    minmax(0,1fr)
                );
        }

    }

    @media (max-width: 575.98px) {

        .product-form-page {
            padding-top: 15px;
        }

        .product-form-shell {
            border-radius: 20px;
        }

        .product-form-hero,
        .product-form-body {
            padding:
                22px 18px;
        }

        .form-section {
            padding: 17px;
        }

        .gallery-preview {
            grid-template-columns:
                repeat(
                    2,
                    minmax(0,1fr)
                );
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn,
        .form-actions button {
            width: 100%;
        }

    }
</style>


<div class="product-form-page">

    <div class="product-form-shell">


        <div class="product-form-hero">

            <div class="product-form-eyebrow">
                Quản trị sản phẩm
            </div>

            <h1>
                Thêm đặc sản mới
            </h1>

            <p>

                Tạo sản phẩm mới,
                chọn ảnh đại diện
                và thêm tối đa 8 ảnh chi tiết
                để khách hàng
                có thể xem sản phẩm rõ hơn.

            </p>

        </div>


        <div class="product-form-body">


            @if($errors->any())

                <div class="alert alert-danger mb-4">

                    <strong class="d-block mb-2">
                        ⚠️ Vui lòng kiểm tra lại:
                    </strong>

                    <ul class="mb-0 ps-3">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                action="{{ route('admin.products.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                <div class="row g-4">


                    {{-- ============================
                        CỘT THÔNG TIN
                    ============================= --}}
                    <div class="col-lg-8">


                        <div class="form-section">

                            <div class="form-section-title">
                                Thông tin cơ bản
                            </div>


                            <div class="mb-3">

                                <label
                                    for="name"
                                    class="form-label"
                                >
                                    Tên sản phẩm

                                    <span class="text-danger">
                                        *
                                    </span>
                                </label>


                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="
                                        form-control
                                        @error('name')
                                            is-invalid
                                        @enderror
                                    "
                                    value="{{ old('name') }}"
                                    placeholder="Ví dụ: Thịt trâu gác bếp Sơn La"
                                    required
                                    autofocus
                                >


                                @error('name')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            <div class="mb-3">

                                <label
                                    for="category_id"
                                    class="form-label"
                                >
                                    Danh mục

                                    <span class="text-danger">
                                        *
                                    </span>
                                </label>


                                <select
                                    id="category_id"
                                    name="category_id"
                                    class="
                                        form-select
                                        @error('category_id')
                                            is-invalid
                                        @enderror
                                    "
                                    required
                                >

                                    <option value="">
                                        -- Chọn danh mục --
                                    </option>


                                    @foreach(
                                        $categories
                                        as
                                        $category
                                    )

                                        <option
                                            value="{{ $category->id }}"
                                            @selected(
                                                old('category_id')
                                                ==
                                                $category->id
                                            )
                                        >
                                            {{ $category->name }}
                                        </option>

                                    @endforeach

                                </select>


                                @error('category_id')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>


                            <div>

                                <label
                                    for="description"
                                    class="form-label"
                                >
                                    Mô tả sản phẩm
                                </label>


                                <textarea
                                    id="description"
                                    name="description"
                                    class="
                                        form-control
                                        @error('description')
                                            is-invalid
                                        @enderror
                                    "
                                    rows="6"
                                    placeholder="Nguồn gốc, hương vị, cách sử dụng, bảo quản..."
                                >{{ old('description') }}</textarea>


                                @error('description')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>


                        <div class="form-section">

                            <div class="form-section-title">
                                Giá bán &amp; quy cách
                            </div>


                            <div class="row g-3">


                                <div class="col-md-4">

                                    <label
                                        for="unit"
                                        class="form-label"
                                    >
                                        Đơn vị bán

                                        <span class="text-danger">
                                            *
                                        </span>
                                    </label>


                                    <select
                                        id="unit"
                                        name="unit"
                                        class="
                                            form-select
                                            @error('unit')
                                                is-invalid
                                            @enderror
                                        "
                                        required
                                    >

                                        <option
                                            value="kg"
                                            @selected(
                                                old(
                                                    'unit',
                                                    'kg'
                                                )
                                                ===
                                                'kg'
                                            )
                                        >
                                            kg
                                        </option>

                                        <option
                                            value="g"
                                            @selected(
                                                old('unit')
                                                ===
                                                'g'
                                            )
                                        >
                                            g
                                        </option>

                                        <option
                                            value="gói"
                                            @selected(
                                                old('unit')
                                                ===
                                                'gói'
                                            )
                                        >
                                            gói
                                        </option>

                                        <option
                                            value="túi"
                                            @selected(
                                                old('unit')
                                                ===
                                                'túi'
                                            )
                                        >
                                            túi
                                        </option>

                                        <option
                                            value="hộp"
                                            @selected(
                                                old('unit')
                                                ===
                                                'hộp'
                                            )
                                        >
                                            hộp
                                        </option>

                                        <option
                                            value="chai"
                                            @selected(
                                                old('unit')
                                                ===
                                                'chai'
                                            )
                                        >
                                            chai
                                        </option>

                                        <option
                                            value="lọ"
                                            @selected(
                                                old('unit')
                                                ===
                                                'lọ'
                                            )
                                        >
                                            lọ
                                        </option>

                                        <option
                                            value="bó"
                                            @selected(
                                                old('unit')
                                                ===
                                                'bó'
                                            )
                                        >
                                            bó
                                        </option>

                                        <option
                                            value="sản phẩm"
                                            @selected(
                                                old('unit')
                                                ===
                                                'sản phẩm'
                                            )
                                        >
                                            sản phẩm
                                        </option>

                                    </select>


                                    @error('unit')

                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                <div class="col-md-4">

                                    <label
                                        for="quantity"
                                        id="quantityLabel"
                                        class="form-label"
                                    >
                                        Tồn kho

                                        <span class="text-danger">
                                            *
                                        </span>
                                    </label>


                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        id="quantity"
                                        name="quantity"
                                        class="
                                            form-control
                                            @error('quantity')
                                                is-invalid
                                            @enderror
                                        "
                                        value="{{ old('quantity', 0) }}"
                                        required
                                    >


                                    @error('quantity')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                <div class="col-md-4">

                                    <label
                                        for="price"
                                        id="priceLabel"
                                        class="form-label"
                                    >
                                        Giá bán

                                        <span class="text-danger">
                                            *
                                        </span>
                                    </label>


                                    <input
                                        type="number"
                                        step="1000"
                                        min="0"
                                        id="price"
                                        name="price"
                                        class="
                                            form-control
                                            @error('price')
                                                is-invalid
                                            @enderror
                                        "
                                        value="{{ old('price') }}"
                                        placeholder="Ví dụ: 350000"
                                        required
                                    >


                                    @error('price')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>


                            <div class="row g-3 mt-1">


                                <div class="col-md-6">

                                    <label
                                        for="min_quantity"
                                        id="minQuantityLabel"
                                        class="form-label"
                                    >
                                        Mua tối thiểu

                                        <span class="text-danger">
                                            *
                                        </span>
                                    </label>


                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0.01"
                                        id="min_quantity"
                                        name="min_quantity"
                                        class="
                                            form-control
                                            @error('min_quantity')
                                                is-invalid
                                            @enderror
                                        "
                                        value="{{
                                            old(
                                                'min_quantity',
                                                0.25
                                            )
                                        }}"
                                        required
                                    >


                                    @error('min_quantity')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                <div class="col-md-6">

                                    <label
                                        for="quantity_step"
                                        id="quantityStepLabel"
                                        class="form-label"
                                    >
                                        Bước tăng

                                        <span class="text-danger">
                                            *
                                        </span>
                                    </label>


                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0.01"
                                        id="quantity_step"
                                        name="quantity_step"
                                        class="
                                            form-control
                                            @error('quantity_step')
                                                is-invalid
                                            @enderror
                                        "
                                        value="{{
                                            old(
                                                'quantity_step',
                                                0.25
                                            )
                                        }}"
                                        required
                                    >


                                    @error('quantity_step')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>


                            <div class="unit-help mt-3">

                                <strong>
                                    💡 Quy cách bán:
                                </strong>

                                <span id="unitHelpText">
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- ============================
                        CỘT HÌNH ẢNH
                    ============================= --}}
                    <div class="col-lg-4">

                        <div class="form-section">

                            <div class="form-section-title">
                                Hình ảnh sản phẩm
                            </div>


                            {{-- ẢNH ĐẠI DIỆN --}}
                            <div class="upload-card mb-3">

                                <div class="upload-card-title">
                                    Ảnh đại diện
                                </div>


                                <div class="upload-note">

                                    Ảnh chính hiển thị
                                    trên danh sách sản phẩm.

                                    JPG, PNG, WEBP · tối đa 5MB.

                                </div>


                                <input
                                    type="file"
                                    id="image"
                                    name="image"
                                    class="
                                        form-control
                                        mt-3
                                        @error('image')
                                            is-invalid
                                        @enderror
                                    "
                                    accept="
                                        image/jpeg,
                                        image/png,
                                        image/webp
                                    "
                                >


                                @error('image')

                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>

                                @enderror


                                <div
                                    class="main-preview"
                                    id="mainImagePreview"
                                >

                                    <div class="main-preview-placeholder">

                                        <div style="font-size:42px;">
                                            🖼️
                                        </div>

                                        <strong>
                                            Chưa chọn ảnh đại diện
                                        </strong>

                                    </div>

                                </div>

                            </div>


                            {{-- GALLERY --}}
                            <div class="upload-card">

                                <div
                                    class="
                                        d-flex
                                        justify-content-between
                                        align-items-start
                                        gap-2
                                    "
                                >

                                    <div>

                                        <div class="upload-card-title">
                                            Ảnh chi tiết
                                        </div>

                                        <div class="upload-note">

                                            Chọn nhiều ảnh cùng lúc.

                                            Tối đa 8 ảnh,
                                            mỗi ảnh tối đa 5MB.

                                        </div>

                                    </div>


                                    <span
                                        class="
                                            badge
                                            rounded-pill
                                            text-bg-light
                                            border
                                        "
                                        id="galleryCountBadge"
                                    >
                                        0/8
                                    </span>

                                </div>


                                <input
                                    type="file"
                                    id="gallery_images"
                                    name="gallery_images[]"
                                    class="
                                        form-control
                                        mt-3

                                        @error('gallery_images')
                                            is-invalid
                                        @enderror

                                        @error('gallery_images.*')
                                            is-invalid
                                        @enderror
                                    "
                                    accept="
                                        image/jpeg,
                                        image/png,
                                        image/webp
                                    "
                                    multiple
                                >


                                @error('gallery_images')

                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>

                                @enderror


                                @error('gallery_images.*')

                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>

                                @enderror


                                <div
                                    class="gallery-preview"
                                    id="galleryPreview"
                                >

                                    <div class="gallery-empty">
                                        Chưa chọn ảnh chi tiết.
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="form-actions">

                    <button
                        type="submit"
                        class="
                            btn
                            btn-save-product
                        "
                    >
                        💾 Lưu sản phẩm
                    </button>


                    <a
                        href="{{
                            route(
                                'admin.products.index'
                            )
                        }}"
                        class="
                            btn
                            btn-outline-secondary
                            px-4
                        "
                    >
                        ← Quay lại
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>


@push('scripts')

<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | QUY CÁCH BÁN
        |--------------------------------------------------------------------------
        */

        const unitSelect =
            document.getElementById(
                'unit'
            );

        const quantityLabel =
            document.getElementById(
                'quantityLabel'
            );

        const priceLabel =
            document.getElementById(
                'priceLabel'
            );

        const minQuantityLabel =
            document.getElementById(
                'minQuantityLabel'
            );

        const quantityStepLabel =
            document.getElementById(
                'quantityStepLabel'
            );

        const quantityInput =
            document.getElementById(
                'quantity'
            );

        const minInput =
            document.getElementById(
                'min_quantity'
            );

        const stepInput =
            document.getElementById(
                'quantity_step'
            );

        const unitHelpText =
            document.getElementById(
                'unitHelpText'
            );


        const fractionalUnits = [
            'kg',
            'g'
        ];


        function updateUnitUI() {

            const unit =
                unitSelect.value;


            quantityLabel.innerHTML =
                `Tồn kho (${unit}) <span class="text-danger">*</span>`;


            priceLabel.innerHTML =
                `Giá / ${unit} (VNĐ) <span class="text-danger">*</span>`;


            minQuantityLabel.innerHTML =
                `Mua tối thiểu (${unit}) <span class="text-danger">*</span>`;


            quantityStepLabel.innerHTML =
                `Bước tăng (${unit}) <span class="text-danger">*</span>`;


            if (
                fractionalUnits.includes(
                    unit
                )
            ) {

                quantityInput.step = '0.01';
                minInput.step = '0.01';
                stepInput.step = '0.01';


                unitHelpText.textContent =
                    `Sản phẩm bán theo ${unit} có thể dùng số lẻ như 0.25, 0.5, 0.75...`;

            }
            else {

                quantityInput.step = '1';
                minInput.step = '1';
                stepInput.step = '1';


                unitHelpText.textContent =
                    `Sản phẩm bán theo ${unit} thường dùng số lượng 1, 2, 3...`;

            }

        }


        unitSelect.addEventListener(
            'change',
            updateUnitUI
        );


        updateUnitUI();


        /*
        |--------------------------------------------------------------------------
        | PREVIEW ẢNH ĐẠI DIỆN
        |--------------------------------------------------------------------------
        */

        const mainInput =
            document.getElementById(
                'image'
            );

        const mainPreview =
            document.getElementById(
                'mainImagePreview'
            );


        mainInput.addEventListener(
            'change',
            function () {

                const file =
                    this.files
                    &&
                    this.files[0];


                if (
                    !file
                    ||
                    !file.type.startsWith(
                        'image/'
                    )
                ) {

                    mainPreview.innerHTML = `
                        <div class="main-preview-placeholder">

                            <div style="font-size:42px;">
                                🖼️
                            </div>

                            <strong>
                                Chưa chọn ảnh đại diện
                            </strong>

                        </div>
                    `;

                    return;
                }


                const reader =
                    new FileReader();


                reader.onload =
                    function (event) {

                        mainPreview.innerHTML = `
                            <img
                                src="${event.target.result}"
                                alt="Preview ảnh đại diện"
                            >
                        `;

                    };


                reader.readAsDataURL(
                    file
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | PREVIEW GALLERY
        |--------------------------------------------------------------------------
        */

        const galleryInput =
            document.getElementById(
                'gallery_images'
            );

        const galleryPreview =
            document.getElementById(
                'galleryPreview'
            );

        const galleryCountBadge =
            document.getElementById(
                'galleryCountBadge'
            );


        galleryInput.addEventListener(
            'change',
            function () {

                const files =
                    Array.from(
                        this.files || []
                    );


                if (files.length > 8) {

                    alert(
                        'Mỗi sản phẩm chỉ được chọn tối đa 8 ảnh chi tiết.'
                    );


                    this.value = '';


                    renderGallery([]);

                    return;
                }


                renderGallery(
                    files
                );

            }
        );


        function renderGallery(files) {

            galleryCountBadge.textContent =
                `${files.length}/8`;


            if (!files.length) {

                galleryPreview.innerHTML = `
                    <div class="gallery-empty">
                        Chưa chọn ảnh chi tiết.
                    </div>
                `;

                return;
            }


            galleryPreview.innerHTML =
                '';


            files.forEach(
                function (
                    file,
                    index
                ) {

                    if (
                        !file.type.startsWith(
                            'image/'
                        )
                    ) {
                        return;
                    }


                    const reader =
                        new FileReader();


                    reader.onload =
                        function (event) {

                            const item =
                                document.createElement(
                                    'div'
                                );


                            item.className =
                                'gallery-preview-item';


                            item.innerHTML = `
                                <img
                                    src="${event.target.result}"
                                    alt="Ảnh chi tiết ${index + 1}"
                                >

                                <span class="gallery-preview-index">
                                    ${index + 1}
                                </span>
                            `;


                            galleryPreview
                                .appendChild(
                                    item
                                );

                        };


                    reader.readAsDataURL(
                        file
                    );

                }
            );

        }

    }
);
</script>

@endpush

@endsection