@extends('layouts.app')

@section('title', $product->name . ' | Tinh Hoa Tây Bắc')

@section('content')

<style>
    .product-detail-card {
        border: 1px solid #ead8bf;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 12px 32px rgba(95,52,29,.08);
    }

    .product-image-wrapper {
        background: linear-gradient(180deg,#fffaf0,#f8efe2);
        border-radius: 18px;
        overflow: hidden;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image {
        width: 100%;
        max-height: 480px;
        object-fit: contain;
        padding: 18px;
    }

    .no-image {
        min-height: 400px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        font-size: 18px;
    }

    .price-box {
        background: #fffaf0;
        border: 1px solid #ead8bf;
        border-radius: 16px;
    }

    .price-main {
        color: #a83b2d;
        font-size: 32px;
        font-weight: 800;
    }

    .admin-box {
        background: #fff8e1;
        border: 1px solid #ffe69c;
        border-radius: 14px;
        padding: 16px;
    }

    .buy-box {
        border: 1px solid #ead8bf;
        border-radius: 18px;
        padding: 20px;
        background: #fff;
    }

    .quantity-control {
        display: flex;
        align-items: stretch;
        max-width: 310px;
    }

    .quantity-control button {
        width: 52px;
        border: 1px solid #d8c5ac;
        background: #f8efe2;
        font-size: 22px;
        font-weight: 800;
        color: #5f341d;
    }

    .quantity-control input {
        width: 150px;
        border-left: 0;
        border-right: 0;
        border-radius: 0;
        text-align: center;
        font-weight: 800;
    }

    .quantity-control button:first-child {
        border-radius: 10px 0 0 10px;
    }

    .quantity-control button:last-child {
        border-radius: 0 10px 10px 0;
    }

    .live-total {
        color: #a83b2d;
        font-size: 28px;
        font-weight: 900;
    }

    .btn-tb {
        border: 0;
        color: #fff;
        background: linear-gradient(135deg,#a83b2d,#5f341d);
    }

    .btn-tb:hover {
        color: #fff;
        background: linear-gradient(135deg,#8b3025,#3b2114);
    }

    /* =========================
       ĐÁNH GIÁ SẢN PHẨM
    ========================== */
    .review-section {
        margin-top: 28px;
        border: 1px solid #ead8bf;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 12px 32px rgba(95,52,29,.06);
        overflow: hidden;
    }

    .review-summary {
        background: linear-gradient(135deg,#fffaf0,#f8efe2);
        border: 1px solid #ead8bf;
        border-radius: 16px;
        padding: 22px;
    }

    .rating-number {
        color: #a83b2d;
        font-size: 42px;
        line-height: 1;
        font-weight: 900;
    }

    .star-display {
        color: #f59e0b;
        letter-spacing: 2px;
        font-size: 22px;
    }

    .review-form-box {
        border: 1px solid #ead8bf;
        border-radius: 16px;
        padding: 22px;
        background: #fffdf9;
    }

    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 5px;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        margin: 0;
        color: #d6d3d1;
        font-size: 34px;
        cursor: pointer;
        transition: .15s;
    }

    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label {
        color: #f59e0b;
    }

    .review-item {
        padding: 20px 0;
        border-bottom: 1px solid #eee2d3;
    }

    .review-item:last-child {
        border-bottom: 0;
    }

    /* =========================
       NỘI DUNG CHI TIẾT + SẢN PHẨM TƯƠNG TỰ
    ========================== */
    .product-content-section,
    .related-section {
        margin-top: 28px;
        border: 1px solid #ead8bf;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 12px 32px rgba(95,52,29,.06);
        overflow: hidden;
    }

    .product-content-title {
        color: #5f341d;
        font-weight: 900;
        border-bottom: 2px solid #f2c15c;
        padding-bottom: 14px;
        margin-bottom: 22px;
    }

    .product-long-description {
        color: #4b5563;
        line-height: 1.95;
        font-size: 17px;
        white-space: pre-line;
    }

    .purchase-benefits {
        display: grid;
        grid-template-columns: repeat(2, minmax(0,1fr));
        gap: 10px;
        margin-top: 16px;
    }

    .purchase-benefit {
        background: #fffaf0;
        border: 1px solid #ead8bf;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 14px;
        font-weight: 700;
        color: #5f341d;
    }

    .related-card {
        height: 100%;
        border: 1px solid #ead8bf;
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .related-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(95,52,29,.12);
    }

    .related-image-wrap {
        height: 190px;
        background: #fffaf0;
        overflow: hidden;
        position: relative;
    }

    .related-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .related-name {
        color: #2f241e;
        text-decoration: none;
        font-weight: 800;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 48px;
    }

    .related-name:hover { color: #a83b2d; }

    @media (max-width: 767.98px) {
        .purchase-benefits { grid-template-columns: 1fr; }
        .product-image-wrapper { min-height: 300px; }
    }

    .review-avatar {
        width: 44px;
        height: 44px;
        flex: 0 0 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
        background: linear-gradient(135deg,#5f341d,#48633b);
        font-weight: 900;
    }


    /* =========================
       PRODUCT HERO - BỐ CỤC MUA HÀNG MỚI
    ========================== */
    .product-detail-card {
        border-radius: 26px;
        border: 1px solid #ead8bf;
        background: #fff;
        box-shadow: 0 18px 50px rgba(95,52,29,.09);
    }

    .product-image-wrapper {
        position: sticky;
        top: 155px;
        min-height: 520px;
        border: 1px solid #f0dfc9;
        background:
            radial-gradient(circle at top right, rgba(242,193,92,.18), transparent 35%),
            linear-gradient(180deg,#fffdf8,#fff8ec);
    }

    .product-image {
        max-height: 520px;
        padding: 26px;
    }

    .product-category-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 13px;
        border: 1px solid #ead8bf;
        border-radius: 999px;
        background: #fff8ec;
        color: #6b3a20;
        font-size: 14px;
        font-weight: 800;
    }

    .product-title-new {
        color: #2f241e;
        font-size: clamp(30px,3vw,43px);
        line-height: 1.15;
        font-weight: 900;
        letter-spacing: -.5px;
    }

    .rating-row-new {
        padding-bottom: 15px;
        border-bottom: 1px solid #f0e4d5;
    }

    .product-short-description {
        color: #655b55;
        line-height: 1.8;
        font-size: 15px;
    }

    .commerce-panel {
        overflow: hidden;
        border: 1px solid #ead8bf;
        border-radius: 20px;
        background: #fffdf9;
    }

    .commerce-price {
        padding: 20px 22px;
        background:
            radial-gradient(circle at right top, rgba(242,193,92,.18), transparent 36%),
            linear-gradient(135deg,#fffaf0,#f8efe2);
    }

    .sale-old-price {
        color: #8b817b;
        font-size: 15px;
        text-decoration: line-through;
    }

    .sale-badge-new {
        display: inline-block;
        margin-left: 8px;
        padding: 4px 8px;
        border-radius: 8px;
        background: #a83b2d;
        color: #fff;
        font-size: 12px;
        font-weight: 900;
    }

    .stock-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        border-radius: 999px;
        background: #eef7ea;
        color: #35612e;
        font-size: 13px;
        font-weight: 800;
    }

    .stock-pill.out {
        background: #fff0ee;
        color: #a83b2d;
    }

    .benefit-strip {
        display: grid;
        grid-template-columns: repeat(3,minmax(0,1fr));
        border-top: 1px solid #ead8bf;
        border-bottom: 1px solid #ead8bf;
        background: #fff;
    }

    .benefit-strip-item {
        padding: 13px 10px;
        text-align: center;
        color: #5f341d;
        font-size: 13px;
        font-weight: 800;
        border-right: 1px solid #eee2d3;
    }

    .benefit-strip-item:last-child {
        border-right: 0;
    }

    .purchase-area {
        padding: 20px 22px 22px;
    }

    .purchase-label {
        color: #3b2b22;
        font-size: 15px;
        font-weight: 900;
    }

    .quantity-control-new {
        display: inline-flex;
        overflow: hidden;
        border: 1px solid #d8c5ac;
        border-radius: 12px;
        background: #fff;
    }

    .quantity-control-new button {
        width: 48px;
        height: 48px;
        border: 0;
        background: #f8efe2;
        color: #5f341d;
        font-size: 21px;
        font-weight: 900;
    }

    .quantity-control-new input {
        width: 115px;
        height: 48px;
        border: 0;
        border-left: 1px solid #e4d4c0;
        border-right: 1px solid #e4d4c0;
        outline: 0;
        text-align: center;
        font-weight: 900;
    }

    .order-total-new {
        padding: 14px 16px;
        border-radius: 14px;
        background: #fff7e8;
        border: 1px dashed #e2bd75;
    }

    .btn-cart-new {
        min-height: 52px;
        border: 0;
        border-radius: 13px;
        background: linear-gradient(135deg,#a83b2d,#6d291f);
        color: #fff;
        font-weight: 900;
    }

    .btn-cart-new:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 9px 20px rgba(168,59,45,.2);
    }

    .trust-grid-new {
        display: grid;
        grid-template-columns: repeat(2,minmax(0,1fr));
        gap: 10px;
        margin-top: 14px;
    }

    .trust-item-new {
        padding: 11px 12px;
        border: 1px solid #eee2d3;
        border-radius: 12px;
        background: #fff;
        color: #5f341d;
        font-size: 13px;
        font-weight: 700;
    }

    .product-facts {
        display: grid;
        grid-template-columns: repeat(3,minmax(0,1fr));
        gap: 12px;
        margin-top: 18px;
    }

    .product-fact {
        padding: 13px 14px;
        border: 1px solid #eee2d3;
        border-radius: 13px;
        background: #fffdf9;
    }

    .product-fact small {
        display: block;
        margin-bottom: 3px;
        color: #8a817b;
    }

    .product-fact strong {
        color: #493126;
    }

    @media (max-width: 991.98px) {
        .product-image-wrapper {
            position: relative;
            top: auto;
            min-height: 390px;
        }
    }

    @media (max-width: 575.98px) {
        .benefit-strip {
            grid-template-columns: 1fr;
        }
        .benefit-strip-item {
            border-right: 0;
            border-bottom: 1px solid #eee2d3;
        }
        .benefit-strip-item:last-child {
            border-bottom: 0;
        }
        .trust-grid-new,
        .product-facts {
            grid-template-columns: 1fr;
        }
    }


    .sold-pill-new {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #fff3e5;
        border: 1px solid #f0cf9d;
        color: #a34a22;
        font-size: 13px;
        font-weight: 900;
    }

</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <a
                    href="{{ route('products.index') }}"
                    class="btn btn-outline-secondary"
                >
                    ← Quay lại danh sách đặc sản
                </a>

                @if(Auth::check() && Auth::user()->role === 'admin')
                    <div class="d-flex gap-2 flex-wrap">
                        <a
                            href="{{ route('admin.products.edit', $product) }}"
                            class="btn btn-warning"
                        >
                            ✏️ Sửa sản phẩm
                        </a>

                        <a
                            href="{{ route('admin.products.index') }}"
                            class="btn btn-outline-dark"
                        >
                            ⚙️ Quản lý nâng cao
                        </a>
                    </div>
                @endif
            </div>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card product-detail-card">
                <div class="card-body p-3 p-md-4 p-lg-5">
                    <div class="row g-4 g-xl-5 align-items-start">

                        {{-- ẢNH SẢN PHẨM --}}
                        <div class="col-lg-6">
                            <div class="product-image-wrapper">
                                @if($product->image)
                                    <img
                                        src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="product-image"
                                        onerror="
                                            this.style.display='none';
                                            this.nextElementSibling.style.display='flex';
                                        "
                                    >
                                    <div class="no-image" style="display:none;">
                                        🧺 Không tìm thấy ảnh sản phẩm
                                    </div>
                                @else
                                    <div class="no-image">
                                        🧺 Sản phẩm chưa có ảnh
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- THÔNG TIN + MUA HÀNG --}}
                        <div class="col-lg-6">
                            @php
                                $topReviewCount = $product->reviews()->count();
                                $topAverageRating = $topReviewCount > 0
                                    ? round((float) $product->reviews()->avg('rating'), 1)
                                    : 0;

                                $minQty = (float) ($product->min_quantity ?? 1);
                                $stepQty = (float) ($product->quantity_step ?? 1);
                                $stockQty = (float) $product->quantity;

                                $stockText = rtrim(
                                    rtrim(
                                        number_format($stockQty, 2, '.', ''),
                                        '0'
                                    ),
                                    '.'
                                );
                            @endphp

                            <span class="product-category-badge mb-3">
                                🌿 {{ $product->category?->name ?? 'Chưa phân loại' }}
                            </span>

                            <h1 class="product-title-new mb-3">
                                {{ $product->name }}
                            </h1>

                            <div class="rating-row-new d-flex align-items-center flex-wrap gap-2 mb-3">
                                <span class="star-display" style="font-size:18px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= round($topAverageRating) ? '★' : '☆' }}
                                    @endfor
                                </span>
                                <strong>{{ number_format($topAverageRating, 1) }}/5</strong>
                                <span class="text-muted">· {{ $topReviewCount }} đánh giá</span>

                                <span class="sold-pill-new">
                                    🔥 Đã bán
                                    {{ rtrim(rtrim(number_format((float) $product->sold_quantity, 2, '.', ''), '0'), '.') }} {{ $product->unit }}
                                </span>
                            </div>

                            <div class="product-short-description mb-3">
                                {{ \Illuminate\Support\Str::limit(
                                    $product->description ?? 'Đặc sản Tây Bắc tuyển chọn, đảm bảo chất lượng và hương vị đặc trưng.',
                                    180
                                ) }}
                            </div>

                            @if(Auth::check() && Auth::user()->role === 'admin')
                                <div class="admin-box mb-3">
                                    <strong>👑 Chế độ quản trị</strong>
                                    <div class="small text-muted mt-1">
                                        Bạn đang xem sản phẩm với quyền Admin.
                                    </div>
                                </div>
                            @endif

                            <div class="commerce-panel">
                                <div class="commerce-price">
                                    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                                        <div>
                                            <div class="small text-muted mb-1">Giá bán</div>

                                            @if($product->isOnSale())
                                                <div class="mb-1">
                                                    <span class="sale-old-price">
                                                        {{ number_format((float) $product->price, 0, ',', '.') }} đ
                                                    </span>
                                                    <span class="sale-badge-new">
                                                        -{{ $product->getDiscountPercent() }}%
                                                    </span>
                                                </div>
                                            @endif

                                            <div>
                                                <span class="price-main">
                                                    {{ number_format($product->getCurrentPrice(), 0, ',', '.') }} đ
                                                </span>
                                                <strong style="color:#5f341d;">
                                                    / {{ $product->unit ?? 'sản phẩm' }}
                                                </strong>
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <div class="small text-muted mb-2">Tình trạng</div>
                                            <span class="stock-pill {{ $stockQty <= 0 ? 'out' : '' }}">
                                                @if($stockQty > 0)
                                                    ● Còn hàng · {{ $stockText }} {{ $product->unit ?? 'sản phẩm' }}
                                                @else
                                                    ● Hết hàng
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                @if(!Auth::check() || Auth::user()->role !== 'admin')
                                    <div class="benefit-strip">
                                        <div class="benefit-strip-item">🚚 Giao toàn quốc</div>
                                        <div class="benefit-strip-item">💳 COD / QR / Bank</div>
                                        <div class="benefit-strip-item">🌿 Đặc sản chọn lọc</div>
                                    </div>
                                @endif

                                @if(Auth::check() && Auth::user()->role === 'admin')
                                    <div class="purchase-area">
                                        <div class="d-flex gap-3 flex-wrap">
                                            <a
                                                href="{{ route('admin.products.edit', $product->id) }}"
                                                class="btn btn-warning btn-lg flex-fill"
                                            >
                                                ✏️ Chỉnh sửa sản phẩm
                                            </a>

                                            <form
                                                action="{{ route('admin.products.destroy', $product->id) }}"
                                                method="POST"
                                                class="flex-fill"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-lg w-100">
                                                    🗑️ Xóa sản phẩm
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                @elseif(Auth::check())
                                    <div class="purchase-area">
                                        <form
                                            action="{{ route('cart.add', $product->id) }}"
                                            method="POST"
                                            id="addToCartForm"
                                        >
                                            @csrf

                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                                                <div>
                                                    <div class="purchase-label">
                                                        {{
                                                            ($product->unit ?? '') === 'kg'
                                                                ? '⚖️ Chọn khối lượng'
                                                                : '📦 Chọn số lượng'
                                                        }}
                                                    </div>
                                                    <div class="small text-muted mt-1">
                                                        Tối thiểu {{ $minQty }} {{ $product->unit ?? 'sản phẩm' }}
                                                        · Bước {{ $stepQty }} {{ $product->unit ?? 'sản phẩm' }}
                                                    </div>
                                                </div>

                                                <div class="quantity-control-new">
                                                    <button type="button" id="minusBtn" aria-label="Giảm số lượng">−</button>
                                                    <input
                                                        type="number"
                                                        id="buyQuantity"
                                                        name="quantity"
                                                        value="{{ $minQty }}"
                                                        min="{{ $minQty }}"
                                                        max="{{ $stockQty }}"
                                                        step="{{ $stepQty }}"
                                                        required
                                                    >
                                                    <button type="button" id="plusBtn" aria-label="Tăng số lượng">+</button>
                                                </div>
                                            </div>

                                            <div class="order-total-new d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                                <div>
                                                    <div class="small text-muted">Thành tiền</div>
                                                    <div class="live-total" id="liveTotal">0 đ</div>
                                                </div>
                                                <strong id="quantityText">
                                                    {{ $minQty }} {{ $product->unit ?? 'sản phẩm' }}
                                                </strong>
                                            </div>

                                            <button
                                                type="submit"
                                                class="btn btn-cart-new btn-lg w-100"
                                                {{ $stockQty <= 0 ? 'disabled' : '' }}
                                            >
                                                @if($stockQty > 0)
                                                    🛒 THÊM VÀO GIỎ HÀNG
                                                @else
                                                    ❌ SẢN PHẨM ĐÃ HẾT HÀNG
                                                @endif
                                            </button>
                                        </form>

                                        <div class="trust-grid-new">
                                            <div class="trust-item-new">🛡️ Nguồn gốc rõ ràng</div>
                                            <div class="trust-item-new">📦 Đóng gói cẩn thận</div>
                                            <div class="trust-item-new">💵 Thanh toán linh hoạt</div>
                                            <div class="trust-item-new">📞 Hỗ trợ 08:00–22:00</div>
                                        </div>
                                    </div>

                                @else
                                    <div class="purchase-area">
                                        <a href="{{ route('login') }}" class="btn btn-warning btn-lg w-100 fw-bold">
                                            🔐 Đăng nhập để mua sản phẩm
                                        </a>

                                        <div class="trust-grid-new">
                                            <div class="trust-item-new">🚚 Giao hàng toàn quốc</div>
                                            <div class="trust-item-new">💳 COD / Chuyển khoản / QR</div>
                                            <div class="trust-item-new">🌿 Đặc sản Tây Bắc chọn lọc</div>
                                            <div class="trust-item-new">📞 Hỗ trợ 08:00–22:00</div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="product-facts">
                                <div class="product-fact">
                                    <small>Danh mục</small>
                                    <strong>{{ $product->category?->name ?? 'Chưa phân loại' }}</strong>
                                </div>
                                <div class="product-fact">
                                    <small>Đơn vị bán</small>
                                    <strong>{{ $product->unit ?? 'sản phẩm' }}</strong>
                                </div>
                                <div class="product-fact">
                                    <small>Tồn kho hiện tại</small>
                                    <strong>
                                        {{ $stockQty > 0 ? $stockText . ' ' . ($product->unit ?? 'sản phẩm') : 'Hết hàng' }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- =====================================================
                 📖 MÔ TẢ CHI TIẾT
            ====================================================== --}}
            <div class="product-content-section">
                <div class="p-4 p-lg-5">
                    <h3 class="product-content-title">📖 Thông tin chi tiết sản phẩm</h3>
                    <div class="product-long-description">{{ $product->description ?? 'Chưa có mô tả chi tiết cho sản phẩm này.' }}</div>
                </div>
            </div>

            {{-- =====================================================
                 ⭐ ĐÁNH GIÁ SẢN PHẨM
            ====================================================== --}}
            @php
                $reviews = $product->reviews()
                    ->with('user')
                    ->latest()
                    ->get();

                $reviewCount = $reviews->count();
                $averageRating = $reviewCount > 0
                    ? round($reviews->avg('rating'), 1)
                    : 0;

                $myReview = Auth::check()
                    ? $reviews->firstWhere('user_id', Auth::id())
                    : null;
            @endphp

            <div class="review-section">
                <div class="p-4 p-lg-5">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                        <div>
                            <h3 class="fw-bold mb-1">⭐ Đánh giá sản phẩm</h3>
                            <div class="text-muted">
                                Nhận xét thực tế từ khách hàng đã mua sản phẩm.
                            </div>
                        </div>

                        <div class="review-summary text-center">
                            <div class="rating-number">
                                {{ number_format($averageRating, 1) }}
                            </div>

                            <div class="star-display">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= round($averageRating) ? '★' : '☆' }}
                                @endfor
                            </div>

                            <div class="small text-muted mt-1">
                                {{ $reviewCount }} đánh giá
                            </div>
                        </div>
                    </div>

                    @if(Auth::check() && Auth::user()->role !== 'admin')
                        <div class="review-form-box mb-4">
                            <h5 class="fw-bold mb-3">
                                {{ $myReview ? '✏️ Chỉnh sửa đánh giá của bạn' : '✍️ Viết đánh giá' }}
                            </h5>

                            <form
                                action="{{ route('reviews.store', $product->id) }}"
                                method="POST"
                            >
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Bạn đánh giá sản phẩm này thế nào?
                                    </label>

                                    <div class="star-rating">
                                        @for($star = 5; $star >= 1; $star--)
                                            <input
                                                type="radio"
                                                id="rating{{ $star }}"
                                                name="rating"
                                                value="{{ $star }}"
                                                {{ (int) old('rating', $myReview?->rating ?? 0) === $star ? 'checked' : '' }}
                                                required
                                            >
                                            <label
                                                for="rating{{ $star }}"
                                                title="{{ $star }} sao"
                                            >
                                                ★
                                            </label>
                                        @endfor
                                    </div>

                                    @error('rating')
                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="comment" class="form-label fw-bold">
                                        Nhận xét
                                    </label>

                                    <textarea
                                        id="comment"
                                        name="comment"
                                        class="form-control"
                                        rows="4"
                                        maxlength="1000"
                                        placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..."
                                    >{{ old('comment', $myReview?->comment) }}</textarea>

                                    @error('comment')
                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-tb px-4">
                                    ⭐ {{ $myReview ? 'Cập nhật đánh giá' : 'Gửi đánh giá' }}
                                </button>
                            </form>
                        </div>
                    @elseif(!Auth::check())
                        <div class="alert alert-light border mb-4">
                            🔐
                            <a href="{{ route('login') }}" class="fw-bold">
                                Đăng nhập
                            </a>
                            để đánh giá sản phẩm.
                        </div>
                    @endif

                    <div>
                        <h5 class="fw-bold mb-2">
                            💬 Nhận xét của khách hàng
                        </h5>

                        @forelse($reviews as $review)
                            <div class="review-item">
                                <div class="d-flex gap-3">
                                    <div class="review-avatar">
                                        {{ strtoupper(substr($review->user?->name ?? 'K', 0, 1)) }}
                                    </div>

                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                                            <div>
                                                <div class="fw-bold">
                                                    {{ $review->user?->name ?? 'Khách hàng' }}
                                                </div>

                                                <div class="star-display" style="font-size:17px;">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        {{ $i <= $review->rating ? '★' : '☆' }}
                                                    @endfor
                                                </div>
                                            </div>

                                            <div class="small text-muted">
                                                {{ $review->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>

                                        @if($review->comment)
                                            <p class="mb-0 mt-2 text-secondary" style="white-space:pre-line;">
                                                {{ $review->comment }}
                                            </p>
                                        @endif

                                        @if(Auth::check() && Auth::user()->role === 'admin')
                                            <form
                                                action="{{ route('admin.reviews.destroy', $review->id) }}"
                                                method="POST"
                                                class="mt-2"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                >
                                                    🗑️ Xóa đánh giá
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <div style="font-size:42px;">⭐</div>
                                <div class="fw-bold mt-2">
                                    Chưa có đánh giá nào
                                </div>
                                <div class="small">
                                    Hãy là khách hàng đầu tiên chia sẻ cảm nhận.
                                </div>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

            {{-- =====================================================
                 🌿 SẢN PHẨM TƯƠNG TỰ
            ====================================================== --}}
            @php
                $relatedProducts = \App\Models\Product::query()
                    ->where('category_id', $product->category_id)
                    ->where('id', '!=', $product->id)
                    ->orderBy('name', 'asc')
                    ->limit(4)
                    ->get();
            @endphp

            @if($relatedProducts->isNotEmpty())
                <div class="related-section">
                    <div class="p-4 p-lg-5">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                            <div>
                                <h3 class="fw-bold mb-1" style="color:#5f341d;">🌿 Sản phẩm tương tự</h3>
                                <div class="text-muted">Khám phá thêm đặc sản trong {{ $product->category?->name ?? 'cùng danh mục' }}.</div>
                            </div>
                            <a href="{{ route('products.index', ['category_id' => $product->category_id]) }}" class="btn btn-outline-secondary">Xem thêm →</a>
                        </div>

                        <div class="row g-4">
                            @foreach($relatedProducts as $related)
                                <div class="col-6 col-lg-3">
                                    <div class="related-card">
                                        <a href="{{ route('products.show', $related) }}" class="text-decoration-none">
                                            <div class="related-image-wrap">
                                                @if($related->image)
                                                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="related-image">
                                                @else
                                                    <div class="h-100 d-flex align-items-center justify-content-center text-muted">🧺 Chưa có ảnh</div>
                                                @endif
                                                @if($related->isOnSale())
                                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">-{{ $related->getDiscountPercent() }}%</span>
                                                @endif
                                            </div>
                                        </a>
                                        <div class="p-3">
                                            <a href="{{ route('products.show', $related) }}" class="related-name">{{ $related->name }}</a>
                                            <div class="small text-warning mt-2">
                                                @php
                                                    $relatedAvg = round((float) $related->reviews()->avg('rating'), 1);
                                                @endphp
                                                ★ {{ number_format($relatedAvg, 1) }}
                                            </div>
                                            <div class="mt-2">
                                                @if($related->isOnSale())
                                                    <div class="small text-muted text-decoration-line-through">{{ number_format((float) $related->price, 0, ',', '.') }} đ</div>
                                                @endif
                                                <strong style="color:#a83b2d;font-size:18px;">{{ number_format($related->getCurrentPrice(), 0, ',', '.') }} đ</strong>
                                                <span class="small text-muted">/ {{ $related->unit ?? 'sản phẩm' }}</span>
                                            </div>
                                            <a href="{{ route('products.show', $related) }}" class="btn btn-tb w-100 mt-3">Xem sản phẩm</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@if(Auth::check() && Auth::user()->role !== 'admin')
<script>
(() => {
    const input = document.getElementById('buyQuantity');
    const minus = document.getElementById('minusBtn');
    const plus = document.getElementById('plusBtn');
    const total = document.getElementById('liveTotal');
    const quantityText = document.getElementById('quantityText');

    if (!input || !minus || !plus || !total) {
        return;
    }

    const price = Number(@json((float) $product->getCurrentPrice()));
    const min = Number(@json((float) ($product->min_quantity ?? 1)));
    const step = Number(@json((float) ($product->quantity_step ?? 1)));
    const max = Number(@json((float) $product->quantity));
    const unit = @json($product->unit ?? 'sản phẩm');

    const clampAndSnap = (value) => {
        if (!Number.isFinite(value)) {
            value = min;
        }

        value = Math.max(min, Math.min(max, value));

        const steps = Math.round((value - min) / step);
        value = min + (steps * step);

        return Math.round(value * 100) / 100;
    };

    const formatQty = (value) => {
        return Number(value.toFixed(2)).toString();
    };

    const update = () => {
        const value = clampAndSnap(Number(input.value));
        input.value = formatQty(value);

        total.textContent =
            new Intl.NumberFormat('vi-VN')
                .format(Math.round(price * value))
            + ' đ';

        if (quantityText) {
            quantityText.textContent =
                formatQty(value) + ' ' + unit;
        }

        minus.disabled = value <= min;
        plus.disabled = value + step > max + 0.00001;
    };

    minus.addEventListener('click', () => {
        input.value = Number(input.value || min) - step;
        update();
    });

    plus.addEventListener('click', () => {
        input.value = Number(input.value || min) + step;
        update();
    });

    input.addEventListener('change', update);
    input.addEventListener('input', update);

    update();
})();
</script>
@endif

@endsection
