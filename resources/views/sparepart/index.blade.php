@extends('layouts.app')

@section('title', 'Penjualan Sparepart - Bengkel Theo')
@section('page-heading', 'Penjualan Sparepart')

@section('content')
    <div class="toolbar">
        <div></div>
        <a class="btn btn-primary" href="{{ route('sparepart.create') }}">Tambah Stok</a>
    </div>

    <form class="catalog-search" action="{{ route('sparepart.index') }}" method="GET">
        <div>
            <label for="q">Cari Penjualan Sparepart</label>
            <input id="q" type="search" name="q" value="{{ $search }}" placeholder="Cari nama atau kode sparepart...">
        </div>
        <button class="btn btn-primary" type="submit">Cari</button>
        @if ($search)
            <a class="btn btn-light" href="{{ route('sparepart.index') }}">Reset</a>
        @endif
    </form>

    <div class="product-grid">
        @forelse ($penjualanSpareparts as $sparepart)
            <article class="product-card">
                <div class="product-image">
                    @if ($sparepart->gambar_sparepart)
                        <img src="{{ asset('storage/' . $sparepart->gambar_sparepart) }}" alt="{{ $sparepart->nama_sparepart }}">
                    @else
                        <div class="product-placeholder">
                            <span>BT</span>
                            <small>Sparepart</small>
                        </div>
                    @endif
                </div>

                <div class="product-body">
                    <div class="product-code">{{ $sparepart->kode_sparepart }}</div>
                    <h2>{{ $sparepart->nama_sparepart }}</h2>
                    <div class="product-price">Rp {{ number_format($sparepart->harga, 0, ',', '.') }}</div>
                    <div class="stock-badge {{ $sparepart->stok > 0 ? 'stock-ready' : 'stock-empty' }}">
                        Stok: {{ number_format($sparepart->stok) }}
                    </div>
                </div>

                <div class="product-actions">
                    <button
                        class="btn btn-warning"
                        type="button"
                        data-confirm-action="{{ route('sparepart.beli', $sparepart->id) }}"
                        data-confirm-message="Proses pembelian dan cetak nota produk ini?"
                        data-confirm-button="Ya, Proses"
                        data-confirm-button-class="btn btn-warning"
                        {{ $sparepart->stok < 1 ? 'disabled' : '' }}>
                        Beli & Print Nota
                    </button>
                    <a class="btn btn-secondary" href="{{ route('sparepart.edit', $sparepart->id) }}">Edit</a>
                    <button
                        class="btn btn-danger"
                        type="button"
                        data-confirm-action="{{ route('sparepart.delete', $sparepart->id) }}"
                        data-confirm-method="DELETE"
                        data-confirm-message="Hapus produk sparepart ini?"
                        data-confirm-button="Ya, Hapus"
                        data-confirm-button-class="btn btn-danger">
                        Hapus
                    </button>
                </div>
            </article>
        @empty
            <div class="content-card empty-state">
                <h2>{{ $search ? 'Sparepart tidak ditemukan.' : 'Belum ada produk sparepart.' }}</h2>
                <p>{{ $search ? 'Coba gunakan nama atau kode sparepart lain.' : 'Tambahkan produk pertama agar katalog sparepart mulai terisi.' }}</p>
            </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $penjualanSpareparts->links() }}
    </div>
@endsection
