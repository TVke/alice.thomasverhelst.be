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

Broadcast::channel('game.{session}', function ($player, \App\GameSession $session) {
    if ($session->players()->where('id', $player->id)->exists()) {
        return [
            'id' => $player->id,
            'username' => $player->username,
            'pawn' => $player->pawn,
            'position' => $player->position,
        ];
    }
});
