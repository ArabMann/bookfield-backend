<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $schedules = [
        //     [
        //         "price" => 20000,
        //         "start" => "08:00:00",
        //         "end" => '10:00:00',
        //         "day_id" => 1,
        //         'created_at' => now(),
        //         'updated_at' => now(),  
        //     ],
        //     [
        //         "price" => 20000,
        //         "start" => "10:00:00",
        //         "end" => '11:00:00',
        //         "day_id" => 1,
        //         'created_at' => now(),
        //         'updated_at' => now(),  
        //     ],
        //     [
        //         "price" => 20000,
        //         "start" => "11:00:00",
        //         "day_id" => 1,
        //         "end" => '12:00:00',
        //         'created_at' => now(),
        //         'updated_at' => now(),  
        //     ],
        // ];

        // DB::table("schedules")->insert($schedules);
    }
}
