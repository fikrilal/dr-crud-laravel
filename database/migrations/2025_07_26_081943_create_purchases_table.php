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
        Schema::create('purchases', function (Blueprint $table) {
            $table->string('nota', 20)->primary()->comment('Purchase Receipt Number');
            $table->date('tgl_nota')->comment('Transaction Date');
            $table->string('kd_supplier', 10)->comment('Supplier Code');
            $table->foreignId('user_id')->comment('User who created the purchase order');
            $table->decimal('diskon', 10, 2)->default(0)->comment('Discount Amount');
            $table->decimal('total_before_discount', 10, 2)->comment('Subtotal before discount');
            $table->decimal('total_after_discount', 10, 2)->comment('Final total after discount');
            $table->enum('status', ['pending', 'received', 'cancelled'])->default('pending')->comment('Purchase Status');
            $table->text('notes')->nullable()->comment('Purchase notes');
            $table->timestamps();
            
            $table->index('tgl_nota');
            $table->index('kd_supplier');
            $table->index('user_id');
            $table->index('status');
            $table->foreign('kd_supplier')->references('kd_supplier')->on('suppliers')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
