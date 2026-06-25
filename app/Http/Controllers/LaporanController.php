<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RiwayatPenjualanSparepart;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->query('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Pendapatan Servis (Booking yang sudah dibayar)
        $servisSelesai = Booking::whereNotNull('dibayar_at')
            ->whereBetween('dibayar_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        $totalPendapatanServis = $servisSelesai->sum('harga_servis');
        $totalPendapatanSparepartBooking = $servisSelesai->sum('harga_sparepart');
        $totalBookingSelesai = $servisSelesai->count();

        // Pendapatan Penjualan Sparepart Langsung
        $penjualanLangsung = RiwayatPenjualanSparepart::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        $totalPenjualanLangsung = $penjualanLangsung->sum('total');
        $totalItemTerjual = $penjualanLangsung->sum('jumlah');

        // Total Keseluruhan
        $grandTotal = $totalPendapatanServis + $totalPendapatanSparepartBooking + $totalPenjualanLangsung;

        return view('laporan.index', compact(
            'startDate',
            'endDate',
            'totalPendapatanServis',
            'totalPendapatanSparepartBooking',
            'totalBookingSelesai',
            'totalPenjualanLangsung',
            'totalItemTerjual',
            'grandTotal'
        ));
    }
}
