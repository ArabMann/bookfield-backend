<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $indoor = "Indoor";
        // $outdoor = "Outdoor";

        // $room = DB::table('rooms')->insert([
        //     [
        //         "name" => $indoor,
        //         "slug" => Str::slug($indoor)
        //     ],
        //     [
        //         "name" => $outdoor,
        //         "slug" => Str::slug($outdoor)
        //     ],
        // ]);
    }
}
