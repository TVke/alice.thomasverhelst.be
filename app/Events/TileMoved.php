<?php

namespace App\Events;

use App\GameSession;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Collection;

class TileMoved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var \App\GameSession */
    protected $gameSession;

//    public $changes;
//
//    public $rotation;

    public $tiles;

    public $players;

    public function __construct(GameSession $gameSession, Collection $tiles, Collection $players)
    {
        $this->gameSession = $gameSession;

//        $this->changes = $changes;
//
//        $this->rotation = $rotation;

        $this->tiles = $tiles;

        $this->players = $players;

        $this->dontBroadcastToCurrentUser();
    }

    public function broadcastOn()
    {
        return new PresenceChannel("game.{$this->gameSession->session}");
    }
}
