@extends('layouts.app')

@section('title', 'Login - Bengkel Theo')

@section('content')
    <div class="card border-0 shadow-lg mx-auto" style="max-width: 460px; width: 100%;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <img class="auth-logo mx-auto mb-3" src="{{ asset('images/logo-bengkel-theo.png') }}" alt="Bengkel Theo">
                <h1 class="h3 fw-bold mb-1">Login </h1>
                <p class="text-muted mb-0">Masuk untuk melihat stok dan penjualan sparepart.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    Email atau password salah.
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="email">Email</label>
                    <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="password">Password</label>
                    <input class="form-control" id="password" type="password" name="password" required>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary w-100" type="submit">Login</button>
            </form>

            <p class="text-center text-muted mt-4 mb-0">
                Belum punya akun?
                <a class="fw-semibold" href="{{ route('register') }}">Daftar akun</a>
            </p>
        </div>
    </div>
@endsection
