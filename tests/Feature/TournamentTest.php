<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Constants;
use App\Models\Player;
use App\Services\TournamentService;
use App\Exceptions\InvalidNumberOfPlayersException;
use App\Exceptions\InvalidPlayersGenderException;
use Illuminate\Database\Eloquent\Model;
use App\UseCases\TournamentSimulation\TournamentSimulationStrategy;
use Illuminate\Foundation\Testing\RefreshDatabase;


class TournamentTest extends TestCase
{
    // use RefreshDatabase;

    public function test_create_tournament_with_no_players(): void
    {
        $this->expectException(InvalidNumberOfPlayersException::class);
        $players = [];
        
        $tournamentService = new TournamentService();
        $tournamentService->createTournament(
            Constants::GENDER_MALE, 
            $players
        );
    }

    public function test_create_tournament_with_even_players(): void
    {
        $players = [
            new Player([
                "name" => "Novak Djokovic",
                "country" => "Serbia",
                "level" => 95,
                "gender" => "M",
                "skills" => [
                    "velocity" => 90,
                    "reaction" => 85,
                    "force" => 80,
                ] 
            ])     
        ];

        $this->expectException(InvalidNumberOfPlayersException::class);

        $service = new TournamentService();
        $service->createTournament(Constants::GENDER_MALE, $players);

    }

    public function test_create_tournament_with_repetead_players(): void
    {
        $players = [
            new Player([
                "name" => "Novak Djokovic",
                "country" => "Serbia",
                "level" => 95,
                "gender" => "M",
                "skills" => [
                    "velocity" => 90,
                    "reaction" => 85,
                    "force" => 80,
                ] 
            ]),
            new Player([
                "name" => "Novak Djokovic",
                "country" => "Serbia",
                "level" => 95,
                "gender" => "M",
                "skills" => [
                    "velocity" => 90,
                    "reaction" => 85,
                    "force" => 80,
                ]   
                ]),
                new Player([
                    "name" => "Another player",
                    "country" => "Serbia",
                    "level" => 95,
                    "gender" => "M",
                    "skills" => [
                        "velocity" => 90,
                        "reaction" => 85,
                        "force" => 80,
                    ]   
                ])
        ];

        $this->expectException(InvalidNumberOfPlayersException::class);

        $service = new TournamentService();
        $service->createTournament(Constants::GENDER_MALE, $players);
    }

    public function test_create_tournament_with_invalid_gender_players(): void
    {
        $players = [
            new Player([
                "name" => "Novak Djokovic",
                "country" => "Serbia",
                "level" => 95,
                "gender" => "M",
                "skills" => [
                    "velocity" => 90,
                    "reaction" => 85,
                    "force" => 80,
                ] 
            ]),
            new Player([
                "name" => "Aryna Sabalenka",
                "country" => "Belarus",
                "level" => 99,
                "gender" => "F",
                "skills" => [
                    "velocity" => 90,
                    "reaction" => 85,
                    "force" => 80,
                ]   
            ])      
        ];

        $this->expectException(InvalidPlayersGenderException::class);

        $service = new TournamentService();
        $service->createTournament(Constants::GENDER_MALE, $players);
    }

    public function test_create_first_matches()
    {

        $players = [
            new Player([
                "name" => "Novak Djokovic",
                "country" => "Serbia",
                "level" => 95,
                "gender" => "M",
                "skills" => [
                    "velocity" => 90,
                    "reaction" => 85,
                    "force" => 80,
                ] 
            ]),
            new Player([
                "name" => "Carlos Alcaraz",
                "country" => "Spain",
                "level" => 99,
                "gender" => "M",
                "skills" => [
                    "velocity" => 90,
                    "reaction" => 85,
                    "force" => 80,
                ]
                ]),
            new Player([
                "name" => "Novak2 Djokovic",
                "country" => "Serbia",
                "level" => 95,
                "gender" => "M",
                "skills" => [
                    "velocity" => 90,
                    "reaction" => 85,
                    "force" => 80,
                ] 
            ]),
            new Player([
                "name" => "Carlos2 Alcaraz",
                "country" => "Spain",
                "level" => 99,
                "gender" => "M",
                "skills" => [
                    "velocity" => 90,
                    "reaction" => 85,
                    "force" => 80,
                ]
            ])       
        ];

        $service = new TournamentService();
        $tournament = $service->createTournament(Constants::GENDER_MALE, $players);

        $this->assertTrue($tournament->rounds == count($players)/2);
    }

    public function test_match_winner()
    {
        $players = [
            new Player([
                "name" => "Novak Djokovic",
                "country" => "Serbia",
                "level" => 95,
                "gender" => "M",
                "skills" => [
                    "velocity" => 90,
                    "reaction" => 85,
                    "force" => 80,
                ] 
            ]),
            new Player([
                "name" => "Carlos Alcaraz",
                "country" => "Spain",
                "level" => 99,
                "gender" => "M",
                "skills" => [
                    "velocity" => 90,
                    "reaction" => 85,
                    "force" => 80,
                ]
            ])
        ];

        $service = new TournamentService();
        $tournament = $service->createTournament(Constants::GENDER_MALE, $players);
        $tournament = $service->startTournament($tournament);

        $this->assertTrue($tournament->winner != null, "Winner is null");
        $this->assertTrue($tournament->winner->name === "Carlos Alcaraz", "Winner is not Carlos Alcaraz");
        $this->assertTrue($tournament->status === Constants::TOURNAMENT_STATUS_FINISHED, "Tournament is not finished");
    }
}
