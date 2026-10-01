<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();

            $table->string('provider', 30)->default('sepay');
            $table->string('provider_transaction_id', 100);
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->decimal('amount', 15, 2);
            $table->string('reference_code')->nullable();
            $table->text('content')->nullable();
            $table->longText('raw_payload')->nullable();

            $table->timestamps();

            $table->unique(
                ['provider', 'provider_transaction_id'],
                'payment_transactions_provider_tx_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
