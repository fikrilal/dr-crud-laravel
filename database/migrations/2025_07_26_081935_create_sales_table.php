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
        Schema::create('sales', function (Blueprint $table) {
            $table->string('nota', 20)->primary()->comment('Sales Receipt Number');
            $table->date('tgl_nota')->comment('Transaction Date');
            $table->string('kd_pelanggan', 10)->nullable()->comment('Customer Code (nullable for walk-in)');
            $table->foreignId('user_id')->comment('Pharmacist who processed the sale');
            $table->decimal('diskon', 10, 2)->default(0)->comment('Discount Amount');
            $table->decimal('total_before_discount', 10, 2)->comment('Subtotal before discount');
            $table->decimal('total_after_discount', 10, 2)->comment('Final total after discount');
            $table->enum('payment_method', ['cash', 'card', 'transfer'])->default('cash')->comment('Payment Method');
            $table->text('notes')->nullable()->comment('Transaction notes');
            $table->timestamps();
            
            $table->index('tgl_nota');
            $table->index('kd_pelanggan');
            $table->index('user_id');
            $table->index('total_after_discount');
            $table->foreign('kd_pelanggan')->references('kd_pelanggan')->on('customers')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
