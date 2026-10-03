@extends('admin.layouts.app')

@section('title', 'Sửa Sản phẩm')

@section('content')

<style>
    .admin-product-form-page {
        padding: 28px 0 70px;
    }

    .product-form-card {
        overflow: hidden;
        border: 1px solid #e3cdae;
        border-radius: 26px;
        background: #fff;
        box-shadow: 0 22px 60px rgba(72, 43, 27, .10);
    }

    .product-form-header {
        position: relative;
        overflow: hidden;
        padding: 30px 34px;
        color: #fff;
        background:
            radial-gradient(
                circle at 90% 10%,
                rgba(242, 193, 92, .22),
                transparent 30%
            ),
            linear-gradient(
                135deg,
                #2d170e 0%,
                #633820 55%,
                #48633b 100%
            );
    }

    .product-form-header h2 {
        margin: 0;
        font-size: 30px;
        font-weight: 900;
    }

    .product-form-card .card-body {
        padding: 30px;
    }

    .form-label {
        margin-bottom: 8px;
        color: #51372a;
        font-size: 14px;
        font-weight: 800;
    }

    .form-control,
    .form-select {
        min-height: 52px;
        border: 1px solid #dfcbae;
        border-radius: 14px;
        color: #34251d;
        background: #fffcf7;
        box-shadow: none;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #d19b4b;
        background: #fff;
        box-shadow: 0 0 0 .2rem rgba(217, 119, 6, .08);
    }

    textarea.form-control {
        min-height: 145px;
        resize: vertical;
    }

    .unit-help {
        position: relative;
        overflow: hidden;
        padding: 16px 18px;
        border: 1px solid #e9cf9e;
        border-radius: 16px;
        color: #5f341d;
        background:
            radial-gradient(
                circle at 95% 10%,
                rgba(242, 193, 92, .15),
                transparent 28%
            ),
            linear-gradient(
                135deg,
                #fff9e7,
                #fff1c9
            );
    }

    .product-side {
        padding-left: 22px;
        border-left: 1px solid #ead8bf;
    }

    .main-image-box {
        min-height: 270px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 16px;
        border: 1px solid #e1caaa;
        border-radius: 20px;
        background:
            radial-gradient(
                circle at 80% 10%,
                rgba(242, 193, 92, .15),
                transparent 30%
            ),
            #fffaf2;
    }

    .main-image-box img {
        display: block;
        max-width: 100%;
        max-height: 240px;
        border-radius: 16px;
        object-fit: contain;
        box-shadow: 0 10px 25px rgba(95, 52, 29, .10);
    }

    .admin-gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        margin-top: 12px;
    }

    .admin-gallery-item {
        position: relative;
        overflow: hidden;
        aspect-ratio: 1 / 1;
        border: 1px solid #e3cdae;
        border-radius: 13px;
        background: #fffaf0;
        transition:
            opacity .18s ease,
            transform .18s ease;
    }

    .admin-gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .admin-gallery-item.is-deleting {
        opacity: .45;
        pointer-events: none;
    }

    .admin-gallery-remove {
        position: absolute;
        z-index: 3;
        top: 6px;
        right: 6px;
        min-height: 28px;
        padding: 4px 9px;
        border: 0;
        border-radius: 999px;
        color: #fff;
        background: rgba(164, 49, 38, .95);
        font-size: 10px;
        font-weight: 900;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(109, 30, 23, .22);
    }

    .admin-gallery-remove:hover {
        background: #8e261e;
    }

    .admin-gallery-remove:disabled {
        cursor: wait;
        opacity: .7;
    }

    .gallery-status {
        min-height: 20px;
        margin-top: 8px;
        font-size: 12px;
        font-weight: 700;
    }

    .btn-tb {
        min-width: 165px;
        min-height: 46px;
        border: 0;
        border-radius: 13px;
        color: #fff;
        background:
            linear-gradient(
                135deg,
                #a83b2d 0%,
                #633820 50%,
                #48633b 100%
            );
        font-weight: 900;
        box-shadow: 0 9px 20px rgba(95, 52, 29, .18);
    }

    .btn-tb:hover {
        color: #fff;
        filter: brightness(1.05);
    }

    .back-btn {
        min-height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 18px;
        border: 1px solid #ceb795;
        border-radius: 13px;
        color: #5f341d;
        background: #fff;
        font-weight: 800;
    }

    .back-btn:hover {
        color: #fff;
        border-color: #5f341d;
        background: #5f341d;
    }

    .delete-product-zone {
        margin-top: 30px;
        padding-top: 22px;
        border-top: 1px solid #ead8bf;
    }

    @media (max-width: 991.98px) {
        .product-side {
            margin-top: 10px;
            padding-left:
                calc(
                    var(--bs-gutter-x)
                    *
                    .5
                );
            border-left: 0;
        }
    }

    @media (max-width: 575.98px) {
        .admin-product-form-page {
            padding-top: 15px;
        }

        .product-form-card {
            border-radius: 19px;
        }

        .product-form-header {
            padding: 23px 20px;
        }

        .product-form-header h2 {
            font-size: 25px;
        }

        .product-form-card .card-body {
            padding: 20px;
        }

        .admin-gallery-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn,
        .form-actions .back-btn {
            width: 100%;
        }
    }
