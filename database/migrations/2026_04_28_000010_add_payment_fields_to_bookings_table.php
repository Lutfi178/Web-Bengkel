<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('harga_servis')->default(0)->after('keluhan_motor');
            $table->unsignedBigInteger('harga_sparepart')->default(0)->after('harga_servis');
            $table->unsignedBigInteger('total_bayar')->default(0)->after('harga_sparepart');
            $table->timestamp('dibayar_at')->nullable()->after('total_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'harga_servis',
                'harga_sparepart',
                'total_bayar',
                'dibayar_at',
            ]);
        });
    }
};
