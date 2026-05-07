@extends('layouts.app')

@section('title', 'Nota Booking Servis - Bengkel Theo')
@section('page-heading', 'Nota Booking Servis')

@section('content')
    <div class="nota-toolbar">
        <a class="btn btn-light" href="{{ route('booking.index') }}">Kembali</a>
        <button class="btn btn-primary" type="button" onclick="window.print()">Print Nota</button>
    </div>

    <section class="nota-card">
        <div class="nota-header">
            <div>
                <h1>Bengkel Theo</h1>
                <p>Nota Pembayaran Booking Servis</p>
            </div>
            <div class="nota-number">
                <span>No Nota</span>
                <strong>{{ $nomorNota }}</strong>
            </div>
        </div>

        <div class="nota-info">
            <div>
                <span>Nomor Antrian</span>
                <strong>{{ $booking->nomor_antrian ?? '-' }}</strong>
            </div>
            <div>
                <span>Nama</span>
                <strong>{{ $booking->nama }}</strong>
            </div>
            <div>
                <span>No HP/WA</span>
                <strong>{{ $booking->no_hp_wa }}</strong>
            </div>
            <div>
                <span>Tanggal Booking</span>
                <strong>{{ $booking->tanggal_booking?->format('d/m/Y') ?? '-' }}</strong>
            </div>
            <div>
                <span>Motor</span>
                <strong>{{ $booking->jenis_motor }}</strong>
            </div>
            <div>
                <span>Paket Servis</span>
                <strong>{{ $booking->paket_servis ?? 'Tidak memilih paket' }}</strong>
            </div>
            <div>
                <span>Plat Motor</span>
                <strong>{{ $booking->plat_motor }}</strong>
            </div>
            <div>
                <span>Tanggal Bayar</span>
                <strong>{{ ($booking->dibayar_at ?? now())->format('d/m/Y H:i') }}</strong>
            </div>
            <div>
                <span>Admin</span>
                <strong>{{ auth()->user()->name }}</strong>
            </div>
        </div>

        <div class="mb-3">
            <span class="text-muted fw-bold small text-uppercase">Keluhan/Kerusakan</span>
            <p class="mb-0">{{ $booking->keluhan_motor ?: '-' }}</p>
        </div>

        <table class="nota-table">
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @if ($booking->paket_servis)
                    <tr>
                        <td>{{ $booking->paket_servis }}</td>
                        <td>Rp {{ number_format($booking->harga_paket_servis, 0, ',', '.') }}</td>
                    </tr>
                @endif
                <tr>
                    <td>Harga Servis</td>
                    <td>Rp {{ number_format($booking->harga_servis, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Biaya Pergantian Sparepart</td>
                    <td>Rp {{ number_format($booking->harga_sparepart, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="nota-total">
            <span>Total Bayar</span>
            <strong>Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}</strong>
        </div>

        <div class="nota-footer">
            <p>Terima kasih sudah mempercayakan servis motor Anda kepada Bengkel Theo.</p>
        </div>
    </section>
@endsection
