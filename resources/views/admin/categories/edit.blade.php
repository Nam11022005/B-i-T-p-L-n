@extends('admin.layouts.app')

@section('title', 'Sửa danh mục | Tinh Hoa Tây Bắc')

@section('content')

<style>
:root{
    --tb-brown:#5f341d;--tb-dark:#2c1810;--tb-red:#a83b2d;
    --tb-gold:#f2c15c;--tb-green:#48633b;--tb-border:#ead8bf;
}
.category-form-page{position:relative;isolation:isolate;padding:34px 0 78px}
.category-form-page:before{content:"";position:absolute;z-index:-2;top:-35px;left:50%;
width:min(100vw,1760px);height:700px;transform:translateX(-50%);pointer-events:none;
background:radial-gradient(circle at 8% 8%,rgba(242,193,92,.18),transparent 24%),
radial-gradient(circle at 94% 11%,rgba(72,99,59,.13),transparent 28%),
linear-gradient(180deg,rgba(255,250,240,.96),rgba(255,255,255,0))}
.category-form-shell{overflow:hidden;border:1px solid #e3cdae;border-radius:30px;background:#fff;
box-shadow:0 28px 70px rgba(72,43,27,.12),0 5px 18px rgba(72,43,27,.05)}
.category-form-hero{position:relative;overflow:hidden;min-height:190px;display:flex;align-items:center;
justify-content:space-between;gap:28px;padding:34px 38px;color:#fff;
background:radial-gradient(circle at 87% 13%,rgba(242,193,92,.24),transparent 28%),
linear-gradient(135deg,#28150d 0%,#5f341d 53%,#48633b 100%)}
.category-form-hero:after{content:"🧺";position:absolute;right:42px;top:18px;font-size:92px;opacity:.07}
.category-form-hero>*{position:relative;z-index:2}
.category-kicker{display:inline-flex;padding:6px 11px;margin-bottom:9px;border:1px solid rgba(242,193,92,.3);
border-radius:999px;color:#f5d98e;background:rgba(255,255,255,.055);font-size:11px;font-weight:900;letter-spacing:.09em}
.category-form-hero h1{font-size:clamp(31px,3vw,44px);font-weight:900;letter-spacing:-.8px}
.category-form-hero p{max-width:650px;color:rgba(255,255,255,.76);line-height:1.7}
.category-back{min-height:44px;display:inline-flex;align-items:center;padding:9px 17px;border:1px solid rgba(255,255,255,.25);
border-radius:999px;color:#fff;background:rgba(255,255,255,.08);text-decoration:none;font-weight:800}
.category-back:hover{color:#fff;background:rgba(255,255,255,.14)}
.category-form-body{padding:36px;background:linear-gradient(180deg,#fff,#fffdf9)}
.category-form-grid{display:grid;grid-template-columns:minmax(0,1.12fr) minmax(280px,.88fr);gap:28px}
.category-card{border:1px solid #e5d0b3;border-radius:22px;background:linear-gradient(180deg,#fff,#fffdfa);
box-shadow:0 15px 38px rgba(95,52,29,.07);padding:26px}
.category-preview{position:relative;overflow:hidden;background:radial-gradient(circle at 90% 10%,rgba(242,193,92,.16),transparent 27%),
linear-gradient(145deg,#fffdf8,#fff5e5)}
.category-preview-icon{width:82px;height:82px;display:grid;place-items:center;margin-bottom:20px;border:1px solid #e4c99e;
border-radius:24px;background:linear-gradient(135deg,#fff1cf,#f7deb0);font-size:40px;box-shadow:0 10px 22px rgba(95,52,29,.08)}
.category-label{margin-bottom:8px;color:#51372a;font-size:13px;font-weight:850}
.category-input{min-height:52px;border:1px solid #dfcbae;border-radius:14px;background:linear-gradient(180deg,#fffefb,#fffaf3)}
.category-input:focus{border-color:#d0a05d;background:#fff;box-shadow:0 0 0 .2rem rgba(217,119,6,.09)}
.category-help{margin-top:11px;padding:13px 15px;border:1px solid #ebd2a4;border-radius:14px;background:linear-gradient(135deg,#fff9e7,#fff2cf);
color:#6a5234;font-size:13px;line-height:1.6}
.category-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:26px;padding-top:22px;border-top:1px solid var(--tb-border)}
.category-actions .btn{min-height:46px;padding-inline:18px;border-radius:12px;font-weight:850}
.category-save{min-width:170px;border:0;color:#fff;background:linear-gradient(135deg,#a83b2d,#5f341d 50%,#48633b);
box-shadow:0 10px 22px rgba(95,52,29,.17)}
.category-save:hover{color:#fff;transform:translateY(-1px)}
.category-cancel{border-color:#ccb28e;color:#5f341d;background:#fff}
.category-cancel:hover{color:#fff;background:#5f341d;border-color:#5f341d}
.category-form-page .alert{border-radius:15px}
@media(max-width:991.98px){.category-form-grid{grid-template-columns:1fr}}
@media(max-width:767.98px){
.category-form-shell{border-radius:22px}.category-form-hero{flex-direction:column;align-items:flex-start;padding:26px 22px}
.category-form-body{padding:22px}.category-card{border-radius:18px}.category-actions{flex-direction:column-reverse}.category-actions .btn{width:100%}}
</style>

<div class="container-fluid category-form-page">
    <div class="category-form-shell">
        <section class="category-form-hero">
            <div>
                <div class="category-kicker">⚙️ QUẢN TRỊ DANH MỤC</div>
                <h1 class="mb-2">✏️ Cập nhật danh mục</h1>
                <p class="mb-0">Chỉnh sửa tên danh mục và giữ nguyên các sản phẩm đang thuộc danh mục này.</p>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="category-back">← Quay lại danh mục</a>
        </section>

        <div class="category-form-body">
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <strong class="d-block mb-2">⚠️ Vui lòng kiểm tra lại:</strong>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="category-form-grid">
                <div class="category-card">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label for="name" class="category-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name', $category->name) }}"
                               class="form-control category-input @error('name') is-invalid @enderror"
                               maxlength="255" required autofocus>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <div class="category-help">
                            💡 Tên hiện tại: <strong>{{ $category->name }}</strong>.
                            Đổi tên sẽ cập nhật cách danh mục được hiển thị trên website.
                        </div>

                        <div class="category-actions">
                            <a href="{{ route('admin.categories.index') }}" class="btn category-cancel">Hủy</a>
                            <button type="submit" class="btn category-save">✓ Lưu thay đổi</button>
                        </div>
                    </form>
                </div>

                <aside class="category-card category-preview">
                    <div class="category-preview-icon">🌿</div>
                    <div class="small fw-bold mb-2" style="color:#48633b;">DANH MỤC HIỆN TẠI</div>
                    <h4 class="fw-bold mb-2">{{ $category->name }}</h4>
                    <p class="text-muted mb-0">ID danh mục: <strong>#{{ $category->id }}</strong></p>
                </aside>
            </div>
        </div>
    </div>
</div>
@endsection
