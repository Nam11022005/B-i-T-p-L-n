<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminWalletManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }

    private function customer(float $balance = 0): User
    {
        return User::factory()->create([
            'role' => 'customer',
            'email_verified_at' => now(),
            'wallet_balance' => $balance,
        ]);
    }

    public function test_only_an_admin_can_open_wallet_management(): void
    {
        $customer = $this->customer();

        $this->actingAs($customer)
            ->get(route('admin.customers.show', $customer))
            ->assertForbidden();
    }

    public function test_admin_can_view_wallet_transactions_and_adjust_balance_with_an_audit_record(): void
    {
        $admin = $this->admin();
        $customer = $this->customer(10000);

        WalletTransaction::create([
            'user_id' => $customer->id,
            'type' => 'topup',
            'status' => 'completed',
            'amount' => 10000,
            'balance_after' => 10000,
            'reference_code' => 'WLTADMINTEST',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.customers.show', $customer))
            ->assertOk()
            ->assertSee('Ví Tinh Hoa')
            ->assertSee($customer->name)
            ->assertSee('WLTADMINTEST');

        $this->actingAs($admin)
            ->post(route('admin.customers.wallet.adjust', $customer), [
                'direction' => 'credit',
                'amount' => 15000,
                'note' => 'Bù tiền nạp thiếu',
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'wallet_balance' => 25000,
        ]);
        $this->assertDatabaseHas('wallet_transactions', [
            'user_id' => $customer->id,
            'type' => 'admin_credit',
            'status' => 'completed',
            'amount' => 15000,
            'balance_after' => 25000,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.customers.wallet.adjust', $customer), [
                'direction' => 'debit',
                'amount' => 5000,
                'note' => 'Điều chỉnh nhầm số dư',
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'wallet_balance' => 20000,
        ]);
        $this->assertDatabaseHas('wallet_transactions', [
            'user_id' => $customer->id,
            'type' => 'admin_debit',
            'status' => 'completed',
            'amount' => 5000,
            'balance_after' => 20000,
        ]);
    }

    public function test_admin_cannot_reduce_a_wallet_below_zero(): void
    {
        $admin = $this->admin();
        $customer = $this->customer(10000);

        $this->actingAs($admin)
            ->from(route('admin.customers.show', $customer))
            ->post(route('admin.customers.wallet.adjust', $customer), [
                'direction' => 'debit',
                'amount' => 15000,
                'note' => 'Kiểm tra số dư',
            ])
            ->assertRedirect(route('admin.customers.show', $customer))
            ->assertSessionHasErrors('amount');

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'wallet_balance' => 10000,
        ]);
        $this->assertDatabaseCount('wallet_transactions', 0);
    }
}
