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
    return (int) $user->id === (int) $id;
});

Broadcast::channel('helpTchat.{channelID}', function ($user, $channelID) {
   //it executes when laravel-echo-server do request http://localhost:8000/api/broadcasting/auth
   
    error_log($user);
    error_log($channelID);

    return true; // just allow all authenticated users
});
