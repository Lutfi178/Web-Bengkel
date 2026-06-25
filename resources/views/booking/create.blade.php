@extends('layouts.user')

@section('title', 'Booking Online - Bengkel Theo')
@section('page-heading', 'Booking Online')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <span class="eyebrow">Form Booking</span>
            <h1 class="h4 fw-bold mb-0">{{ $formTitle }}</h1>
        </div>

        <div class="card-body">
            <form action="{{ $formAction }}" method="POST">
                @csrf
                @if ($formMethod !== 'POST')
                    @method($formMethod)
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="tanggal_booking">Tanggal Booking</label>
                        <input class="form-control" id="tanggal_booking" type="date" name="tanggal_booking" value="{{ old('tanggal_booking', $booking?->tanggal_booking?->format('Y-m-d')) }}" required>
                        @error('tanggal_booking')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Nomor Antrian</label>
                        <div class="queue-grid" id="queueGrid" data-filled-by-date='@json($nomorAntrianTerisiByTanggal)'>
                            @for ($nomor = 1; $nomor <= 10; $nomor++)
                                @php
                                    $terisi = in_array($nomor, $nomorAntrianTerisi, true);
                                    $nomorTerpilih = (int) old('nomor_antrian', $booking->nomor_antrian ?? 0) === $nomor;
                                @endphp
                                <label class="queue-option {{ $terisi ? 'is-taken' : '' }} {{ $nomorTerpilih ? 'is-selected' : '' }}" data-queue-option data-number="{{ $nomor }}">
                                    <input type="radio" name="nomor_antrian" value="{{ $nomor }}" @checked($nomorTerpilih) @disabled($terisi) required>
                                    <strong>{{ $nomor }}</strong>
                                    <span>{{ $nomorTerpilih ? 'Dipilih' : ($terisi ? 'Terisi' : 'Tersedia') }}</span>
                                </label>
                            @endfor
                        </div>
                        <small class="help-text">Nomor antrian berlaku per tanggal booking. Tanggal berbeda akan memulai antrian dari awal.</small>
                        @error('nomor_antrian')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="nama">Nama</label>
                        <input class="form-control" id="nama" type="text" name="nama" value="{{ old('nama', $booking->nama ?? auth()->user()->name) }}" required>
                        @error('nama')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="no_hp_wa">No HP/WA</label>
                        <input class="form-control" id="no_hp_wa" type="text" name="no_hp_wa" value="{{ old('no_hp_wa', $booking->no_hp_wa ?? '') }}" required>
                        @error('no_hp_wa')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold" for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $booking->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="plat_motor">Plat Motor</label>
                        <input class="form-control" id="plat_motor" type="text" name="plat_motor" value="{{ old('plat_motor', $booking->plat_motor ?? '') }}" required>
                        @error('plat_motor')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="jenis_motor">Jenis Motor</label>
                        <select class="form-control" id="jenis_motor" name="jenis_motor" required>
                            <option value="">Pilih jenis motor</option>
                            @foreach (['KAWASAKI', 'HONDA', 'YAMAHA', 'SUZUKI'] as $jenisMotor)
                                <option value="{{ $jenisMotor }}" @selected(old('jenis_motor', $booking->jenis_motor ?? '') === $jenisMotor)>{{ $jenisMotor }}</option>
                            @endforeach
                        </select>
                        @error('jenis_motor')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="paket_servis">Paket Servis</label>
                        <select class="form-control" id="paket_servis" name="paket_servis">
                            <option value="">Tidak memilih paket</option>
                            @foreach ($paketServis as $namaPaket => $hargaPaket)
                                <option value="{{ $namaPaket }}" @selected(old('paket_servis', $booking->paket_servis ?? '') === $namaPaket)>
                                    {{ $namaPaket }} (Rp {{ number_format($hargaPaket, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                        @error('paket_servis')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold" for="keluhan_motor">Keluhan Motor/Kerusakan</label>
                        <textarea class="form-control" id="keluhan_motor" name="keluhan_motor" rows="4">{{ old('keluhan_motor', $booking->keluhan_motor ?? '') }}</textarea>
                        @error('keluhan_motor')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button class="btn btn-primary" type="submit">{{ $submitLabel }}</button>
                    @if ($booking)
                        <a class="btn btn-secondary" href="{{ $cancelRoute ?? route('booking.create') }}">Batal Edit</a>
                    @endif
                    <a class="btn btn-light" href="{{ route('sparepart.stok') }}">Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dateInput = document.getElementById('tanggal_booking');
            const queueGrid = document.getElementById('queueGrid');

            if (!dateInput || !queueGrid) {
                return;
            }

            const filledByDate = JSON.parse(queueGrid.dataset.filledByDate || '{}');
            const updateQueue = function () {
                const filledNumbers = filledByDate[dateInput.value] || [];

                queueGrid.querySelectorAll('[data-queue-option]').forEach(function (option) {
                    const input = option.querySelector('input');
                    const label = option.querySelector('span');
                    const number = Number(option.dataset.number);
                    const isFilled = filledNumbers.includes(number);

                    option.classList.toggle('is-taken', isFilled);
                    input.disabled = isFilled;

                    if (isFilled && input.checked) {
                        input.checked = false;
                    }

                    option.classList.toggle('is-selected', input.checked);
                    label.textContent = input.checked ? 'Dipilih' : (isFilled ? 'Terisi' : 'Tersedia');
                });
            };

            queueGrid.querySelectorAll('input[name="nomor_antrian"]').forEach(function (input) {
                input.addEventListener('change', updateQueue);
            });

            dateInput.addEventListener('change', updateQueue);
            updateQueue();
        });
    </script>
@endsection
