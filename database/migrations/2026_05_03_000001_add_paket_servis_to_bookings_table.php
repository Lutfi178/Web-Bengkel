<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('paket_servis')->nullable()->after('jenis_motor');
            $table->unsignedBigInteger('harga_paket_servis')->default(0)->after('paket_servis');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['paket_servis', 'harga_paket_servis']);
        });
    }
};
