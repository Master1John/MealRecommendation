<?php
namespace App\Services;

use App\Models\Meal;
use App\Models\MealRecommendation;
use App\Models\User;
use Carbon\Carbon;

class RecommendationService
{
    protected $user;
    protected $mealsPerDay = 3;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function recommend()
    {
        // 1) Calculate target calories & macros
        $targets = $this->calculateTargets();

        // 2) For each meal slot, pull a meal near the per-meal targets
        $perMealCal = $targets['calories'] / $this->mealsPerDay;
        $range = 0.10; // ±10%

        $recommendations = collect();
        for ($i = 0; $i < $this->mealsPerDay; $i++) {
            $meal = Meal::query()->where('goal_type', $this->user->goal)
                ->whereBetween('calories', [
                    $perMealCal * (1 - $range),
                    $perMealCal * (1 + $range)
                ])
                // you could also filter by macros or tags, e.g.:
                // ->where('protein', '>=', $targets['protein_per_meal'])
                ->inRandomOrder()
                ->first();

            if ($meal) {
                $recommendations->push($meal);
                // record it
                MealRecommendation::query()->create([
                    'user_id'          => $this->user->id,
                    'meal_id'          => $meal->id,
                    'recommended_date' => Carbon::now()->toDateString(),
                ]);
            }
        }

        return $recommendations;
    }

    protected function calculateTargets(): array
    {
        // 1. BMR using Mifflin-St Jeor
        $w = $this->user->weight;
        $h = $this->user->height;
        $a = $this->user->age;
        $s = strtolower($this->user->gender) === 'male' ? 5 : -161;

        $bmr = 10 * $w + 6.25 * $h - 5 * $a + $s;

        // 2. TDEE—assume a placeholder activity factor; you can let user choose this later
        $activityFactor = 1.2; // sedentary
        $tdee = $bmr * $activityFactor;

        // 3. Adjust for goal
        switch ($this->user->goal) {
            case 'weight_loss':
                $tdee -= 500;
                break;
            case 'weight_gain':
                $tdee += 500;
                break;
            // general_health or maintenance → no change
        }

        // 4. Macronutrient breakdown (example: 30% protein, 30% fat, 40% carbs)
        $cal = max(1200, $tdee); // floor so it never gets too low
        $proteinCal = $cal * 0.30;
        $fatCal     = $cal * 0.30;
        $carbCal    = $cal * 0.40;

        return [
            'calories'           => $cal,
            'protein_per_day'    => $proteinCal / 4,   // 4 kcal per g protein
            'fat_per_day'        => $fatCal / 9,       // 9 kcal per g fat
            'carbs_per_day'      => $carbCal / 4,
        ];
    }
}

