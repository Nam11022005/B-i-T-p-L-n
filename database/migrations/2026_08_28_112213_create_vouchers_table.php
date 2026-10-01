<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->string('name');

            // percent | fixed | shipping
            $table->string('type');

            // 10 = 10% hoặc 50000 = 50.000đ
            $table->decimal('value', 15, 2);

            // Giá trị đơn tối thiểu
            $table->decimal('min_order_value', 15, 2)->default(0);

            // Giảm tối đa - có thể null
            $table->decimal('max_discount', 15, 2)->nullable();

            // Giới hạn số lần sử dụng
            $table->unsignedInteger('usage_limit')->nullable();

            // Đã sử dụng
            $table->unsignedInteger('used_count')->default(0);

            $table->dateTime('starts_at')->nullable();
            $table->dateTime('expires_at')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};