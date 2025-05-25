<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;

class MealController extends Controller
{
    public function index()
    {
        return Meal::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'calories' => 'required|integer',
            'protein' => 'nullable|numeric',
            'carbs' => 'nullable|numeric',
            'fat' => 'nullable|numeric',
            'meal_time' => 'required|string',
            'goal_type' => 'required|string'
        ]);

        $meal = Meal::query()->create($validated);

        return response()->json($meal, 201);
    }

    public function show($id)
    {
        return Meal::query()->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $meal = Meal::query()->findOrFail($id);
        $meal->update($request->all());

        return response()->json($meal);
    }

    public function destroy($id)
    {
        $meal = Meal::query()->findOrFail($id);
        $meal->delete();

        return response()->json(['message' => 'Meal deleted']);
    }
}
