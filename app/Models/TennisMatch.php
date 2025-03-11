<?php

namespace App\Models;

use App\Constants;
use App\Interfaces\ITennisMatch;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\EmbedsOne;
use MongoDB\Laravel\Eloquent\SoftDeletes;


class TennisMatch extends Model implements ITennisMatch
{
    use SoftDeletes;

    protected $connection = 'mongodb';
    //for development simplicity
    protected $guarded = [];
    protected $attributes = [
        'round' => null,
        'player1' => null,
        'player2' => null,
        'winner' => null
    ];

    public function player1(): EmbedsOne
    {
        return $this->embedsOne(Player::class);
    }

    public function player2(): EmbedsOne
    {
        return $this->embedsOne(Player::class);
    }

    public function winner(): EmbedsOne
    {
        return $this->embedsOne(Player::class);
    }
}
