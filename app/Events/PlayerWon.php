<?php

namespace App\Events;

use App\GameSession;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PlayerWon implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var \App\GameSession */
    protected $gameSession;

    public $username;

    public function __construct(GameSession $gameSession, $username)
    {
        $this->gameSession = $gameSession;

        $this->username = $username;
    }

    public function broadcastOn()
    {
        return new PresenceChannel("game.{$this->gameSession->session}");
    }
}
