<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FightLog extends Model
{
    protected $fillable = [
        'fight_id',
        'turn_number',
        'description'
    ];

    public function fight()
    {
        return $this->belongsTo(Fight::class);
    }
}