<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bengkel Theo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>
<body class="user-theme">
    @auth
        @php
            $userNotification = \App\Models\UserNotification::where('user_id', auth()->id())->whereNull('read_at')->latest()->first();
        @endphp

        <div class="user-layout">
            <header class="user-navbar">
                <a class="user-nav-brand" href="{{ route('sparepart.stok') }}">
                    <img src="{{ asset('images/logo-bengkel-theo.png') }}" alt="Bengkel Theo">
                    <span>
                        <strong>Bengkel Theo</strong>
                        <small>Motor Service & Parts</small>
                    </span>
                </a>

                <nav class="user-nav-menu">
                    <a class="user-nav-link {{ request()->routeIs('sparepart.stok') ? 'active' : '' }}" href="{{ route('sparepart.stok') }}">Katalog Sparepart</a>
                    <a class="user-nav-link {{ request()->routeIs('booking.create') ? 'active' : '' }}" href="{{ route('booking.create') }}">Booking Online</a>
                    <a class="user-nav-link {{ request()->routeIs('booking.saya') || request()->routeIs('booking.edit-online') ? 'active' : '' }}" href="{{ route('booking.saya') }}">Bookingan Saya</a>
                </nav>

                <div class="user-nav-actions">
                    <div class="user-profile-badge">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        {{ auth()->user()->name ?? auth()->user()->email }}
                    </div>
                    <button class="btn-logout" type="button" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        Logout
                    </button>
                </div>
            </header>

            <main class="user-main">
                <div class="container">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h2 class="page-title mb-0">@yield('page-heading', 'Bengkel Theo')</h2>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>

        <!-- Modals -->
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
    @else
        <main class="auth-page">
            <div class="container">
                @yield('content')
            </div>
        </main>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalElement = document.getElementById('confirmActionModal');
            
            if (modalElement) {
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
            }

            const userNotificationModal = document.getElementById('userNotificationModal');
            if (userNotificationModal) {
                new bootstrap.Modal(userNotificationModal).show();
            }
        });
    </script>
</body>
</html>
