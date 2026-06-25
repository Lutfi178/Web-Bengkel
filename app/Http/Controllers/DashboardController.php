<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PenjualanSparepart;
use App\Models\RiwayatPenjualanSparepart;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $tahunIni = now()->year;
        $namaBulan = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        $penjualanPerBulan = RiwayatPenjualanSparepart::selectRaw("MONTH(created_at) as bulan, SUM(total) as total")
            ->whereRaw("YEAR(created_at) = ?", [$tahunIni])
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $servisPerBulan = Booking::selectRaw("MONTH(created_at) as bulan, COUNT(*) as total")
            ->whereRaw("YEAR(created_at) = ?", [$tahunIni])
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $grafikPenjualan = collect(range(1, 12))->map(function (int $bulan) use ($namaBulan, $penjualanPerBulan) {
            return [
                'bulan' => $namaBulan[$bulan],
                'total' => (int) ($penjualanPerBulan[$bulan] ?? 0),
            ];
        });

        $grafikServis = collect(range(1, 12))->map(function (int $bulan) use ($namaBulan, $servisPerBulan) {
            return [
                'bulan' => $namaBulan[$bulan],
                'total' => (int) ($servisPerBulan[$bulan] ?? 0),
            ];
        });

        $nilaiTertinggiPenjualan = max($grafikPenjualan->max('total'), 1);
        $nilaiTertinggiServis = max($grafikServis->max('total'), 1);
        $sparepartPalingLaris = RiwayatPenjualanSparepart::selectRaw('nama_sparepart, kode_sparepart, SUM(jumlah) as jumlah_terjual, SUM(total) as total_pendapatan')
            ->groupBy('nama_sparepart', 'kode_sparepart')
            ->orderByDesc('jumlah_terjual')
            ->orderByDesc('total_pendapatan')
            ->limit(5)
            ->get();
        $stokHampirHabis = PenjualanSparepart::query()
            ->whereBetween('stok', [1, 3])
            ->orderBy('stok')
            ->orderBy('nama_sparepart')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'totalSparepart' => RiwayatPenjualanSparepart::sum('jumlah'),
            'totalBookingServis' => Booking::count(),
            'totalPendapatanSparepart' => RiwayatPenjualanSparepart::sum('total'),
            'totalTransaksiHariIni' => RiwayatPenjualanSparepart::whereDate('created_at', today())->count(),
            'totalPendapatanBulanIni' => RiwayatPenjualanSparepart::whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('total'),
            'bookingBelumDibayar' => Booking::whereNull('dibayar_at')->count(),
            'sparepartPalingLaris' => $sparepartPalingLaris,
            'stokHampirHabis' => $stokHampirHabis,
            'tahunGrafik' => $tahunIni,
            'grafikPenjualan' => $grafikPenjualan,
            'grafikServis' => $grafikServis,
            'nilaiTertinggiPenjualan' => $nilaiTertinggiPenjualan,
            'nilaiTertinggiServis' => $nilaiTertinggiServis,
        ]);
    }
}
