@extends('layouts.app')

@section('title', 'Dashboard - Bengkel Theo')
@section('page-heading', 'Dashboard')

@section('content')
    <section class="operation-card">
        <div>
            <span class="eyebrow">Jam Operasional</span>
            <h2>SENIN - SABTU </h2>
        </div>
        <strong>08.00 - 17.00</strong>
    </section>

    <div class="stats-grid">
        <div class="stat-card">
            <span>Total Penjualan</span>
            <strong>{{ number_format($totalSparepart) }}</strong>
        </div>
        <div class="stat-card">
            <span>Total Booking Servis</span>
            <strong>{{ number_format($totalBookingServis) }}</strong>
        </div>
        <div class="stat-card">
            <span>Pendapatan Sparepart</span>
            <strong>Rp {{ number_format($totalPendapatanSparepart, 0, ',', '.') }}</strong>
        </div>
        <div class="stat-card">
            <span>Transaksi Hari Ini</span>
            <strong>{{ number_format($totalTransaksiHariIni) }}</strong>
        </div>
        <div class="stat-card">
            <span>Pendapatan Bulan Ini</span>
            <strong>Rp {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}</strong>
        </div>
        <div class="stat-card">
            <span>Booking Belum Dibayar</span>
            <strong>{{ number_format($bookingBelumDibayar) }}</strong>
        </div>
    </div>

    <div class="dashboard-insight-grid">
        <section class="content-card">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Ringkasan</span>
                    <h2>Sparepart Paling Laris</h2>
                </div>
            </div>

            <div class="insight-list">
                @forelse ($sparepartPalingLaris as $sparepart)
                    <div class="insight-row">
                        <div>
                            <strong>{{ $sparepart->nama_sparepart }}</strong>
                            <span>{{ $sparepart->kode_sparepart }}</span>
                        </div>
                        <div class="insight-value">
                            <strong>{{ number_format($sparepart->jumlah_terjual) }} terjual</strong>
                            <span>Rp {{ number_format($sparepart->total_pendapatan, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="empty-mini">Belum ada transaksi sparepart.</div>
                @endforelse
            </div>
        </section>

        <section class="content-card">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Peringatan</span>
                    <h2>Stok Hampir Habis</h2>
                </div>
                <a class="btn btn-light btn-sm" href="{{ route('sparepart.index') }}">Kelola Stok</a>
            </div>

            <div class="insight-list">
                @forelse ($stokHampirHabis as $sparepart)
                    <div class="insight-row">
                        <div>
                            <strong>{{ $sparepart->nama_sparepart }}</strong>
                            <span>{{ $sparepart->kode_sparepart }}</span>
                        </div>
                        <div class="stock-warning">
                            {{ number_format($sparepart->stok) }} tersisa
                        </div>
                    </div>
                @empty
                    <div class="empty-mini">Tidak ada stok yang hampir habis.</div>
                @endforelse
            </div>
        </section>
    </div>

    <div class="chart-grid">
        <section class="content-card chart-card">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Grafik </span>
                    <h2>Penjualan Sparepart {{ $tahunGrafik }}</h2>
                </div>
                <strong>Rp {{ number_format($grafikPenjualan->sum('total'), 0, ',', '.') }}</strong>
            </div>

            <div class="bar-chart">
                @foreach ($grafikPenjualan as $data)
                    @php
                        $tinggi = $data['total'] > 0 ? max(($data['total'] / $nilaiTertinggiPenjualan) * 100, 8) : 0;
                    @endphp
                    <div class="bar-item">
                        <div class="bar-track">
                            <div class="bar-fill" style="height: {{ $tinggi }}%">
                                @if ($data['total'] > 0)
                                    <span>Rp {{ number_format($data['total'], 0, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                        <strong>{{ $data['bulan'] }}</strong>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="content-card chart-card">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Grafik </span>
                    <h2>Servis Per Bulan {{ $tahunGrafik }}</h2>
                </div>
                <strong>{{ number_format($grafikServis->sum('total')) }} Booking</strong>
            </div>

            <div class="bar-chart">
                @foreach ($grafikServis as $data)
                    @php
                        $tinggi = $data['total'] > 0 ? max(($data['total'] / $nilaiTertinggiServis) * 100, 8) : 0;
                    @endphp
                    <div class="bar-item">
                        <div class="bar-track">
                            <div class="bar-fill bar-fill-service" style="height: {{ $tinggi }}%">
                                @if ($data['total'] > 0)
                                    <span>{{ number_format($data['total']) }}</span>
                                @endif
                            </div>
                        </div>
                        <strong>{{ $data['bulan'] }}</strong>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

@endsection
