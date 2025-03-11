<?php

declare(strict_types=1);


namespace App\Services;

use App\Models\Player;
use App\Models\TennisMatch;
use App\Repositories\TournamentRepository;
use App\Models\Tournament;
use App\Interfaces\ITournament;
use App\Constants;
use App\Exceptions\InvalidNumberOfPlayersException;
use App\Exceptions\InvalidPlayersGenderException;
use App\UseCases\TournamentSimulation\TournamentSimulationStrategy;
use MongoDB\Laravel\Eloquent\Builder;

class TournamentService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new TournamentRepository();
    }

    private function arePlayersOfSameGenderThanTournament(String $tGender, Array $players): bool
    {
        return array_all($players, function (Player $player) use ($tGender) {
            return $player->gender === $tGender;
        });
    }

    private function areEvenPlayers(Array $players): bool
    {
        return count($players) % 2 == 0;
    }

    private function arePlayersRepeated(Array $players): bool
    {
        $playersNames = array_map(function (Player $player) {
            return trim($player->name);
        }, $players);

        return count($playersNames) !== count(array_unique($playersNames));
    }

    public function createTournament(String $gender, Array $players): ITournament
    {
        if (count($players) == 0 
            || $this->arePlayersRepeated($players)
            || !$this->areEvenPlayers($players)) {
            throw new InvalidNumberOfPlayersException();
        }

        if (!$this->arePlayersOfSameGenderThanTournament($gender, $players)) {
            throw new InvalidPlayersGenderException();
        }

        $tournament = new Tournament();
        $tournament->status = Constants::TOURNAMENT_STATUS_CREATED;
        $tournament->gender = $gender;
        $tournament->players = [];
        $tournament->rounds = count($players) / 2;

        $tournament->save();

        foreach ($players as $player) {
            $tournament->players()->attach($player);
        }

        return $tournament;
    }

    public function startTournament(ITournament $tournament): ITournament
    {
        $simulation = new TournamentSimulationStrategy($tournament->gender);

        return $simulation->simulateTournament($tournament);
    }

    public function getTournamentsBy(array $filters)
    {
        $tournaments = Tournament::where(function (Builder $query) use ($filters){
            foreach ($filters as $field => $value) {
                if ($field === 'created_at') {
                    $query->whereDate($field, $value);
                    continue;
                }
                $query->where($field, $value);
            }
        })->get();

        return $tournaments;
    }
}