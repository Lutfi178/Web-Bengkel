<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_penjualan_spareparts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_sparepart_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nama_sparepart');
            $table->string('kode_sparepart');
            $table->unsignedBigInteger('harga');
            $table->unsignedInteger('jumlah')->default(1);
            $table->unsignedBigInteger('total');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_penjualan_spareparts');
    }
};
