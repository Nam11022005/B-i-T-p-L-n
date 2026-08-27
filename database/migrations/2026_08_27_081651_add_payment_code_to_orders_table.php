<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('orders', 'payment_code')) {

            Schema::table('orders', function (Blueprint $table) {

                $table->string('payment_code', 20)
                    ->nullable()
                    ->unique()
                    ->after('payment_status');

            });

        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'payment_code')) {

            Schema::table('orders', function (Blueprint $table) {

                $table->dropUnique([
                    'payment_code'
                ]);

                $table->dropColumn(
                    'payment_code'
                );

            });

        }
    }
};