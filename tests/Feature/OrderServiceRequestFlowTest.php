<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderServiceRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class OrderServiceRequestFlowTest extends TestCase
{
    use RefreshDatabase;

    private function user(string $role): User
    {
        return User::factory()->create([
            'role' => $role,
            'email_verified_at' => now(),
        ]);
    }

    private function order(User $customer, array $attributes = []): Order
    {
        return Order::create(array_merge([
            'user_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_phone' => '0912345678',
            'shipping_address' => 'Hà Nội',
            'subtotal' => 350000,
            'shipping_fee' => 25000,
            'discount' => 0,
            'total_price' => 375000,
            'status' => 'pending',
            'payment_method' => 'wallet',
            'payment_status' => 'paid',
            'shipping_method' => 'standard',
        ], $attributes));
    }

    public function test_customer_can_request_a_refund_and_admin_credits_the_wallet_when_approved(): void
    {
        $customer = $this->user('customer');
        $admin = $this->user('admin');
        $order = $this->order($customer, ['status' => 'delivered']);

        $this->actingAs($customer)
            ->post(route('orders.service-requests.store', $order), [
                'type' => 'refund',
                'reason' => 'Sản phẩm nhận được bị lỗi và cần được hoàn tiền.',
            ])
            ->assertSessionHas('success');

        $serviceRequest = OrderServiceRequest::firstOrFail();
        $this->assertSame('pending', $serviceRequest->status);

        $this->actingAs($customer)
            ->get(route('orders.show', $order))
            ->assertOk()
            ->assertSee('Hỗ trợ đơn hàng');

        $this->actingAs($admin)
            ->get(route('admin.orders.show', $order))
            ->assertOk()
            ->assertSee('Yêu cầu từ khách hàng');

        $this->actingAs($admin)
            ->patch(route('admin.service-requests.process', $serviceRequest), [
                'decision' => 'approved',
                'admin_note' => 'Đã kiểm tra và hoàn tiền vào ví.',
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('order_service_requests', [
            'id' => $serviceRequest->id,
            'status' => 'approved',
            'processed_by' => $admin->id,
        ]);
        $this->assertDatabaseHas('users', ['id' => $customer->id, 'wallet_balance' => 375000]);
        $this->assertDatabaseHas('wallet_transactions', [
            'order_id' => $order->id,
            'type' => 'refund',
            'amount' => 375000,
        ]);
    }

    public function test_approved_cancellation_restores_stock_and_credits_a_paid_order_to_wallet(): void
    {
        Notification::fake();

        $customer = $this->user('customer');
        $admin = $this->user('admin');
        $category = Category::create(['name' => 'Test yêu cầu hủy']);
        $product = Product::create([
            'name' => 'Sản phẩm cần hủy',
            'description' => 'Kiểm tra hủy đơn',
            'quantity' => 8,
            'price' => 350000,
            'category_id' => $category->id,
        ]);
        $order = $this->order($customer, ['status' => 'confirmed']);
        OrderItem::create(['order_id' => $order->id, 'product_id' => $product->id, 'quantity' => 2, 'price' => 350000]);

        $this->actingAs($customer)
            ->post(route('orders.service-requests.store', $order), [
                'type' => 'cancel',
                'reason' => 'Tôi cần hủy đơn vì không còn nhu cầu sử dụng.',
            ]);

        $serviceRequest = OrderServiceRequest::firstOrFail();

        $this->actingAs($admin)
            ->patch(route('admin.service-requests.process', $serviceRequest), ['decision' => 'approved']);

        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'cancelled']);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'quantity' => 10]);
        $this->assertDatabaseHas('users', ['id' => $customer->id, 'wallet_balance' => 375000]);
        $this->assertDatabaseHas('wallet_transactions', ['order_id' => $order->id, 'type' => 'refund']);
    }
}
