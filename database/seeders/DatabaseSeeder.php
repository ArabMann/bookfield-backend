<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            CategorySeeder::class,
            RoomSeeder::class,
            FieldSeeder::class,
            DaySeeder::class,
            ScheduleSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
        ]);
    }
}
