<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PelangganController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('q');

        $pelanggans = User::where('role', 'user')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('email', 'like', "%{$search}%");
                });
            })
            ->withCount('bookings')
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('pelanggan.index', compact('pelanggans', 'search'));
    }
}
