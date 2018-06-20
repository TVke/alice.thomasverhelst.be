<?php

namespace App\Events;

use App\GameSession;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var \App\GameSession */
    protected $gameSession;

    public $players;

    public $activePlayer;

    public function __construct(GameSession $gameSession, $players, $activePlayer)
    {
        $this->gameSession = $gameSession;

        $this->players = $players;

        $this->activePlayer = $activePlayer;
    }

    public function broadcastOn()
    {
        return new PresenceChannel("game.{$this->gameSession->session}");
    }
}
