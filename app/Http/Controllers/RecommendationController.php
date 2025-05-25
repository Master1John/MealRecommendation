<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Meal;
use App\Models\MealRecommendation;

class RecommendationController extends Controller
{
    public function recommend()
    {
        $user = Auth::user();

        if (!$user->goal) {
            return response()->json(['message' => 'User goal is not set.'], 400);
        }

        $recommendedMeals = Meal::query()->where('goal_type', $user->goal)
            ->inRandomOrder()
            ->limit(3) // Adjust as needed
            ->get();

        foreach ($recommendedMeals as $meal) {
            MealRecommendation::query()->create([
                'user_id' => $user->id,
                'meal_id' => $meal->id,
                'recommended_date' => Carbon::now()->toDateString()
            ]);
        }

        return response()->json($recommendedMeals);
    }

    public function history()
    {
        $user = Auth::user();

        $history = MealRecommendation::with('meal')
            ->where('user_id', $user->id)
            ->orderBy('recommended_date', 'desc')
            ->get();

        return response()->json($history);
    }
}
