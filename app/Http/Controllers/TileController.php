<?php

namespace App\Http\Controllers;

use App\Events\GameChanged;
use App\GameSession;
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        $session = GameSession::where('session', session('game_token'))->first();

        if (! $session) {
            return null;
        }

        event(new GameChanged($session, [$request->tile]));
    }

    public function destroy($id)
    {
        //
    }
}
