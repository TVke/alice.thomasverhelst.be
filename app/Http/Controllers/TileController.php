<?php

namespace App\Http\Controllers;

use App\Events\GameChanged;
use App\Events\RotateTile;
use App\Events\TileMoved;
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

        event(new TileMoved($session, $request->tile));
    }

    public function destroy($id)
    {
        //
    }

    public function rotate()
    {
        $session = GameSession::where('session',session('game_token'))->first();

        event(new RotateTile($session));
    }
}
