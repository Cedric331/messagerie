<?php

use App\Models\Channel;
use Illuminate\Support\Facades\Auth;
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



Broadcast::channel('chat.{channel}', function ($user, Channel $channel) {
    if(Auth::check() && $channel->user->contains($user->id)){
      return ['id' => $user->id, 'name' => $user->name, 'avatar' => $user->avatar];
    };
 });

