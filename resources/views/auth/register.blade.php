@extends('layouts.user')

@section('title', 'Register - Bengkel Theo')

@section('content')
    <div class="card border-0 shadow-lg mx-auto" style="max-width: 520px; width: 100%;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <img class="auth-logo mx-auto mb-3" src="{{ asset('images/logo-bengkel-theo.png') }}" alt="Bengkel Theo">
                <h1 class="h3 fw-bold mb-1">Daftar Akun</h1>
                <p class="text-muted mb-0">Buat akun untuk mengakses stok sparepart.</p>
            </div>

            <form action="{{ route('register.proses') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="name">Nama</label>
                    <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="email">Email</label>
                    <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" required>
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

                <div class="mb-4">
                    <label class="form-label fw-semibold" for="password_confirmation">Konfirmasi Password</label>
                    <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" required>
                </div>

                <button class="btn btn-primary w-100" type="submit">Daftar</button>
            </form>

            <p class="text-center text-muted mt-4 mb-0">
                Sudah punya akun?
                <a class="fw-semibold" href="{{ route('login') }}">Login</a>
            </p>
        </div>
    </div>
@endsection
