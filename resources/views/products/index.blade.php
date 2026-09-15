@extends('layouts.app')

@section('title', 'Đặc sản Tây Bắc | Tinh Hoa Tây Bắc')

@section('content')

<style>
    .products-hero {
        padding: 34px;
        border-radius: 24px;
        color: #fff;
        background: linear-gradient(
            135deg,
            #2c1810 0%,
            #5f341d 55%,
            #48633b 100%
        );
        box-shadow: 0 15px 40px rgba(95,52,29,.16);
    }

    .filter-card,
    .product-card {
        border: 1px solid #ead8bf;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 10px 28px rgba(95,52,29,.07);
    }

    .filter-card {
        padding: 22px;
    }

    .filter-label {
        font-size: 13px;
        font-weight: 700;
        color: #5f341d;
        margin-bottom: 6px;
    }

    .form-control,
    .form-select {
        min-height: 44px;
        border-radius: 10px;
        border-color: #e5d4bd;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #a83b2d;
        box-shadow: 0 0 0 3px rgba(168,59,45,.08);
    }

    .product-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: .2s ease;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 35px rgba(95,52,29,.12);
    }

    .product-image-wrap {
        height: 220px;
        position: relative;
        background: linear-gradient(180deg,#fffaf0,#f8efe2);
    }

    .product-image {
        width: 100%;
        height: 100%;
        padding: 16px;
        object-fit: contain;
    }

    .product-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 64px;
    }

    .stock-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 2;
    }

    .category-badge {
        background: #f8efe2;
        color: #5f341d;
        border: 1px solid #ead8bf;
    }

    .price {
        color: #a83b2d;
        font-size: 22px;
        font-weight: 800;
    }

    /* Căn các card và cụm nút thẳng hàng */
    .product-card > .p-4 {
        flex: 1 1 auto;
    }

    .product-title {
        min-height: 48px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
    }

    .product-description {
        min-height: 60px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
    }

    .product-bottom {
        margin-top: auto;
    }

    .btn-tb {
        border: none;
        color: #fff;
        background: linear-gradient(135deg,#a83b2d,#5f341d);
    }

    .btn-tb:hover {
        color: #fff;
        background: linear-gradient(135deg,#8b3025,#3b2114);
    }

    .btn-outline-tb {
        color: #5f341d;
        border-color: #5f341d;
    }

    .btn-outline-tb:hover {
        color: #fff;
        background: #5f341d;
        border-color: #5f341d;
    }

    .result-count {
        color: #48633b;
        font-weight: 700;
    }

    .sold-count {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #8a5a3c;
        font-size: 13px;
        font-weight: 800;
    }

</style>

<div class="container py-4">

    {{-- HERO --}}
    <section class="products-hero mb-4">
        <div class="row align-items-center g-3">
            <div class="col-lg-8">
                <div class="small fw-bold mb-2" style="color:#f2c15c;">
                    🌿 TINH HOA TÂY BẮC
                </div>

                <h1 class="fw-bold mb-2">
                    🥩 Đặc sản Tây Bắc
                </h1>

                <p class="mb-0" style="color:rgba(255,255,255,.78);">
                    Tìm kiếm và lựa chọn những đặc sản mang đậm
                    hương vị núi rừng Tây Bắc.
                </p>
            </div>

            <div class="col-lg-4 text-lg-end">
                <span class="badge px-3 py-2 fs-6"
                      style="background:#f2c15c;color:#3b2114;">
                    {{ $products->total() }} sản phẩm
                </span>
            </div>
        </div>
    </section>

    {{-- TÌM KIẾM + LỌC --}}
    <section class="filter-card mb-4">

        <form
            action="{{ route('products.index') }}"
            method="GET"
        >
            <div class="row g-3">

                <div class="col-lg-4 col-md-6">
                    <label class="filter-label">
                        🔎 Tìm kiếm
                    </label>

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Nhập tên đặc sản..."
                    >
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="filter-label">
                        🧺 Danh mục
                    </label>

                    <select
                        name="category_id"
                        class="form-select"
                    >
                        <option value="">
                            Tất cả danh mục
                        </option>

                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="filter-label">
                        💰 Giá từ
                    </label>

                    <input
                        type="number"
                        name="min_price"
                        min="0"
                        class="form-control"
                        value="{{ request('min_price') }}"
                        placeholder="0"
                    >
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="filter-label">
                        💰 Giá đến
                    </label>

                    <input
                        type="number"
                        name="max_price"
                        min="0"
                        class="form-control"
                        value="{{ request('max_price') }}"
                        placeholder="5.000.000"
                    >
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="filter-label">
                        📦 Tình trạng
                    </label>

                    <select
                        name="stock"
                        class="form-select"
                    >
                        <option value="">Tất cả</option>

                        <option
                            value="in_stock"
                            {{ request('stock') === 'in_stock' ? 'selected' : '' }}
                        >
                            Còn hàng
                        </option>

                        <option
                            value="out_of_stock"
                            {{ request('stock') === 'out_of_stock' ? 'selected' : '' }}
                        >
                            Hết hàng
                        </option>
                    </select>
                </div>

                <div class="col-lg-4 col-md-6">
                    <label class="filter-label">
                        ↕️ Sắp xếp
                    </label>

                    <select
                        name="sort"
                        class="form-select"
                    >
                        <option value="">
                            Mới nhất
                        </option>

                        <option
                            value="price_asc"
                            {{ request('sort') === 'price_asc' ? 'selected' : '' }}
                        >
                            Giá thấp → cao
                        </option>

                        <option
                            value="price_desc"
                            {{ request('sort') === 'price_desc' ? 'selected' : '' }}
                        >
                            Giá cao → thấp
                        </option>

                        <option
                            value="name_asc"
                            {{ request('sort') === 'name_asc' ? 'selected' : '' }}
                        >
                            Tên A → Z
                        </option>

                        <option
                            value="name_desc"
                            {{ request('sort') === 'name_desc' ? 'selected' : '' }}
                        >
                            Tên Z → A
                        </option>
                    </select>
                </div>

                <div class="col-lg-8 d-flex align-items-end gap-2">

                    <button
                        type="submit"
                        class="btn btn-tb px-4"
                    >
                        🔎 Tìm kiếm & lọc
                    </button>

                    <a
                        href="{{ route('products.index') }}"
                        class="btn btn-outline-secondary px-4"
                    >
                        ↻ Xóa bộ lọc
                    </a>

                </div>

            </div>
        </form>

    </section>

    {{-- KẾT QUẢ --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">

        <div>
            <h4 class="fw-bold mb-1">
                Danh sách đặc sản
            </h4>

            <div class="result-count">
                Tìm thấy {{ $products->total() }} sản phẩm
            </div>
        </div>

        @if(Auth::check() && Auth::user()->role === 'admin')
            <div class="d-flex gap-2 flex-wrap">
                <a
                    href="{{ route('admin.products.create') }}"
                    class="btn btn-tb"
                >
                    ➕ Thêm sản phẩm
                </a>

                <a
                    href="{{ route('admin.products.index') }}"
                    class="btn btn-outline-tb"
                >
                    ⚙️ Quản lý nâng cao
                </a>
            </div>
        @endif

    </div>

    @if($products->isEmpty())

        <div class="card border-0 text-center py-5">

            <div style="font-size:70px;">
                🔎
            </div>

            <h4 class="fw-bold mt-3">
                Không tìm thấy sản phẩm
            </h4>

            <p class="text-muted">
                Hãy thử thay đổi từ khóa hoặc điều kiện lọc.
            </p>

            <div>
                <a
                    href="{{ route('products.index') }}"
                    class="btn btn-tb"
                >
                    Xem tất cả đặc sản
                </a>
            </div>

        </div>

    @else

        <div
            class="
                row
                row-cols-1
                row-cols-sm-2
                row-cols-lg-3
                row-cols-xl-4
                g-4
            "
        >

            @foreach($products as $product)

                <div class="col">

                    <div class="product-card">

                        <div class="product-image-wrap">

                            @if($product->quantity > 0)

                                <span class="badge bg-success stock-badge">
                                    Còn hàng
                                </span>

                            @else

                                <span class="badge bg-danger stock-badge">
                                    Hết hàng
                                </span>

                            @endif


                            @if(
                                $product->image
                                && Storage::disk('public')->exists($product->image)
                            )

                                <img
                                    src="{{ Storage::disk('public')->url($product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="product-image"
                                >

                            @else

                                <div class="product-fallback">
                                    🧺
                                </div>

                            @endif

                        </div>


                        <div class="p-4 d-flex flex-column flex-grow-1">

                            <div class="mb-2">

                                <span class="badge category-badge">
                                    {{ $product->category->name ?? 'Chưa phân loại' }}
                                </span>

                            </div>


                            <h5 class="fw-bold mb-2 product-title">
                                {{ $product->name }}
                            </h5>


                            <p class="text-muted small product-description">
                                {{
                                    \Illuminate\Support\Str::limit(
                                        $product->description
                                        ?? 'Đặc sản Tây Bắc đậm đà hương vị núi rừng.',
                                        90
                                    )
                                }}
                            </p>


                            <div class="product-bottom">

                            <div class="price mb-1">
                                @if($product->isOnSale())
                                    <span class="text-muted text-decoration-line-through small me-2">
                                        {{ number_format($product->price, 0, ',', '.') }} đ
                                    </span>
                                    <span>
                                        {{ number_format($product->getCurrentPrice(), 0, ',', '.') }} đ
                                    </span>
                                    <span class="badge bg-danger ms-1">
                                        -{{ $product->getDiscountPercent() }}%
                                    </span>
                                @else
                                    {{ number_format($product->price, 0, ',', '.') }} đ
                                @endif
                            </div>

                            <small class="text-muted mb-3">
                                Kho: {{ $product->quantity }} sản phẩm
                            </small>

                            <div class="sold-count mb-3">
                                🔥 Đã bán
                                {{ rtrim(rtrim(number_format((float) $product->sold_quantity, 2, '.', ''), '0'), '.') }} {{ $product->unit }}
                            </div>


                            <div class="d-grid gap-2">

                                @if(Auth::check() && Auth::user()->role === 'admin')

                                    <a
                                        href="{{ route('products.show', $product) }}"
                                        class="btn btn-outline-tb"
                                    >
                                        👁 Xem chi tiết
                                    </a>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <a
                                                href="{{ route('admin.products.edit', $product) }}"
                                                class="btn btn-warning w-100 fw-bold"
                                            >
                                                ✏️ Sửa
                                            </a>
                                        </div>

                                        <div class="col-6">
                                            <form
                                                action="{{ route('admin.products.toggleFeatured', $product) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="btn {{ $product->is_featured ? 'btn-warning' : 'btn-outline-warning' }} w-100 fw-bold"
                                                >
                                                    {{ $product->is_featured ? '★ Đã ghim' : '☆ Nổi bật' }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <button
                                                type="button"
                                                class="btn {{ $product->isOnSale() ? 'btn-danger' : 'btn-outline-danger' }} w-100"
                                                data-bs-toggle="modal"
                                                data-bs-target="#promotionModal{{ $product->id }}"
                                            >
                                                🔥 {{ $product->isOnSale() ? 'Sửa sale' : 'Sale' }}
                                            </button>
                                        </div>

                                        <div class="col-6">
                                            <form
                                                action="{{ route('admin.products.destroy', $product) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-outline-danger w-100">
                                                    🗑️ Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                @elseif(Auth::check())

                                    <a
                                        href="{{ route('products.show', $product) }}"
                                        class="btn btn-outline-tb"
                                    >
                                        👁 Xem chi tiết
                                    </a>

                                    <form
                                        action="{{ route('cart.add', $product) }}"
                                        method="POST"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-tb w-100"
                                            {{ $product->quantity <= 0 ? 'disabled' : '' }}
                                        >
                                            {{ $product->quantity > 0 ? '🛒 Thêm vào giỏ hàng' : '❌ Hết hàng' }}
                                        </button>
                                    </form>

                                @else

                                    <a
                                        href="{{ route('products.show', $product) }}"
                                        class="btn btn-outline-tb"
                                    >
                                        👁 Xem chi tiết
                                    </a>

                                    <a href="{{ route('login') }}" class="btn btn-tb">
                                        🔐 Đăng nhập để mua
                                    </a>

                                @endif

                            </div>

                            </div>{{-- /.product-bottom --}}

                        </div>

                    </div>

                </div>

                @if(Auth::check() && Auth::user()->role === 'admin')
                    <div
                        class="modal fade"
                        id="promotionModal{{ $product->id }}"
                        tabindex="-1"
                        aria-hidden="true"
                    >
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 rounded-4">
                                <form
                                    action="{{ route('admin.products.setPromotion', $product) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <div class="modal-header">
                                        <div>
                                            <h5 class="modal-title fw-bold">🔥 Thiết lập khuyến mãi</h5>
                                            <div class="small text-muted mt-1">{{ $product->name }}</div>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Giá gốc</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                value="{{ number_format((float) $product->price, 0, ',', '.') }} đ"
                                                disabled
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Giá khuyến mãi</label>
                                            <input
                                                type="number"
                                                name="sale_price"
                                                class="form-control"
                                                min="0"
                                                max="{{ $product->price }}"
                                                value="{{ $product->sale_price ? (float) $product->sale_price : '' }}"
                                                required
                                            >
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Bắt đầu</label>
                                                <input
                                                    type="datetime-local"
                                                    name="sale_start"
                                                    class="form-control"
                                                    value="{{ $product->sale_start ? $product->sale_start->format('Y-m-d\\TH:i') : now()->format('Y-m-d\\TH:i') }}"
                                                >
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">Kết thúc</label>
                                                <input
                                                    type="datetime-local"
                                                    name="sale_end"
                                                    class="form-control"
                                                    value="{{ $product->sale_end ? $product->sale_end->format('Y-m-d\\TH:i') : now()->addDays(7)->format('Y-m-d\\TH:i') }}"
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        @if($product->sale_price)
                                            <button
                                                type="submit"
                                                form="removeSaleForm{{ $product->id }}"
                                                class="btn btn-outline-danger me-auto"
                                            >
                                                🗑️ Gỡ sale
                                            </button>
                                        @endif

                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                            Đóng
                                        </button>
                                        <button type="submit" class="btn btn-danger">
                                            🔥 Lưu khuyến mãi
                                        </button>
                                    </div>
                                </form>

                                @if($product->sale_price)
                                    <form
                                        id="removeSaleForm{{ $product->id }}"
                                        action="{{ route('admin.products.removePromotion', $product) }}"
                                        method="POST"
                                        class="d-none"
                                    >
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

            @endforeach

        </div>


        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>

    @endif

</div>

@endsection
