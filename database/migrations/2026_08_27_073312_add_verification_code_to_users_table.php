<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'verification_code')) {

            Schema::table('users', function (Blueprint $table) {

                $table->string('verification_code', 6)
                    ->nullable()
                    ->after('email_verified_at');

            });
        }


        if (!Schema::hasColumn('users', 'verification_code_expires_at')) {

            Schema::table('users', function (Blueprint $table) {

                $table->timestamp('verification_code_expires_at')
                    ->nullable()
                    ->after('verification_code');

            });
        }
    }


    public function down(): void
    {
        if (Schema::hasColumn('users', 'verification_code_expires_at')) {

            Schema::table('users', function (Blueprint $table) {

                $table->dropColumn(
                    'verification_code_expires_at'
                );

            });
        }


        if (Schema::hasColumn('users', 'verification_code')) {

            Schema::table('users', function (Blueprint $table) {

                $table->dropColumn(
                    'verification_code'
                );

            });
        }
    }
};