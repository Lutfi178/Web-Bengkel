@extends('layouts.admin')

@section('title', 'Data Pelanggan - Bengkel Theo')

@section('content')
    <div class="admin-page-header">
        <h1 class="admin-page-title">Data Pelanggan</h1>
    </div>

    <div class="admin-table-container">
        <form class="admin-filter-bar" action="{{ route('pelanggan.index') }}" method="GET">
            <div class="form-group">
                <label for="q">Cari Email Pelanggan</label>
                <input id="q" type="search" name="q" value="{{ $search }}" placeholder="Masukkan email pelanggan...">
            </div>
            <div style="display: flex; gap: 8px;">
                <button class="admin-btn admin-btn-primary" type="submit">Cari</button>
                @if ($search)
                    <a class="admin-btn admin-btn-secondary" href="{{ route('pelanggan.index') }}">Reset</a>
                @endif
            </div>
        </form>

        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Email Pelanggan</th>
                        <th>Terdaftar Sejak</th>
                        <th>Total Booking Servis</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelanggans as $p)
                        <tr>
                            <td>
                                <strong>{{ $p->email }}</strong>
                            </td>
                            <td>{{ $p->created_at ? $p->created_at->format('d M Y H:i') : '-' }}</td>
                            <td>
                                <span class="admin-badge neutral" style="font-size:14px;">{{ $p->bookings_count }} kali</span>
                            </td>
                            <td>
                                <span class="admin-badge success">Aktif</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center; padding: 40px; color: #64748b;">
                                {{ $search ? 'Pelanggan tidak ditemukan.' : 'Belum ada data pelanggan.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 16px 20px; border-top: 1px solid #e2e8f0;">
            {{ $pelanggans->links() }}
        </div>
    </div>
@endsection
