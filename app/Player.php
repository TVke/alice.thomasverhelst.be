<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(GameSession::class);
    }
}
