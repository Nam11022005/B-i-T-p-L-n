<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Env;
use Tests\TestCase;

class PaymentWebhookFlowTest extends TestCase
{
    use RefreshDatabase;


    protected function setUp(): void
    {
        parent::setUp();

        Env::getRepository()->set(
            'SEPAY_WEBHOOK_API_KEY',
            'test-sepay-key'
        );
    }


    private function createCustomer(): User
    {
        return User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
    }


    private function createBankOrder(
        User $customer,
        array $attributes = []
    ): Order {
        return Order::create(
            array_merge(
                [
                    'user_id' =>
                        $customer->id,

                    'customer_name' =>
                        $customer->name,

                    'customer_phone' =>
                        '0385742505',

                    'shipping_address' =>
                        '123 Đường Test, Hà Nội',

                    'notes' =>
                        null,

                    'subtotal' =>
                        500000,

                    'shipping_fee' =>
                        25000,

                    'discount' =>
                        0,

                    'total_price' =>
                        525000,

                    'status' =>
                        'pending',

                    'payment_method' =>
                        'bank',

                    'payment_status' =>
                        'pending_confirmation',

                    'payment_code' =>
                        'THB123456',

                    'shipping_method' =>
                        'standard',

                    'voucher_code' =>
                        null,
                ],
                $attributes
            )
        );
    }


    private function webhookPayload(
        array $attributes = []
    ): array {
        return array_merge(
            [
                'id' =>
                    'SEPAY-TEST-001',

                'transferType' =>
                    'in',

                'transferAmount' =>
                    525000,

                'content' =>
                    'THANH TOAN DON THB123456',

                'code' =>
                    'THB123456',

                'referenceCode' =>
                    'REF-TEST-001',

                'gateway' =>
                    'MBBank',

                'accountNumber' =>
                    '0385742505',

                'transactionDate' =>
                    now()->format(
                        'Y-m-d H:i:s'
                    ),

                'description' =>
                    'Thanh toan don hang',
            ],
            $attributes
        );
    }


    public function test_webhook_rejects_invalid_api_key(): void
    {
        $customer =
            $this->createCustomer();


        $order =
            $this->createBankOrder(
                $customer
            );


        $this
            ->withHeader(
                'Authorization',
                'Apikey wrong-key'
            )
            ->postJson(
                route(
                    'webhooks.sepay'
                ),
                $this->webhookPayload()
            )
            ->assertUnauthorized()
            ->assertJson([
                'success' => false,
            ]);


        $this->assertDatabaseHas(
            'orders',
            [
                'id' =>
                    $order->id,

                'payment_status' =>
                    'pending_confirmation',
            ]
        );


        $this->assertDatabaseCount(
            'payment_transactions',
            0
        );
    }


    public function test_valid_sepay_webhook_marks_order_as_paid(): void
    {
        $customer =
            $this->createCustomer();


        $order =
            $this->createBankOrder(
                $customer
            );


        $this
            ->withHeader(
                'Authorization',
                'Apikey test-sepay-key'
            )
            ->postJson(
                route(
                    'webhooks.sepay'
                ),
                $this->webhookPayload()
            )
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);


        $this->assertDatabaseHas(
            'orders',
            [
                'id' =>
                    $order->id,

                'payment_status' =>
                    'paid',
            ]
        );


