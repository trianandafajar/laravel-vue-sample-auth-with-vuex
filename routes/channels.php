<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    // Pastikan pengguna yang sedang aktif memiliki ID yang sama
    if ((int) $user->id === (int) $id) {
        return true; // Pengguna dapat mendengarkan channel ini
    }

    // Jika ID tidak cocok, kembalikan false untuk menolak akses
    return false;
});
