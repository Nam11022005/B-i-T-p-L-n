<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Notifications\OrderStatusChangedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Tạo customer đã xác thực email.
     */
    private function createCustomer(): User
    {
        return User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
    }


    /**
     * Tạo admin.
     */
    private function createAdmin(): User
    {
        return User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }


    /**
     * Tạo một đơn hàng test.
     */
    private function createOrder(
        User $customer,
        array $attributes = []
    ): Order {
        return Order::create(
            array_merge(
                [
                    'user_id' => $customer->id,

                    'customer_name' => $customer->name,

                    'customer_phone' => '0385742505',

                    'shipping_address' =>
                        '123 Đường Test, Hà Nội',

                    'notes' =>
                        'Đơn hàng dùng cho automated test',

                    'subtotal' => 350000,

                    'shipping_fee' => 25000,

                    'discount' => 0,

                    'total_price' => 375000,

                    'status' => 'pending',

                    'payment_method' => 'cod',

                    'payment_status' => 'unpaid',

                    'payment_code' => null,

                    'shipping_method' => 'standard',

                    'voucher_code' => null,
                ],
                $attributes
            )
        );
    }


    /**
     * Customer được xem đơn của chính mình
     * và API payment-status trả đúng dữ liệu.
     */
    public function test_customer_can_view_own_order_and_payment_status(): void
    {
        $customer =
            $this->createCustomer();


        $order =
            $this->createOrder(
                $customer,
                [
                    'payment_method' => 'bank',

                    'payment_status' =>
                        'pending_confirmation',

                    'payment_code' =>
                        'THB123456',
                ]
            );


        $this
            ->actingAs($customer)
            ->get(
                route(
                    'orders.show',
                    $order
                )
            )
            ->assertOk();


        $this
            ->actingAs($customer)
            ->getJson(
                route(
                    'orders.paymentStatus',
                    $order
                )
            )
            ->assertOk()
            ->assertJson([
                'paid' => false,

                'payment_status' =>
                    'pending_confirmation',

                'order_id' =>
                    $order->id,
            ]);
    }


    /**
     * Customer không được xem đơn
     * của customer khác.
     */
    public function test_customer_cannot_view_another_users_order(): void
    {
        $owner =
            $this->createCustomer();


        $otherCustomer =
            $this->createCustomer();


        $order =
            $this->createOrder(
                $owner,
                [
                    'payment_method' => 'bank',

                    'payment_status' =>
                        'pending_confirmation',

                    'payment_code' =>
                        'THB654321',
                ]
            );


        $this
            ->actingAs($otherCustomer)
            ->get(
                route(
                    'orders.show',
                    $order
                )
            )
            ->assertForbidden();


        $this
            ->actingAs($otherCustomer)
            ->getJson(
                route(
                    'orders.paymentStatus',
                    $order
                )
            )
            ->assertForbidden();
    }


    /**
     * Admin có thể xác nhận
     * thanh toán chuyển khoản.
     */
    public function test_admin_can_confirm_bank_payment(): void
    {
        $admin =
            $this->createAdmin();


        $customer =
            $this->createCustomer();


        $order =
            $this->createOrder(
                $customer,
                [
                    'payment_method' => 'bank',

                    'payment_status' =>
                        'pending_confirmation',

                    'payment_code' =>
                        'THB999999',
                ]
            );


        $response =
            $this
                ->actingAs($admin)
                ->patch(
                    route(
                        'admin.orders.confirmPayment',
                        $order
                    )
                );


        $response->assertRedirect(
            route(
                'admin.orders.show',
                $order
            )
        );


        $this->assertDatabaseHas(
            'orders',
            [
                'id' =>
                    $order->id,

                'payment_method' =>
                    'bank',

                'payment_status' =>
                    'paid',
            ]
        );


        $this
            ->actingAs($customer)
            ->getJson(
                route(
                    'orders.paymentStatus',
                    $order
                )
            )
            ->assertOk()
            ->assertJson([
                'paid' => true,

                'payment_status' =>
                    'paid',

                'order_id' =>
                    $order->id,
            ]);
    }


    /**
     * Khi admin hủy đơn:
     * - trạng thái thành cancelled
     * - tồn kho được hoàn lại
     * - ghi status history
     *
     * Khi mở lại đơn:
     * - tồn kho bị trừ lại
     * - trạng thái mới được ghi lịch sử
     */
    public function test_admin_cancel_order_restores_stock_and_reopening_deducts_stock_again(): void
    {
        Notification::fake();


        $admin =
            $this->createAdmin();


        $customer =
            $this->createCustomer();


        $category =
            Category::create([
                'name' =>
                    'Đặc sản Test',
            ]);


        /*
         * Giả lập:
         *
         * Ban đầu có 10 sản phẩm.
         * Customer đã checkout 2.
         * Tồn kho hiện tại còn 8.
         */
        $product =
            Product::create([
                'name' =>
                    'Thịt gác bếp Test',

                'description' =>
                    'Sản phẩm kiểm tra tồn kho',

                'quantity' => 8,

                'price' => 350000,

                'category_id' =>
                    $category->id,

                'unit' => 'kg',

                'min_quantity' => 1,

                'quantity_step' => 1,
            ]);


        $order =
            $this->createOrder(
                $customer,
                [
                    'subtotal' => 700000,

                    'shipping_fee' => 25000,

                    'total_price' => 725000,

                    'status' => 'pending',
                ]
            );


        OrderItem::create([
            'order_id' =>
                $order->id,

            'product_id' =>
                $product->id,

            'quantity' => 2,

            'price' => 350000,
        ]);


        /*
         * =============================================
         * ADMIN HỦY ĐƠN
         * => hoàn lại 2
         * => stock từ 8 thành 10
         * =============================================
         */
        $response =
            $this
                ->actingAs($admin)
                ->patch(
                    route(
                        'admin.orders.updateStatus',
                        $order
                    ),
                    [
                        'status' =>
                            'cancelled',
                    ]
                );


        $response->assertRedirect(
            route(
                'admin.orders.show',
                $order
            )
        );


        $this->assertDatabaseHas(
            'orders',
            [
                'id' =>
                    $order->id,

                'status' =>
                    'cancelled',
            ]
        );


        $this->assertDatabaseHas(
            'products',
            [
                'id' =>
                    $product->id,

                'quantity' =>
                    10,
            ]
        );


        $this->assertDatabaseHas(
            'order_status_histories',
            [
                'order_id' =>
                    $order->id,

                'user_id' =>
                    $admin->id,

                'status' =>
                    'cancelled',
            ]
        );


        Notification::assertSentTo(
            $customer,
            OrderStatusChangedNotification::class
        );


        /*
         * =============================================
         * ADMIN MỞ LẠI ĐƠN
         * => trừ lại 2
         * => stock từ 10 thành 8
         * =============================================
         */
        $response =
            $this
                ->actingAs($admin)
                ->patch(
                    route(
                        'admin.orders.updateStatus',
                        $order
                    ),
                    [
                        'status' =>
                            'confirmed',
                    ]
                );


        $response->assertRedirect(
            route(
                'admin.orders.show',
                $order
            )
        );


        $this->assertDatabaseHas(
            'orders',
            [
                'id' =>
                    $order->id,

                'status' =>
                    'confirmed',
            ]
        );


        $this->assertDatabaseHas(
            'products',
            [
                'id' =>
                    $product->id,

                'quantity' =>
                    8,
            ]
        );


        $this->assertDatabaseHas(
            'order_status_histories',
            [
                'order_id' =>
                    $order->id,

                'user_id' =>
                    $admin->id,

                'status' =>
                    'confirmed',
            ]
        );


        $this->assertDatabaseCount(
            'order_status_histories',
            2
        );
    }


    public function test_cancelling_a_paid_wallet_order_refunds_and_reopening_charges_the_wallet_again(): void
    {
        Notification::fake();

        $admin = $this->createAdmin();
        $customer = $this->createCustomer();

        $order = $this->createOrder($customer, [
            'total_price' => 375000,
            'payment_method' => 'wallet',
            'payment_status' => 'paid',
        ]);

        $this
            ->actingAs($admin)
            ->patch(route('admin.orders.updateStatus', $order), ['status' => 'cancelled'])
            ->assertRedirect(route('admin.orders.show', $order));

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'wallet_balance' => 375000,
        ]);
        $this->assertDatabaseHas('wallet_transactions', [
            'order_id' => $order->id,
            'type' => 'refund',
            'amount' => 375000,
        ]);

        $this
            ->actingAs($admin)
            ->patch(route('admin.orders.updateStatus', $order), ['status' => 'confirmed'])
            ->assertRedirect(route('admin.orders.show', $order));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'confirmed',
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'wallet_balance' => 0,
        ]);
        $this->assertDatabaseHas('wallet_transactions', [
            'order_id' => $order->id,
            'type' => 'payment',
            'amount' => 375000,
        ]);
        $this->assertDatabaseCount('wallet_transactions', 2);
    }


    /**
     * Admin không được gửi
     * trạng thái không hợp lệ.
     */
    public function test_admin_cannot_set_invalid_order_status(): void
    {
        $admin =
            $this->createAdmin();


        $customer =
            $this->createCustomer();


        $order =
            $this->createOrder(
                $customer
            );


        $response =
            $this
                ->actingAs($admin)
                ->from(
                    route(
                        'admin.orders.show',
                        $order
                    )
                )
                ->patch(
                    route(
                        'admin.orders.updateStatus',
                        $order
                    ),
                    [
                        'status' =>
                            'invalid-status',
                    ]
                );


        $response
            ->assertRedirect(
                route(
                    'admin.orders.show',
                    $order
                )
            )
            ->assertSessionHasErrors(
                'status'
            );


        $this->assertDatabaseHas(
            'orders',
            [
                'id' =>
                    $order->id,

                'status' =>
                    'pending',
            ]
        );


        $this->assertDatabaseMissing(
            'order_status_histories',
            [
                'order_id' =>
                    $order->id,
            ]
        );
    }

    public function test_delivered_order_rejects_all_status_changes_without_side_effects(): void
    {
        Notification::fake();
        $admin = $this->createAdmin();
        $order = $this->createOrder($this->createCustomer(), ['status' => 'delivered']);
        $category = Category::create(['name' => 'Delivery lock test']);
        $product = Product::create([
            'name' => 'Delivery lock product', 'price' => 350000, 'quantity' => 8,
            'category_id' => $category->id, 'unit' => 'kg',
            'min_quantity' => 1, 'quantity_step' => 1,
        ]);
        OrderItem::create(['order_id' => $order->id, 'product_id' => $product->id, 'quantity' => 2, 'price' => 350000]);
        $before = $order->fresh()->getAttributes();

        foreach (['pending', 'confirmed', 'shipped', 'cancelled'] as $status) {
            $this->actingAs($admin)->patch(route('admin.orders.updateStatus', $order), ['status' => $status])
                ->assertRedirect(route('admin.orders.show', $order))
                ->assertSessionHas('error');
            $this->assertSame($before, $order->fresh()->getAttributes());
            $this->assertEquals(8, $product->fresh()->quantity);
            $this->assertSame(0, $order->statusHistories()->count());
        }
        Notification::assertNothingSent();
        $this->actingAs($admin)->get(route('admin.orders.show', $order))
            ->assertOk()->assertSee('Đã khóa trạng thái')
            ->assertDontSee('id="adminOrderStatusForm"', false)
            ->assertDontSee('id="adminOrderStatus"', false);
    }

    public function test_admin_can_track_shipping_then_complete_and_lock_delivery(): void
    {
        Notification::fake();
        $admin = $this->createAdmin();
        $customer = $this->createCustomer();
        $order = $this->createOrder($customer, ['status' => 'confirmed']);
        $this->travelTo(now()->startOfMinute());
        $started = now()->format('H:i · d/m/Y');
        $this->actingAs($admin)->patch(route('admin.orders.updateStatus', $order), ['status' => 'shipped'])
            ->assertSessionHas('success')->assertSessionMissing('error');
        $this->assertSame('shipped', $order->fresh()->status);
        $this->actingAs($admin)->get(route('admin.orders.show', $order))
            ->assertOk()->assertSee('Đang giao hàng')->assertSee('Bắt đầu giao:')
            ->assertSee($started)->assertSee('id="adminOrderStatusForm"', false);

        $this->travel(1)->hours();
        $completed = now()->format('H:i · d/m/Y');
        $this->actingAs($admin)->patch(route('admin.orders.updateStatus', $order), ['status' => 'delivered'])
            ->assertSessionHas('success')->assertSessionMissing('error');
        $this->assertSame('delivered', $order->fresh()->status);
        $this->assertSame(['shipped', 'delivered'], $order->statusHistories()->pluck('status')->all());
        $this->actingAs($admin)->get(route('admin.orders.show', $order))
            ->assertOk()->assertSee('Đã khóa trạng thái')->assertSee($started)->assertSee($completed)
            ->assertDontSee('id="adminOrderStatusForm"', false);
        Notification::assertSentToTimes($customer, OrderStatusChangedNotification::class, 2);

        // Repeated submissions do not duplicate history or notifications.
        $this->actingAs($admin)->patch(route('admin.orders.updateStatus', $order), ['status' => 'delivered'])
            ->assertSessionHas('success');
        $this->assertSame(2, $order->statusHistories()->count());
        Notification::assertSentToTimes($customer, OrderStatusChangedNotification::class, 2);
        $this->travelBack();
    }
}
