<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;
use App\Constants;
use Illuminate\Support\Facades\Validator;
use App\Services\TournamentService;
use App\Models\Player;
use App\Http\Resources\TournamentResource;


class TournamentController extends Controller
{
    const GENDER_RULE = ("in:".Constants::GENDER_MALE.",".Constants::GENDER_FEMALE);

    /**
     * Get tennis tournaments
     *
     * Get the list of successed tournaments
     * 
     */
    public function index(Request $request, TournamentService $service)
    {
        $request->validate([
            'gender' => "nullable|in:M,F",
            'created_at' => 'nullable|date',
        ]);

        $filters = $request->input();
        $filters['status'] = Constants::TOURNAMENT_STATUS_FINISHED;

        $tournaments = $service->getTournamentsBy($filters);

        return TournamentResource::collection($tournaments);
    }

    /**
     * Create a tennis tournament
     * 
     * Create and simulate a tournament by providing a list of players with their current skills.
     */
    public function store(Request $request, TournamentService $service, Tournament $tournament)
    {
        $request->validate([
            'gender' => ("required|in:M,F"),
            'players.*.name' => 'required|unique:players',
            'players.*.gender' => ("required|in:M,F"),
            'players.*.country' => 'required',
            'players.*.level' => 'required||integer|between:1,100',
            'players.*.skills.velocity' => 'required|integer|between:1,100',
            'players.*.skills.reaction' => 'required|integer|between:1,100',
            'players.*.skills.force' => 'required|integer|between:1,100',
        ]);

        foreach ($request->input('players') as $player) {
            $players[] = new Player($player);
        }

        $tournament = $service->createTournament($request->input('gender'), $players);
        $tournament = $service->startTournament($tournament);

        return new TournamentResource($tournament);
    }
}
