<?php

use App\Models\Meal;
use App\Models\MealPlan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meal_plan_meal', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MealPlan::class);
            $table->foreignId(Meal::class);
            $table->enum('meal_time', ['breakfast', 'lunch', 'dinner', 'snack']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_plan_meal');
    }
};
