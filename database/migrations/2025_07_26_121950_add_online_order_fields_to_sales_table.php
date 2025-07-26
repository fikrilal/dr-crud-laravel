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
            $table->string('no_faktur', 20)->nullable()->after('nota')->comment('Alternative order number for online orders');
            $table->datetime('tanggal')->nullable()->after('tgl_nota')->comment('Full datetime for orders');
            $table->decimal('total_harga', 10, 2)->nullable()->after('total_after_discount')->comment('Total price alias');
            $table->string('metode_pembayaran', 50)->nullable()->after('payment_method')->comment('Payment method alias');
            $table->enum('status_pembayaran', ['pending', 'paid', 'failed', 'refunded'])->default('pending')->after('metode_pembayaran')->comment('Payment status');
            $table->text('catatan')->nullable()->after('notes')->comment('Order notes alias');
            $table->text('alamat_kirim')->nullable()->after('catatan')->comment('Delivery address for online orders');
            $table->enum('status_pesanan', ['pending', 'processing', 'shipped', 'completed', 'cancelled'])->default('pending')->after('alamat_kirim')->comment('Order status');
            $table->enum('tipe_transaksi', ['offline', 'online'])->default('offline')->after('status_pesanan')->comment('Transaction type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn([
                'no_faktur',
                'tanggal', 
                'total_harga',
                'metode_pembayaran',
                'status_pembayaran',
                'catatan',
                'alamat_kirim',
                'status_pesanan',
                'tipe_transaksi'
            ]);
        });
    }
};
