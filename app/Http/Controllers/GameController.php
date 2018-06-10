<?php

namespace App\Http\Controllers;

use App\Events\PlayerWon;
use App\Player;
use App\GameSession;
use App\Events\GameStarted;
use App\Events\ObjectFound;
use Illuminate\Http\Request;
use App\Events\PlayerChanged;
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

        return view('game', compact('players'));
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

    public function firstObject(Request $request)
    {
        $session = GameSession::where('session', session('game_token'))->firstOrFail();

        return $activePlayer = Player::where('game_session_id', $session->id)
            ->where('pawn', $request->pawn)
            ->firstOrFail()
            ->current_object;
    }

    public function objectFound(Request $request)
    {
        $session = GameSession::where('session', session('game_token'))->firstOrFail();

        $activePlayer = Player::where('game_session_id', $session->id)
            ->where('active', true)
            ->where('pawn', $request->pawn)
            ->firstOrFail();

        $foundObject = Player::where('game_session_id', $session->id)
            ->where('active', true)
            ->where('current_object->name', $request->object)
            ->firstOrFail()
            ->current_object;

        event(new ObjectFound($session, $this->makeJson($foundObject), $activePlayer->pawn));

        $objects = $this->makeJson($activePlayer->objects);

        if ($objects->isEmpty()){
            event(new PlayerWon($session, $activePlayer->pawn));

            $this->calculateScores($session, $activePlayer);

            return null;
        }

        $newObject = $objects->pop();

        Player::where('id', $activePlayer->id)->update(['current_object' => json_encode($newObject)]);

        Player::where('id', $activePlayer->id)->update(['objects' => json_encode($objects)]);

        return collect($newObject);
    }

    protected function makeJson(string $json)
    {
        return collect(json_decode($json));
    }

    protected function calculateScores($session, $winner)
    {
        $amountOfPlayers = $session->players->count();

        $players = Player::where('game_session_id',$session->id)->get();

        $players->each(function ($player) use ($amountOfPlayers, $winner) {
            $objectsLeftCount = $this->makeJson($player->objects)->count();
            $objectsFound = 24 / $amountOfPlayers - $objectsLeftCount;

            $score = 10 * $amountOfPlayers * $objectsFound;

            if ($player->id === $winner->id){
                $score = 10 * $amountOfPlayers * $objectsFound * $amountOfPlayers;
            }

            Player::where('id',$player->id)->update(['score' => $score]);
        });
    }
}
