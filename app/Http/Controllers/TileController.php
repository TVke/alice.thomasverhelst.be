<?php

namespace App\Http\Controllers;

use App\GameSession;
use App\Events\GameChanged;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
