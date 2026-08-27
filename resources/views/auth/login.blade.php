<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập | Phương Nam Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #eef2ff, #f8fafc 45%, #e0f2fe);
        }
        .auth-card {
            width: 100%;
            max-width: 460px;
            background: rgba(255,255,255,0.9);
            border: none;
            border-radius: 1.2rem;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
        }
        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            border: none;
        }
    </style>
</head>
<body>
    <div class="card auth-card p-4">
        <div class="text-center mb-4">
            <h2 class="fw-bold mb-1">Đăng nhập</h2>
            <p class="text-muted mb-0">Chào mừng bạn quay lại Phương Nam Shop</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        </form>

        <p class="text-center mt-4 mb-0">
            Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
        </p>
    </div>
</body>
</html>