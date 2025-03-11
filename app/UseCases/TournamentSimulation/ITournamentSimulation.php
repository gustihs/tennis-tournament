<?php

namespace App\UseCases\TournamentSimulation;
use App\Interfaces\ITournament;

interface ITournamentSimulation
{
    public function simulate(ITournament $tournament): ITournament;
}