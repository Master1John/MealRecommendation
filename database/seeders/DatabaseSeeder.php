<?php

namespace Database\Seeders;

use App\Models\User;
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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'gender' => 'male',
            'age' => 25,
            'height' => 175,
            'weight' => 70,
            'goal' => 'gain_muscle',
        ]);

        $this->call([
            MealSeeder::class,
            MealRecommendationSeeder::class
        ]);
    }
}
