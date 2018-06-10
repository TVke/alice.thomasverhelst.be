<?php

namespace App\Http\Controllers\Auth;

use App\GameSession;
use App\Http\Controllers\Controller;
use App\Player;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/game/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function logout(Request $request)
    {
        $session = GameSession::where('session', session('game_token'))->firstOrFail();

        $this->redirectTo .= $session->session;

        $player = Player::where('pawn', Auth::user()->pawn)->where('game_session_id', $session->id)->firstOrFail();

        $player->session()->dissociate();

        $player->save();

        Player::where('id', $player->id)->update([
            'pawn' => null,
        ]);

        Player::where('id', $player->id)->whereNull('score')->delete();

        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect($this->redirectTo);
    }
}
