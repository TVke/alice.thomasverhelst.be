<?php

namespace App\Http\Controllers;

use App\Events\GameChanged;
use App\Events\GameStarted;
use App\Events\PlayerChanged;
use App\Player;
use App\GameSession;
use Illuminate\Http\Request;
use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function index(Request $request, ?GameSession $session = null)
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

        event(new PlayerChanged($session, $randomPlayer));
    }

    public function objects(Player $player)
    {
        $objects = Valuestore::make(resource_path('data/objects.json'));

        return $objects->all();
    }

    protected function makeJson(string $json){
        return collect(json_decode($json));
}
}
