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
        background: linear-gradient(
            90deg,
            #5f341d 0%,
            #48633b 100%
        );
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
        background: linear-gradient(
            135deg,
            #48633b,
            #2f4b2b
        );
        color: #fff;
    }

    .btn-tb:hover {
        color: #fff;
        background: linear-gradient(
            135deg,
            #3e5634,
            #253d22
        );
    }
</style>


<div class="card product-form-card">

    {{-- HEADER --}}
    <div class="product-form-header">

        <h2 class="mb-0">
            ➕ Thêm Sản phẩm Mới
        </h2>

    </div>


    <div class="card-body p-4">

        {{-- ==========================================
            HIỂN THỊ LỖI
        =========================================== --}}
        @if ($errors->any())

            <div
                class="alert alert-danger
                alert-dismissible fade show mb-4"
            >

                <strong class="d-block mb-2">
                    ⚠️ Lỗi xảy ra:
                </strong>

                <ul class="mb-0 ps-3">

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                >
                </button>

            </div>

        @endif


        {{-- ==========================================
            FORM THÊM SẢN PHẨM
        =========================================== --}}
        <form
            action="{{ route('admin.products.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="row g-4">


                {{-- ==================================
                    CỘT TRÁI
                =================================== --}}
                <div class="col-lg-8">


                    {{-- TÊN SẢN PHẨM --}}
                    <div class="mb-3">

                        <label
                            for="name"
                            class="form-label fw-bold"
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
                            class="form-control
                            @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Ví dụ: Thịt trâu gác bếp Sơn La"
                            required
                            autofocus
                        >


                        @error('name')

                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    {{-- DANH MỤC --}}
                    <div class="mb-3">

                        <label
                            for="category_id"
                            class="form-label fw-bold"
                        >
                            Danh mục

                            <span class="text-danger">
                                *
                            </span>
                        </label>


                        <select
                            id="category_id"
                            name="category_id"
                            class="form-select
                            @error('category_id') is-invalid @enderror"
                            required
                        >

                            <option value="">
                                -- Chọn danh mục --
                            </option>


                            @foreach ($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    @selected(
                                        old('category_id')
                                        == $category->id
                                    )
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



                    {{-- MÔ TẢ --}}
                    <div class="mb-3">

                        <label
                            for="description"
                            class="form-label fw-bold"
                        >
                            Mô tả
                        </label>


                        <textarea
                            id="description"
                            name="description"
                            class="form-control
                            @error('description') is-invalid @enderror"
                            rows="4"
                            placeholder="Mô tả đặc sản, nguồn gốc, cách sử dụng..."
                        >{{ old('description') }}</textarea>


                        @error('description')

                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    {{-- ==================================
                        ĐƠN VỊ - TỒN KHO - GIÁ
                    =================================== --}}
                    <div class="row g-3">


                        {{-- ĐƠN VỊ --}}
                        <div class="col-md-4">

                            <div class="mb-3">

                                <label
                                    for="unit"
                                    class="form-label fw-bold"
                                >
                                    Đơn vị bán

                                    <span class="text-danger">
                                        *
                                    </span>
                                </label>


                                <select
                                    id="unit"
                                    name="unit"
                                    class="form-select
                                    @error('unit') is-invalid @enderror"
                                    required
                                >

                                    <option
                                        value="kg"
                                        @selected(
                                            old('unit', 'kg') === 'kg'
                                        )
                                    >
                                        kg
                                    </option>


                                    <option
                                        value="g"
                                        @selected(
                                            old('unit') === 'g'
                                        )
                                    >
                                        g
                                    </option>


                                    <option
                                        value="gói"
                                        @selected(
                                            old('unit') === 'gói'
                                        )
                                    >
                                        gói
                                    </option>


                                    <option
                                        value="túi"
                                        @selected(
                                            old('unit') === 'túi'
                                        )
                                    >
                                        túi
                                    </option>


                                    <option
                                        value="hộp"
                                        @selected(
                                            old('unit') === 'hộp'
                                        )
                                    >
                                        hộp
                                    </option>


                                    <option
                                        value="chai"
                                        @selected(
                                            old('unit') === 'chai'
                                        )
                                    >
                                        chai
                                    </option>


                                    <option
                                        value="lọ"
                                        @selected(
                                            old('unit') === 'lọ'
                                        )
                                    >
                                        lọ
                                    </option>


                                    <option
                                        value="bó"
                                        @selected(
                                            old('unit') === 'bó'
                                        )
                                    >
                                        bó
                                    </option>


                                    <option
                                        value="sản phẩm"
                                        @selected(
                                            old('unit') === 'sản phẩm'
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

                        </div>



                        {{-- TỒN KHO --}}
                        <div class="col-md-4">

                            <div class="mb-3">

                                <label
                                    for="quantity"
                                    id="quantityLabel"
                                    class="form-label fw-bold"
                                >
                                    Tồn kho (kg)

                                    <span class="text-danger">
                                        *
                                    </span>
                                </label>


                                <input
                                    type="number"
                                    id="quantity"
                                    name="quantity"
                                    class="form-control
                                    @error('quantity') is-invalid @enderror"
                                    value="{{ old('quantity', 0) }}"
                                    min="0"
                                    step="0.01"
                                    required
                                >


                                @error('quantity')

                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>



                        {{-- GIÁ --}}
                        <div class="col-md-4">

                            <div class="mb-3">

                                <label
                                    for="price"
                                    id="priceLabel"
                                    class="form-label fw-bold"
                                >
                                    Giá / kg (VNĐ)

                                    <span class="text-danger">
                                        *
                                    </span>
                                </label>


                                <input
                                    type="number"
                                    id="price"
                                    name="price"
                                    class="form-control
                                    @error('price') is-invalid @enderror"
                                    value="{{ old('price') }}"
                                    placeholder="Ví dụ: 600000"
                                    min="0"
                                    step="1000"
                                    required
                                >


                                @error('price')

                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                    </div>



                    {{-- ==================================
                        MUA TỐI THIỂU + BƯỚC TĂNG
                    =================================== --}}
                    <div class="row g-3">


                        {{-- MUA TỐI THIỂU --}}
                        <div class="col-md-6">

                            <div class="mb-3">

                                <label
                                    for="min_quantity"
                                    id="minQuantityLabel"
                                    class="form-label fw-bold"
                                >
                                    Mua tối thiểu (kg)

                                    <span class="text-danger">
                                        *
                                    </span>
                                </label>


                                <input
                                    type="number"
                                    id="min_quantity"
                                    name="min_quantity"
                                    class="form-control
                                    @error('min_quantity') is-invalid @enderror"
                                    value="{{ old('min_quantity', 0.1) }}"
                                    min="0.01"
                                    step="0.01"
                                    required
                                >


                                @error('min_quantity')

                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>



                        {{-- BƯỚC TĂNG --}}
                        <div class="col-md-6">

                            <div class="mb-3">

                                <label
                                    for="quantity_step"
                                    id="quantityStepLabel"
                                    class="form-label fw-bold"
                                >
                                    Bước tăng (kg)

                                    <span class="text-danger">
                                        *
                                    </span>
                                </label>


                                <input
                                    type="number"
                                    id="quantity_step"
                                    name="quantity_step"
                                    class="form-control
                                    @error('quantity_step') is-invalid @enderror"
                                    value="{{ old('quantity_step', 0.1) }}"
                                    min="0.01"
                                    step="0.01"
                                    required
                                >


                                @error('quantity_step')

                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>

                                @enderror

                            </div>

                        </div>

                    </div>




                    {{-- ==================================
                        KHUYẾN MÃI
                    =================================== --}}
                    <div class="mt-4 p-3 rounded-4 border" style="background:#fffaf0;border-color:#ead8bf !important;">
                        <h5 class="fw-bold mb-3" style="color:#a83b2d;">
                            🔥 Thiết lập khuyến mãi
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="sale_price" class="form-label fw-bold">
                                    Giá khuyến mãi (VNĐ)
                                </label>
                                <input
                                    type="number"
                                    id="sale_price"
                                    name="sale_price"
                                    class="form-control @error('sale_price') is-invalid @enderror"
                                    value="{{ old('sale_price') }}"
                                    min="0"
                                    step="1000"
                                    placeholder="Để trống nếu không giảm giá"
                                >
                                @error('sale_price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="sale_start" class="form-label fw-bold">
                                    Bắt đầu
                                </label>
                                <input
                                    type="datetime-local"
                                    id="sale_start"
                                    name="sale_start"
                                    class="form-control @error('sale_start') is-invalid @enderror"
                                    value="{{ old('sale_start') }}"
                                >
                                @error('sale_start')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="sale_end" class="form-label fw-bold">
                                    Kết thúc
                                </label>
                                <input
                                    type="datetime-local"
                                    id="sale_end"
                                    name="sale_end"
                                    class="form-control @error('sale_end') is-invalid @enderror"
                                    value="{{ old('sale_end') }}"
                                >
                                @error('sale_end')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <small class="text-muted d-block mt-2">
                            Nếu nhập giá khuyến mãi nhưng để trống thời gian,
                            chương trình giảm giá có hiệu lực ngay và không giới hạn ngày kết thúc.
                        </small>
                    </div>


                    {{-- GỢI Ý QUY CÁCH --}}
                    <div class="unit-help">

                        <strong>
                            💡 Quy cách bán:
                        </strong>

                        <span id="unitHelpText">
                            Sản phẩm bán theo kg có thể
                            nhập số lượng thập phân.
                        </span>

                    </div>

                </div>



                {{-- ==================================
                    CỘT PHẢI - ẢNH
                =================================== --}}
                <div class="col-lg-4">

                    <div class="mb-3">

                        <label
                            for="image"
                            class="form-label fw-bold"
                        >
                            Ảnh minh họa
                        </label>


                        <div
                            class="border rounded-3
                            p-3 text-center
                            image-drop-area"
                            id="image-drop-area"
                        >

                            <div id="image-placeholder">

                                <div class="fs-3 mb-2">
                                    🖼️
                                </div>

                                <p class="text-muted mb-0">
                                    Click hoặc kéo ảnh vào đây
                                </p>

                                <small class="text-muted d-block">
                                    PNG, JPG, GIF, SVG
                                    (Max 2MB)
                                </small>

                            </div>

                        </div>


                        <input
                            type="file"
                            id="image"
                            name="image"
                            class="form-control
                            @error('image') is-invalid @enderror
                            d-none"
                            accept="image/*"
                        >


                        <div
                            id="image-preview"
                            class="mt-2"
                        >
                        </div>


                        @error('image')

                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>

            </div>



            {{-- ==========================================
                NÚT
            =========================================== --}}
            <div
                class="mt-4
                d-flex justify-content-between
                gap-2"
            >

                <a
                    href="{{ route('admin.products.index') }}"
                    class="btn btn-outline-secondary"
                >
                    ← Quay lại
                </a>


                <button
                    type="submit"
                    class="btn btn-tb"
                >
                    💾 Thêm sản phẩm
                </button>

            </div>

        </form>

    </div>

</div>



{{-- ==========================================
    JAVASCRIPT
=========================================== --}}
@push('scripts')

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        // ==========================================
        // LẤY CÁC Ô INPUT
        // ==========================================

        const unitSelect =
            document.getElementById('unit');

        const quantityInput =
            document.getElementById('quantity');

        const minInput =
            document.getElementById('min_quantity');

        const stepInput =
            document.getElementById('quantity_step');


        const quantityLabel =
            document.getElementById('quantityLabel');

        const priceLabel =
            document.getElementById('priceLabel');

        const minQuantityLabel =
            document.getElementById('minQuantityLabel');

        const quantityStepLabel =
            document.getElementById('quantityStepLabel');

        const unitHelpText =
            document.getElementById('unitHelpText');


        // ==========================================
        // THAY ĐỔI LOGIC THEO ĐƠN VỊ
        // ==========================================

        function updateUnitUI(changeDefault = true) {

            const unit = unitSelect.value;


            // Đổi tên label theo đơn vị
            quantityLabel.innerHTML =
                `Tồn kho (${unit})
                <span class="text-danger">*</span>`;


            priceLabel.innerHTML =
                `Giá / ${unit} (VNĐ)
                <span class="text-danger">*</span>`;


            minQuantityLabel.innerHTML =
                `Mua tối thiểu (${unit})
                <span class="text-danger">*</span>`;


            quantityStepLabel.innerHTML =
                `Bước tăng (${unit})
                <span class="text-danger">*</span>`;



            // ======================================
            // 1. BÁN THEO KG
            // ======================================

            if (unit === 'kg') {

                /*
                 * Tồn kho có thể:
                 * 10
                 * 10.5
                 * 20.25
                 */
                quantityInput.step = '0.01';


                /*
                 * Admin có thể nhập:
                 * 0.1
                 * 0.2
                 * 0.25
                 * 0.5
                 * ...
                 */
                minInput.min = '0.01';
                minInput.step = '0.01';

                stepInput.min = '0.01';
                stepInput.step = '0.01';


                if (changeDefault) {

                    minInput.value = '0.1';

                    stepInput.value = '0.1';

                }


                unitHelpText.innerHTML =
                    `Bán theo <strong>kg</strong>:
                    có thể nhập số lẻ như
                    <strong>0.1kg, 0.25kg,
                    0.5kg, 1.5kg...</strong>.
                    Bạn có thể tự nhập bước tăng.`;

            }



            // ======================================
            // 2. BÁN THEO GAM
            // ======================================

            else if (unit === 'g') {

                /*
                 * Gam thường sử dụng số nguyên.
                 */
                quantityInput.step = '1';


                minInput.min = '1';
                minInput.step = '1';

                stepInput.min = '1';
                stepInput.step = '1';


                if (changeDefault) {

                    minInput.value = '50';

                    stepInput.value = '50';

                }


                unitHelpText.innerHTML =
                    `Bán theo <strong>g</strong>:
                    mặc định tăng
                    <strong>50g</strong>.
                    Admin có thể đổi thành
                    100g, 200g, 250g...`;

            }



            // ======================================
            // 3. HỘP / GÓI / TÚI / CHAI / LỌ / BÓ
            // ======================================

            else {

                /*
                 * Những sản phẩm này không mua:
                 * 0.5 hộp
                 * 1.5 chai
                 * 0.25 gói
                 *
                 * Mà chỉ:
                 * 1, 2, 3...
                 */
                quantityInput.step = '1';


                minInput.min = '1';
                minInput.step = '1';

                stepInput.min = '1';
                stepInput.step = '1';


                if (changeDefault) {

                    minInput.value = '1';

                    stepInput.value = '1';

                }


                unitHelpText.innerHTML =
                    `Bán theo
                    <strong>${unit}</strong>:
                    số lượng tăng theo
                    <strong>1 ${unit}</strong>,
                    ví dụ:
                    1, 2, 3, 4...`;

            }

        }



        // ==========================================
        // KHI ADMIN ĐỔI ĐƠN VỊ
        // ==========================================

        unitSelect.addEventListener(
            'change',
            function () {

                /*
                 * true:
                 * tự thay min_quantity
                 * và quantity_step
                 * theo loại đơn vị mới.
                 */
                updateUnitUI(true);

            }
        );


        /*
         * Khi trang vừa mở:
         * chỉ cập nhật label/step,
         * KHÔNG ghi đè dữ liệu old()
         * nếu Laravel vừa validate lỗi.
         */
        updateUnitUI(false);



        // ==========================================
        // XỬ LÝ ẢNH
        // ==========================================

        const imageInput =
            document.getElementById('image');

        const dropArea =
            document.getElementById(
                'image-drop-area'
            );

        const preview =
            document.getElementById(
                'image-preview'
            );

        const placeholder =
            document.getElementById(
                'image-placeholder'
            );


        // Click chọn ảnh
        dropArea.addEventListener(
            'click',
            function () {

                imageInput.click();

            }
        );



        // ==========================================
        // DRAG & DROP
        // ==========================================

        [
            'dragenter',
            'dragover',
            'dragleave',
            'drop'

        ].forEach(function (eventName) {

            dropArea.addEventListener(
                eventName,
                function (e) {

                    e.preventDefault();

                    e.stopPropagation();

                }
            );

        });



        [
            'dragenter',
            'dragover'

        ].forEach(function (eventName) {

            dropArea.addEventListener(
                eventName,
                function () {

                    dropArea.style.backgroundColor =
                        '#f8efe2';

                }
            );

        });



        [
            'dragleave',
            'drop'

        ].forEach(function (eventName) {

            dropArea.addEventListener(
                eventName,
                function () {

                    dropArea.style.backgroundColor =
                        '#fffaf0';

                }
            );

        });



        // ==========================================
        // THẢ ẢNH
        // ==========================================

        dropArea.addEventListener(
            'drop',
            function (e) {

                const files =
                    e.dataTransfer.files;


                if (files.length) {

                    imageInput.files =
                        files;


                    handleImageSelection();

                }

            }
        );



        // ==========================================
        // CHỌN ẢNH
        // ==========================================

        imageInput.addEventListener(
            'change',
            handleImageSelection
        );



        // ==========================================
        // PREVIEW ẢNH
        // ==========================================

        function handleImageSelection() {

            const file =
                imageInput.files[0];


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
                function (e) {

                    placeholder.style.display =
                        'none';


                    preview.innerHTML =
                        `
                        <img
                            src="${e.target.result}"
                            class="img-fluid
                            rounded border"
                            alt="Ảnh xem trước"
                            style="
                                max-height:220px;
                            "
                        >
                        `;

                };


            reader.readAsDataURL(file);

        }

    }
);

</script>

@endpush

@endsection 