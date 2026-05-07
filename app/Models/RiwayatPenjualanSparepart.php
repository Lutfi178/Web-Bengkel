<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPenjualanSparepart extends Model
{
    protected $fillable = [
        'penjualan_sparepart_id',
        'nama_sparepart',
        'kode_sparepart',
        'harga',
        'jumlah',
        'total',
    ];
}
