<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'connectors' => $this->whenLoaded('connectors'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'can'        => [
                'update'      => $request->user()->can('update', $this->resource),
                'delete'      => $request->user()->can('delete', $this->resource),
                'restore'     => $request->user()->can('restore', $this->resource),
                'forceDelete' => $request->user()->can('forceDelete', $this->resource),
            ],
        ];
    }
}
