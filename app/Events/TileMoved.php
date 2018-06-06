<?php

namespace App\Events;

use App\GameSession;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TileMoved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var \App\GameSession */
    protected $gameSession;

    public $changes;

    public $rotation;

    public function __construct(GameSession $gameSession, $changes, $rotation)
    {
        $this->gameSession = $gameSession;

        $this->changes = $changes;

        $this->rotation = $rotation;

        $this->dontBroadcastToCurrentUser();
    }

    public function broadcastOn()
    {
        return new PresenceChannel("game.{$this->gameSession->session}");
    }
}