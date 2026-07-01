@extends('layouts.admin')

@section('title', 'Dashboard - Bengkel Theo')
@section('page-heading', 'Dashboard Operasional')

@section('content')
    <!-- Jam Operasional Banner -->
    <div class="jam-ops-card">
        <div class="jam-ops-info">
            <span class="jam-ops-label">Jam Operasional</span>
            <h3 class="jam-ops-value">SENIN - SABTU</h3>
        </div>
        <div class="jam-ops-time">
            08-17
        </div>
    </div>

    <!-- Metrics Grid -->
    <div class="admin-metrics-grid">
        <div class="admin-metric-card">
            <span class="metric-label">Total Penjualan</span>
            <p class="metric-value">{{ number_format($totalSparepart) }}</p>
        </div>
        <div class="admin-metric-card">
            <span class="metric-label">Booking Servis</span>
            <p class="metric-value">{{ number_format($totalBookingServis) }}</p>
        </div>
        <div class="admin-metric-card">
            <span class="metric-label">Pendapatan</span>
            <p class="metric-value">Rp {{ number_format($totalPendapatanSparepart, 0, ',', '.') }}</p>
        </div>
        <div class="admin-metric-card">
            <span class="metric-label">Stok Hampir Habis</span>
            <p class="metric-value">{{ \App\Models\PenjualanSparepart::whereBetween('stok', [1, 3])->count() }}</p>
        </div>
    </div>

    <!-- Ringkasan & Peringatan Section -->
    <div class="admin-grid-2">
        <div class="admin-panel">
            <span class="column-header-kicker">Ringkasan</span>
            <h3 class="column-header-title">Sparepart Paling Laris</h3>
            <div class="laris-list">
                @forelse ($sparepartPalingLaris as $sparepart)
                    <div class="laris-item">
                        <span>{{ $sparepart->nama_sparepart }}</span>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">Belum ada transaksi.</div>
                @endforelse
            </div>
        </div>

        <div class="admin-panel">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="column-header-kicker">Peringatan</span>
                    <h3 class="column-header-title text-danger">Stok Hampir Habis</h3>
                </div>
                <a class="btn btn-outline-secondary btn-sm rounded-pill px-3" href="{{ route('sparepart.index') }}">Kelola</a>
            </div>
            <div class="hampir-habis-list">
                @forelse ($stokHampirHabis as $sparepart)
                    <div class="hampir-habis-item">
                        <span>{{ $sparepart->nama_sparepart }}</span>
                        <span class="stock-pill-badge">{{ $sparepart->stok }} stok</span>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">Stok aman.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Grafik Section -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <div class="admin-panel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <span class="column-header-kicker">Grafik</span>
                    <h3 class="column-header-title m-0">Penjualan Sparepart {{ $tahunGrafik }}</h3>
                </div>
                <strong class="text-success fs-5">Rp {{ number_format($grafikPenjualan->sum('total'), 0, ',', '.') }}</strong>
            </div>
            <div class="bar-chart mt-4">
                @foreach ($grafikPenjualan as $data)
                    @php
                        $tinggi = $data['total'] > 0 ? max(($data['total'] / $nilaiTertinggiPenjualan) * 100, 8) : 0;
                        $isHighlighted = $data['total'] == $nilaiTertinggiPenjualan && $data['total'] > 0;
                    @endphp
                    <div class="bar-item">
                        <div class="bar-track">
                            <div class="bar-fill {{ $isHighlighted ? 'highlighted' : '' }}" style="height: {{ $tinggi }}%;">
                            </div>
                        </div>
                        <strong>{{ $data['bulan'] }}</strong>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="admin-panel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <span class="column-header-kicker">Grafik</span>
                    <h3 class="column-header-title m-0">Grafik Servis {{ $tahunGrafik }}</h3>
                </div>
                <strong class="text-primary fs-5">{{ number_format($grafikServis->sum('total')) }} Booking</strong>
            </div>
            <div class="bar-chart mt-4">
                @foreach ($grafikServis as $data)
                    @php
                        $tinggi = $data['total'] > 0 ? max(($data['total'] / $nilaiTertinggiServis) * 100, 8) : 0;
                        $isHighlighted = $data['total'] == $nilaiTertinggiServis && $data['total'] > 0;
                    @endphp
                    <div class="bar-item">
                        <div class="bar-track">
                            <div class="bar-fill {{ $isHighlighted ? 'highlighted' : '' }}" style="height: {{ $tinggi }}%;">
                            </div>
                        </div>
                        <strong>{{ $data['bulan'] }}</strong>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
