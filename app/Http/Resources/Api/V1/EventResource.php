<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'start_at'         => $this->start_at,
            'end_at'           => $this->end_at,
            'inclusive_end_at' => $this->end_at->subDay(),
            'is_all_day'       => $this->is_all_day,
            'color'            => $this->color,
        ];
    }
}
