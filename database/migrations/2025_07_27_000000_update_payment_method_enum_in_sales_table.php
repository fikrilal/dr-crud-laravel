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
        Schema::table('sales', function (Blueprint $table) {
            // Expand the enum to match UI options
            $table->enum('payment_method', [
                'cash',
                'credit_card',
                'debit_card',
                'transfer',
                'insurance',
            ])->default('cash')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // Revert to original three-value enum
            $table->enum('payment_method', [
                'cash',
                'card',
                'transfer',
            ])->default('cash')->change();
        });
    }
}; 