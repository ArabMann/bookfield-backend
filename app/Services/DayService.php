<?php

namespace App\Services;

use App\Http\Resources\DayResource;
use App\Models\Category;
use App\Models\Day;
use Illuminate\Support\Facades\DB;

class DayService
{
    public function getAll()
    {
        $days = Day::orderBy('name', "asc")->get();
        return $days;
    }

    public function dayStore(array $data)
    {

        $response = DB::transaction(function () use ($data) {
            $day = Day::create([
                "name" => $data["name"],
                "field_id" => $data["field_id"],
            ]);

            for ($i = 0; $i < count($data["start"]); $i++) {
                DB::table('schedules')->insert([
                    [
                        "day_id" => $day->id,
                        "price" => $data["price"][$i],
                        "start" => $data["start"][$i],
                        "end" => $data["end"][$i],
                    ]
                ]);
            }

            return $day;
        });

        return $response;
    }

    public function dayUpdate(array $data, $day)
    {
        $response = DB::transaction(function () use ($data, $day) {
            $dayUpdate = $day->update([
                "name" => $data["name"],
                "field_id" => $data["field_id"],
            ]);

            for ($i = 0; $i < count($data["start"]); $i++) {
                DB::table("schedules")->where("id", $i + 1)->update([
                    "day_id" => $day->id,
                    "price" => $data["price"][$i],
                    "start" => $data["start"][$i],
                    "end" => $data["end"][$i],
                ]);
            };

            return $day;
        });

        return $response;
    }

    public function dayDelete($day)
    {
        DB::beginTransaction();
        try {
            DB::commit();
            $day->delete();
            return response()->json([
                'success' => true,
                "message" => "Data Day Berhasil Dihapus",
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'success' => false,
                "message" => "Data Day Tidak Berhasil Dihapus",
            ]);
        }
    }
}
