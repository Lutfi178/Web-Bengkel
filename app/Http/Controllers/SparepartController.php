<?php

namespace App\Http\Controllers;

use App\Models\PenjualanSparepart;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SparepartController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('q');

        $spareparts = PenjualanSparepart::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nama_sparepart', 'like', '%' . $search . '%')
                    ->orWhere('kode_sparepart', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('sparepart.stok', compact('spareparts', 'search'));
    }
}
