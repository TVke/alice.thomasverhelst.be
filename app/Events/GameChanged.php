<?php

namespace App\Events;

use App\GameSession;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var \App\GameSession */
    protected $gameSession;

    public $tiles = [];

    public $players = [];

    public function __construct(GameSession $gameSession, $changedTile = [], $pawnPath = [])
    {
        $this->gameSession = $gameSession;

        $this->tiles = $changedTile;

        $this->players = $pawnPath;

        $this->dontBroadcastToCurrentUser();
    }

    public function broadcastOn()
    {
        return new PresenceChannel("game-{$this->gameSession->session}");
    }
}
