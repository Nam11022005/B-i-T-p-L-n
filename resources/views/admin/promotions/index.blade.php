@extends('admin.layouts.app')

@section('title', 'Khuyến mại sản phẩm | Tinh Hoa Tây Bắc')

@section('content')
<style>
    .promotion-admin-page { padding: 32px 0 72px; }
    .promotion-admin-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        padding: 30px 34px;
        margin-bottom: 24px;
        border-radius: 26px;
        color: #fff;
        background: linear-gradient(135deg, #5f341d, #a83b2d 52%, #48633b);
        box-shadow: 0 20px 48px rgba(95, 52, 29, .16);
    }

    .promotion-admin-hero h1 { margin: 0; color: #fff; font-size: clamp(28px, 3vw, 42px); font-weight: 900; }
    .promotion-admin-hero p { margin: 8px 0 0; color: rgba(255,255,255,.84); }
    .promotion-stat-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; margin-bottom: 20px; }
    .promotion-stat {
        padding: 16px;
        border: 1px solid #ead8bf;
        border-radius: 16px;
        color: #5f341d;
        background: #fffdf9;
        text-decoration: none;
        box-shadow: 0 8px 20px rgba(95,52,29,.05);
    }
    .promotion-stat:hover, .promotion-stat.is-active { border-color: #48633b; color: #2f4b2b; background: #f5faef; }
    .promotion-stat strong { display: block; font-size: 25px; line-height: 1; }
    .promotion-stat span { display: block; margin-top: 6px; font-size: 13px; font-weight: 700; }
    .promotion-list { overflow: hidden; border: 1px solid #ead8bf; border-radius: 20px; background: #fff; box-shadow: 0 12px 32px rgba(95,52,29,.07); }
    .promotion-list-header { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 16px 20px; border-bottom: 1px solid #ead8bf; background: #fff8eb; }
    .promotion-list-header h2 { margin: 0; color: #5f341d; font-size: 19px; font-weight: 900; }
    .promotion-row { display: grid; grid-template-columns: 82px minmax(180px, 1.4fr) minmax(155px, 1fr) minmax(180px, 1.1fr) auto; align-items: center; gap: 16px; padding: 16px 20px; border-bottom: 1px solid #f1e6d8; }
    .promotion-row:last-child { border-bottom: 0; }
    .promotion-product-image { width: 82px; height: 82px; border-radius: 13px; overflow: hidden; background: #fff7e9; }
    .promotion-product-image img { width: 100%; height: 100%; object-fit: cover; }
    .promotion-product-name { color: #2c1810; font-weight: 850; text-decoration: none; }
    .promotion-product-name:hover { color: #a83b2d; }
    .promotion-category { display: block; margin-top: 5px; color: #806f60; font-size: 12px; }
    .promotion-price-old { color: #8e8176; font-size: 13px; text-decoration: line-through; }
    .promotion-price-new { display: block; color: #a83b2d; font-size: 20px; font-weight: 900; }
    .promotion-discount { display: inline-block; margin-top: 5px; padding: 3px 8px; border-radius: 999px; color: #9f2f22; background: #fff0ec; font-size: 12px; font-weight: 800; }
    .promotion-period { color: #5f5248; font-size: 13px; line-height: 1.55; }
    .promotion-status { display: inline-block; margin-bottom: 8px; padding: 4px 9px; border-radius: 999px; font-size: 12px; font-weight: 800; }
    .status-active { color: #216238; background: #e9f7ed; }
    .status-upcoming { color: #7a5413; background: #fff3cf; }
    .status-expired { color: #a33a2a; background: #fff0ed; }
    .promotion-actions { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 7px; }
    .promotion-empty { padding: 48px 24px; color: #76665a; text-align: center; }
    @media (max-width: 991.98px) {
        .promotion-stat-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .promotion-row { grid-template-columns: 72px minmax(0, 1fr); }
        .promotion-product-image { width: 72px; height: 72px; }
        .promotion-row > :nth-child(3), .promotion-row > :nth-child(4), .promotion-row > :nth-child(5) { grid-column: 2; }
        .promotion-actions { justify-content: flex-start; }
    }
    @media (max-width: 575.98px) {
        .promotion-admin-hero { padding: 24px; }
        .promotion-stat-grid { grid-template-columns: 1fr 1fr; }
        .promotion-row { gap: 12px; padding: 14px; }
    }
</style>

<div class="promotion-admin-page">
    <div class="promotion-admin-hero">
        <div>
            <h1>🔥 Khuyến mại sản phẩm</h1>
            <p>Xem toàn bộ sản phẩm đang giảm giá và thao tác ngay tại đây.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-light fw-bold">
            + Đưa sản phẩm lên sale
        </a>
    </div>

    <div class="promotion-stat-grid">
        @foreach(['all' => 'Tất cả', 'active' => 'Đang diễn ra', 'upcoming' => 'Sắp diễn ra', 'expired' => 'Đã hết hạn'] as $key => $label)
            <a href="{{ route('admin.promotions.index', ['status' => $key]) }}" class="promotion-stat {{ $status === $key ? 'is-active' : '' }}">
                <strong>{{ $promotionStats[$key] }}</strong>
                <span>{{ $label }}</span>
            </a>
        @endforeach
    </div>

    <div class="promotion-list">
        <div class="promotion-list-header">
            <h2>Danh sách sản phẩm khuyến mại</h2>
            <span class="text-muted small">{{ $promotions->total() }} sản phẩm</span>
        </div>

        @forelse($promotions as $product)
            @php
                $imageUrl = $product->image && Storage::disk('public')->exists($product->image)
                    ? Storage::disk('public')->url($product->image)
                    : asset('images/tay-bac-specialties-hero.png');
                $promotionStatus = $product->isOnSale() ? 'active' : ($product->sale_start && $product->sale_start->isFuture() ? 'upcoming' : 'expired');
                $statusText = ['active' => 'Đang diễn ra', 'upcoming' => 'Sắp diễn ra', 'expired' => 'Đã hết hạn'][$promotionStatus];
            @endphp
            <div class="promotion-row">
                <img class="promotion-product-image" src="{{ $imageUrl }}" alt="{{ $product->name }}">
                <div>
                    <a class="promotion-product-name" href="{{ route('admin.products.show', $product) }}">{{ $product->name }}</a>
                    <span class="promotion-category">{{ $product->category?->name ?? 'Chưa phân loại' }} · {{ $product->unit }}</span>
                </div>
                <div>
                    <span class="promotion-price-old">{{ number_format($product->price, 0, ',', '.') }}đ/{{ $product->unit }}</span>
                    <span class="promotion-price-new">{{ number_format($product->sale_price, 0, ',', '.') }}đ/{{ $product->unit }}</span>
                    <span class="promotion-discount">Giảm {{ $product->getDiscountPercent() }}%</span>
                </div>
                <div class="promotion-period">
                    <span class="promotion-status status-{{ $promotionStatus }}">{{ $statusText }}</span><br>
                    Từ: {{ $product->sale_start?->format('d/m/Y H:i') ?? 'Ngay khi kích hoạt' }}<br>
                    Đến: {{ $product->sale_end?->format('d/m/Y H:i') ?? 'Không giới hạn' }}
                </div>
                <div class="promotion-actions">
                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-secondary">Xem</a>
                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#promotionModal{{ $product->id }}">Chỉnh sale</button>
                    <form action="{{ route('admin.products.removePromotion', $product) }}" method="POST" onsubmit="return confirm('Gỡ khuyến mại của sản phẩm này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Gỡ</button>
                    </form>
                </div>
            </div>

            <div class="modal fade" id="promotionModal{{ $product->id }}" tabindex="-1" aria-labelledby="promotionModalLabel{{ $product->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form class="modal-content" action="{{ route('admin.products.setPromotion', $product) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-header">
                            <h5 class="modal-title" id="promotionModalLabel{{ $product->id }}">Chỉnh khuyến mại: {{ $product->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">
                            <p class="small text-muted">Giá gốc: <strong>{{ number_format($product->price, 0, ',', '.') }}đ/{{ $product->unit }}</strong></p>
                            <div class="mb-3">
                                <label class="form-label" for="sale_price_{{ $product->id }}">Giá khuyến mại</label>
                                <input class="form-control" type="number" id="sale_price_{{ $product->id }}" name="sale_price" value="{{ $product->sale_price }}" min="0" max="{{ max((float) $product->price - 1, 0) }}" required>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="sale_start_{{ $product->id }}">Bắt đầu</label>
                                    <input class="form-control" type="datetime-local" id="sale_start_{{ $product->id }}" name="sale_start" value="{{ $product->sale_start?->format('Y-m-d\TH:i') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="sale_end_{{ $product->id }}">Kết thúc</label>
                                    <input class="form-control" type="datetime-local" id="sale_end_{{ $product->id }}" name="sale_end" value="{{ $product->sale_end?->format('Y-m-d\TH:i') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-danger">Lưu khuyến mại</button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="promotion-empty">
                <div class="fs-2">🏷️</div>
                <strong>Chưa có sản phẩm khuyến mại ở trạng thái này.</strong>
                <p class="mb-0 mt-2">Vào mục Sản phẩm để thiết lập giá và thời gian giảm giá.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $promotions->links() }}</div>
</div>
@endsection
