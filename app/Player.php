<?php

namespace App;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends User
{
    protected $guarded = [];

    protected $hidden = [
        'id', 'password', 'remember_token', 'game_session_id', 'created_at', 'updated_at',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(GameSession::class,'game_session_id');
    }
}
