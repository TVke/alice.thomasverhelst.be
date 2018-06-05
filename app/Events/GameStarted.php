<?php

namespace App\Events;

use App\GameSession;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var \App\GameSession */
    protected $gameSession;

    public $players;

    public function __construct(GameSession $gameSession, $players)
    {
        $this->gameSession = $gameSession;

        $this->players = $players;
    }

    public function broadcastOn()
    {
        return new PresenceChannel("game.{$this->gameSession->session}");

    }
}
