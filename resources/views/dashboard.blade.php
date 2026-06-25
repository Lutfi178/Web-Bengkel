@extends('layouts.admin')

@section('title', 'Dashboard - Bengkel Theo')

@section('content')
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Dashboard Overview</h1>
        </div>
        <div class="admin-badge neutral" style="font-size: 14px; padding: 10px 18px;">
            <svg style="margin-right:8px;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            JAM OPERASIONAL: 08.00 - 17.00
        </div>
    </div>

    <div class="admin-metrics-grid">
        <div class="admin-metric-card">
            <span class="metric-label">Penjualan Sparepart</span>
            <p class="metric-value">{{ number_format($totalSparepart) }}</p>
        </div>
        <div class="admin-metric-card success">
            <span class="metric-label">Total Booking Servis</span>
            <p class="metric-value">{{ number_format($totalBookingServis) }}</p>
        </div>
        <div class="admin-metric-card">
            <span class="metric-label">Pendapatan Sparepart</span>
            <p class="metric-value">Rp {{ number_format($totalPendapatanSparepart, 0, ',', '.') }}</p>
        </div>
        <div class="admin-metric-card warning">
            <span class="metric-label">Booking Belum Bayar</span>
            <p class="metric-value">{{ number_format($bookingBelumDibayar) }}</p>
        </div>
    </div>

    <div class="admin-grid-2">
        <div class="admin-panel">
            <div class="admin-panel-header">
                <h3 class="admin-panel-title">Sparepart Paling Laris</h3>
            </div>
            <div class="admin-list-group">
                @forelse ($sparepartPalingLaris as $sparepart)
                    <div class="admin-list-item">
                        <div>
                            <div class="admin-list-item-title">{{ $sparepart->nama_sparepart }}</div>
                            <div class="admin-list-item-sub">{{ $sparepart->kode_sparepart }}</div>
                        </div>
                        <div class="admin-list-item-value">
                            <strong>{{ number_format($sparepart->jumlah_terjual) }} unit</strong>
                            <div class="admin-list-item-sub">Rp {{ number_format($sparepart->total_pendapatan, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">Belum ada transaksi.</div>
                @endforelse
            </div>
        </div>

        <div class="admin-panel">
            <div class="admin-panel-header">
                <h3 class="admin-panel-title text-danger">Peringatan Stok Tipis</h3>
                <a class="admin-btn admin-btn-secondary" href="{{ route('sparepart.index') }}">Kelola</a>
            </div>
            <div class="admin-list-group">
                @forelse ($stokHampirHabis as $sparepart)
                    <div class="admin-list-item">
                        <div>
                            <div class="admin-list-item-title">{{ $sparepart->nama_sparepart }}</div>
                            <div class="admin-list-item-sub">{{ $sparepart->kode_sparepart }}</div>
                        </div>
                        <div>
                            <span class="admin-badge warning">{{ number_format($sparepart->stok) }} tersisa</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">Stok aman.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Keep the charts using basic HTML for now, stacked vertically -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <div class="admin-panel">
            <div class="admin-panel-header">
                <h3 class="admin-panel-title">Grafik Penjualan {{ $tahunGrafik }}</h3>
                <strong>Rp {{ number_format($grafikPenjualan->sum('total'), 0, ',', '.') }}</strong>
            </div>
            <div class="bar-chart mt-4">
                @foreach ($grafikPenjualan as $data)
                    @php
                        $tinggi = $data['total'] > 0 ? max(($data['total'] / $nilaiTertinggiPenjualan) * 100, 8) : 0;
                    @endphp
                    <div class="bar-item">
                        <div class="bar-track">
                            <div class="bar-fill" style="height: {{ $tinggi }}%; background:#2563eb;">
                            </div>
                        </div>
                        <strong>{{ $data['bulan'] }}</strong>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="admin-panel">
            <div class="admin-panel-header">
                <h3 class="admin-panel-title">Grafik Servis {{ $tahunGrafik }}</h3>
                <strong>{{ number_format($grafikServis->sum('total')) }} Booking</strong>
            </div>
            <div class="bar-chart mt-4">
                @foreach ($grafikServis as $data)
                    @php
                        $tinggi = $data['total'] > 0 ? max(($data['total'] / $nilaiTertinggiServis) * 100, 8) : 0;
                    @endphp
                    <div class="bar-item">
                        <div class="bar-track">
                            <div class="bar-fill" style="height: {{ $tinggi }}%; background:#10b981;">
                            </div>
                        </div>
                        <strong>{{ $data['bulan'] }}</strong>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
