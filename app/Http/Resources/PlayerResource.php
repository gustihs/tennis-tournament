<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
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
            'name' => $this->name,
            'gender' => $this->gender,
            'country' => $this->country,
            'skills' => [
                'velocity' => (integer) $this->skills['velocity'],
                'reaction' => (integer) this->skills['reaction'],
                'force' => (integer) $this->skills['force'],
            ],
            'level' => (integer) $this->level,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
