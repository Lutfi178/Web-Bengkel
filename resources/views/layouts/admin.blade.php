<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bengkel Theo - Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-theme">
    @auth
        @php
            $userNotification = auth()->user()->role === 'user'
                ? \App\Models\UserNotification::where('user_id', auth()->id())->whereNull('read_at')->latest()->first()
                : null;
        @endphp

        <div class="app-shell">
            <aside class="sidebar">
                <a class="brand" href="{{ auth()->user()->role === 'admin' ? route('dashboard') : route('sparepart.stok') }}">
                    <img class="brand-logo" src="{{ asset('images/logo-bengkel-theo.png') }}" alt="Bengkel Theo">
                    <span>
                        <strong>Bengkel Theo</strong>
                        <small>Motor Service</small>
                        <small class="brand-address">Jl. Moh. Yamin No.67, Jayengan, Kec. Serengan, Kota Surakarta, Jawa Tengah 57153</small>
                    </span>
                </a>

                <nav class="side-menu">
                    @if (auth()->user()->role === 'admin')
                        <a class="side-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">DASHBOARD</a>
                        <a class="side-link {{ request()->routeIs('booking.index') ? 'active' : '' }}" href="{{ route('booking.index') }}">Booking User</a>
                        <a class="side-link {{ request()->routeIs('pelanggan.index') ? 'active' : '' }}" href="{{ route('pelanggan.index') }}">Data Pelanggan</a>
                        <a class="side-link {{ request()->routeIs('laporan.index') ? 'active' : '' }}" href="{{ route('laporan.index') }}">Laporan Keuangan</a>
                    @else
                        <a class="side-link {{ request()->routeIs('booking.create') ? 'active' : '' }}" href="{{ route('booking.create') }}">Booking Online</a>
                        <a class="side-link {{ request()->routeIs('booking.saya') || request()->routeIs('booking.edit-online') ? 'active' : '' }}" href="{{ route('booking.saya') }}">Bookingan Saya</a>
                    @endif
                </nav>

                <button class="side-link logout-link" type="button" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button>
            </aside>

            <div class="app-content">
                <header class="topbar">
                    <div class="topbar-title">
                        <button class="sidebar-toggle" type="button" id="sidebarToggle" aria-label="Tampilkan atau sembunyikan menu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <div>
                            <span class="topbar-kicker">Bengkel Theo</span>
                            <h2>@yield('page-heading', 'Bengkel Theo')</h2>
                        </div>
                    </div>
                    <div class="topbar-actions">
                        <span class="role-chip">{{ auth()->user()->role === 'admin' ? 'Admin' : 'User' }}</span>
                        <div class="user-chip">{{ auth()->user()->email }}</div>
                    </div>
                </header>
    @endauth

    <main class="@auth main @else auth-page @endauth">
        <div class="@auth container @endauth">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    @auth
            </div>
        </div>

        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="logoutModalLabel">Konfirmasi Logout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin logout dari sistem?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tidak</button>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-danger" type="submit">Ya, Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirmActionModal" tabindex="-1" aria-labelledby="confirmActionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="confirmActionModalLabel">Konfirmasi Aksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body" id="confirmActionMessage">
                        Apakah Anda yakin?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tidak</button>
                        <form id="confirmActionForm" method="POST">
                            @csrf
                            <input id="confirmActionMethod" type="hidden" name="_method" value="">
                            <button class="btn btn-primary" type="submit" id="confirmActionButton">Ya</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if ($userNotification)
            <div class="modal fade" id="userNotificationModal" tabindex="-1" aria-labelledby="userNotificationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="userNotificationModalLabel">{{ $userNotification->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            {{ $userNotification->message }}
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('notifikasi.read', $userNotification->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-primary" type="submit">Saya Mengerti</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalElement = document.getElementById('confirmActionModal');
            const sidebarToggle = document.getElementById('sidebarToggle');

            if (localStorage.getItem('sidebar-collapsed') === 'true') {
                document.body.classList.add('sidebar-collapsed');
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function () {
                    document.body.classList.toggle('sidebar-collapsed');
                    localStorage.setItem('sidebar-collapsed', document.body.classList.contains('sidebar-collapsed') ? 'true' : 'false');
                });
            }

            if (!modalElement) {
                return;
            }

            const modal = new bootstrap.Modal(modalElement);
            const form = document.getElementById('confirmActionForm');
            const methodInput = document.getElementById('confirmActionMethod');
            const message = document.getElementById('confirmActionMessage');
            const submitButton = document.getElementById('confirmActionButton');

            document.querySelectorAll('[data-confirm-action]').forEach(function (button) {
                button.addEventListener('click', function () {
                    form.action = button.dataset.confirmAction;
                    methodInput.value = button.dataset.confirmMethod || '';
                    message.textContent = button.dataset.confirmMessage || 'Apakah Anda yakin?';
                    submitButton.textContent = button.dataset.confirmButton || 'Ya';
                    submitButton.className = button.dataset.confirmButtonClass || 'btn btn-primary';
                    modal.show();
                });
            });

            const userNotificationModal = document.getElementById('userNotificationModal');
            if (userNotificationModal) {
                new bootstrap.Modal(userNotificationModal).show();
            }
        });
    </script>
</body>
</html>
