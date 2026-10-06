<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShipmentTrackingTest extends TestCase
{
    use RefreshDatabase;

    private function order(User $user, string $status = 'shipped'): Order
    {
        return Order::create([
            'user_id' => $user->id, 'customer_name' => $user->name,
            'customer_phone' => '0912345678', 'shipping_address' => 'Hà Nội',
            'subtotal' => 100000, 'shipping_fee' => 20000, 'discount' => 0,
            'total_price' => 120000, 'status' => $status,
            'payment_method' => 'cod', 'payment_status' => 'unpaid',
            'shipping_method' => 'standard',
        ]);
    }

    private function payload(): array
    {
        return ['shipping_carrier' => 'Giao Hàng Nhanh', 'tracking_number' => 'GHN123456',
            'shipment_status' => 'in_transit', 'estimated_delivery_at' => now()->addDays(2)->format('Y-m-d'),
            'location' => 'Kho Hà Nội', 'note' => 'Đã đến kho trung chuyển'];
    }

    public function test_admin_updates_shipment_and_owner_sees_history(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);
        $order = $this->order($customer);
        $this->actingAs($admin)->patch(route('admin.orders.shipment.update', $order), $this->payload())
            ->assertSessionHasNoErrors()->assertRedirect(route('admin.orders.show', $order));
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'tracking_number' => 'GHN123456', 'status' => 'shipped', 'payment_status' => 'unpaid']);
        $this->assertDatabaseHas('shipment_events', ['order_id' => $order->id, 'user_id' => $admin->id, 'location' => 'Kho Hà Nội']);
        $this->actingAs($customer)->get(route('orders.show', $order))->assertOk()
            ->assertSee('GHN123456')->assertSee('Kho Hà Nội')->assertDontSee('Lưu thông tin giao hàng');
        $this->actingAs($admin)->get(route('admin.orders.show', $order))->assertOk()->assertSee('Lưu thông tin giao hàng');
    }

    public function test_customers_cannot_update_or_read_other_customers_shipments(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $other = User::factory()->create(['role' => 'customer']);
        $order = $this->order($other);
        $this->actingAs($customer)->patch(route('admin.orders.shipment.update', $order), $this->payload())->assertForbidden();
        $this->actingAs($customer)->get(route('orders.show', $order))->assertForbidden();
        $this->assertDatabaseCount('shipment_events', 0);
    }

    public function test_terminal_and_unshipped_orders_reject_transit_updates(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        foreach (['delivered', 'cancelled', 'pending', 'confirmed'] as $status) {
            $order = $this->order($admin, $status);
            $this->patch(route('admin.orders.shipment.update', $order), $this->payload())->assertSessionHasErrors('shipment_status');
            $this->assertNull($order->fresh()->tracking_number);
        }
        $this->assertDatabaseCount('shipment_events', 0);
    }

    public function test_tracking_is_required_in_transit_and_unchanged_submission_does_not_duplicate_history(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $order = $this->order($admin);
        $this->actingAs($admin);
        $this->patch(route('admin.orders.shipment.update', $order), array_merge($this->payload(), ['tracking_number' => '']))->assertSessionHasErrors('tracking_number');
        $data = array_diff_key($this->payload(), array_flip(['note', 'location']));
        $this->patch(route('admin.orders.shipment.update', $order), $data)->assertSessionHasNoErrors();
        $this->patch(route('admin.orders.shipment.update', $order), $data)->assertSessionHasNoErrors();
        $this->assertDatabaseCount('shipment_events', 1);
    }
}
