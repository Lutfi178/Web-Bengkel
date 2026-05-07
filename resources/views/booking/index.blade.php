@extends('layouts.app')

@section('title', 'Data Booking User - Bengkel Theo')
@section('page-heading', 'Data Booking User')

@section('content')
    <div class="data-panel">
        <div class="data-panel-header">
            <div>
                <h1 class="h4 fw-bold mb-0">BOOKING ONLINE</h1>
            </div>
        </div>

        <div class="data-panel-body">
            <form class="booking-filter" action="{{ route('booking.index') }}" method="GET">
                <div>
                    <label for="q">Nama / Plat Motor</label>
                    <input class="form-control" id="q" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari nama atau plat...">
                </div>
                <div>
                    <label for="tanggal_booking">Tanggal Booking</label>
                    <input class="form-control" id="tanggal_booking" type="date" name="tanggal_booking" value="{{ $filters['tanggal_booking'] ?? '' }}">
                </div>
                <div>
                    <label for="nomor_antrian">No Antrian</label>
                    <input class="form-control" id="nomor_antrian" type="number" name="nomor_antrian" min="1" max="10" value="{{ $filters['nomor_antrian'] ?? '' }}" placeholder="1-10">
                </div>
                <div class="booking-filter-actions">
                    <button class="btn btn-primary" type="submit">Filter</button>
                    @if (array_filter($filters))
                        <a class="btn btn-light" href="{{ route('booking.index') }}">Reset</a>
                    @endif
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle data-table">
                    <thead>
                        <tr>
                            <th>No Antrian</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No HP/WA</th>
                            <th>Tanggal Booking</th>
                            <th>Plat Motor</th>
                            <th>Jenis Motor</th>
                            <th>Paket Servis</th>
                            <th>Keluhan/Kerusakan</th>
                            <th>User</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr>
                                <td><span class="soft-pill">{{ $booking->nomor_antrian ?? '-' }}</span></td>
                                <td><strong>{{ $booking->nama }}</strong></td>
                                <td class="text-muted">{{ $booking->alamat }}</td>
                                <td><span class="soft-pill">{{ $booking->no_hp_wa }}</span></td>
                                <td>{{ $booking->tanggal_booking?->format('d/m/Y') ?? '-' }}</td>
                                <td><span class="soft-pill">{{ $booking->plat_motor }}</span></td>
                                <td>{{ $booking->jenis_motor }}</td>
                                <td>
                                    @if ($booking->paket_servis)
                                        <strong>{{ $booking->paket_servis }}</strong><br>
                                        <span class="text-muted">Rp {{ number_format($booking->harga_paket_servis, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-muted">Tidak memilih</span>
                                    @endif
                                </td>
                                <td class="booking-complaint">{{ $booking->keluhan_motor ?: '-' }}</td>
                                <td class="text-muted">{{ $booking->user?->email ?? '-' }}</td>
                                <td>{{ $booking->created_at?->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge text-bg-warning">Belum Bayar</span>
                                </td>
                                <td>
                                    <div class="action-stack">
                                        <a class="btn btn-primary btn-sm" href="{{ route('booking.bayar', $booking->id) }}">Bayar</a>
                                        <button
                                            class="btn btn-danger btn-sm"
                                            type="button"
                                            data-confirm-action="{{ route('booking.delete', $booking->id) }}"
                                            data-confirm-method="DELETE"
                                            data-confirm-message="Batalkan booking ini?"
                                            data-confirm-button="Ya, Batalkan"
                                            data-confirm-button-class="btn btn-danger">
                                            Batalkan
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="empty-table" colspan="13">Belum ada booking online dari user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
@endsection
