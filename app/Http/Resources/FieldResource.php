<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => [
                "id" => $this->category?->id,
                "name" => $this->category?->name,
            ],
            'room' => [
                "id" => $this->room?->id,
                "name" => $this->room?->name,
            ],
            'description' => $this->description,
            'image' => $this->image,
            "slug" => $this->slug,
            "day" => DayResource::collection($this->days),
        ];
    }
}