</style>


@php
    $unitOptions = [
        'kg',
        'g',
        'gói',
        'túi',
        'hộp',
        'chai',
        'lọ',
        'bó',
        'sản phẩm'
    ];

    $selectedUnit = old(
        'unit',
        $product->unit ?? 'sản phẩm'
    );

    $quantityValue = old(
        'quantity',
        (float) $product->quantity
    );

    $priceValue = old(
        'price',
        (float) $product->price
    );

    $minQuantityValue = old(
        'min_quantity',
        (float) ($product->min_quantity ?? 1)
    );

    $quantityStepValue = old(
        'quantity_step',
        (float) ($product->quantity_step ?? 1)
    );
@endphp


<div class="admin-product-form-page">

    <div class="card product-form-card">

        <div class="product-form-header">

            <h2>
                ✏️ Cập nhật Sản phẩm
            </h2>

        </div>


        <div class="card-body">

            @if($errors->any())

                <div class="alert alert-danger mb-4">

                    <strong class="d-block mb-2">
                        ⚠️ Vui lòng kiểm tra lại dữ liệu:
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
                action="{{ route('admin.products.update', $product) }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PUT')


                <div class="row g-4">


                    {{-- =====================================================
                        CỘT TRÁI
                    ====================================================== --}}

                    <div class="col-lg-8">


                        {{-- TÊN --}}

                        <div class="mb-3">

                            <label
                                for="name"
                                class="form-label"
                            >
                                Tên sản phẩm
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $product->name) }}"
                                required
                            >

                            @error('name')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- DANH MỤC --}}

                        <div class="mb-3">

                            <label
                                for="category_id"
                                class="form-label"
                            >
                                Danh mục
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                id="category_id"
                                name="category_id"
                                class="form-select @error('category_id') is-invalid @enderror"
                                required
                            >

                                <option value="">
                                    -- Chọn danh mục --
                                </option>

                                @foreach($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        @selected(old('category_id', $product->category_id) == $category->id)
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


                        {{-- MÔ TẢ --}}

                        <div class="mb-3">

                            <label
                                for="description"
                                class="form-label"
                            >
                                Mô tả
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="6"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Mô tả đặc sản, nguồn gốc, cách dùng..."
                            >{{ old('description', $product->description) }}</textarea>

                            @error('description')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- ĐƠN VỊ + TỒN KHO + GIÁ --}}

                        <div class="row g-3">

                            <div class="col-md-4">

                                <div class="mb-3">

                                    <label
                                        for="unit"
                                        class="form-label"
                                    >
                                        Đơn vị bán
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select
                                        id="unit"
                                        name="unit"
                                        class="form-select @error('unit') is-invalid @enderror"
                                        required
                                    >

                                        @foreach($unitOptions as $unit)

                                            <option
                                                value="{{ $unit }}"
                                                @selected($selectedUnit === $unit)
                                            >
                                                {{ $unit }}
                                            </option>

                                        @endforeach

                                    </select>

                                    @error('unit')

                                        <div class="invalid-feedback">
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
                                        class="form-label"
                                    >
                                        Tồn kho
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="number"
                                        id="quantity"
                                        name="quantity"
                                        step="any"
                                        min="0"
                                        class="form-control @error('quantity') is-invalid @enderror"
                                        value="{{ $quantityValue }}"
                                        required
                                    >

                                    @error('quantity')

                                        <div class="invalid-feedback">
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
                                        class="form-label"
                                    >
                                        Giá bán
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="number"
                                        id="price"
                                        name="price"
                                        step="1"
                                        min="0"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ $priceValue }}"
                                        required
                                    >

                                    @error('price')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>

                        </div>


                        {{-- MUA TỐI THIỂU + BƯỚC TĂNG --}}

                        <div class="row g-3">

                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label
                                        for="min_quantity"
                                        id="minQuantityLabel"
                                        class="form-label"
                                    >
                                        Mua tối thiểu
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="number"
                                        id="min_quantity"
                                        name="min_quantity"
                                        step="any"
                                        min="0.01"
                                        class="form-control @error('min_quantity') is-invalid @enderror"
                                        value="{{ $minQuantityValue }}"
                                        required
                                    >

                                    @error('min_quantity')

                                        <div class="invalid-feedback">
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
                                        class="form-label"
                                    >
                                        Bước tăng
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="number"
                                        id="quantity_step"
                                        name="quantity_step"
                                        step="any"
                                        min="0.01"
                                        class="form-control @error('quantity_step') is-invalid @enderror"
                                        value="{{ $quantityStepValue }}"
                                        required
                                    >

                                    @error('quantity_step')

                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>

                        </div>


                        <div class="unit-help">

                            <strong>
                                ⚖️ Quy cách bán:
                            </strong>

                            <span id="unitHelpText">
                            </span>

                        </div>

                    </div>


                    {{-- =====================================================
                        CỘT PHẢI
                    ====================================================== --}}

                    <div class="col-lg-4 product-side">


                        {{-- ẢNH CHÍNH --}}

                        <div class="mb-4">

                            <label
                                for="image"
                                class="form-label"
                            >
                                Ảnh minh họa sản phẩm
                            </label>

                            <input
                                type="file"
                                id="image"
                                name="image"
                                class="form-control @error('image') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                            >

                            @error('image')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror


                            <div
                                id="image-preview-box"
                                class="main-image-box mt-3"
                            >

                                @if($product->image && Storage::disk('public')->exists($product->image))

                                    <img
                                        src="{{ Storage::disk('public')->url($product->image) }}"
                                        alt="{{ $product->name }}"
                                    >

                                @else

                                    <div
                                        class="
                                            text-center
                                            fw-bold
                                        "
                                        style="color:#75523e;"
                                    >
                                        <div style="font-size:48px;">
                                            📷
                                        </div>

                                        <div class="mt-2">
                                            Chưa có ảnh sản phẩm
                                        </div>
                                    </div>

                                @endif

                            </div>

                        </div>


                        {{-- ẢNH CHI TIẾT --}}

                        <div
                            class="
                                mb-3
                                pt-3
                                border-top
                            "
                            style="border-color:#ead8bf !important;"
                        >

                            <label
                                for="gallery_images"
                                class="form-label"
                            >
                                Ảnh chi tiết sản phẩm
                            </label>


                            @if($product->images->isNotEmpty())

                                <div
                                    id="current-gallery-grid"
                                    class="admin-gallery-grid"
                                >

                                    @foreach($product->images as $galleryImage)

                                        <div
                                            class="admin-gallery-item"
                                            data-gallery-item="{{ $galleryImage->id }}"
                                        >

                                            <img
                                                src="{{ Storage::disk('public')->url($galleryImage->path) }}"
                                                alt="{{ $product->name }} - ảnh chi tiết {{ $loop->iteration }}"
                                            >

                                            <button
                                                type="button"
                                                class="admin-gallery-remove js-delete-gallery-image"
                                                data-delete-url="{{ route('admin.products.gallery.destroy', ['product' => $product->id, 'image' => $galleryImage->id]) }}"
                                                title="Xóa ảnh"
                                            >
                                                🗑 Xóa
                                            </button>

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <div
                                    id="no-gallery-message"
                                    class="
                                        small
                                        text-muted
                                        mb-2
                                    "
                                >
                                    Chưa có ảnh chi tiết.
                                </div>

                            @endif


                            <div
                                id="gallery-delete-status"
                                class="gallery-status"
                                aria-live="polite"
                            >
                            </div>


                            <input
                                type="file"
                                id="gallery_images"
                                name="gallery_images[]"
                                class="form-control mt-2 @error('gallery_images') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                multiple
                            >

                            <small class="text-muted d-block mt-2">
                                Thêm tối đa 8 ảnh chi tiết tổng cộng,
                                mỗi ảnh không quá 5MB.
                            </small>


                            <div
                                id="gallery-selection-status"
                                class="gallery-status"
                                aria-live="polite"
                            >
                            </div>


                            <div
                                id="gallery-preview-grid"
                                class="admin-gallery-grid"
                            >
                            </div>


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

                        </div>

                    </div>

                </div>


                {{-- ACTION --}}

                <div
                    class="
                        form-actions
                        mt-4
                        d-flex
                        gap-2
                        flex-wrap
                    "
                >

                    <button
                        type="submit"
                        class="btn btn-tb"
                    >
                        💾 Cập nhật
                    </button>

                    <a
                        href="{{ route('admin.products.index') }}"
                        class="back-btn"
                    >
                        ← Quay lại
                    </a>

                </div>

            </form>


            {{-- XÓA SẢN PHẨM --}}

            <div class="delete-product-zone">

                <h6 class="fw-bold text-danger mb-3">
                    Xóa sản phẩm này
                </h6>

                <form
                    action="{{ route('admin.products.destroy', $product) }}"
                    method="POST"
                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này? Hành động này không thể hoàn tác.');"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-outline-danger"
                    >
                        🗑 Xóa sản phẩm
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | ĐƠN VỊ + SỐ LƯỢNG
    |--------------------------------------------------------------------------
    */

    const unitSelect =
        document.getElementById('unit');

    const quantityLabel =
        document.getElementById('quantityLabel');

    const priceLabel =
        document.getElementById('priceLabel');

    const minQuantityLabel =
        document.getElementById('minQuantityLabel');

    const quantityStepLabel =
        document.getElementById('quantityStepLabel');

    const quantityInput =
        document.getElementById('quantity');

    const minInput =
        document.getElementById('min_quantity');

    const stepInput =
        document.getElementById('quantity_step');

    const unitHelpText =
        document.getElementById('unitHelpText');


    function updateUnitUI() {

        if (!unitSelect) {
            return;
        }

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


        /*
        |--------------------------------------------------------------------------
        | QUAN TRỌNG
        |--------------------------------------------------------------------------
        |
        | step="any" cho phép:
        |
        | 1
        | 1.2
        | 0.23
        | 2.57
        | 10.125
        |
        */

        quantityInput.step =
            'any';

        minInput.step =
            'any';

        stepInput.step =
            'any';


        unitHelpText.textContent =
            `Có thể nhập số nguyên hoặc số thập phân, ví dụ: 1, 1.2, 0.23, 2.5 ${unit}.`;

    }


    if (unitSelect) {

        unitSelect.addEventListener(
            'change',
            updateUnitUI
        );

        updateUnitUI();

    }


    /*
    |--------------------------------------------------------------------------
    | PREVIEW ẢNH CHÍNH
    |--------------------------------------------------------------------------
    */

    const imageInput =
        document.getElementById('image');

    const imagePreviewBox =
        document.getElementById('image-preview-box');


    if (
        imageInput
        &&
        imagePreviewBox
    ) {

        imageInput.addEventListener(
            'change',
            function () {

                const file =
                    this.files
                    &&
                    this.files[0];


                if (
                    !file
                    ||
                    !file.type.startsWith('image/')
                ) {
                    return;
                }


                const reader =
                    new FileReader();


                reader.onload =
                    function (event) {

                        imagePreviewBox.innerHTML =
                            `
                                <img
                                    src="${event.target.result}"
                                    alt="Ảnh sản phẩm mới"
                                >
                            `;

                    };


                reader.readAsDataURL(
                    file
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | XÓA ẢNH CHI TIẾT NGAY
    |--------------------------------------------------------------------------
    */

    const csrfToken =
        '{{ csrf_token() }}';

    const deleteStatus =
        document.getElementById(
            'gallery-delete-status'
        );


    document
        .querySelectorAll(
            '.js-delete-gallery-image'
        )
        .forEach(function (button) {

            button.addEventListener(
                'click',
                async function () {

                    const confirmed =
                        window.confirm(
                            'Bạn có chắc muốn xóa ảnh chi tiết này?'
                        );


                    if (!confirmed) {
                        return;
                    }


                    const item =
                        button.closest(
                            '.admin-gallery-item'
                        );

                    const deleteUrl =
                        button.dataset
                            .deleteUrl;

                    const oldText =
                        button.textContent;


                    button.disabled =
                        true;

                    button.textContent =
                        'Đang xóa...';


                    if (item) {

                        item.classList.add(
                            'is-deleting'
                        );

                    }


                    if (deleteStatus) {

                        deleteStatus.textContent =
                            'Đang xóa ảnh...';

                        deleteStatus.style.color =
                            '#746b65';

                    }


                    try {

                        const response =
                            await fetch(
                                deleteUrl,
                                {
                                    method:
                                        'DELETE',

                                    headers: {
                                        'X-CSRF-TOKEN':
                                            csrfToken,

                                        'X-Requested-With':
                                            'XMLHttpRequest',

                                        'Accept':
                                            'application/json'
                                    }
                                }
                            );


                        const data =
                            await response
                                .json()
                                .catch(function () {

                                    return {};

                                });


                        if (!response.ok) {

                            throw new Error(
                                data.message
                                ||
                                'Không thể xóa ảnh.'
                            );

                        }


                        if (item) {

                            item.remove();

                        }


                        if (deleteStatus) {

                            deleteStatus.textContent =
                                data.message
                                ||
                                'Đã xóa ảnh chi tiết.';

                            deleteStatus.style.color =
                                '#277344';

                        }


                        const galleryGrid =
                            document.getElementById(
                                'current-gallery-grid'
                            );


                        if (
                            galleryGrid
                            &&
                            !galleryGrid.querySelector(
                                '.admin-gallery-item'
                            )
                        ) {

                            galleryGrid.innerHTML =
                                `
                                    <div
                                        class="small text-muted"
                                        style="grid-column:1/-1;"
                                    >
                                        Chưa có ảnh chi tiết.
                                    </div>
                                `;

                        }

                    }
                    catch (error) {

                        button.disabled =
                            false;

                        button.textContent =
                            oldText;


                        if (item) {

                            item.classList.remove(
                                'is-deleting'
                            );

                        }


                        if (deleteStatus) {

                            deleteStatus.textContent =
                                error.message
                                ||
                                'Có lỗi khi xóa ảnh.';

                            deleteStatus.style.color =
                                '#b43e2e';

                        }

                    }

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | PREVIEW ẢNH CHI TIẾT MỚI
    |--------------------------------------------------------------------------
    */

    const galleryInput =
        document.getElementById(
            'gallery_images'
        );

    const galleryPreviewGrid =
        document.getElementById(
            'gallery-preview-grid'
        );

    const gallerySelectionStatus =
        document.getElementById(
            'gallery-selection-status'
        );


    if (
        galleryInput
        &&
        galleryPreviewGrid
        &&
        gallerySelectionStatus
    ) {

        galleryInput.addEventListener(
            'change',
            function () {

                const files =
                    Array.from(
                        this.files
                        ||
                        []
                    );


                galleryPreviewGrid.innerHTML =
                    '';


                if (!files.length) {

                    gallerySelectionStatus.textContent =
                        '';

                    return;

                }


                gallerySelectionStatus.textContent =
                    `Đã chọn ${files.length} ảnh mới. Ảnh sẽ được thêm khi bấm Cập nhật.`;

                gallerySelectionStatus.style.color =
                    '#277344';


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


                        const item =
                            document.createElement(
                                'div'
                            );


                        item.className =
                            'admin-gallery-item';


                        const image =
                            document.createElement(
                                'img'
                            );


                        image.alt =
                            `Ảnh mới ${index + 1}: ${file.name}`;


                        const objectUrl =
                            URL.createObjectURL(
                                file
                            );


                        image.src =
                            objectUrl;


                        image.onload =
                            function () {

                                URL.revokeObjectURL(
                                    objectUrl
                                );

                            };


                        item.appendChild(
                            image
                        );


                        galleryPreviewGrid.appendChild(
                            item
                        );

                    }
                );

            }
        );

    }

});
</script>

@endpush

@endsection