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
        Schema::table('drugs', function (Blueprint $table) {
            $table->date('tanggal_kadaluarsa')->nullable()->after('description')->comment('Drug expiry date');
            $table->text('efek_samping')->nullable()->after('tanggal_kadaluarsa')->comment('Side effects');
            $table->text('kontraindikasi')->nullable()->after('efek_samping')->comment('Contraindications');
            $table->string('dosis_dewasa')->nullable()->after('kontraindikasi')->comment('Adult dosage');
            $table->string('dosis_anak')->nullable()->after('dosis_dewasa')->comment('Child dosage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->dropColumn(['tanggal_kadaluarsa', 'efek_samping', 'kontraindikasi', 'dosis_dewasa', 'dosis_anak']);
        });
    }
};
