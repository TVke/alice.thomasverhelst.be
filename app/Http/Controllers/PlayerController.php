<?php

namespace App\Http\Controllers;

use App\GameSession;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlayerController extends Controller
{
    public function index()
    {
        $session = GameSession::where('session', session('game_token'))->first();

        if (! $session){
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

        $baseUrl = config('app.url');

        $session = GameSession::where('session', session('game_token'))->first();

        $sessionToken = $session->session;

        $session->players()->create(request(['username', 'pawn']));

        session(['player' => $request->username]);

        return "{$baseUrl}/game/{$sessionToken}";
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //        PawnMoved::dispatch(['x' => 3, 'y' => 4]);
    }

    public function destroy($id)
    {
        //
    }
}
