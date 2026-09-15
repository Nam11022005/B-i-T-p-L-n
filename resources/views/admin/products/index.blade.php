@extends('admin.layouts.app')

@section('title', 'Quản lý sản phẩm | Tinh Hoa Tây Bắc')

@section('content')

<style>
    .admin-products-head {
        margin-bottom: 24px;
    }

    .filter-box {
        padding: 22px;
        margin-bottom: 24px;
        border: 1px solid #ead8bf;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 10px 28px rgba(95,52,29,.07);
    }

    .filter-label {
        margin-bottom: 6px;
        color: #5f341d;
        font-size: 13px;
        font-weight: 700;
    }

    .product-thumb {
        width: 58px;
        height: 58px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #ead8bf;
        background: #fffaf0;
    }

    .product-fallback {
        width: 58px;
        height: 58px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ead8bf;
        border-radius: 10px;
        background: #f8efe2;
        font-size: 26px;
    }

    .category-badge {
        color: #5f341d;
        background: #f8efe2;
        border: 1px solid #ead8bf;
    }

    .price-admin {
        color: #a83b2d;
        font-weight: 800;
        white-space: nowrap;
    }

    .table-shell {
        overflow: hidden;
        border: 1px solid #ead8bf;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 10px 28px rgba(95,52,29,.07);
    }

    .featured-badge {
        color: #6b4700;
        background: #fff3cd;
        border: 1px solid #f2c15c;
    }

    .btn-featured {
        color: #6b4700;
        border-color: #f2c15c;
        background: #fffaf0;
    }

    .btn-featured:hover {
        color: #3b2114;
        border-color: #e7ad2c;
        background: #f2c15c;
    }

    .btn-sale {
        color: #fff;
        border: 0;
        background: linear-gradient(135deg, #d97706, #a83b2d);
    }

    .btn-sale:hover {
        color: #fff;
        background: linear-gradient(135deg, #bd6504, #8f3025);
    }

    .sale-badge {
        color: #fff;
        background: #a83b2d;
    }

    .promotion-modal .modal-content {
        overflow: hidden;
        border: 0;
        border-radius: 18px;
    }

    .promotion-modal .modal-header {
        color: #fff;
        background: linear-gradient(90deg, #5f341d, #a83b2d);
    }

</style>

<div class="admin-products-head d-flex justify-content-between align-items-center flex-wrap gap-3">

    <div>
        <h2 class="fw-bold mb-1">
            📦 Danh sách Sản phẩm
        </h2>

        <div class="text-muted">
            Quản lý, tìm kiếm và lọc các đặc sản trong cửa hàng
        </div>
    </div>

    <a
        href="{{ route('admin.products.create') }}"
        class="btn btn-success px-4"
    >
        ➕ Thêm Sản phẩm
    </a>

</div>


{{-- TÌM KIẾM + LỌC --}}
<div class="filter-box">

    <form
        action="{{ route('admin.products.index') }}"
        method="GET"
    >

        <div class="row g-3">

            <div class="col-lg-4 col-md-6">

                <label class="filter-label">
                    🔎 ID / Tên sản phẩm
                </label>

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="VD: 12 hoặc Thịt trâu..."
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
                        Tất cả
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
                    📦 Tồn kho
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


            <div class="col-lg-2 col-md-6">

                <label class="filter-label">
                    💰 Giá từ
                </label>

                <input
                    type="number"
                    min="0"
                    name="min_price"
                    class="form-control"
                    value="{{ request('min_price') }}"
                >

            </div>


            <div class="col-lg-2 col-md-6">

                <label class="filter-label">
                    💰 Giá đến
                </label>

                <input
                    type="number"
                    min="0"
                    name="max_price"
                    class="form-control"
                    value="{{ request('max_price') }}"
                >

            </div>


            <div class="col-lg-2 col-md-6">

                <label class="filter-label">
                    ⭐ Nổi bật
                </label>

                <select
                    name="featured"
                    class="form-select"
                >
                    <option value="">Tất cả</option>

                    <option
                        value="featured"
                        {{ request('featured') === 'featured' ? 'selected' : '' }}
                    >
                        Đã ghim
                    </option>

                    <option
                        value="normal"
                        {{ request('featured') === 'normal' ? 'selected' : '' }}
                    >
                        Chưa ghim
                    </option>
                </select>

            </div>


            <div class="col-lg-2 col-md-6">

                <label class="filter-label">
                    ↕️ Sắp xếp
                </label>

                <select
                    name="sort"
                    class="form-select"
                >
                    <option value="">Mới nhất</option>

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

                    <option
                        value="stock_asc"
                        {{ request('sort') === 'stock_asc' ? 'selected' : '' }}
                    >
                        Tồn kho ít → nhiều
                    </option>

                    <option
                        value="stock_desc"
                        {{ request('sort') === 'stock_desc' ? 'selected' : '' }}
                    >
                        Tồn kho nhiều → ít
                    </option>
                </select>

            </div>


            <div class="col-lg-8 d-flex align-items-end gap-2">

                <button
                    type="submit"
                    class="btn btn-primary px-4"
                >
                    🔎 Tìm kiếm & lọc
                </button>

                <a
                    href="{{ route('admin.products.index') }}"
                    class="btn btn-outline-secondary px-4"
                >
                    ↻ Xóa bộ lọc
                </a>

            </div>

        </div>

    </form>

</div>


<div class="d-flex justify-content-between align-items-center mb-3">

    <strong>
        Kết quả: {{ $products->total() }} sản phẩm
    </strong>

</div>


<div class="table-responsive table-shell">

    <table class="table align-middle">

        <thead>
            <tr>
                <th>ID</th>
                <th>Sản phẩm</th>
                <th>Danh mục</th>
                <th>Mô tả</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th class="text-center">Nổi bật</th>
                <th class="text-center">Hành động</th>
            </tr>
        </thead>

        <tbody>

            @forelse($products as $product)

                <tr>

                    <td>
                        #{{ $product->id }}
                    </td>


                    <td>

                        <div class="d-flex align-items-center gap-2">

                            @if(
                                $product->image
                                && Storage::disk('public')->exists($product->image)
                            )

                                <img
                                    src="{{ Storage::disk('public')->url($product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="product-thumb"
                                >

                            @else

                                <div class="product-fallback">
                                    🧺
                                </div>

                            @endif

                            <strong>
                                {{ $product->name }}
                            </strong>

                        </div>

                    </td>


                    <td>

                        <span class="badge category-badge">
                            {{ $product->category->name ?? 'Không có' }}
                        </span>

                    </td>


                    <td style="max-width:280px;">

                        {{
                            \Illuminate\Support\Str::limit(
                                $product->description ?? 'Không có mô tả',
                                85
                            )
                        }}

                    </td>


                    <td>

                        @if($product->quantity > 0)

                            <span class="badge bg-success">
                                {{ $product->quantity }}
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Hết hàng
                            </span>

                        @endif

                    </td>


                    <td class="price-admin">

                        @if($product->isOnSale())
                            <div class="text-muted text-decoration-line-through small">
                                {{ number_format($product->price, 0, ',', '.') }} đ
                            </div>
                            <div>
                                {{ number_format($product->getCurrentPrice(), 0, ',', '.') }} đ
                                <span class="badge bg-danger">
                                    -{{ $product->getDiscountPercent() }}%
                                </span>
                            </div>
                        @else
                            {{ number_format($product->price, 0, ',', '.') }} đ
                        @endif

                    </td>


                    <td class="text-center">

                        @if($product->is_featured)

                            <span class="badge featured-badge">
                                ⭐ Đã ghim
                            </span>

                        @else

                            <span class="badge bg-light text-dark border">
                                ☆ Chưa ghim
                            </span>

                        @endif

                    </td>


                    <td>

                        <div class="d-flex justify-content-center flex-wrap gap-2">

                            <form
                                action="{{ route('admin.products.toggleFeatured', $product) }}"
                                method="POST"
                                class="d-inline"
                            >
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="btn btn-sm {{ $product->is_featured ? 'btn-warning' : 'btn-featured' }}"
                                    title="{{ $product->is_featured ? 'Bỏ ghim sản phẩm nổi bật' : 'Ghim lên trang chủ' }}"
                                >
                                    {{ $product->is_featured ? '★ Bỏ ghim' : '☆ Ghim' }}
                                </button>
                            </form>

                            @if($product->isOnSale())

                                <button
                                    type="button"
                                    class="btn btn-sm btn-sale"
                                    data-bs-toggle="modal"
                                    data-bs-target="#promotionModal{{ $product->id }}"
                                    title="Chỉnh sửa chương trình khuyến mãi"
                                >
                                    🔥 Đang sale
                                </button>

                                <form
                                    action="{{ route('admin.products.removePromotion', $product) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Bạn có chắc muốn gỡ sản phẩm này khỏi khuyến mãi?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-outline-danger btn-sm"
                                    >
                                        ✖ Gỡ sale
                                    </button>
                                </form>

                            @else

                                <button
                                    type="button"
                                    class="btn btn-sm btn-sale"
                                    data-bs-toggle="modal"
                                    data-bs-target="#promotionModal{{ $product->id }}"
                                >
                                    🔥 Đưa lên sale
                                </button>

                            @endif


                            <a
                                href="{{ route('admin.products.show', $product->id) }}"
                                class="btn btn-outline-primary btn-sm"
                            >
                                👁 Xem
                            </a>

                            <a
                                href="{{ route('admin.products.edit', $product->id) }}"
                                class="btn btn-warning btn-sm"
                            >
                                ✏️ Sửa
                            </a>

                            <form
                                action="{{ route('admin.products.destroy', $product->id) }}"
                                method="POST"
                                onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                >
                                    🗑️ Xóa
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>

                {{-- ==========================================
                    🔥 MODAL THIẾT LẬP KHUYẾN MÃI
                =========================================== --}}
                <div
                    class="modal fade promotion-modal"
                    id="promotionModal{{ $product->id }}"
                    tabindex="-1"
                    aria-labelledby="promotionModalLabel{{ $product->id }}"
                    aria-hidden="true"
                >
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <form
                                action="{{ route('admin.products.setPromotion', $product) }}"
                                method="POST"
                            >
                                @csrf
                                @method('PATCH')

                                {{-- Dùng để validate sale_price < price --}}
                                <input
                                    type="hidden"
                                    name="price"
                                    value="{{ $product->price }}"
                                >

                                <div class="modal-header">
                                    <h5
                                        class="modal-title fw-bold"
                                        id="promotionModalLabel{{ $product->id }}"
                                    >
                                        🔥 Thiết lập khuyến mãi
                                    </h5>

                                    <button
                                        type="button"
                                        class="btn-close btn-close-white"
                                        data-bs-dismiss="modal"
                                        aria-label="Đóng"
                                    ></button>
                                </div>

                                <div class="modal-body p-4">

                                    <div class="mb-4">
                                        <div class="fw-bold fs-5">
                                            {{ $product->name }}
                                        </div>

                                        <div class="text-muted">
                                            Giá gốc:
                                            <strong>
                                                {{ number_format($product->price, 0, ',', '.') }} đ
                                            </strong>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label
                                            for="sale_price_{{ $product->id }}"
                                            class="form-label fw-bold"
                                        >
                                            💰 Giá khuyến mãi
                                        </label>

                                        <input
                                            type="number"
                                            id="sale_price_{{ $product->id }}"
                                            name="sale_price"
                                            class="form-control"
                                            value="{{ $product->sale_price }}"
                                            min="0"
                                            max="{{ max((float) $product->price - 1, 0) }}"
                                            step="1000"
                                            placeholder="Ví dụ: 480000"
                                            required
                                        >

                                        <div class="form-text">
                                            Phải nhỏ hơn giá gốc
                                            {{ number_format($product->price, 0, ',', '.') }} đ.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label
                                            for="sale_start_{{ $product->id }}"
                                            class="form-label fw-bold"
                                        >
                                            🕐 Bắt đầu
                                        </label>

                                        <input
                                            type="datetime-local"
                                            id="sale_start_{{ $product->id }}"
                                            name="sale_start"
                                            class="form-control"
                                            value="{{ $product->sale_start?->format('Y-m-d\TH:i') }}"
                                            required
                                        >
                                    </div>

                                    <div class="mb-3">
                                        <label
                                            for="sale_end_{{ $product->id }}"
                                            class="form-label fw-bold"
                                        >
                                            🕐 Kết thúc
                                        </label>

                                        <input
                                            type="datetime-local"
                                            id="sale_end_{{ $product->id }}"
                                            name="sale_end"
                                            class="form-control"
                                            value="{{ $product->sale_end?->format('Y-m-d\TH:i') }}"
                                            required
                                        >
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal"
                                    >
                                        Hủy
                                    </button>

                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                    >
                                        🔥 Áp dụng khuyến mãi
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            @empty

                <tr>

                    <td
                        colspan="8"
                        class="text-center py-5"
                    >

                        <div style="font-size:46px;">
                            🔎
                        </div>

                        <div class="fw-bold mt-2">
                            Không tìm thấy sản phẩm phù hợp
                        </div>

                        <a
                            href="{{ route('admin.products.index') }}"
                            class="btn btn-outline-primary btn-sm mt-3"
                        >
                            Xóa bộ lọc
                        </a>

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>


<div class="d-flex justify-content-center mt-4">
    {{ $products->links() }}
</div>

@endsection
