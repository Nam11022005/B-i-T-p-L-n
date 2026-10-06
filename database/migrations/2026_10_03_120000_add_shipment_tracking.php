<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_carrier', 100)->nullable();
            $table->string('tracking_number', 100)->nullable();
            $table->string('shipment_status', 40)->nullable();
            $table->date('estimated_delivery_at')->nullable();
        });
        Schema::create('shipment_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status', 40);
            $table->string('carrier', 100)->nullable();
            $table->string('tracking_number', 100)->nullable();
            $table->string('location', 150)->nullable();
            $table->string('note', 1000)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipment_events');
        Schema::table('orders', fn (Blueprint $table) => $table->dropColumn([
            'shipping_carrier', 'tracking_number', 'shipment_status', 'estimated_delivery_at',
        ]));
    }
};
