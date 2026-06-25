@extends('layouts.admin')

@section('title', 'Tambah Penjualan Sparepart - Bengkel Theo')
@section('page-heading', 'Tambah Penjualan Sparepart')

@section('content')
    <h1 class="page-title">Tambah Produk Sparepart</h1>

    <div class="content-card">
        <form action="{{ route('sparepart.store') }}" method="POST" enctype="multipart/form-data">
            @include('sparepart.form')
        </form>
    </div>
@endsection
