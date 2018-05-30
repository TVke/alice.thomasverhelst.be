<?php

namespace App\Http\Controllers;

use App\GameSession;
use App\Player;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;

class GameController extends Controller
{
    public function index(Request $request, GameSession $session)
    {
        if ($session) {
            session(['game_token' => $session->session]);
        }

        if (! $session && ! session()->has('player')) {
            GameSession::newSession();
        }

        if(! session()->has('player')){
            return view('game');
        }

        $sessionInfo = explode('_',session()->get('player'));

        $player = Player::where('id', $sessionInfo[0])->where('pawn', $sessionInfo[1])->firstOrFail();

//        return $player;
        if ($player->session && $player->session->session !== session()->get('game_token')){
            $request->session()->forget('player');
        }

        if ($player->session && $player->session->started) {
            return view('errors.started');
        }

        return view('game',compact('player'));
    }

    public function start(GameSession $session)
    {
        GameSession::where('session', $session)->update(['started' => true]);

        $playersCount = $session->players()->count();

        $allObjects = $session->objects;

        return $session->players()->get();

//        return player first card
    }

    public function objects(Player $player)
    {
        $objects = Valuestore::make(resource_path('data/objects.json'));

        return $objects->all();
    }
}
