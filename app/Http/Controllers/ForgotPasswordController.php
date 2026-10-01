<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORM NHẬP EMAIL
    |--------------------------------------------------------------------------
    */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }


    /*
    |--------------------------------------------------------------------------
    | GỬI OTP
    |--------------------------------------------------------------------------
    */
    public function sendOtp(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users,email',
            ],
            [
                'email.required' => 'Vui lòng nhập địa chỉ email.',
                'email.email' => 'Địa chỉ email không hợp lệ.',
                'email.exists' => 'Email này chưa được đăng ký trong hệ thống.',
            ]
        );

        // Tạo OTP 6 số
        $otp = (string) random_int(100000, 999999);

        /*
         * Lưu OTP trong session.
         * OTP có hiệu lực 5 phút.
         */
        session([
            'forgot_password_email' => $request->email,
            'forgot_password_otp' => $otp,
            'forgot_password_otp_expires_at' => now()->addMinutes(5)->timestamp,
            'forgot_password_verified' => false,
        ]);

        /*
         * Gửi OTP qua email
         */
        Mail::raw(
            "Xin chào!\n\n"
            . "Bạn vừa yêu cầu đặt lại mật khẩu cho tài khoản Tinh Hoa Tây Bắc.\n\n"
            . "Mã OTP của bạn là: {$otp}\n\n"
            . "Mã OTP có hiệu lực trong 5 phút.\n\n"
            . "Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email.\n\n"
            . "Tinh Hoa Tây Bắc",
            function ($message) use ($request) {
                $message
                    ->to($request->email)
                    ->subject('Mã OTP đặt lại mật khẩu | Tinh Hoa Tây Bắc');
            }
        );

        return redirect()
            ->route('password.otp.form')
            ->with('success', 'Mã OTP đã được gửi đến email của bạn.');
    }


    /*
    |--------------------------------------------------------------------------
    | FORM NHẬP OTP
    |--------------------------------------------------------------------------
    */
    public function showOtpForm()
    {
        if (!session()->has('forgot_password_email')) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Vui lòng nhập email trước.',
                ]);
        }

        return view('auth.verify-forgot-password-otp');
    }


    /*
    |--------------------------------------------------------------------------
    | KIỂM TRA OTP
    |--------------------------------------------------------------------------
    */
    public function verifyOtp(Request $request)
    {
        $request->validate(
            [
                'otp' => 'required|digits:6',
            ],
            [
                'otp.required' => 'Vui lòng nhập mã OTP.',
                'otp.digits' => 'Mã OTP phải gồm 6 chữ số.',
            ]
        );

        $sessionOtp = session('forgot_password_otp');
        $expiresAt = session('forgot_password_otp_expires_at');

        if (!$sessionOtp || !$expiresAt) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'otp' => 'Phiên đặt lại mật khẩu không hợp lệ.',
                ]);
        }

        /*
         * Kiểm tra OTP hết hạn
         */
        if (now()->timestamp > $expiresAt) {
            session()->forget([
                'forgot_password_otp',
                'forgot_password_otp_expires_at',
                'forgot_password_verified',
            ]);

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'otp' => 'Mã OTP đã hết hạn. Vui lòng yêu cầu mã mới.',
                ]);
        }

        /*
         * Kiểm tra OTP
         */
        if (!hash_equals((string) $sessionOtp, (string) $request->otp)) {
            return back()
                ->withInput()
                ->withErrors([
                    'otp' => 'Mã OTP không chính xác.',
                ]);
        }

        /*
         * Đánh dấu đã xác thực OTP
         */
        session([
            'forgot_password_verified' => true,
        ]);

        /*
         * Không cần giữ OTP sau khi xác thực
         */
        session()->forget([
            'forgot_password_otp',
            'forgot_password_otp_expires_at',
        ]);

        return redirect()
            ->route('password.reset.form')
            ->with('success', 'Xác thực OTP thành công.');
    }


    /*
    |--------------------------------------------------------------------------
    | FORM ĐẶT MẬT KHẨU MỚI
    |--------------------------------------------------------------------------
    */
    public function showResetForm()
    {
        if (
            !session()->has('forgot_password_email')
            || session('forgot_password_verified') !== true
        ) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Vui lòng xác thực OTP trước.',
                ]);
        }

        return view('auth.reset-password');
    }


    /*
    |--------------------------------------------------------------------------
    | CẬP NHẬT MẬT KHẨU
    |--------------------------------------------------------------------------
    */
    public function resetPassword(Request $request)
    {
        if (
            !session()->has('forgot_password_email')
            || session('forgot_password_verified') !== true
        ) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Phiên đặt lại mật khẩu không hợp lệ.',
                ]);
        }

        $request->validate(
            [
                'password' => 'required|string|min:8|confirmed',
            ],
            [
                'password.required' => 'Vui lòng nhập mật khẩu mới.',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
                'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            ]
        );

        $email = session('forgot_password_email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            session()->forget([
                'forgot_password_email',
                'forgot_password_verified',
            ]);

            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Không tìm thấy tài khoản.',
                ]);
        }

        /*
         * Mã hóa mật khẩu mới
         */
        $user->password = Hash::make($request->password);
        $user->save();

        /*
         * Xóa toàn bộ session reset password
         */
        session()->forget([
            'forgot_password_email',
            'forgot_password_otp',
            'forgot_password_otp_expires_at',
            'forgot_password_verified',
        ]);

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Đổi mật khẩu thành công! Bạn có thể đăng nhập bằng mật khẩu mới.'
            );
    }
}