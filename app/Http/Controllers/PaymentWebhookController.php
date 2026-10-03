<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\OrderStatusHistory;
use App\Models\User;
use App\Models\WalletTransaction;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SEPAY WEBHOOK
    |--------------------------------------------------------------------------
    */

    public function sepay(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | KIỂM TRA API KEY
        |--------------------------------------------------------------------------
        */

        $expectedKey = (string) env(
            'SEPAY_WEBHOOK_API_KEY',
            ''
        );

        $authorization = (string) $request->header(
            'Authorization',
            ''
        );


        if (
            $expectedKey === ''
            ||
            !hash_equals(
                'Apikey ' . $expectedKey,
                $authorization
            )
        ) {

            return response()->json([
                'success' => false,
                'message' => 'Unauthorized webhook.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATE DỮ LIỆU SEPAY
        |--------------------------------------------------------------------------
        */

        $data = $request->validate([

            'id' =>
                'required',

            'transferType' =>
                'required|string',

            'transferAmount' =>
                'required|numeric|min:0',

            'content' =>
                'nullable|string',

            'code' =>
                'nullable|string',

            'referenceCode' =>
                'nullable|string',

            'gateway' =>
                'nullable|string',

            'accountNumber' =>
                'nullable|string',

            'transactionDate' =>
                'nullable|string',

            'description' =>
                'nullable|string',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CHỈ XỬ LÝ TIỀN VÀO
        |--------------------------------------------------------------------------
        */

        if (
            strtolower(
                $data['transferType']
            )
            !==
            'in'
        ) {

            return response()->json([
                'success' => true,
            ]);
        }


        $providerTransactionId =
            (string) $data['id'];


        try {

            DB::transaction(
                function () use (
                    $data,
                    $providerTransactionId
                ) {

                    if ($this->processWalletTopUp($data, $providerTransactionId)) {
                        return;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | CHỐNG WEBHOOK RETRY
                    |--------------------------------------------------------------------------
                    */

                    $alreadyProcessed =
                        DB::table(
                            'payment_transactions'
                        )
                            ->where(
                                'provider',
                                'sepay'
                            )
                            ->where(
                                'provider_transaction_id',
                                $providerTransactionId
                            )
                            ->exists();


                    if ($alreadyProcessed) {

                        Log::info(
                            'SePay webhook: giao dịch đã xử lý trước đó.',
                            [
                                'transaction_id' =>
                                    $providerTransactionId,
                            ]
                        );

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | LẤY MÃ THANH TOÁN
                    |--------------------------------------------------------------------------
                    */

                    $code =
                        strtoupper(
                            trim(
                                (string) (
                                    $data['code']
                                    ??
                                    ''
                                )
                            )
                        );


                    $content =
                        strtoupper(
                            (string) (
                                $data['content']
                                ??
                                ''
                            )
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | TÌM ĐƠN HÀNG
                    |--------------------------------------------------------------------------
                    |
                    | Chỉ tìm đơn:
                    |
                    | - chuyển khoản ngân hàng
                    | - chưa thanh toán
                    |
                    */

                    $orderQuery =
                        Order::query()
                            ->where(
                                'payment_method',
                                'bank'
                            )
                            ->where(
                                'payment_status',
                                '!=',
                                'paid'
                            );


                    $order = null;


                    /*
                    |--------------------------------------------------------------------------
                    | ƯU TIÊN MÃ CODE SEPAY
                    |--------------------------------------------------------------------------
                    */

                    if ($code !== '') {

                        $order =
                            (clone $orderQuery)

                                ->whereRaw(
                                    'UPPER(payment_code) = ?',
                                    [
                                        $code,
                                    ]
                                )

                                ->lockForUpdate()

                                ->first();
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | NẾU KHÔNG CÓ CODE → TÌM TRONG CONTENT
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !$order
                        &&
                        $content !== ''
                    ) {

                        $candidates =
                            (clone $orderQuery)

                                ->whereNotNull(
                                    'payment_code'
                                )

                                ->lockForUpdate()

                                ->get();


                        $order =
                            $candidates->first(
                                function (
                                    $candidate
                                ) use (
                                    $content
                                ) {

                                    return str_contains(
                                        $content,
                                        strtoupper(
                                            (string)
                                                $candidate
                                                    ->payment_code
                                        )
                                    );

                                }
                            );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | KHÔNG TÌM THẤY ĐƠN
                    |--------------------------------------------------------------------------
                    */

                    if (!$order) {

                        Log::warning(
                            'SePay webhook: không tìm thấy đơn hàng.',
                            [
                                'transaction_id' =>
                                    $providerTransactionId,

                                'code' =>
                                    $code,

                                'content' =>
                                    $content,
                            ]
                        );

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | ĐƠN ĐÃ BỊ HỦY
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $order->status
                        ===
                        'cancelled'
                    ) {

                        Log::warning(
                            'SePay webhook: giao dịch đến cho đơn hàng đã bị hủy.',
                            [
                                'order_id' =>
                                    $order->id,

                                'transaction_id' =>
                                    $providerTransactionId,
                            ]
                        );

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | XÁC ĐỊNH THỜI ĐIỂM GIAO DỊCH
                    |--------------------------------------------------------------------------
                    |
                    | Ưu tiên transactionDate từ SePay.
                    |
                    | Nếu SePay không gửi hoặc không parse được
                    | thì dùng thời gian hiện tại.
                    |
                    */

                    $transactionTime =
                        now();


                    if (
                        !empty(
                            $data[
                                'transactionDate'
                            ]
                        )
                    ) {

                        try {

                            $transactionTime =
                                Carbon::parse(
                                    $data[
                                        'transactionDate'
                                    ]
                                );

                        } catch (\Throwable $e) {

                            Log::warning(
                                'SePay webhook: không đọc được transactionDate.',
                                [
                                    'transactionDate' =>
                                        $data[
                                            'transactionDate'
                                        ],
                                ]
                            );
                        }
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | KIỂM TRA HẾT HẠN THANH TOÁN 5 PHÚT
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $order->payment_expires_at
                        &&
                        $transactionTime
                            ->greaterThan(
                                $order
                                    ->payment_expires_at
                            )
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | TỰ ĐỘNG HỦY ĐƠN
                        |--------------------------------------------------------------------------
                        */

                        $this->cancelExpiredOrder(
                            $order
                        );


                        Log::warning(
                            'SePay webhook: thanh toán đến sau thời hạn.',
                            [
                                'order_id' =>
                                    $order->id,

                                'transaction_id' =>
                                    $providerTransactionId,

                                'transaction_time' =>
                                    $transactionTime
                                        ->toDateTimeString(),

                                'expired_at' =>
                                    optional(
                                        $order
                                            ->payment_expires_at
                                    )
                                        ->toDateTimeString(),
                            ]
                        );


                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | KIỂM TRA SỐ TIỀN
                    |--------------------------------------------------------------------------
                    */

                    $receivedAmount =
                        round(
                            (float)
                                $data[
                                    'transferAmount'
                                ],
                            2
                        );


                    $requiredAmount =
                        round(
                            (float)
                                $order
                                    ->total_price,
                            2
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | CHƯA CHUYỂN ĐỦ
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $receivedAmount
                        <
                        $requiredAmount
                    ) {

                        Log::warning(
                            'SePay webhook: số tiền chưa đủ.',
                            [
                                'order_id' =>
                                    $order->id,

                                'required' =>
                                    $requiredAmount,

                                'received' =>
                                    $receivedAmount,

                                'transaction_id' =>
                                    $providerTransactionId,
                            ]
                        );


                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | LƯU GIAO DỊCH
                    |--------------------------------------------------------------------------
                    */

                    DB::table(
                        'payment_transactions'
                    )->insert([

                        'provider' =>
                            'sepay',

                        'provider_transaction_id' =>
                            $providerTransactionId,

                        'order_id' =>
                            $order->id,

                        'amount' =>
                            $receivedAmount,

                        'reference_code' =>
                            $data[
                                'referenceCode'
                            ]
                            ??
                            null,

                        'content' =>
                            $data[
                                'content'
                            ]
                            ??
                            null,

                        'raw_payload' =>
                            json_encode(
                                $data,
                                JSON_UNESCAPED_UNICODE
                                |
                                JSON_UNESCAPED_SLASHES
                            ),

                        'created_at' =>
                            now(),

                        'updated_at' =>
                            now(),
                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | XÁC NHẬN THANH TOÁN
                    |--------------------------------------------------------------------------
                    |
                    | QUAN TRỌNG:
                    |
                    | Checkout đã trừ tồn kho khi tạo đơn.
                    |
                    | Webhook chỉ xác nhận tiền.
                    |
                    | KHÔNG được trừ tồn kho lần nữa.
                    |
                    */

                    $order->payment_status =
                        'paid';


                    /*
                    |--------------------------------------------------------------------------
                    | THANH TOÁN XONG → XÓA THỜI HẠN
                    |--------------------------------------------------------------------------
                    */

                    $order->payment_expires_at =
                        null;


                    $order->save();


                    /*
                    |--------------------------------------------------------------------------
                    | LOG
                    |--------------------------------------------------------------------------
                    */

                    Log::info(
                        'SePay webhook: thanh toán thành công.',
                        [
                            'order_id' =>
                                $order->id,

                            'transaction_id' =>
                                $providerTransactionId,

                            'amount' =>
                                $receivedAmount,
                        ]
                    );
                }
            );


            /*
            |--------------------------------------------------------------------------
            | LUÔN TRẢ 200 NẾU XỬ LÝ THÀNH CÔNG
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'success' => true,
            ]);

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | LOG LỖI
            |--------------------------------------------------------------------------
            */

            Log::error(
                'SePay webhook error',
                [
                    'message' =>
                        $e->getMessage(),

                    'transaction_id' =>
                        $providerTransactionId,

                    'payload' =>
                        $data,
                ]
            );


            return response()->json([
                'success' => false,
                'message' =>
                    'Webhook processing failed.',
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | TỰ ĐỘNG HỦY ĐƠN HẾT HẠN THANH TOÁN
    |--------------------------------------------------------------------------
    |
    | Checkout đã trừ tồn kho khi tạo đơn.
    |
    | Khi đơn bị hủy do hết 5 phút:
    |
    | 1. Hoàn lại tồn kho.
    | 2. Hoàn lại lượt Voucher.
    | 3. status = cancelled.
    | 4. payment_status = unpaid.
    | 5. Ghi timeline.
    |
    */

    private function processWalletTopUp(
        array $data,
        string $providerTransactionId
    ): bool {
        $code = strtoupper(trim((string) ($data['code'] ?? '')));
        $content = strtoupper((string) ($data['content'] ?? ''));

        if (!str_starts_with($code, 'WLT') && !str_contains($content, 'WLT')) {
            return false;
        }

        $topUp = WalletTransaction::query()
            ->where('type', 'topup')
            ->where('status', 'pending')
            ->whereRaw('UPPER(reference_code) = ?', [$code])
            ->lockForUpdate()
            ->first();

        if (!$topUp && $content !== '') {
            $topUp = WalletTransaction::query()
                ->where('type', 'topup')
                ->where('status', 'pending')
                ->whereNotNull('reference_code')
                ->lockForUpdate()
                ->get()
                ->first(fn (WalletTransaction $transaction) => str_contains(
                    $content,
                    strtoupper($transaction->reference_code)
                ));
        }

        if (!$topUp) {
            return false;
        }

        if (WalletTransaction::query()
            ->where('provider', 'sepay')
            ->where('provider_transaction_id', $providerTransactionId)
            ->exists()) {
            return true;
        }

        $receivedAmount = round((float) $data['transferAmount'], 2);

        if ($receivedAmount < (float) $topUp->amount) {
            Log::warning('SePay webhook: số tiền nạp ví chưa đủ.', [
                'wallet_transaction_id' => $topUp->id,
                'received' => $receivedAmount,
            ]);

            return true;
        }

        $user = User::query()
            ->whereKey($topUp->user_id)
            ->lockForUpdate()
            ->firstOrFail();

        $newBalance = round((float) $user->wallet_balance + $receivedAmount, 2);
        $user->wallet_balance = $newBalance;
        $user->save();

        $topUp->update([
            'status' => 'completed',
            'amount' => $receivedAmount,
            'balance_after' => $newBalance,
            'provider' => 'sepay',
            'provider_transaction_id' => $providerTransactionId,
            'description' => 'Nạp tiền qua chuyển khoản ngân hàng.',
            'raw_payload' => json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);

        return true;
    }

    private function cancelExpiredOrder(
        Order $order
    ): void {

        /*
        |--------------------------------------------------------------------------
        | ĐÃ HỦY → KHÔNG LÀM LẠI
        |--------------------------------------------------------------------------
        */

        if (
            $order->status
            ===
            'cancelled'
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | ĐÃ THANH TOÁN → TUYỆT ĐỐI KHÔNG HỦY
        |--------------------------------------------------------------------------
        */

        if (
            $order->payment_status
            ===
            'paid'
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | LOAD SẢN PHẨM TRONG ĐƠN
        |--------------------------------------------------------------------------
        */

        $order->load(
            'items'
        );


        /*
        |--------------------------------------------------------------------------
        | HOÀN LẠI TỒN KHO
        |--------------------------------------------------------------------------
        */

        foreach (
            $order->items
            as
            $item
        ) {

            $product =
                Product::whereKey(
                    $item->product_id
                )
                    ->lockForUpdate()
                    ->first();


            /*
             * Nếu sản phẩm đã bị xóa
             * thì bỏ qua để tránh lỗi toàn bộ transaction.
             */

            if (!$product) {
                continue;
            }


            $currentStock =
                (float)
                    $product
                        ->quantity;


            $returnQuantity =
                (float)
                    $item
                        ->quantity;


            $product->quantity =
                round(
                    $currentStock
                    +
                    $returnQuantity,
                    2
                );


            $product->save();
        }


        /*
        |--------------------------------------------------------------------------
        | HOÀN LẠI LƯỢT DÙNG VOUCHER
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $order->voucher_code
            )
        ) {

            $voucher =
                Voucher::where(
                    'code',
                    $order
                        ->voucher_code
                )
                    ->lockForUpdate()
                    ->first();


            if (
                $voucher
                &&
                (int)
                    $voucher
                        ->used_count
                >
                0
            ) {

                $voucher->decrement(
                    'used_count'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | HỦY ĐƠN
        |--------------------------------------------------------------------------
        */

        $order->status =
            'cancelled';


        $order->payment_status =
            'unpaid';


        $order->save();


        /*
        |--------------------------------------------------------------------------
        | GHI LỊCH SỬ
        |--------------------------------------------------------------------------
        */

        OrderStatusHistory::create([

            'order_id' =>
                $order->id,

            'user_id' =>
                $order->user_id,

            'status' =>
                'cancelled',

            'title' =>
                'Đơn hàng tự động bị hủy',

            'note' =>
                'Đơn hàng đã quá thời hạn 5 phút nhưng hệ thống chưa nhận được thanh toán chuyển khoản.',
        ]);
    }
}
