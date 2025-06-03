<?php

namespace Database\Factories;

use App\MealType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mealNames = [
            'Eru and Fufu', 'Ndolé and Plantains', 'Jollof Rice', 'Koki and Plantains',
            'Poulet DG', 'Achu and Yellow Soup', 'Kati Kati', 'Cornchaff', 'Okok', 'Egusi Pudding'
        ];

        $name = $this->faker->randomElement($mealNames);

        return [
            'name' => $name,
            'description' => 'A traditional Cameroonian meal called ' . $name,
            'type' => $this->faker->randomElement(array_column(MealType::cases(), 'value')),
            'calories' => $this->faker->numberBetween(300, 700),
            'protein' => $this->faker->randomFloat(1, 10, 40),
            'carbs' => $this->faker->randomFloat(1, 20, 80),
            'fat' => $this->faker->randomFloat(1, 5, 30),
            'meal_time' => $this->faker->randomElement(['breakfast', 'lunch', 'dinner']),
            'goal_type' => $this->faker->randomElement(['lose_weight', 'gain_muscle', 'maintain_weight']),
        ];
    }
}
