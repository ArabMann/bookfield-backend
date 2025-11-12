<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $users = [
            [
                "name" => "Ade Tirta Adrianta",
                "email" => "atirtaadrianta@gmail.com",
                "birthday" => "2001-03-10",
                "phone_number" => "089654553167",
                "role_id" => 1,
                "password" => bcrypt("12345678"),
            ],
            [
                "name" => "Alfin",
                "birthday" => "2000-12-02",
                "email" => "kachoukalhi@gmail.com",
                "phone_number" => "0895324981393",
                "role_id" => 2,
                "password" => bcrypt("12345678"),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
