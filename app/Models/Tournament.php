<?php

namespace App\Models;

use App\Constants;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\EmbedsMany;
use MongoDB\Laravel\Relations\EmbedsOne;
use App\Interfaces\ITournament;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class Tournament extends Model implements ITournament
{
    use SoftDeletes;

    protected $connection = 'mongodb';
    //for development simplicity
    protected $guarded = [];
    protected $attributes = [
        'gender' => null,
        'status' => Constants::TOURNAMENT_STATUS_CREATED,
        'players' => [],
        'rounds' => 0,
        'winner' => null,
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d',
        ];
    }

    public function matches(): EmbedsMany
    {
        return $this->embedsMany(TennisMatch::class);
    }

    public function players(): EmbedsMany
    {
        return $this->embedsMany(Player::class);
    }

    public function winner(): EmbedsOne
    {
        return $this->embedsOne(Player::class);
    }
}
