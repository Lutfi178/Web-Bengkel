@extends('layouts.admin')

@section('title', 'Laporan Keuangan - Bengkel Theo')

@section('content')
    <div class="admin-page-header">
        <h1 class="admin-page-title">Laporan Keuangan</h1>
    </div>

    <div class="admin-table-container" style="padding: 24px;">
        <form action="{{ route('laporan.index') }}" method="GET" style="display: flex; gap: 16px; align-items: flex-end; margin-bottom: 24px;">
            <div class="form-group" style="flex:1;">
                <label for="start_date" style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Dari Tanggal</label>
                <input id="start_date" type="date" name="start_date" value="{{ $startDate }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px;">
            </div>
            <div class="form-group" style="flex:1;">
                <label for="end_date" style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Sampai Tanggal</label>
                <input id="end_date" type="date" name="end_date" value="{{ $endDate }}" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px;">
            </div>
            <div>
                <button class="admin-btn admin-btn-primary" type="submit">Tampilkan</button>
            </div>
        </form>

        <div class="admin-grid-2" style="margin-bottom: 24px;">
            <div class="admin-metric-card" style="border-top: 4px solid #3b82f6;">
                <span class="metric-label">Pendapatan Servis & Ganti Sparepart</span>
                <p class="metric-value" style="font-size: 24px;">Rp {{ number_format($totalPendapatanServis + $totalPendapatanSparepartBooking, 0, ',', '.') }}</p>
                <div style="font-size:13px; color:#64748b; margin-top:8px;">Dari {{ $totalBookingSelesai }} transaksi booking</div>
            </div>
            
            <div class="admin-metric-card" style="border-top: 4px solid #10b981;">
                <span class="metric-label">Penjualan Sparepart Langsung</span>
                <p class="metric-value" style="font-size: 24px;">Rp {{ number_format($totalPenjualanLangsung, 0, ',', '.') }}</p>
                <div style="font-size:13px; color:#64748b; margin-top:8px;">Dari {{ $totalItemTerjual }} item terjual</div>
            </div>
        </div>

        <div class="admin-metric-card" style="background: #0f172a; color: white; border-top: none;">
            <span class="metric-label" style="color: #94a3b8;">Total Keseluruhan Pendapatan</span>
            <p class="metric-value" style="font-size: 36px; color: #fff;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
        </div>
    </div>
@endsection
