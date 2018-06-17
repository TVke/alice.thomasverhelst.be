<?php

namespace App\Http\Controllers;

use App\GameSession;
use App\Events\TileMoved;
use App\Events\RotateTile;
use App\Player;
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

    public function update(Request $request)
    {
        $session = GameSession::where('session', session('game_token'))->first();

        if (! $session) {
            return null;
        }

        $changes = collect($request->changes);
        $rotation = collect($request->rotation);

        $tiles = collect(json_decode($session->tiles));

        $oldLooseTile = collect($tiles->pop());

        $newX = $oldLooseTile->get('x');
        $newY = $oldLooseTile->get('y');

        if ($changes->get('direction') === 'x') {
            $newX = ($changes->get('amount') > 0) ? 0 : 6;
            $newY = $changes->get('line');
        }

        if ($changes->get('direction') === 'y') {
            $newX = $changes->get('line');
            $newY = ($changes->get('amount') > 0) ? 0 : 6;
        }

        $oldLooseTile->put('rotation', $rotation);
        $oldLooseTile->put('x', $newX);
        $oldLooseTile->put('y', $newY);

        $tiles = $tiles->map(function ($tile) use ($changes, $newX, $newY) {
            if ($changes->get('direction') === 'x' && $tile->y === $changes->get('line')) {
                $new = ($changes->get('amount') > 0) ? $tile->x + 1 : $tile->x - 1;

                $tile->x = $new;

                if ($new === 7 || $new === -1) {
                    $tile->x = -1;
                    $tile->y = -1;
                }
            }

            if ($changes->get('direction') === 'y' && $tile->x === $changes->get('line')) {
                $new = ($changes->get('amount') > 0) ? $tile->y + 1 : $tile->y - 1;

                $tile->y = $new;

                if ($new === 7 || $new === -1) {
                    $tile->x = -1;
                    $tile->y = -1;
                }
            }

            return $tile;
        });

        $newLooseTile = $tiles->filter(function ($tile) {
            return $tile->x === -1 && $tile->y === -1;
        })->first();

        $tiles = $tiles->filter(function ($tile) {
            return $tile->x !== -1 && $tile->y !== -1;
        })->flatten();

        $tiles->push($oldLooseTile);
        $tiles->push($newLooseTile);

        GameSession::find($session->id)->update(compact('tiles'));

        // pawns moving
        $players = $session->players()->get()
            ->map(function ($player) {
                $player->position = json_decode($player->position);

                return $player;
            })
            ->map(function ($player) use ($changes) {
                if ($changes->get('direction') === 'x' && $player->position->y === $changes->get('line')) {
                    $new = ($changes->get('amount') > 0) ? $player->position->x + 1 : $player->position->x - 1;

                    if ($new === 7) {
                        $new = 0;
                    }

                    if ($new === -1) {
                        $new = 6;
                    }

                    $player->position->x = $new;
                }
                if ($changes->get('direction') === 'y' && $player->position->x === $changes->get('line')) {
                    $new = ($changes->get('amount') > 0) ? $player->position->y + 1 : $player->position->y - 1;

                    if ($new === 7) {
                        $new = 0;
                    }

                    if ($new === -1) {
                        $new = 6;
                    }

                    $player->position->y = $new;
                }

                return $player;
            });

        $players->each(function ($player) {
            Player::find($player->id)->update(['position' => json_encode($player->position)]);
        });

        event(new TileMoved($session, $tiles, $players));
    }

    public function rotate()
    {
        $session = GameSession::where('session', session('game_token'))->first();

        event(new RotateTile($session));
    }
}
