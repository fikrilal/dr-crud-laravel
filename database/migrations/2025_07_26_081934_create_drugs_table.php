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
        Schema::create('drugs', function (Blueprint $table) {
            $table->string('kd_obat', 10)->primary()->comment('Drug Code');
            $table->string('nm_obat', 100)->comment('Drug Name');
            $table->string('jenis', 50)->comment('Type/Category');
            $table->string('satuan', 20)->comment('Unit of Measure');
            $table->decimal('harga_beli', 10, 2)->comment('Purchase Price');
            $table->decimal('harga_jual', 10, 2)->comment('Selling Price');
            $table->integer('stok')->default(0)->comment('Stock Quantity');
            $table->string('kd_supplier', 10)->comment('Supplier Code');
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Drug Status');
            $table->integer('min_stock_level')->default(10)->comment('Minimum stock alert level');
            $table->text('description')->nullable()->comment('Drug description for customers');
            $table->timestamps();
            
            $table->index('nm_obat');
            $table->index('jenis');
            $table->index('status');
            $table->index('kd_supplier');
            $table->index('stok');
            $table->foreign('kd_supplier')->references('kd_supplier')->on('suppliers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drugs');
    }
};
