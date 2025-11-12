<?php

namespace App\Http\Resources;

use App\Models\Day;
use App\Models\Field;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
    */
    public function schedule($id){
        $schedule = Schedule::findOrFail($id);
        return [
            "id" => $schedule->id,
            "start" => $schedule->start,
            "end" => $schedule->end,
        ];
    }
    public function day($id){
        $day = Day::findOrFail($id);
        return [
            "id" => $day->id,
            "name" => $day->name,
        ];
    }
    public function field($id){
        $field = Field::findOrFail($id);
        return [
            "id" => $field->id,
            "name" => $field->name,
            "image" => $field->image,
        ];
    }
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "price" => $this->price,
            "schedule" => $this->schedule($this->schedule_id),
            "field" => $this->field($this->field_id),
            "day" => $this->day($this->day_id),
            // "total_amount" =>
        ];
    }

}
