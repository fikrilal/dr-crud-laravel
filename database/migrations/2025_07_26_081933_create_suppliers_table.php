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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->string('kd_supplier', 10)->primary()->comment('Supplier Code');
            $table->string('nm_supplier', 100)->comment('Supplier Name');
            $table->text('alamat')->comment('Address');
            $table->string('kota', 50)->comment('City');
            $table->string('telpon', 20)->nullable()->comment('Phone Number');
            $table->string('email', 100)->nullable()->comment('Email Address');
            $table->string('contact_person', 100)->nullable()->comment('Contact Person Name');
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Supplier Status');
            $table->timestamps();
            
            $table->index('nm_supplier');
            $table->index('kota');
            $table->index('status');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
