<?php

namespace App\Http\Controllers;

use App\Events\PawnMoved;
use App\Events\PlayerChanged;
use App\GameSession;
use App\Player;
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

        $session->players()->where('active', true)->where('pawn', $pawn)->firstOrFail();

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
        $session = GameSession::where('session', session('game_token'))->firstOrFail();

        $players = $session->players()->orderBy('pawn')->get();

        $currentPlayer = $session->players()->where('active', true)->first();

        $pawns = $players->map(function (Player $player) use ($currentPlayer) {
            return $player->pawn;
        });

        $nextPlayerPawn = '';

        for ($i = 0, $ilen = count($pawns); $i < $ilen; ++$i) {
            if ($pawns[$i] === $currentPlayer->pawn && $i+1 < $ilen) {
                $nextPlayerPawn = $pawns[$i+1];
            }

            if ($pawns[$i] === $currentPlayer->pawn && $i + 1 === $ilen) {
                $nextPlayerPawn = $pawns[0];
            }
        }
        $session->players()->where('active', true)->update(['active' => false]);

        $session->players()->where('pawn', $nextPlayerPawn)->update(['active' => true]);

        event(new PlayerChanged($session, $nextPlayerPawn));
    }
}
