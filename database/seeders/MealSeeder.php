<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files = Storage::disk('public')->files('images/meals');

        foreach ($files as $filePath) {
            $filename = basename($filePath);
            $name = pathinfo($filename, PATHINFO_FILENAME);

            $mealName = Str::title(str_replace(['_', '-'], ' ', $name));

            Meal::factory()->create([
                'name' => $mealName,
                'description' => 'Delicious' . $mealName,
                'image' => str_replace('public/', '', $filePath),
            ]);
        }
    }
}
