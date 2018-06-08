<?php

namespace App\Http\Controllers;

use App\Events\ObjectFound;
use App\Player;
use App\GameSession;
use App\Events\GameStarted;
use App\Events\PlayerChanged;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function index(?GameSession $session = null)
    {
//        if ($player->session && $player->session->started) {
//            return view('errors.started');
//        }

        if ($session) {
            session(['game_token' => $session->session]);
        }

        if (! $session) {
            Auth::logout();

            $gameToken = GameSession::newSession();

            $session = GameSession::where('session', $gameToken)->first();
        }

        $players = $session->players()->get();

        return view('game',compact('players'));
    }

    public function start(GameSession $session)
    {
        GameSession::where('session', $session->session)->update(['started' => true]);

        $session->players()->update(['active' => false]);

        $players = $session->players;

        $allObjects = $this->makeJson($session->objects);

        $cardsPerPlayer = $allObjects->count() / $players->count();

        $partedObjects = $allObjects->chunk($cardsPerPlayer);

        $randomPlayer = $players->random();

        Player::where('id', $randomPlayer->id)->update(['active' => true]);

        $players->each(function ($player) use ($partedObjects) {
            $objects = $partedObjects->pop()->flatten();

            $current_object = json_encode($objects->pop());

            Player::where('id', $player->id)->update(compact('objects', 'current_object'));
        });

        event(new GameStarted($session, $session->players));

        event(new PlayerChanged($session, $randomPlayer->pawn));
    }

    public function objectFound(Request $request){
        $session = GameSession::where('session', session('game_token'))->firstOrFail();

        $activePlayer = $session->players()->where('active', true)->where('pawn', $request->pawn)->firstOrFail();

        $foundObject = $session->players()->where('active', true)->where('current_object->name', $request->object)->firstOrFail();



        $newObject = '';

        $newObjectList = '';

        Player::where('id', $activePlayer->id)->update(['current_object'=> $newObject]);
        Player::where('id', $activePlayer->id)->update(['objects'=> $newObjectList]);

        event(new ObjectFound($session, $foundObject, $activePlayer->pawn));

    }

    protected function makeJson(string $json){
        return collect(json_decode($json));
}
}
