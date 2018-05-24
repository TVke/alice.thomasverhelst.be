<?php

namespace App\Http\Controllers;

use App\GameSession;
use App\Events\GameChanged;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Valuestore\Valuestore;

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

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:players|max:255',
            'pawn' => [
                'required',
                Rule::in(['Alice', 'Queen of Hearts', 'Mad Hatter', 'White Rabbit'])
            ],
        ]);

        session(['pawn' => $request->pawn]);

        $baseUrl = config('app.url');

        $session = GameSession::where('session', session('game_token'))->first();

        $sessionToken = $session->session;

        $positions = Valuestore::make(resource_path('data/startPositions.json'));

        $session->players()->create([
            'username' => $request->username,
            'pawn' => $request->pawn,
            'position' => json_encode($positions->get($request->pawn)),
        ]);

        return $sessionToken;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $pawn)
    {
        $session = GameSession::where('session', session('game_token'))->first();

        if (! $session) {
            return null;
        }

        if ($pawn !== session('pawn')){
            return null;
        }

        $path = $request->path;

        event(new GameChanged($session, [], $path));

        unset($path[0]['step']);

        $position = json_encode($path[0]);

        $session->players()->where('pawn', $pawn)->update(compact('position'));
    }

    public function destroy($id)
    {
        //
    }
}
