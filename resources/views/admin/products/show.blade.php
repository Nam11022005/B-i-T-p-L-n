@extends('admin.layouts.app')

@section('title', 'Chi tiết Sản phẩm')

@section('content')

<style>
    .product-detail-card {
        border: 1px solid #ead8bf;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 28px rgba(95, 52, 29, 0.08);
    }

    .product-detail-header {
        background: linear-gradient(
            90deg,
            #5f341d 0%,
            #48633b 100%
        );
        color: white;
        padding: 18px 22px;
    }

    .info-box {
        background: #fffaf0;
        border: 1px solid #ead8bf;
        border-radius: 14px;
        padding: 16px;
        height: 100%;
    }

    .info-label {
        color: #7a6a5f;
        font-size: 14px;
        margin-bottom: 5px;
        display: block;
    }

    .price-text {
        color: #a83b2d;
        font-weight: 800;
    }

    .stock-text {
        color: #48633b;
        font-weight: 800;
    }

    .unit-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 999px;
        background: #f8efe2;
        color: #5f341d;
        border: 1px solid #ead8bf;
        font-weight: 700;
    }

    .product-image {
        width: 100%;
        max-height: 430px;
        object-fit: contain;
        border-radius: 18px;
        background: #fffaf0;
        border: 1px solid #ead8bf;
        padding: 10px;
    }

    .no-image {
        height: 320px;
        border-radius: 18px;
        background: linear-gradient(
            135deg,
            #fffaf0,
            #f8efe2
        );
        border: 1px solid #ead8bf;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
    }
</style>

