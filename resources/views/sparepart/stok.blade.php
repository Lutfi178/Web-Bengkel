@extends('layouts.app')

@section('title', 'Stok Sparepart - Bengkel Theo')
@section('page-heading', 'Stok Sparepart')

@section('content')
    <form class="catalog-search" action="{{ route('sparepart.stok') }}" method="GET">
        <div>
            <label for="q">Cari Sparepart</label>
            <input id="q" type="search" name="q" value="{{ $search }}" placeholder="Cari nama atau kode sparepart...">
        </div>
        <button class="btn btn-primary" type="submit">Cari</button>
        @if ($search)
            <a class="btn btn-light" href="{{ route('sparepart.stok') }}">Reset</a>
        @endif
    </form>

    <div class="stock-catalog-grid">
        @forelse ($spareparts as $sparepart)
            <article class="stock-product-card">
                <div class="stock-product-image">
                    @if ($sparepart->gambar_sparepart)
                        <img src="{{ asset('storage/' . $sparepart->gambar_sparepart) }}" alt="{{ $sparepart->nama_sparepart }}">
                    @else
                        <div class="stock-product-placeholder">
                            <span>BT</span>
                            <small>Sparepart</small>
                        </div>
                    @endif

                    <div class="stock-floating-badge {{ $sparepart->stok > 0 ? 'stock-ready' : 'stock-empty' }}">
                        {{ $sparepart->stok > 0 ? 'Tersedia' : 'Habis' }}
                    </div>
                </div>

                <div class="stock-product-body">
                    <div class="product-code">{{ $sparepart->kode_sparepart }}</div>
                    <h2>{{ $sparepart->nama_sparepart }}</h2>
                    <div class="product-price">Rp {{ number_format($sparepart->harga, 0, ',', '.') }}</div>

                    <div class="stock-product-meta">
                        <span>Stok</span>
                        <strong>{{ number_format($sparepart->stok) }}</strong>
                    </div>
                </div>
            </article>
        @empty
            <div class="content-card empty-state">
                <h2>{{ $search ? 'Sparepart tidak ditemukan.' : 'Stok sparepart masih kosong.' }}</h2>
                <p>{{ $search ? 'Coba gunakan nama atau kode sparepart lain.' : 'Produk yang ditambahkan admin akan muncul di katalog ini.' }}</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $spareparts->links() }}
    </div>
@endsection
