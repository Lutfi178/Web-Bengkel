<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\UserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BookingController extends Controller
{
    private array $paketServis = [
        'Paket Basic Service' => 75000,
        'Paket Standard Service' => 120000,
        'Paket Premium Service' => 250000,
        'Paket Lengkap + Cuci' => 180000,
    ];

    public function index(Request $request): View
    {
        $filters = $request->only(['tanggal_booking', 'q', 'nomor_antrian']);

        $bookings = Booking::with('user')
            ->whereHas('user', fn ($query) => $query->where('role', 'user'))
            ->whereNull('dibayar_at')
            ->when($filters['tanggal_booking'] ?? null, fn ($query, string $tanggal) => $query->whereDate('tanggal_booking', $tanggal))
            ->when($filters['q'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('plat_motor', 'like', '%' . $search . '%');
                });
            })
            ->when($filters['nomor_antrian'] ?? null, fn ($query, string $nomorAntrian) => $query->where('nomor_antrian', $nomorAntrian))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('booking.index', compact('bookings', 'filters'));
    }

    public function histori(Request $request): View
    {
        $filters = $request->only(['tanggal_booking', 'tanggal_bayar', 'q', 'nomor_antrian']);

        $bookings = Booking::with('user')
            ->whereHas('user', fn ($query) => $query->where('role', 'user'))
            ->whereNotNull('dibayar_at')
            ->when($filters['tanggal_booking'] ?? null, fn ($query, string $tanggal) => $query->whereDate('tanggal_booking', $tanggal))
            ->when($filters['tanggal_bayar'] ?? null, fn ($query, string $tanggal) => $query->whereDate('dibayar_at', $tanggal))
            ->when($filters['q'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('plat_motor', 'like', '%' . $search . '%')
                        ->orWhere('jenis_motor', 'like', '%' . $search . '%');
                });
            })
            ->when($filters['nomor_antrian'] ?? null, fn ($query, string $nomorAntrian) => $query->where('nomor_antrian', $nomorAntrian))
            ->latest('dibayar_at')
            ->paginate(10)
            ->withQueryString();

        return view('booking.histori', compact('bookings', 'filters'));
    }

    public function create(): View
    {
        return view('booking.create', [
            'booking' => null,
            'formAction' => route('booking.store'),
            'formMethod' => 'POST',
            'formTitle' => 'Booking Servis Motor',
            'submitLabel' => 'Kirim Booking',
            'paketServis' => $this->paketServis,
            'nomorAntrianTerisi' => $this->nomorAntrianTerisi(old('tanggal_booking')),
            'nomorAntrianTerisiByTanggal' => $this->nomorAntrianTerisiByTanggal(),
        ]);
    }

    public function bookingSaya(Request $request): View
    {
        $filters = $request->only(['tanggal_booking', 'q']);

        $bookings = Booking::where('user_id', $request->user()->id)
            ->when($filters['tanggal_booking'] ?? null, fn ($query, string $tanggal) => $query->whereDate('tanggal_booking', $tanggal))
            ->when($filters['q'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('plat_motor', 'like', '%' . $search . '%')
                        ->orWhere('jenis_motor', 'like', '%' . $search . '%')
                        ->orWhere('paket_servis', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('booking.saya', compact('bookings', 'filters'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->bookingRules(null, $request->input('tanggal_booking')));

        $validated['harga_paket_servis'] = $validated['paket_servis']
            ? $this->paketServis[$validated['paket_servis']]
            : 0;
        $validated['user_id'] = $request->user()->id;

        $booking = Booking::create($validated);

        return redirect()
            ->route('booking.edit-online', $booking->id)
            ->with('success', 'Booking online berhasil dikirim. Jika ada kesalahan input, silakan ubah data lalu simpan perubahan.');
    }

    public function editOnline(int $id): View|RedirectResponse
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        if ($booking->dibayar_at) {
            return redirect()->route('booking.create')->with('error', 'Booking yang sudah dibayar tidak dapat diedit.');
        }

        return view('booking.create', [
            'booking' => $booking,
            'formAction' => route('booking.update-online', $booking->id),
            'formMethod' => 'PUT',
            'formTitle' => 'Edit Booking Servis Motor',
            'submitLabel' => 'Simpan Perubahan',
            'cancelRoute' => route('booking.saya'),
            'paketServis' => $this->paketServis,
            'nomorAntrianTerisi' => $this->nomorAntrianTerisi(old('tanggal_booking', $booking->tanggal_booking?->format('Y-m-d')), $booking->id),
            'nomorAntrianTerisiByTanggal' => $this->nomorAntrianTerisiByTanggal($booking->id),
        ]);
    }

    public function updateOnline(Request $request, int $id): RedirectResponse
    {
        $booking = Booking::where('user_id', $request->user()->id)->findOrFail($id);

        if ($booking->dibayar_at) {
            return redirect()->route('booking.create')->with('error', 'Booking yang sudah dibayar tidak dapat diedit.');
        }

        $validated = $request->validate($this->bookingRules($booking->id, $request->input('tanggal_booking')));
        $validated['harga_paket_servis'] = $validated['paket_servis']
            ? $this->paketServis[$validated['paket_servis']]
            : 0;

        $booking->update($validated);

        return redirect()->route('booking.saya')->with('success', 'Booking online berhasil diperbarui.');
    }

    public function destroyOnline(Request $request, int $id): RedirectResponse
    {
        $booking = Booking::where('user_id', $request->user()->id)->findOrFail($id);

        if ($booking->dibayar_at) {
            return redirect()->route('booking.saya')->with('error', 'Booking yang sudah dibayar tidak dapat dihapus.');
        }

        $booking->delete();

        return redirect()->route('booking.saya')->with('success', 'Booking online berhasil dihapus.');
    }

    public function notaOnline(Request $request, int $id): View|RedirectResponse
    {
        $booking = Booking::where('user_id', $request->user()->id)->findOrFail($id);

        if (! $booking->dibayar_at) {
            return redirect()->route('booking.saya')->with('error', 'Nota tersedia setelah booking dibayar.');
        }

        return view('booking.nota', [
            'booking' => $booking,
            'nomorNota' => 'BK-' . now()->format('Ymd') . '-' . str_pad((string) $booking->id, 4, '0', STR_PAD_LEFT),
        ]);
    }

    public function bayar(int $id): View
    {
        $booking = $this->bookingUserQuery()->findOrFail($id);

        return view('booking.bayar', compact('booking'));
    }

    public function prosesBayar(Request $request, int $id): RedirectResponse
    {
        $booking = $this->bookingUserQuery()->findOrFail($id);

        $validated = $request->validate([
            'harga_servis' => ['required', 'numeric', 'min:0'],
            'harga_sparepart' => ['required', 'numeric', 'min:0'],
        ]);

        $hargaServis = (int) $validated['harga_servis'];
        $hargaSparepart = (int) $validated['harga_sparepart'];

        $booking->update([
            'harga_servis' => $hargaServis,
            'harga_sparepart' => $hargaSparepart,
            'total_bayar' => $hargaServis + $hargaSparepart + (int) $booking->harga_paket_servis,
            'dibayar_at' => now(),
        ]);

        return redirect()->route('booking.nota', $booking->id)->with('success', 'Pembayaran booking berhasil disimpan.');
    }

    public function nota(int $id): View
    {
        $booking = $this->bookingUserQuery()->findOrFail($id);

        return view('booking.nota', [
            'booking' => $booking,
            'nomorNota' => 'BK-' . now()->format('Ymd') . '-' . str_pad((string) $booking->id, 4, '0', STR_PAD_LEFT),
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        $booking = $this->bookingUserQuery()->findOrFail($id);

        UserNotification::create([
            'user_id' => $booking->user_id,
            'title' => 'Booking Dibatalkan',
            'message' => 'Booking servis nomor antrian ' . ($booking->nomor_antrian ?? '-') . ' untuk motor ' . $booking->jenis_motor . ' dengan plat ' . $booking->plat_motor . ' pada tanggal ' . ($booking->tanggal_booking?->format('d/m/Y') ?? '-') . ' telah dibatalkan oleh admin.',
        ]);

        $booking->delete();

        return redirect()->route('booking.index')->with('success', 'Booking user berhasil dibatalkan.');
    }

    private function bookingUserQuery()
    {
        return Booking::with('user')->whereHas('user', fn ($query) => $query->where('role', 'user'));
    }

    private function bookingRules(?int $id = null, ?string $tanggalBooking = null): array
    {
        return [
            'nomor_antrian' => [
                'required',
                'integer',
                'min:1',
                'max:10',
                Rule::unique('bookings', 'nomor_antrian')
                    ->where(fn ($query) => $query->whereDate('tanggal_booking', $tanggalBooking))
                    ->ignore($id),
            ],
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_hp_wa' => ['required', 'string', 'max:30'],
            'tanggal_booking' => ['required', 'date'],
            'plat_motor' => ['required', 'string', 'max:30'],
            'jenis_motor' => ['required', 'string', 'max:255'],
            'paket_servis' => ['nullable', 'string', 'in:' . implode(',', array_keys($this->paketServis))],
            'keluhan_motor' => ['nullable', 'string'],
        ];
    }

    private function nomorAntrianTerisi(?string $tanggalBooking = null, ?int $excludeBookingId = null): array
    {
        return Booking::whereNotNull('nomor_antrian')
            ->when($tanggalBooking, fn ($query) => $query->whereDate('tanggal_booking', $tanggalBooking))
            ->when(! $tanggalBooking, fn ($query) => $query->whereRaw('1 = 0'))
            ->when($excludeBookingId, fn ($query) => $query->whereKeyNot($excludeBookingId))
            ->pluck('nomor_antrian')
            ->map(fn ($nomor) => (int) $nomor)
            ->all();
    }

    private function nomorAntrianTerisiByTanggal(?int $excludeBookingId = null): array
    {
        return Booking::whereNotNull('nomor_antrian')
            ->whereNotNull('tanggal_booking')
            ->when($excludeBookingId, fn ($query) => $query->whereKeyNot($excludeBookingId))
            ->get(['tanggal_booking', 'nomor_antrian'])
            ->groupBy(fn (Booking $booking) => $booking->tanggal_booking->format('Y-m-d'))
            ->map(fn ($bookings) => $bookings->pluck('nomor_antrian')->map(fn ($nomor) => (int) $nomor)->values())
            ->all();
    }

}
