@extends('layouts.app')

@section('title', 'Hồ sơ người dùng')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Hồ sơ cá nhân</h2>
                <p class="text-muted mb-0">Thông tin tài khoản của bạn</p>
            </div>
            <span class="badge bg-success rounded-pill px-3 py-2">Customer</span>
        </div>

        <div class="row g-4 align-items-center">
            <div class="col-md-4 text-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto border border-success border-3 text-success fw-bold" style="width: 120px; height: 120px; font-size: 2rem; background: #ecfdf5;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            </div>

            <div class="col-md-8">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Họ tên</label>
                        <div class="fw-bold fs-5">{{ $user->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block">Vai trò</label>
                        <div class="fw-bold fs-5 text-success">{{ ucfirst($user->role) }}</div>
                    </div>
                    <div class="col-md-12">
                        <label class="text-muted small d-block">Email</label>
                        <div class="fw-bold fs-6">{{ $user->email }}</div>
                    </div>
                    <div class="col-md-12">
                        <label class="text-muted small d-block">Trạng thái</label>
                        <div class="fw-bold text-success">Đang hoạt động</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
