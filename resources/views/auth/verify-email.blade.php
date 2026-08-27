@extends('layouts.app')

@section('title', 'Xác thực email')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6 col-lg-5">

            <div class="card shadow border-0">

                <div class="card-body p-5">

                    <div class="text-center mb-4">

                        <div style="font-size: 60px;">
                            📧
                        </div>

                        <h2 class="fw-bold mt-3">
                            Xác thực email
                        </h2>

                        <p class="text-muted">

                            Chúng tôi đã gửi mã xác thực gồm
                            <strong>6 chữ số</strong> tới:

                        </p>

                        <strong class="text-primary">
                            {{ Auth::user()->email }}
                        </strong>

                    </div>


                    {{-- SUCCESS --}}
                    @if(session('success'))

                        <div class="alert alert-success">

                            ✅ {{ session('success') }}

                        </div>

                    @endif


                    {{-- ERROR --}}
                    @if(session('error'))

                        <div class="alert alert-danger">

                            ❌ {{ session('error') }}

                        </div>

                    @endif


                    @if($errors->any())

                        <div class="alert alert-danger">

                            @foreach($errors->all() as $error)

                                <div>
                                    {{ $error }}
                                </div>

                            @endforeach

                        </div>

                    @endif


                    {{-- ==================================
                        FORM NHẬP OTP
                    ================================== --}}
                    <form
                        action="{{ route('verification.verify.code') }}"
                        method="POST"
                    >

                        @csrf


                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Mã xác thực

                            </label>


                            <input
                                type="text"
                                name="verification_code"
                                class="
                                    form-control
                                    form-control-lg
                                    text-center
                                    fw-bold
                                "
                                maxlength="6"
                                inputmode="numeric"
                                autocomplete="one-time-code"
                                placeholder="000000"
                                style="
                                    letter-spacing: 12px;
                                    font-size: 26px;
                                "
                                required
                                autofocus
                            >

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary btn-lg w-100"
                        >
                            ✅ Xác thực email
                        </button>

                    </form>


                    <hr class="my-4">


                    {{-- ==================================
                        GỬI LẠI MÃ
                    ================================== --}}
                    <div class="text-center">

                        <p class="text-muted mb-2">

                            Bạn chưa nhận được mã?

                        </p>


                        <form
                            action="{{ route('verification.resend') }}"
                            method="POST"
                        >

                            @csrf


                            <button
                                type="submit"
                                class="btn btn-outline-primary"
                            >
                                🔄 Gửi lại mã xác thực
                            </button>

                        </form>

                    </div>


                    <div class="text-center mt-4">

                        <small class="text-muted">

                            ⏱️ Mã xác thực có hiệu lực trong
                            <strong>10 phút</strong>.

                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection