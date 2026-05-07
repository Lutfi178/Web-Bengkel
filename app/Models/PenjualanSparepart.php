<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanSparepart extends Model
{
    protected $fillable = [
        'nama_sparepart',
        'kode_sparepart',
        'gambar_sparepart',
        'harga',
        'no_hp_pembeli',
        'stok',
    ];
}
