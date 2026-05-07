<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penjualan_spareparts', function (Blueprint $table) {
            $table->string('gambar_sparepart')->nullable()->after('kode_sparepart');
        });
    }

    public function down(): void
    {
        Schema::table('penjualan_spareparts', function (Blueprint $table) {
            $table->dropColumn('gambar_sparepart');
        });
    }
};
