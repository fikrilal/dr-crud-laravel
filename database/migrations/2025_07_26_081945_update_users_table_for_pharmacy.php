<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['admin', 'pharmacist', 'customer'])->after('email')->comment('User Role');
            $table->string('kd_pelanggan', 10)->nullable()->after('user_type')->comment('Links to customer if user_type = customer');
            $table->boolean('is_active')->default(true)->after('kd_pelanggan')->comment('Account Status');
            
            $table->index('user_type');
            $table->index('is_active');
            $table->foreign('kd_pelanggan')->references('kd_pelanggan')->on('customers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kd_pelanggan']);
            $table->dropIndex(['user_type']);
            $table->dropIndex(['is_active']);
            $table->dropColumn(['user_type', 'kd_pelanggan', 'is_active']);
        });
    }
};
