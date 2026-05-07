<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\RedirectResponse;

class UserNotificationController extends Controller
{
    public function read(int $id): RedirectResponse
    {
        $notification = UserNotification::where('user_id', auth()->id())->findOrFail($id);

        $notification->update([
            'read_at' => now(),
        ]);

        return back();
    }
}
