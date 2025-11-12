<?php

namespace App\Http\Resources;

use App\Models\Day;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {

        return [
            "id" => $this->id,
            "price" => $this->price,
            "start" => $this->start,
            "end" => $this->end,
            "is_active" => $this->is_active,
            "day" => [
                'id' => $this->day?->id,
                'name' => $this->day?->name,
            ]
        ];
    }
}
