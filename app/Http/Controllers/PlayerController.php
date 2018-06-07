<?php

namespace App\Http\Controllers;

use App\Events\PawnMoved;
use App\Player;
use App\GameSession;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        $session = GameSession::where('session', session('game_token'))->first();

        if (! $session) {
            return [];
        }

        return $session->players()->get();
    }

    public function update(Request $request, $pawn)
    {
        $session = GameSession::where('session', session('game_token'))->firstOrFail();

        $activePawn = $session->players()->where('active', true)->first()->pawn;

        if ($pawn !== $activePawn) {
            abort(404);
        }

        $path = $request->path;

        event(new PawnMoved($session, $path));

        unset($path[0]['step']);

        $position = json_encode($path[0]);

        $session->players()->where('pawn', $pawn)->update(compact('position'));
    }

    public function destroy($pawn)
    {
        $session = GameSession::where('session', session('game_token'))->firstOrFail();

        $player = Player::where('pawn', $pawn)->where('game_session_id', $session->id)->firstOrFail();

        $player->session()->dissociate();

        $player->save();

        Player::where('id', $player->id)->update([
            'pawn' => null,
        ]);

        Player::where('id', $player->id)->whereNull('score')->delete();
    }

    public function next()
    {

    }
}
