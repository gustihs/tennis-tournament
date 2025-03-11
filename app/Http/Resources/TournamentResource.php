<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TournamentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            '_id' => $this->_id,
            'gender' => $this->gender,
            'rounds' => $this->rounds,
            'status' => $this->status,
            'players' => PlayerResource::collection($this->players),
            'matches' => TennisMatchResource::collection($this->matches),
            'winner' => new PlayerResource($this->winner),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
