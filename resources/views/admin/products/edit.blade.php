@extends('admin.layouts.app')

@section('title', 'Sửa Sản phẩm')

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

    .image-preview-box {
        background: #fffaf0;
        border: 1px solid #ead8bf;
        border-radius: 14px;
        min-height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
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
            ✏️ Cập nhật Sản phẩm
        </h2>

    </div>


    <div class="card-body p-4">

        {{-- ==========================================
            LỖI
        =========================================== --}}
        @if ($errors->any())

            <div class="alert alert-danger mb-4">

                <strong class="d-block mb-2">
                    ⚠️ Vui lòng kiểm tra lại dữ liệu:
                </strong>

                <ul class="mb-0 ps-3">

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- ==========================================
            FORM UPDATE
        =========================================== --}}
        <form
            action="{{ route('admin.products.update', $product) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')


            <div class="row g-4">


                {{-- ==================================
                    CỘT TRÁI
                =================================== --}}
                <div class="col-lg-8">


                    {{-- TÊN --}}
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
                                        old(
                                            'category_id',
                                            $product->category_id
                                        )
                                        == $category->id
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
                        >{{ old(
                            'description',
                            $product->description
                        ) }}</textarea>


                        @error('description')

                            <div class="invalid-feedback">
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


                                @php
                                    $selectedUnit = old(
                                        'unit',
                                        $product->unit
                                        ?? 'sản phẩm'
                                    );
                                @endphp


                                <select
                                    id="unit"
                                    name="unit"
                                    class="form-select
                                    @error('unit') is-invalid @enderror"
                                    required
                                >

                                    @foreach([
                                        'kg',
                                        'g',
                                        'gói',
                                        'túi',
                                        'hộp',
                                        'chai',
                                        'lọ',
                                        'bó',
                                        'sản phẩm'
                                    ] as $unit)

                                        <option
                                            value="{{ $unit }}"
                                            @selected(
                                                $selectedUnit === $unit
                                            )
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



                        {{-- TỒN KHO --}}
                        <div class="col-md-4">

                            <div class="mb-3">

                                <label
                                    for="quantity"
                                    id="quantityLabel"
                                    class="form-label fw-bold"
                                >
                                    Tồn kho

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
                                    value="{{ old(
                                        'quantity',
                                        $product->quantity
                                    ) }}"
                                    min="0"
                                    step="0.01"
                                    required
                                >


                                @error('quantity')

                                    <div class="invalid-feedback">
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
                                    Giá bán

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
                                    value="{{ old(
                                        'price',
                                        $product->price
                                    ) }}"
                                    min="0"
                                    step="1000"
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
                                    Mua tối thiểu

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
                                    value="{{ old(
                                        'min_quantity',
                                        $product->min_quantity ?? 1
                                    ) }}"
                                    min="0.01"
                                    step="0.01"
                                    required
                                >


                                @error('min_quantity')

                                    <div class="invalid-feedback">
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
                                    Bước tăng

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
                                    value="{{ old(
                                        'quantity_step',
                                        $product->quantity_step ?? 1
                                    ) }}"
                                    min="0.01"
                                    step="0.01"
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
                                    value="{{ old('sale_price', $product->sale_price) }}"
                                    min="0"
                                    step="1000"
                                    placeholder="Để trống để tắt giảm giá"
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
                                    value="{{ old('sale_start', $product->sale_start?->format('Y-m-d\\TH:i')) }}"
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
                                    value="{{ old('sale_end', $product->sale_end?->format('Y-m-d\\TH:i')) }}"
                                >
                                @error('sale_end')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <small class="text-muted d-block mt-2">
                            Xóa giá khuyến mãi rồi cập nhật để tắt chương trình giảm giá.
                        </small>
                    </div>


                    {{-- GỢI Ý --}}
                    <div class="unit-help">

                        <strong>
                            💡 Quy cách bán:
                        </strong>

                        <span id="unitHelpText">
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
                            Ảnh minh họa sản phẩm
                        </label>


                        <input
                            type="file"
                            id="image"
                            name="image"
                            class="form-control
                            @error('image') is-invalid @enderror"
                            accept="image/*"
                        >


                        <div
                            id="image-preview-box"
                            class="image-preview-box
                            mt-3 p-3 text-center"
                        >

                            @if(
                                $product->image
                                &&
                                Storage::disk('public')
                                    ->exists($product->image)
                            )

                                <img
                                    id="current-product-image"
                                    src="{{
                                        Storage::disk('public')
                                            ->url($product->image)
                                    }}"
                                    alt="{{ $product->name }}"
                                    class="img-fluid rounded"
                                    style="max-height:220px;"
                                >

                            @else

                                <div
                                    id="current-product-image-fallback"
                                    class="fw-bold"
                                    style="
                                        color:#5f341d;
                                        font-size:18px;
                                    "
                                >
                                    🧺 Chưa có ảnh sản phẩm
                                </div>

                            @endif

                        </div>


                        @error('image')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>

            </div>



            {{-- ==========================================
                BUTTON
            =========================================== --}}
            <div class="mt-4 d-flex gap-2 flex-wrap">

                <button
                    type="submit"
                    class="btn btn-tb"
                >
                    💾 Cập nhật
                </button>


                <a
                    href="{{ route('admin.products.index') }}"
                    class="btn btn-secondary"
                >
                    ← Quay lại
                </a>

            </div>

        </form>



        {{-- ==========================================
            XÓA
        =========================================== --}}
        <div class="mt-4 pt-3 border-top">

            <h6 class="fw-bold text-danger mb-2">
                Xóa sản phẩm này
            </h6>


            <form
                action="{{ route(
                    'admin.products.destroy',
                    $product
                ) }}"
                method="POST"
                onsubmit="
                    return confirm(
                        'Bạn có chắc chắn muốn xóa sản phẩm này? Hành động này không thể hoàn tác.'
                    );
                "
            >

                @csrf
                @method('DELETE')


                <button
                    type="submit"
                    class="btn btn-outline-danger"
                >
                    🗑️ Xóa sản phẩm
                </button>

            </form>

        </div>

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
        // INPUT
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
        // XỬ LÝ ĐƠN VỊ
        // ==========================================

        function updateUnitUI(
            changeDefault = false
        ) {

            const unit =
                unitSelect.value;


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
            // KG
            // ======================================

            if (unit === 'kg') {

                quantityInput.min = '0';
                quantityInput.step = '0.01';


                minInput.min = '0.01';
                minInput.step = '0.01';


                stepInput.min = '0.01';
                stepInput.step = '0.01';


                /*
                 * Chỉ đổi giá trị mặc định
                 * khi Admin chủ động đổi đơn vị.
                 *
                 * Khi vừa vào trang edit,
                 * KHÔNG ghi đè dữ liệu DB.
                 */
                if (changeDefault) {

                    minInput.value = '0.1';

                    stepInput.value = '0.1';

                }


                unitHelpText.innerHTML =
                    `Bán theo <strong>kg</strong>:
                    có thể mua số lẻ như
                    0.1kg, 0.25kg,
                    0.5kg, 1.5kg...
                    Admin có thể tự chọn
                    bước tăng.`;

            }



            // ======================================
            // GAM
            // ======================================

            else if (unit === 'g') {

                quantityInput.min = '0';
                quantityInput.step = '1';


                /*
                 * QUAN TRỌNG:
                 *
                 * min phải là 1
                 * chứ không được là 0.01.
                 *
                 * Nếu min=0.01 + step=1
                 * trình duyệt sẽ chỉ nhận:
                 *
                 * 0.01
                 * 1.01
                 * 2.01
                 *
                 * Đây chính là lỗi trước đó.
                 */
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
                    có thể đặt 50g,
                    100g, 200g,
                    250g...`;

            }



            // ======================================
            // HỘP / GÓI / TÚI / CHAI / LỌ / BÓ
            // SẢN PHẨM
            // ======================================

            else {

                quantityInput.min = '0';
                quantityInput.step = '1';


                /*
                 * Đây là phần sửa lỗi chính.
                 *
                 * min = 1
                 * step = 1
                 *
                 * Nên browser nhận:
                 *
                 * 1
                 * 2
                 * 3
                 * 4
                 */
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
                    1 ${unit},
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

                updateUnitUI(true);

            }
        );



        /*
         * Khi vừa vào Edit:
         *
         * false = giữ nguyên dữ liệu
         * đang có trong database.
         */
        updateUnitUI(false);



        // ==========================================
        // PREVIEW ẢNH
        // ==========================================

        const imageInput =
            document.getElementById('image');

        const previewBox =
            document.getElementById(
                'image-preview-box'
            );


        if (imageInput) {

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
                        !file.type.startsWith(
                            'image/'
                        )
                    ) {

                        return;

                    }


                    const reader =
                        new FileReader();


                    reader.onload =
                        function (e) {

                            previewBox.innerHTML =
                                `
                                <img
                                    src="${e.target.result}"
                                    alt="Preview ảnh mới"
                                    class="img-fluid rounded"
                                    style="
                                        max-height:220px;
                                    "
                                >
                                `;

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