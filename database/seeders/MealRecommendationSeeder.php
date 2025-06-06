<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\MealRecommendation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MealRecommendationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->first();

        $meals = Meal::query()->where('goal_type', $user->goal)->get();

        $meal = $meals->random();

        MealRecommendation::query()->create([
            'user_id' => $user->id,
            'meal_id' => $meal->id,
            'recommended_date' => Carbon::now()->toDateString()
        ]);
    }
}
