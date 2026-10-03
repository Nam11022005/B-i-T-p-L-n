<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type', 20); // topup | payment | refund
            $table->string('status', 20)->default('pending'); // pending | completed
            $table->decimal('amount', 15, 2);
            $table->decimal('balance_after', 15, 2)->nullable();
            $table->string('reference_code', 40)->nullable()->unique();
            $table->string('provider', 30)->nullable();
            $table->string('provider_transaction_id', 100)->nullable();
            $table->text('description')->nullable();
            $table->longText('raw_payload')->nullable();
            $table->timestamps();

            $table->unique(
                ['provider', 'provider_transaction_id'],
                'wallet_transactions_provider_tx_unique'
            );
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
