<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;

class MealController extends Controller
{
    public function index()
    {
        return response()->json(Meal::query()->paginate(10), 201);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'image|nullable|mimes:jpeg,jpg,png,jif,webp|max:2048',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'calories' => 'required|integer',
            'protein' => 'nullable|numeric',
            'carbs' => 'nullable|numeric',
            'fat' => 'nullable|numeric',
            'goal_type' => 'required|string'
        ]);


        $path = $request->file('image')->store('public/images/meals');

        $relativePath = str_replace('public', '', $path);

        $meal = Meal::query()->create([...$request->except('image'), 'image' => $relativePath]);

        return response()->json($meal, 201);
    }

    public function show($id)
    {
        $meal = Meal::query()->findOrFail($id);
        return response()->json($meal, 201);
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
