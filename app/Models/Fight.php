<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fight extends Model
{
    protected $fillable = [
        'player_a',
        'player_b',
        'winner',
        'loser',
        'winner_hp'
    ];

    public function logs()
    {
        return $this->hasMany(FightLog::class);
    }
}