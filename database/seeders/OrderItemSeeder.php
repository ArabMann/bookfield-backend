<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $schedule = Schedule::findOrFail(1);
        // DB::table("order_items")->insert([
        //     [
        //         "field_id" => 1,
        //         "day_id" => 1,
        //         "order_id" => 1,
        //         "price" => $schedule->price,
        //         "schedule_id" => $schedule->id,
        //     ]
        // ]);
    }
}
