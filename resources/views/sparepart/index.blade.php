@extends('layouts.admin')

@section('title', 'Penjualan Sparepart - Bengkel Theo')

@section('content')
    <div class="admin-page-header">
        <h1 class="admin-page-title">Penjualan Sparepart</h1>
        <a class="admin-btn admin-btn-primary" href="{{ route('sparepart.create') }}">
            + Tambah Stok
        </a>
    </div>

    <div class="admin-table-container">
        <form class="admin-filter-bar" action="{{ route('sparepart.index') }}" method="GET">
            <div class="form-group">
                <label for="q">Cari Sparepart</label>
                <input id="q" type="search" name="q" value="{{ $search }}" placeholder="Cari nama atau kode sparepart...">
            </div>
            <div style="display: flex; gap: 8px;">
                <button class="admin-btn admin-btn-primary" type="submit">Cari</button>
                @if ($search)
                    <a class="admin-btn admin-btn-secondary" href="{{ route('sparepart.index') }}">Reset</a>
                @endif
            </div>
        </form>

        <!-- Using a data grid for admin instead of cards -->
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Kode</th>
                        <th>Nama Sparepart</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penjualanSpareparts as $sparepart)
                        <tr>
                            <td>
                                @if ($sparepart->gambar_sparepart)
                                    <img src="{{ asset('storage/' . $sparepart->gambar_sparepart) }}" alt="{{ $sparepart->nama_sparepart }}" style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                                @else
                                    <div style="width: 48px; height: 48px; background: #f1f5f9; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 10px; font-weight: bold;">
                                        NO IMG
                                    </div>
                                @endif
                            </td>
                            <td><strong>{{ $sparepart->kode_sparepart }}</strong></td>
                            <td>{{ $sparepart->nama_sparepart }}</td>
                            <td style="font-weight: 700;">Rp {{ number_format($sparepart->harga, 0, ',', '.') }}</td>
                            <td>
                                @if($sparepart->stok > 10)
                                    <span class="admin-badge success">{{ number_format($sparepart->stok) }}</span>
                                @elseif($sparepart->stok > 0)
                                    <span class="admin-badge warning">{{ number_format($sparepart->stok) }}</span>
                                @else
                                    <span class="admin-badge neutral" style="color: #ef4444;">Habis</span>
                                @endif
                            </td>
                            <td>
                                <div style="display:flex; gap:8px;">
                                    <button
                                        class="admin-btn admin-btn-primary"
                                        style="background: #eab308; color: #fff;"
                                        type="button"
                                        data-confirm-action="{{ route('sparepart.beli', $sparepart->id) }}"
                                        data-confirm-message="Proses pembelian dan cetak nota produk ini?"
                                        data-confirm-button="Ya, Proses"
                                        {{ $sparepart->stok < 1 ? 'disabled' : '' }}>
                                        Beli & Nota
                                    </button>
                                    <a class="admin-btn admin-btn-secondary" href="{{ route('sparepart.edit', $sparepart->id) }}">Edit</a>
                                    <button
                                        class="admin-btn admin-btn-danger"
                                        type="button"
                                        data-confirm-action="{{ route('sparepart.delete', $sparepart->id) }}"
                                        data-confirm-method="DELETE"
                                        data-confirm-message="Hapus produk sparepart ini?"
                                        data-confirm-button="Ya, Hapus">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding: 40px; color: #64748b;">
                                {{ $search ? 'Sparepart tidak ditemukan.' : 'Belum ada produk sparepart.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 16px 20px; border-top: 1px solid #e2e8f0;">
            {{ $penjualanSpareparts->links() }}
        </div>
    </div>
@endsection
