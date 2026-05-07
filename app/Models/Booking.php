<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'nomor_antrian',
        'nama',
        'alamat',
        'no_hp_wa',
        'tanggal_booking',
        'plat_motor',
        'jenis_motor',
        'paket_servis',
        'harga_paket_servis',
        'keluhan_motor',
        'harga_servis',
        'harga_sparepart',
        'total_bayar',
        'dibayar_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_booking' => 'date',
            'dibayar_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
