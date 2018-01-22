<?php

namespace Alice\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function view(){
        return view('game');
    }
}
