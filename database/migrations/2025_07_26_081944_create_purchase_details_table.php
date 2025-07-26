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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id('detail_id')->comment('Detail record ID');
            $table->string('nota', 20)->comment('Purchase Receipt Number');
            $table->string('kd_obat', 10)->comment('Drug Code');
            $table->integer('jumlah')->comment('Quantity Purchased');
            $table->decimal('harga_satuan', 10, 2)->comment('Unit purchase price');
            $table->decimal('subtotal', 10, 2)->comment('Line total (quantity * unit_price)');
            $table->timestamps();
            
            $table->index('nota');
            $table->index('kd_obat');
            $table->index(['nota', 'kd_obat']);
            $table->foreign('nota')->references('nota')->on('purchases')->onDelete('cascade');
            $table->foreign('kd_obat')->references('kd_obat')->on('drugs')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
