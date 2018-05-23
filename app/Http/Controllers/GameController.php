<?php

namespace App\Http\Controllers;

use App\GameSession;
use Spatie\Valuestore\Valuestore;

class GameController extends Controller
{
    public function index(GameSession $session)
    {
        if ($session) {
            session(['game_token' => $session->session]);
        }

        if (! $session && ! session()->has('player')) {
            GameSession::newSession();
        }

        return view('game');
    }

    public function objects()
    {
        $objects = Valuestore::make(resource_path('data/objects.json'));

        return collect($objects->all());
    }
}
