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
        Schema::create('customers', function (Blueprint $table) {
            $table->string('kd_pelanggan', 10)->primary()->comment('Customer Code');
            $table->string('nm_pelanggan', 100)->comment('Customer Name');
            $table->text('alamat')->comment('Address');
            $table->string('kota', 50)->comment('City');
            $table->string('telpon', 20)->nullable()->comment('Phone Number');
            $table->string('email', 100)->nullable()->comment('Email Address');
            $table->date('tanggal_lahir')->nullable()->comment('Date of Birth');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->comment('Gender: L=Male, P=Female');
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Customer Status');
            $table->timestamps();
            
            $table->index('nm_pelanggan');
            $table->index('kota');
            $table->index('email');
            $table->index('telpon');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
