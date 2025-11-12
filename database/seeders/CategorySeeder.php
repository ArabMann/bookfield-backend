<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $futsal = "Futsal";
        // $badminton = "Badmintoon";

        // $categories = DB::table("categories")->insert([
        //     [
        //         "name" => $futsal,
        //         "slug" => Str::slug($futsal)
        //     ],
        //     [
        //         "name" => $badminton,
        //         "slug" => Str::slug($badminton)
        //     ],
        // ]);
    }
}
