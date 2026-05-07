<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('servis_motor');
    }

    public function down(): void
    {
        Schema::create('servis_motor', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('plat_kendaraan');
            $table->string('no_hp');
            $table->unsignedBigInteger('harga_servis');
            $table->timestamps();
        });
    }
};
