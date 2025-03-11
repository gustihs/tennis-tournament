<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TennisMatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'round' => $this->round,
            'player1' => new PlayerResource($this->player1),
            'player2' => new PlayerResource($this->player2),
            'winner' => new PlayerResource($this->winner),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
