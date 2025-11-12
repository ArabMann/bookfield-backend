<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'field' => $this->field->name,
            'day' => $this->day->name,
            'price' => $this->price,
            'schedule' => [
                "id" => $this->schedule->id,
                "start" => $this->schedule->start,
                "end" => $this->schedule->end,
            ],
        ];
    }
}
