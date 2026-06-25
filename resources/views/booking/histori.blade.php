@extends('layouts.admin')

@section('title', 'Histori Servis User - Bengkel Theo')

@section('content')
    <div class="admin-page-header">
        <h1 class="admin-page-title">Histori Servis</h1>
    </div>

    <div class="admin-table-container">
        <form class="admin-filter-bar" action="{{ route('booking.histori') }}" method="GET">
            <div class="form-group">
                <label for="q">Nama / Plat / Motor</label>
                <input id="q" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari nama, plat...">
            </div>
            <div class="form-group">
                <label for="tanggal_booking">Tanggal Booking</label>
                <input id="tanggal_booking" type="date" name="tanggal_booking" value="{{ $filters['tanggal_booking'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="tanggal_bayar">Tanggal Bayar</label>
                <input id="tanggal_bayar" type="date" name="tanggal_bayar" value="{{ $filters['tanggal_bayar'] ?? '' }}">
            </div>
            <div style="display: flex; gap: 8px;">
                <button class="admin-btn admin-btn-primary" type="submit">Filter</button>
                @if (array_filter($filters))
                    <a class="admin-btn admin-btn-secondary" href="{{ route('booking.histori') }}">Reset</a>
                @endif
            </div>
        </form>

        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Antrian</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Tgl Booking</th>
                        <th>Tgl Bayar</th>
                        <th>Rincian Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td><span class="admin-badge neutral">{{ $booking->nomor_antrian ?? '-' }}</span></td>
                            <td>
                                <strong>{{ $booking->nama }}</strong><br>
                                <span style="font-size:12px;color:#64748b;">{{ $booking->no_hp_wa }}</span>
                            </td>
                            <td>
                                <span class="admin-badge neutral">{{ $booking->plat_motor }}</span><br>
                                <span style="font-size:12px;">{{ $booking->jenis_motor }}</span>
                            </td>
                            <td>{{ $booking->tanggal_booking?->format('d/m/Y') ?? '-' }}</td>
                            <td>
                                @if($booking->dibayar_at)
                                    <span style="color:#10b981;font-weight:700;">{{ $booking->dibayar_at->format('d/m/Y') }}</span><br>
                                    <span style="font-size:12px;color:#64748b;">{{ $booking->dibayar_at->format('H:i') }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div style="font-size:13px;">
                                    <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                                        <span style="color:#64748b;">Servis:</span>
                                        <span>Rp {{ number_format($booking->harga_servis, 0, ',', '.') }}</span>
                                    </div>
                                    <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                                        <span style="color:#64748b;">Sparepart:</span>
                                        <span>Rp {{ number_format($booking->harga_sparepart, 0, ',', '.') }}</span>
                                    </div>
                                    <div style="display:flex; justify-content:space-between; border-top:1px solid #e2e8f0; padding-top:4px; font-weight:800; color:#0f172a;">
                                        <span>Total:</span>
                                        <span>Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a class="admin-btn admin-btn-secondary" href="{{ route('booking.nota', $booking->id) }}">
                                    Print Nota
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding: 40px; color: #64748b;">Belum ada histori servis yang sudah dibayar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 16px 20px; border-top: 1px solid #e2e8f0;">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection
