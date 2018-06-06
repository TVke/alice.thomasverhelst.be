<?php

namespace App\Http\Controllers;

use App\GameSession;
use App\Events\TileMoved;
use App\Events\RotateTile;
use Illuminate\Http\Request;

class TileController extends Controller
{
    public function index()
    {
        if (! session()->has('game_token')) {
            GameSession::newSession();
        }

        $session = GameSession::where('session', session('game_token'))->first();

        return $session->tiles;
    }

    public function update(Request $request)
    {
        $session = GameSession::where('session', session('game_token'))->first();

        if (! $session) {
            return null;
        }

//        return [
//            ['changes' => $request->changes],
//            ['rotation' => $request->rotation]
//        ];

        event(new TileMoved($session, $request->changes, $request->rotation));
    }

    public function rotate()
    {
        $session = GameSession::where('session',session('game_token'))->first();

        event(new RotateTile($session));
    }
}
