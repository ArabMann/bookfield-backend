<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class RoomService{

    public function getAll(){
        $rooms = Room::all();
        return $rooms;
    }

    public function findRoom($slug){
        $rooms = Room::with("fields")->where("slug", $slug)->get();
        return $rooms;
    }
}