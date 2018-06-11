<?php

namespace App\Http\Controllers;

use App\Player;

class PageController extends Controller
{
    public function info()
    {
        return view('info');
    }
    
    public function leaderboard()
    {
        $scores = Player::whereNotNull('score')->orderByDesc('score')->paginate(100);
        
        return view('leaderboard', compact('scores'));
    }
}
