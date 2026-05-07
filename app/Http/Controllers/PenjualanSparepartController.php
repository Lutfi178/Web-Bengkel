<?php

namespace App\Http\Controllers;

use App\Models\PenjualanSparepart;
use App\Models\RiwayatPenjualanSparepart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PenjualanSparepartController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('q');

        $penjualanSpareparts = PenjualanSparepart::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nama_sparepart', 'like', '%' . $search . '%')
                    ->orWhere('kode_sparepart', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('sparepart.index', compact('penjualanSpareparts', 'search'));
    }

    public function create(): View
    {
        return view('sparepart.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        if ($request->hasFile('gambar_sparepart')) {
            $validated['gambar_sparepart'] = $request->file('gambar_sparepart')->store('spareparts', 'public');
        }

        PenjualanSparepart::create($validated);

        return redirect()->route('sparepart.index')->with('success', 'Data penjualan sparepart berhasil ditambahkan.');
    }

    public function edit(int $id): View
    {
        $sparepart = PenjualanSparepart::findOrFail($id);

        return view('sparepart.edit', compact('sparepart'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $sparepart = PenjualanSparepart::findOrFail($id);
        $validated = $request->validate($this->rules($id));

        if ($request->hasFile('gambar_sparepart')) {
            if ($sparepart->gambar_sparepart) {
                Storage::disk('public')->delete($sparepart->gambar_sparepart);
            }

            $validated['gambar_sparepart'] = $request->file('gambar_sparepart')->store('spareparts', 'public');
        }

        $sparepart->update($validated);

        return redirect()->route('sparepart.index')->with('success', 'Data penjualan sparepart berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $sparepart = PenjualanSparepart::findOrFail($id);

        if ($sparepart->gambar_sparepart) {
            Storage::disk('public')->delete($sparepart->gambar_sparepart);
        }

        $sparepart->delete();

        return redirect()->route('sparepart.index')->with('success', 'Data penjualan sparepart berhasil dihapus.');
    }

    public function beli(int $id): RedirectResponse
    {
        $riwayat = DB::transaction(function () use ($id) {
            $sparepart = PenjualanSparepart::whereKey($id)->lockForUpdate()->firstOrFail();

            if ($sparepart->stok < 1) {
                return null;
            }

            $sparepart->decrement('stok');

            return RiwayatPenjualanSparepart::create([
                'penjualan_sparepart_id' => $sparepart->id,
                'nama_sparepart' => $sparepart->nama_sparepart,
                'kode_sparepart' => $sparepart->kode_sparepart,
                'harga' => $sparepart->harga,
                'jumlah' => 1,
                'total' => $sparepart->harga,
            ]);
        });

        if (! $riwayat) {
            return back()->with('error', 'Stok sparepart sudah habis.');
        }

        return redirect()
            ->route('sparepart.nota', $riwayat->id)
            ->with('success', 'Pembelian berhasil. Nota siap dicetak.');
    }

    public function nota(int $id): View
    {
        $sparepart = RiwayatPenjualanSparepart::findOrFail($id);

        return view('sparepart.nota', [
            'sparepart' => $sparepart,
            'jumlah' => $sparepart->jumlah,
            'total' => $sparepart->total,
            'nomorNota' => 'BT-' . now()->format('Ymd-His') . '-' . $sparepart->id,
        ]);
    }

    private function rules(?int $id = null): array
    {
        return [
            'nama_sparepart' => ['required', 'string', 'max:255'],
            'gambar_sparepart' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'kode_sparepart' => [
                'required',
                'string',
                'max:100',
                Rule::unique('penjualan_spareparts', 'kode_sparepart')->ignore($id),
            ],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
        ];
    }
}
