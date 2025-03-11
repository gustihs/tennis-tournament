<?php

namespace App\UseCases\TournamentSimulation;

use App\Interfaces\ITournament;
use App\Interfaces\ITennisMatch;
use App\Interfaces\IPlayer;
use App\Constants;
use App\Models\TennisMatch;

abstract class BaseTournamentSimulation  implements ITournamentSimulation
{
    protected $luckyFactor;

    public function __construct(Float $luckyFactor)
    {
        $this->luckyFactor = $luckyFactor;
    }

    abstract protected function calculatePerformance(IPlayer $player): float;

    public function simulate(ITournament $tournament): ITournament
    {
        $tournamentWinner = null;
        $tournament->status = Constants::TOURNAMENT_STATUS_STARTED;
        $players = $tournament->players;

        for ($round = 0; $tournament->rounds; $round++) {

            for ($i = 0; $i < count($players); $i += 2) {
                $groups[] = [$players[$i], $players[$i + 1]];
            }

            $players = [];

            foreach ($groups as $group) {
                $match = new TennisMatch();
                $match->round = $round;
                $match->player1()->associate($group[0]);
                $match->player2()->associate($group[1]);

                $match = $this->simulateMatch($match);
                $tournament->matches()->attach($match);

                $players[] = $match->winner;

                if ($round == $tournament->rounds - 1) {
                    $tournamentWinner = $match->winner;
                    break 2;
                }
            }
        }

        $tournament->status = Constants::TOURNAMENT_STATUS_FINISHED;
        $tournament->winner()->associate($tournamentWinner);
        $tournament->save();

        return $tournament;
    }

    protected function simulateMatch(ITennisMatch $match): ITennisMatch 
    {
        if ($this->calculatePerformance($match->player1) > $this->calculatePerformance($match->player2)) {
            $match->winner()->associate($match->player1);
        } else {
            $match->winner()->associate($match->player2);
        }

        return $match;
    }
}