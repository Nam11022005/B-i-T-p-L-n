@extends('admin.layouts.app')

@section('content')

<div class="container py-4">

    <h2 class="mb-4">
        👤 Hồ sơ Admin
    </h2>

    <div class="card shadow-sm">

        <div class="card-body">

            <h5 class="fw-bold mb-3">
                Thông tin tài khoản
            </h5>

            <p>
                <strong>Họ tên:</strong>
                {{ $user->name }}
            </p>

            <p>
                <strong>Email:</strong>
                {{ $user->email }}
            </p>

            <p>
                <strong>Quyền:</strong>

                <span class="badge bg-danger">
                    {{ $user->role }}
                </span>
            </p>

        </div>

    </div>

</div>

@endsection