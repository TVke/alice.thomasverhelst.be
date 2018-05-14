<?php

namespace App\Http\Controllers;

use App\GameSession;

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
}
