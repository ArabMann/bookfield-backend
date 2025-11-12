<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    //
    public function index()
    {
        $schedules = Schedule::all();
        return (ScheduleResource::collection($schedules))->additional([
            "success" => true,
            "message" => "Data Schedule Berhasil Ditampilkan"
        ]);
    }

    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $response = DB::transaction(function () use ($request, $schedule) {
            $validation = $request->validated();
            $schedule->update($validation);
            return (new ScheduleResource($schedule))->additional([
                "success" => true,
                "message" => "Data Schedule Berhasil Diubah"
            ]);
        });

        return $response;
    }

    public function destroy(Schedule $schedule){
        DB::beginTransaction();
        try{
            $schedule->delete();
            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Data Schedule Berhasil Dihapus",
            ]);
        }catch(Exception $e){
            DB::rollBack();
            return response()->json([
                "success" => false,
                "message" => "Data Schedule Tidak Berhasil Dihapus",
            ]);
        }
    }
}
