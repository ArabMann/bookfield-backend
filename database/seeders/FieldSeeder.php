<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $lapanganFutsal = "Lapangan Futsal Downton";
        // $lapanganBasket = "Lapangan Basket Crackdown";
        
        // $fields = DB::table("fields")->insert([
        //     [
        //         "name" => $lapanganFutsal,
        //         "image" => "Gambar Lapangan Futsal Downton",
        //         "description" => "Description Lapangan Futsal Downton",
        //         "category_id" => 1,
        //         "room_id" => 1,
        //         "slug" => Str::slug($lapanganFutsal),
        //     ],
        //     [
        //         "name" => $lapanganBasket,
        //         "image" => "Gambar Lapangan Basket Downton",
        //         "description" => "Description Lapangan Basket Downton",
        //         "category_id" => 2,
        //         "room_id" => 2,
        //         "slug" => Str::slug($lapanganBasket),
        //     ],
        // ]);
    }
}
