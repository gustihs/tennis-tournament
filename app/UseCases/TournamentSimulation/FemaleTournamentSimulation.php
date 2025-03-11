<?php

namespace App\UseCases\TournamentSimulation;

use App\Interfaces\IPlayer;
use App\Constants;

class FemaleTournamentSimulation extends BaseTournamentSimulation
{
    protected function calculatePerformance(IPlayer $player): float
    {
        $luck = rand(0, 100) / 100;
        $skill = $player->level 
            + $player->getSkill(Constants::PLAYER_SKILL_REACTION);

        return $skill * (1 + $this->luckyFactor * $luck);
    }
}