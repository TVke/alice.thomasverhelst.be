<?php

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

Broadcast::channel('game.{session}', function ($player, $session) {
//    if ($session->players()->contains($player)) {
        return ['id' => 4, 'name' => 'thomas'];
//    }
});
