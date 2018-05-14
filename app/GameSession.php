<?php

namespace App;

use App\Services\Tile;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameSession extends Model
{
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'session';
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class)->select(['id', 'username','pawn']);
    }

    public static function generateToken(): string
    {
        $hash = md5(Str::uuid());

        return str_limit($hash, 10,'');
    }

    public static function newSession()
    {
        $token = static::generateToken();

        static::create([
            'session' => $token,
            'tiles' => Tile::createMap()->toJson(),
        ]);

        session(['game_token' => $token]);
    }
}
