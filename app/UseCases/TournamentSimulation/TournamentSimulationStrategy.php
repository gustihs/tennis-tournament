<?php

namespace App\UseCases\TournamentSimulation;

use App\Constants;
use App\Interfaces\ITournament;

class TournamentSimulationStrategy
{
    private $strategy;

    public function __construct(String $gender, Float $luckyFactor = 0.0)
    {        
        switch ($gender) {
            case Constants::GENDER_MALE:
                $this->strategy = new MaleTournamentSimulation($luckyFactor);
                break;
            case Constants::GENDER_FEMALE:
                $this->strategy = new FemaleTournamentSimulation($luckyFactor);
                break;
            default:
                throw new \Exception("Invalid gender");
        }
    }

    public function simulateTournament(ITournament $tournament): ITournament
    {
        return $this->strategy->simulate($tournament);
    }
}