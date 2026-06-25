@extends(auth()->check() && auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.user')

@section('title', 'Stok Sparepart - Bengkel Theo')
@section('page-heading', 'Stok Sparepart')

@section('content')
    @if(auth()->check() && auth()->user()->role === 'admin')
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-primary" href="{{ route('sparepart.create') }}">+ Tambah Stok</a>
        </div>
    @endif

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

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="p-3 border-top bg-light d-flex gap-2 flex-wrap justify-content-end">
                        <button
                            class="btn btn-warning btn-sm flex-grow-1"
                            type="button"
                            data-confirm-action="{{ route('sparepart.beli', $sparepart->id) }}"
                            data-confirm-message="Proses pembelian dan cetak nota produk ini?"
                            data-confirm-button="Ya, Proses"
                            data-confirm-button-class="btn btn-warning"
                            {{ $sparepart->stok < 1 ? 'disabled' : '' }}>
                            Beli & Nota
                        </button>
                        <a class="btn btn-secondary btn-sm" href="{{ route('sparepart.edit', $sparepart->id) }}">Edit</a>
                        <button
                            class="btn btn-danger btn-sm"
                            type="button"
                            data-confirm-action="{{ route('sparepart.delete', $sparepart->id) }}"
                            data-confirm-method="DELETE"
                            data-confirm-message="Hapus produk sparepart ini?"
                            data-confirm-button="Ya, Hapus"
                            data-confirm-button-class="btn btn-danger">
                            Hapus
                        </button>
                    </div>
                @endif
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
