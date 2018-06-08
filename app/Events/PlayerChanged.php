<?php

namespace App\Events;

use App\GameSession;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PlayerChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var \App\GameSession */
    protected $gameSession;

    public $pawn;

    public function __construct(GameSession $gameSession, $nextPlayerPawn)
    {
        $this->gameSession = $gameSession;

        $this->pawn = $nextPlayerPawn;
    }

    public function broadcastOn()
    {
        return new PresenceChannel("game.{$this->gameSession->session}");
    }
}
