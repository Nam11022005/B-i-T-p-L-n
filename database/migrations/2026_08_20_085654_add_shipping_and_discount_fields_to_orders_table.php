<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->decimal('subtotal', 15, 2)
                    ->default(0)
                    ->after('total_price');
            }

            if (!Schema::hasColumn('orders', 'shipping_fee')) {
                $table->decimal('shipping_fee', 15, 2)
                    ->default(0)
                    ->after('subtotal');
            }

            if (!Schema::hasColumn('orders', 'discount')) {
                $table->decimal('discount', 15, 2)
                    ->default(0)
                    ->after('shipping_fee');
            }

            if (!Schema::hasColumn('orders', 'shipping_method')) {
                $table->string('shipping_method')
                    ->default('standard')
                    ->after('payment_method');
            }

            if (!Schema::hasColumn('orders', 'voucher_code')) {
                $table->string('voucher_code')
                    ->nullable()
                    ->after('shipping_method');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $columns = [
                'subtotal',
                'shipping_fee',
                'discount',
                'shipping_method',
                'voucher_code',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};