<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function ($table) {
            $table->dropUnique(['nomor_antrian']);
        });

        DB::statement('CREATE UNIQUE INDEX bookings_tanggal_booking_nomor_antrian_unique ON bookings (tanggal_booking, nomor_antrian)');
    }

    public function down(): void
    {
        DB::statement('DROP INDEX bookings_tanggal_booking_nomor_antrian_unique');

        Schema::table('bookings', function ($table) {
            $table->unique('nomor_antrian');
        });
    }
};