<div class="card product-detail-card">

    {{-- HEADER --}}
    <div
        class="product-detail-header
        d-flex justify-content-between
        align-items-center flex-wrap gap-2"
    >

        <h2 class="mb-0">
            📦 Chi tiết sản phẩm:
            {{ $product->name }}
        </h2>

        <a
            href="{{ route('admin.products.index') }}"
            class="btn btn-light btn-sm"
        >
            ← Quay lại danh sách
        </a>

    </div>


    <div class="card-body p-4">

        <div class="row g-4">

            {{-- ======================================
                ẢNH SẢN PHẨM
            ======================================= --}}
            <div class="col-lg-6">

                @if(
                    $product->image
                    && Storage::disk('public')->exists(
                        $product->image
                    )
                )

                    <div class="text-center">

                        <img
                            src="{{ Storage::disk('public')->url(
                                $product->image
                            ) }}"
                            alt="{{ $product->name }}"
                            class="product-image"
                        >

                    </div>

                @else

                    <div class="no-image">
                        🧺
                    </div>

                @endif

            </div>


            {{-- ======================================
                THÔNG TIN SẢN PHẨM
            ======================================= --}}
            <div class="col-lg-6">

                <div class="row g-3">

                    {{-- ID --}}
                    <div class="col-12">

                        <div class="info-box">

                            <span class="info-label">
                                ID sản phẩm
                            </span>

                            <strong class="fs-5">
                                #{{ $product->id }}
                            </strong>

                        </div>

                    </div>


                    {{-- TÊN --}}
                    <div class="col-12">

                        <div class="info-box">

                            <span class="info-label">
                                Tên sản phẩm
                            </span>

                            <strong class="fs-5">
                                {{ $product->name }}
                            </strong>

                        </div>

                    </div>


                    {{-- DANH MỤC --}}
                    <div class="col-12">

                        <div class="info-box">

                            <span class="info-label">
                                Danh mục
                            </span>

                            <span
                                class="badge fs-6"
                                style="
                                    background:#48633b;
                                    color:white;
                                "
                            >
                                {{
                                    $product->category->name
                                    ?? 'Chưa phân loại'
                                }}
                            </span>

                        </div>

                    </div>


                    {{-- ĐƠN VỊ BÁN --}}
                    <div class="col-md-6">

                        <div class="info-box">

                            <span class="info-label">
                                Đơn vị bán
                            </span>

                            <span class="unit-badge">
                                {{ $product->unit ?? 'sản phẩm' }}
                            </span>

                        </div>

                    </div>


                    {{-- TỒN KHO --}}
                    <div class="col-md-6">

                        <div class="info-box">

                            <span class="info-label">
                                Tồn kho
                            </span>

                            <strong
                                class="fs-5
                                {{
                                    $product->quantity > 0
                                    ? 'stock-text'
                                    : 'text-danger'
                                }}"
                            >

                                {{
                                    rtrim(
                                        rtrim(
                                            number_format(
                                                $product->quantity,
                                                2,
                                                '.',
                                                ''
                                            ),
                                            '0'
                                        ),
                                        '.'
                                    )
                                }}

                                {{ $product->unit ?? 'sản phẩm' }}

                            </strong>

                        </div>

                    </div>


                    {{-- GIÁ --}}
                    <div class="col-12">

                        <div class="info-box">

                            <span class="info-label">
                                Đơn giá
                            </span>

                            <div class="d-flex align-items-end gap-2">

                                <strong class="fs-4 price-text">

                                    {{
                                        number_format(
                                            $product->price,
                                            0,
                                            ',',
                                            '.'
                                        )
                                    }} đ

                                </strong>

                                <span class="text-muted mb-1">
                                    /
                                    {{ $product->unit ?? 'sản phẩm' }}
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- MUA TỐI THIỂU --}}
                    <div class="col-md-6">

                        <div class="info-box">

                            <span class="info-label">
                                Mua tối thiểu
                            </span>

                            <strong class="fs-5">

                                {{
                                    rtrim(
                                        rtrim(
                                            number_format(
                                                $product->min_quantity ?? 1,
                                                2,
                                                '.',
                                                ''
                                            ),
                                            '0'
                                        ),
                                        '.'
                                    )
                                }}

                                {{ $product->unit ?? 'sản phẩm' }}

                            </strong>

                        </div>

                    </div>


                    {{-- BƯỚC TĂNG --}}
                    <div class="col-md-6">

                        <div class="info-box">

                            <span class="info-label">
                                Bước tăng mỗi lần mua
                            </span>

                            <strong class="fs-5">

                                {{
                                    rtrim(
                                        rtrim(
                                            number_format(
                                                $product->quantity_step ?? 1,
                                                2,
                                                '.',
                                                ''
                                            ),
                                            '0'
                                        ),
                                        '.'
                                    )
                                }}

                                {{ $product->unit ?? 'sản phẩm' }}

                            </strong>

                        </div>

                    </div>


                    {{-- MÔ TẢ --}}
                    <div class="col-12">

                        <div class="info-box">

                            <span class="info-label">
                                Mô tả
                            </span>

                            <p
                                class="mb-0"
                                style="
                                    white-space:pre-line;
                                    line-height:1.7;
                                "
                            >
                                {{
                                    $product->description
                                    ?? 'Không có mô tả'
                                }}
                            </p>

                        </div>

                    </div>


                    {{-- NGÀY TẠO --}}
                    <div class="col-md-6">

                        <div class="info-box">

                            <span class="info-label">
                                Ngày tạo
                            </span>

                            <small class="fw-bold">

                                {{
                                    $product->created_at
                                    ? $product->created_at
                                        ->format('d/m/Y H:i')
                                    : 'N/A'
                                }}

                            </small>

                        </div>

                    </div>


                    {{-- CẬP NHẬT --}}
                    <div class="col-md-6">

                        <div class="info-box">

                            <span class="info-label">
                                Cập nhật lần cuối
                            </span>

                            <small class="fw-bold">

                                {{
                                    $product->updated_at
                                    ? $product->updated_at
                                        ->format('d/m/Y H:i')
                                    : 'N/A'
                                }}

                            </small>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <hr class="my-4">


        {{-- ======================================
            NÚT THAO TÁC
        ======================================= --}}
        <div class="d-flex gap-2 flex-wrap">

            <a
                href="{{ route(
                    'admin.products.edit',
                    $product
                ) }}"
                class="btn btn-warning"
            >
                ✏️ Sửa sản phẩm
            </a>


            <form
                action="{{ route(
                    'admin.products.destroy',
                    $product
                ) }}"
                method="POST"
                class="d-inline"
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
                    class="btn btn-danger"
                >
                    🗑️ Xóa sản phẩm
                </button>

            </form>


            <a
                href="{{ route('admin.products.index') }}"
                class="btn btn-secondary"
            >
                ← Quay lại
            </a>

        </div>

    </div>

</div>

@endsection