<?php

namespace App\Http\Controllers;

use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WalletController extends Controller
{
    public function createTopUp(Request $request)
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:10000', 'max:50000000'],
        ], [
            'amount.required' => 'Vui lòng nhập số tiền cần nạp.',
            'amount.min' => 'Số tiền nạp tối thiểu là 10.000đ.',
            'amount.max' => 'Số tiền nạp tối đa cho mỗi giao dịch là 50.000.000đ.',
        ]);

        $user = Auth::user();

        do {
            $referenceCode = 'WLT' . strtoupper(Str::random(10));
        } while (WalletTransaction::where('reference_code', $referenceCode)->exists());

        $topUp = WalletTransaction::create([
            'user_id' => $user->id,
            'type' => 'topup',
            'status' => 'pending',
            'amount' => round((float) $data['amount'], 2),
            'reference_code' => $referenceCode,
            'description' => 'Chờ chuyển khoản nạp ví.',
        ]);

        return redirect()
            ->route('profile', ['wallet_topup' => $topUp->id])
            ->with('success', 'Đã tạo yêu cầu nạp ví. Hãy quét QR và giữ nguyên nội dung chuyển khoản.');
    }
}
