<?php

namespace Alice\Http\Controllers;

use Alice\Setting;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function view(){
        $settings = Setting::all();
        $movable_pieces = ["line","corner","tpoint","line","corner","tpoint"];
        $rotation_options = [0,90,180,270];
        return view('game',compact(['settings','movable_pieces','rotation_options']));
    }
}
