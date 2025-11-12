<?php

namespace App\Http\Resources;

use App\Models\Day;
use App\Models\Field;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    
    public function totalSchedules($id)
    {
        $schedules = Schedule::where("day_id", $id)->get();
        $total = 0;
        foreach ($schedules as $schedule) {
            if ($schedule->is_active === true) {
                $total += 1;
            }
        }
        return $total;
    }
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "field" => ["id" => $this->field?->id, "name" => $this->field?->name],
            "name" => $this->name,
            "schedule" => ScheduleResource::collection($this->schedules),
            "total" => $this->totalSchedules($this->id),
        ];
    }
}