        $this->assertDatabaseHas(
            'payment_transactions',
            [
                'provider' =>
                    'sepay',

                'provider_transaction_id' =>
                    'SEPAY-TEST-001',

                'order_id' =>
                    $order->id,

                'amount' =>
                    525000,
            ]
        );
    }


    public function test_duplicate_webhook_is_processed_only_once(): void
    {
        $customer =
            $this->createCustomer();


        $order =
            $this->createBankOrder(
                $customer
            );


        $payload =
            $this->webhookPayload([
                'id' =>
                    'SEPAY-DUPLICATE-001',
            ]);


        $this
            ->withHeader(
                'Authorization',
                'Apikey test-sepay-key'
            )
            ->postJson(
                route(
                    'webhooks.sepay'
                ),
                $payload
            )
            ->assertOk();


        $this
            ->withHeader(
                'Authorization',
                'Apikey test-sepay-key'
            )
            ->postJson(
                route(
                    'webhooks.sepay'
                ),
                $payload
            )
            ->assertOk();


        $this->assertDatabaseHas(
            'orders',
            [
                'id' =>
                    $order->id,

                'payment_status' =>
                    'paid',
            ]
        );


        $this->assertDatabaseCount(
            'payment_transactions',
            1
        );


        $this->assertDatabaseHas(
            'payment_transactions',
            [
                'provider_transaction_id' =>
                    'SEPAY-DUPLICATE-001',

                'order_id' =>
                    $order->id,
            ]
        );
    }


    public function test_webhook_does_not_confirm_when_amount_is_insufficient(): void
    {
        $customer =
            $this->createCustomer();


        $order =
            $this->createBankOrder(
                $customer
            );


        $this
            ->withHeader(
                'Authorization',
                'Apikey test-sepay-key'
            )
            ->postJson(
                route(
                    'webhooks.sepay'
                ),
                $this->webhookPayload([
                    'id' =>
                        'SEPAY-LOW-AMOUNT-001',

                    'transferAmount' =>
                        500000,
                ])
            )
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);


        $this->assertDatabaseHas(
            'orders',
            [
                'id' =>
                    $order->id,

                'payment_status' =>
                    'pending_confirmation',
            ]
        );


        $this->assertDatabaseMissing(
            'payment_transactions',
            [
                'provider_transaction_id' =>
                    'SEPAY-LOW-AMOUNT-001',
            ]
        );
    }


    public function test_webhook_can_find_payment_code_inside_transfer_content(): void
    {
        $customer =
            $this->createCustomer();


        $order =
            $this->createBankOrder(
                $customer,
                [
                    'payment_code' =>
                        'THB778899',
                ]
            );


        $this
            ->withHeader(
                'Authorization',
                'Apikey test-sepay-key'
            )
            ->postJson(
                route(
                    'webhooks.sepay'
                ),
                $this->webhookPayload([
                    'id' =>
                        'SEPAY-CONTENT-001',

                    'code' =>
                        null,

                    'content' =>
                        'CHUYEN KHOAN THANH TOAN THB778899 CAM ON',
                ])
            )
            ->assertOk()
            ->assertJson([
                'success' => true,
            ]);


        $this->assertDatabaseHas(
            'orders',
            [
                'id' =>
                    $order->id,

                'payment_status' =>
                    'paid',
            ]
        );


        $this->assertDatabaseHas(
            'payment_transactions',
            [
                'provider_transaction_id' =>
                    'SEPAY-CONTENT-001',

                'order_id' =>
                    $order->id,
            ]
        );
    }


    public function test_webhook_credits_a_pending_wallet_top_up_once(): void
    {
        $customer = $this->createCustomer();

        $topUp = WalletTransaction::create([
            'user_id' => $customer->id,
            'type' => 'topup',
            'status' => 'pending',
            'amount' => 100000,
            'reference_code' => 'WLTTEST1234',
        ]);

        $payload = $this->webhookPayload([
            'id' => 'SEPAY-WALLET-001',
            'transferAmount' => 100000,
            'code' => 'WLTTEST1234',
            'content' => 'NAP VI WLTTEST1234',
        ]);

        $this
            ->withHeader('Authorization', 'Apikey test-sepay-key')
            ->postJson(route('webhooks.sepay'), $payload)
            ->assertOk();

        $this
            ->withHeader('Authorization', 'Apikey test-sepay-key')
            ->postJson(route('webhooks.sepay'), $payload)
            ->assertOk();

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'wallet_balance' => 100000,
        ]);

        $this->assertDatabaseHas('wallet_transactions', [
            'id' => $topUp->id,
            'status' => 'completed',
            'provider' => 'sepay',
            'provider_transaction_id' => 'SEPAY-WALLET-001',
        ]);

        $this->assertDatabaseCount('wallet_transactions', 1);
    }
}
