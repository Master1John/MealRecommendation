<?php

namespace App\Models;

use Attribute as AttributeAttribute;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    /** @use HasFactory<\Database\Factories\MealFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'calories',
        'protein',
        'carbs',
        'fat',
        'goal_type'
    ];


    public function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => asset('storage/' . $value)
        );
    }
}
