@extends('layouts.app')

@section('title', 'Bayar Booking - Bengkel Theo')
@section('page-heading', 'Bayar Booking')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <span class="eyebrow">Pembayaran Servis</span>
            <h1 class="h4 fw-bold mb-0">Input Pembayaran Booking</h1>
        </div>

        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <div class="text-muted small">Nomor Antrian</div>
                        <strong>{{ $booking->nomor_antrian ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <div class="text-muted small">Nama</div>
                        <strong>{{ $booking->nama }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <div class="text-muted small">Motor</div>
                        <strong>{{ $booking->jenis_motor }} - {{ $booking->plat_motor }}</strong>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 bg-light rounded">
                        <div class="text-muted small">Keluhan/Kerusakan</div>
                        <strong>{{ $booking->keluhan_motor ?: '-' }}</strong>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 bg-light rounded">
                        <div class="text-muted small">Paket Servis</div>
                        <strong>
                            {{ $booking->paket_servis ?? 'Tidak memilih paket' }}
                            @if ($booking->paket_servis)
                                - Rp {{ number_format($booking->harga_paket_servis, 0, ',', '.') }}
                            @endif
                        </strong>
                    </div>
                </div>
            </div>

            <form action="{{ route('booking.proses-bayar', $booking->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="harga_servis">Harga Servis</label>
                        <input class="form-control" id="harga_servis" type="number" name="harga_servis" min="0" step="1" value="{{ old('harga_servis', $booking->harga_servis ?? 0) }}" required>
                        @error('harga_servis')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="harga_sparepart">Biaya Pergantian Sparepart</label>
                        <input class="form-control" id="harga_sparepart" type="number" name="harga_sparepart" min="0" step="1" value="{{ old('harga_sparepart', $booking->harga_sparepart ?? 0) }}" required>
                        @error('harga_sparepart')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button class="btn btn-primary" type="submit">Simpan & Print Nota</button>
                    <a class="btn btn-light" href="{{ route('booking.index') }}">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
