<?php

namespace App\Events;

use App\GameSession;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ObjectFound implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var \App\GameSession */
    protected $gameSession;

    /** @var \Illuminate\Support\Collection */
    public $object;

    public $pawn = '';

    public function __construct(GameSession $gameSession, Collection $object, string $pawn)
    {
        $this->gameSession = $gameSession;

        $this->object = $object;

        $this->pawn = $pawn;
    }

    public function broadcastOn()
    {
        return new PresenceChannel("game.{$this->gameSession->session}");
    }
}
