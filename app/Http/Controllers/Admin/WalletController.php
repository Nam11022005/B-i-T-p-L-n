<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class WalletController extends Controller
{
    public function adjust(Request $request, User $customer)
    {
        abort_unless($customer->role === 'customer', 404);

        $data = $request->validate([
            'direction' => ['required', 'in:credit,debit'],
            'amount' => ['required', 'numeric', 'min:1000', 'max:50000000'],
            'note' => ['required', 'string', 'max:500'],
        ], [
            'amount.min' => 'Số tiền điều chỉnh tối thiểu là 1.000đ.',
            'note.required' => 'Cần nhập lý do điều chỉnh để lưu lịch sử.',
        ]);

        try {
            DB::transaction(function () use ($customer, $data) {
                $lockedCustomer = User::query()->whereKey($customer->id)->lockForUpdate()->firstOrFail();
                $amount = round((float) $data['amount'], 2);
                $isCredit = $data['direction'] === 'credit';

                if (!$isCredit && (float) $lockedCustomer->wallet_balance < $amount) {
                    throw ValidationException::withMessages([
                        'amount' => 'Số dư hiện tại không đủ để trừ số tiền này.',
                    ]);
                }

                $newBalance = round(
                    (float) $lockedCustomer->wallet_balance + ($isCredit ? $amount : -$amount),
                    2
                );

                $lockedCustomer->wallet_balance = $newBalance;
                $lockedCustomer->save();

                do {
                    $referenceCode = 'ADM' . strtoupper(Str::random(10));
                } while (WalletTransaction::where('reference_code', $referenceCode)->exists());

                WalletTransaction::create([
                    'user_id' => $lockedCustomer->id,
                    'type' => $isCredit ? 'admin_credit' : 'admin_debit',
                    'status' => 'completed',
                    'amount' => $amount,
                    'balance_after' => $newBalance,
                    'reference_code' => $referenceCode,
                    'description' => trim($data['note']) . ' (Điều chỉnh bởi quản trị viên #' . Auth::id() . ').',
                ]);
            });
        } catch (ValidationException $exception) {
            throw $exception;
        }

        return back()->with('success', 'Đã điều chỉnh số dư ví và lưu lịch sử giao dịch.');
    }
}
