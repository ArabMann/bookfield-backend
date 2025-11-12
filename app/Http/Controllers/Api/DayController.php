<?php

namespace App\Http\Controllers\Api;

use App\Models\Day;
use App\Models\Field;
use App\Models\Schedule;
use App\Services\DayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\DayResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreDayRequest;
use App\Http\Requests\UpdateDayRequest;

class DayController extends Controller
{
    //
    protected $dayService;

    public function __construct(DayService $dayService)
    {
        $this->dayService = $dayService;
    }
    public function index()
    {
        // if (Auth::check() && Auth::user()->role->name !== "Admin") {
        //     return response()->json([
        //         "success" => false,
        //         "message" => "Anda Bukan Admin"
        //     ]);
        // }
        $days = $this->dayService->getAll();
        return (DayResource::collection($days))->additional([
            "success" => true,
            "message" => "Data Day Berhasil ditambahkan",
        ]);
    }

    public function store(StoreDayRequest $request)
    {
        // if (Auth::check() && Auth::user()->role->name !== "Admin") {
        //     return response()->json([
        //         "success" => false,
        //         "message" => "Anda Bukan Admin"
        //     ]);
        // }
        $validation = $request->validated();

        $day = $this->dayService->dayStore($validation);
        return (new DayResource($day))->additional([
            "success" => true,
            "message" => "Data Day Berhasil ditambahkan",
        ]);
    }

    public function update(UpdateDayRequest $request, Day $day)
    {
        // if (Auth::check() && Auth::user()->role->name !== "Admin") {
        //     return response()->json([
        //         "success" => false,
        //         "message" => "Anda Bukan Admin"
        //     ]);
        // }
        $validation = $request->validated();

        $day = $this->dayService->dayUpdate($validation, $day);

        return (new DayResource($day))->additional([
            "success" => true,
            "message" => "Data Day Berhasil ditambahkan",
        ]);
    }

    public function destroy(Day $day)
    {
        // if (Auth::check() && Auth::user()->role->name !== "Admin") {
        //     return response()->json([
        //         "success" => false,
        //         "message" => "Anda Bukan Admin"
        //     ]);
        // }
        return $delete = $this->dayService->dayDelete($day);
    }
}
