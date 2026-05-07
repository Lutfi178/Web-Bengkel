@extends('layouts.app')

@section('title', 'Edit Penjualan Sparepart - Bengkel Theo')
@section('page-heading', 'Edit Penjualan Sparepart')

@section('content')
    <h1 class="page-title">Edit Produk Sparepart</h1>

    <div class="content-card">
        <form action="{{ route('sparepart.update', $sparepart->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('sparepart.form')
        </form>
    </div>
@endsection
