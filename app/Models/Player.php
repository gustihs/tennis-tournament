<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use App\Constants;
use App\Interfaces\IPlayer;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class Player extends Model implements IPlayer
{
    use SoftDeletes;

    protected $connection = 'mongodb';
    //for development simplicity
    protected $guarded = [];
    protected $attributes = [
        "name" => "",
        "gender" => null,
        "level" => 0,
        "skills" => [
            "velocity" => 0,
            "reaction" => 0,
            "force" => 0,
        ]
    ];

    public function getSkill(String $name)
    {
        return $this->skills[$name] ?? 0;
    }
}
