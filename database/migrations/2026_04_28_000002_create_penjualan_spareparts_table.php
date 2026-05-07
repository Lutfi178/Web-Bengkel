<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualan_spareparts', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sparepart');
            $table->string('kode_sparepart')->unique();
            $table->unsignedBigInteger('harga');
            $table->string('no_hp_pembeli');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan_spareparts');
    }
};
