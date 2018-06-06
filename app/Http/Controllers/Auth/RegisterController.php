<?php

namespace App\Http\Controllers\Auth;

use App\GameSession;
use App\Http\Controllers\Controller;
use App\Player;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Valuestore\Valuestore;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/game/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|unique:players|max:255',
            'pawn' => [
                'required',
                Rule::in(['Alice', 'Queen of Hearts', 'Mad Hatter', 'White Rabbit']),
                Rule::unique('players')->where(function ($query) {
                    if (! session()->has('game_token')) {
                        return true;
                    }

                    $session = GameSession::where('session', session('game_token'))->first();

                    return $query->where('game_session_id', $session->id);
                }),
            ],
        ]);
    }

    protected function create(array $data)
    {
        $game_token = session('game_token');

        if (! session()->has('game_token')) {
            $game_token = GameSession::newSession();
        }

        $session = GameSession::where('session', $game_token)->first();

        $this->redirectTo .= $session->session;

        $positions = Valuestore::make(resource_path('data/startPositions.json'));

        return $session->players()->create([
            'username' => $data['username'],
            'pawn' => $data['pawn'],
            'position' => json_encode($positions->get($data['pawn'])),
        ]);
    }
}
