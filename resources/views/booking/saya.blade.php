@extends('layouts.app')

@section('title', 'Bookingan Saya - Bengkel Theo')
@section('page-heading', 'Bookingan Saya')

@section('content')
    <div class="data-panel">
        <div class="data-panel-header">
            <div>
                <span class="eyebrow">Data Booking</span>
                <h1 class="h4 fw-bold mb-0">BOOKINGAN SAYA</h1>
            </div>
            <a class="btn btn-primary" href="{{ route('booking.create') }}">Tambah Booking</a>
        </div>

        <div class="data-panel-body">
            <form class="booking-filter" action="{{ route('booking.saya') }}" method="GET">
                <div>
                    <label for="q">Plat / Motor / Paket</label>
                    <input class="form-control" id="q" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari booking...">
                </div>
                <div>
                    <label for="tanggal_booking">Tanggal Booking</label>
                    <input class="form-control" id="tanggal_booking" type="date" name="tanggal_booking" value="{{ $filters['tanggal_booking'] ?? '' }}">
                </div>
                <div class="booking-filter-actions">
                    <button class="btn btn-primary" type="submit">Filter</button>
                    @if (array_filter($filters))
                        <a class="btn btn-light" href="{{ route('booking.saya') }}">Reset</a>
                    @endif
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle data-table">
                    <thead>
                        <tr>
                            <th>No Antrian</th>
                            <th>Tanggal Booking</th>
                            <th>Plat Motor</th>
                            <th>Jenis Motor</th>
                            <th>Paket Servis</th>
                            <th>Keluhan</th>
                            <th>Total Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr>
                                <td><span class="soft-pill">{{ $booking->nomor_antrian ?? '-' }}</span></td>
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
                                <td>
                                    @if ($booking->dibayar_at)
                                        <strong>Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}</strong>
                                    @else
                                        <span class="text-muted">Belum tersedia</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-stack">
                                        @if ($booking->dibayar_at)
                                            <a class="btn btn-secondary btn-sm" href="{{ route('booking.nota-online', $booking->id) }}">Print Nota</a>
                                        @else
                                            <a class="btn btn-primary btn-sm" href="{{ route('booking.edit-online', $booking->id) }}">Edit</a>
                                            <button
                                                class="btn btn-danger btn-sm"
                                                type="button"
                                                data-confirm-action="{{ route('booking.destroy-online', $booking->id) }}"
                                                data-confirm-method="DELETE"
                                                data-confirm-message="Hapus booking ini?"
                                                data-confirm-button="Ya, Hapus"
                                                data-confirm-button-class="btn btn-danger">
                                                Hapus
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="empty-table" colspan="8">Belum ada booking online.</td>
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
