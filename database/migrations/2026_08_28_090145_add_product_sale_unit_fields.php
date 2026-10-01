<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Cho phép tồn kho theo kg như 20.50 kg
            $table->decimal('quantity', 10, 2)->default(0)->change();

            // kg, gói, túi, hộp, chai...
            $table->string('unit', 30)->default('sản phẩm')->after('price');

            // Ví dụ: tối thiểu 0.25 kg
            $table->decimal('min_quantity', 10, 2)->default(1)->after('unit');

            // Ví dụ: tăng mỗi lần 0.25 kg
            $table->decimal('quantity_step', 10, 2)->default(1)->after('min_quantity');
        });

        Schema::table('order_items', function (Blueprint $table) {
            // Đơn hàng cũng phải lưu được 0.25 kg, 0.5 kg...
            $table->decimal('quantity', 10, 2)->default(1)->change();
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->integer('quantity')->default(0)->change();

            $table->dropColumn([
                'unit',
                'min_quantity',
                'quantity_step',
            ]);
        });
    }
};
