<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Services\RoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    //
    protected $room;
    public function __construct(RoomService $room)
    {
        $this->room = $room;
    }

    public function index()
    {
        if (Auth::check() && Auth::user()->role->name !== "Admin") {
            return response()->json([
                "success" => false,
                "message" => "Anda Bukan Admin"
            ]);
        }
        $rooms = $this->room->getAll();
        return (RoomResource::collection($rooms))->additional([
            "success" => true,
            "message" => "Data Room Berhasil ditampilkan",
        ]);
    }

    // public function findRoom($slug){
    //     $rooms = $this->room->findRoom($slug);
    //     return (RoomResource::collection($rooms))->additional([
    //         "success" => true,
    //         "message" => "Data Room + Field Berhasil ditampilkan",
    //     ]);
    // }
}
