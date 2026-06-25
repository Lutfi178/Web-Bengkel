@extends('layouts.admin')

@section('title', 'Data Booking User - Bengkel Theo')

@section('content')
    <div class="admin-page-header">
        <h1 class="admin-page-title">Booking User</h1>
    </div>

    <div class="admin-table-container">
        <form class="admin-filter-bar" action="{{ route('booking.index') }}" method="GET">
            <div class="form-group">
                <label for="q">Nama / Plat Motor</label>
                <input id="q" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari nama atau plat...">
            </div>
            <div class="form-group">
                <label for="tanggal_booking">Tanggal Booking</label>
                <input id="tanggal_booking" type="date" name="tanggal_booking" value="{{ $filters['tanggal_booking'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="nomor_antrian">No Antrian</label>
                <input id="nomor_antrian" type="number" name="nomor_antrian" min="1" max="10" value="{{ $filters['nomor_antrian'] ?? '' }}" placeholder="1-10">
            </div>
            <div style="display: flex; gap: 8px;">
                <button class="admin-btn admin-btn-primary" type="submit">Filter</button>
                @if (array_filter($filters))
                    <a class="admin-btn admin-btn-secondary" href="{{ route('booking.index') }}">Reset</a>
                @endif
            </div>
        </form>

        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No Antrian</th>
                        <th>Pelanggan</th>
                        <th>Kontak</th>
                        <th>Tanggal</th>
                        <th>Kendaraan</th>
                        <th>Servis / Keluhan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td><span class="admin-badge neutral">{{ $booking->nomor_antrian ?? '-' }}</span></td>
                            <td>
                                <strong>{{ $booking->nama }}</strong><br>
                                <span style="font-size:12px;color:#64748b;">{{ $booking->user?->email ?? 'Guest' }}</span>
                            </td>
                            <td>
                                {{ $booking->no_hp_wa }}<br>
                                <span style="font-size:12px;color:#64748b;">{{ \Illuminate\Support\Str::limit($booking->alamat, 20) }}</span>
                            </td>
                            <td>{{ $booking->tanggal_booking?->format('d/m/Y') ?? '-' }}</td>
                            <td>
                                <span class="admin-badge neutral">{{ $booking->plat_motor }}</span><br>
                                <span style="font-size:12px;">{{ $booking->jenis_motor }}</span>
                            </td>
                            <td>
                                @if ($booking->paket_servis)
                                    <strong>{{ $booking->paket_servis }}</strong>
                                @else
                                    <span style="color:#64748b;">Non-Paket</span>
                                @endif
                                <br><span style="font-size:12px;color:#64748b;">{{ \Illuminate\Support\Str::limit($booking->keluhan_motor, 30) }}</span>
                            </td>
                            <td>
                                <span class="admin-badge warning">Belum Bayar</span>
                            </td>
                            <td>
                                <div style="display:flex; gap:8px;">
                                    <a class="admin-btn admin-btn-primary" href="{{ route('booking.bayar', $booking->id) }}">Bayar</a>
                                    <button
                                        class="admin-btn admin-btn-danger"
                                        type="button"
                                        data-confirm-action="{{ route('booking.delete', $booking->id) }}"
                                        data-confirm-method="DELETE"
                                        data-confirm-message="Batalkan booking ini?"
                                        data-confirm-button="Ya, Batalkan">
                                        Batal
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding: 40px; color: #64748b;">Belum ada booking dari user.</td>
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
