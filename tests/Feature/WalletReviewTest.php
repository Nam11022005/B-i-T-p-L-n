<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Env;
use Tests\TestCase;

class WalletReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_manual_decisions_are_final_and_late_webhooks_do_not_credit_again(): void
    {
        Env::getRepository()->set('SEPAY_WEBHOOK_API_KEY', 'review-test-key');
        $admin = User::factory()->create(['role' => 'admin']);
        foreach (['approve', 'reject'] as $decision) {
            $customer = User::factory()->create(['role' => 'customer', 'wallet_balance' => 10000]);
            $topUp = WalletTransaction::create(['user_id' => $customer->id, 'type' => 'topup',
                'status' => 'pending', 'amount' => 600000, 'reference_code' => 'WLT' . strtoupper($decision)]);
            $url = route('admin.customers.wallet.review', [$customer, $topUp]);
            $this->actingAs($admin)->get(route('admin.customers.show', $customer))->assertOk()->assertSee('Duyệt / từ chối yêu cầu');
            $this->post($url, ['decision' => $decision, 'note' => 'Đã đối chiếu', 'received' => 1])->assertSessionHas('success');
            $this->assertEquals($decision === 'approve' ? 610000 : 10000, $customer->fresh()->wallet_balance);
            $this->assertSame($decision === 'approve' ? 'completed' : 'rejected', $topUp->fresh()->status);
            $this->assertEquals($admin->id, data_get($topUp->fresh()->raw_payload, 'manual_review.admin_id'));
            $this->post($url, ['decision' => 'approve', 'note' => 'Lặp lại', 'received' => 1])->assertSessionHasErrors('decision');
            $this->withHeader('Authorization', 'Apikey review-test-key')->postJson(route('webhooks.sepay'), [
                'id' => 'late-' . $decision, 'transferType' => 'in', 'transferAmount' => 600000,
                'content' => $topUp->reference_code, 'code' => $topUp->reference_code,
            ])->assertOk();
            $this->assertEquals($decision === 'approve' ? 610000 : 10000, $customer->fresh()->wallet_balance);
        }
    }

    public function test_review_requires_admin_correct_customer_reason_and_bank_confirmation(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $other = User::factory()->create(['role' => 'customer']);
        $admin = User::factory()->create(['role' => 'admin']);
        $topUp = WalletTransaction::create(['user_id' => $customer->id, 'type' => 'topup', 'status' => 'pending', 'amount' => 10000]);
        $url = route('admin.customers.wallet.review', [$customer, $topUp]);
        $this->actingAs($customer)->post($url, [])->assertForbidden();
        $this->actingAs($admin)->post(route('admin.customers.wallet.review', [$other, $topUp]), [])->assertNotFound();
        $this->post($url, ['decision' => 'reject'])->assertSessionHasErrors('note');
        $this->post($url, ['decision' => 'approve', 'note' => 'Kiểm tra'])->assertSessionHasErrors('received');
        $this->assertSame('pending', $topUp->fresh()->status);
        $this->post($url, ['decision' => 'reject', 'note' => 'Chưa nhận được tiền'])->assertSessionHas('success');
        $this->assertSame('rejected', $topUp->fresh()->status);
    }
}
