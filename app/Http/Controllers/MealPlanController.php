<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MealPlanController extends Controller
{
    public function index()
    {
        return response()->json(auth()->user()->mealPlans);
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_date' => 'required|date',
            'meals' => 'required|array',
            'meals.*.id' => 'required|exists:meals,id',
            'meals.*.meal_time' => 'required|in:breakfast,lunch,dinner,snack',
        ]);

        $mealPlan = auth()->user()->mealPlans()->create([
            'plan_date' => $request->plan_date,
        ]);

        foreach ($request->meals as $meal) {
            $mealPlan->meals()->attach($meal['id'], ['meal_time' => $meal['meal_time']]);
        }

        return response()->json(['message' => 'Meal plan created successfully.']);
    }

    public function show($date)
    {
        $mealPlan = auth()->user()->mealPlans()
            ->where('plan_date', $date)
            ->with(['meals'])
            ->firstOrFail();

        $groupedMeals = $mealPlan->meals->groupBy('pivot.meal_time');

        return response()->json([
            'date' => $mealPlan->plan_date,
            'meals' => $groupedMeals,
        ]);
    }
}
