@extends('layouts.app')

@section('title', 'Nota Pembelian Sparepart - Bengkel Theo')
@section('page-heading', 'Nota Pembelian')

@section('content')
    <div class="nota-toolbar">
        <a class="btn btn-light" href="{{ route('sparepart.index') }}">Kembali</a>
        <button class="btn btn-primary" type="button" onclick="window.print()">Print Nota</button>
    </div>

    <section class="nota-card">
        <div class="nota-header">
            <div>
                <h1>Bengkel Theo</h1>
                <p>Nota Pembelian Sparepart</p>
            </div>
            <div class="nota-number">
                <span>No Nota</span>
                <strong>{{ $nomorNota }}</strong>
            </div>
        </div>

        <div class="nota-info">
            <div>
                <span>Tanggal</span>
                <strong>{{ $sparepart->created_at->format('d/m/Y H:i') }}</strong>
            </div>
            <div>
                <span>Admin</span>
                <strong>{{ auth()->user()->name }}</strong>
            </div>
        </div>

        <table class="nota-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kode</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $sparepart->nama_sparepart }}</td>
                    <td>{{ $sparepart->kode_sparepart }}</td>
                    <td>Rp {{ number_format($sparepart->harga, 0, ',', '.') }}</td>
                    <td>{{ $jumlah }}</td>
                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="nota-total">
            <span>Total Bayar</span>
            <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
        </div>

        <div class="nota-footer">
            <p>Terima kasih sudah berbelanja di Bengkel Theo.</p>
        </div>
    </section>
@endsection
