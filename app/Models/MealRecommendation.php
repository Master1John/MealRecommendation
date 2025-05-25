<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealRecommendation extends Model
{
    /** @use HasFactory<\Database\Factories\MealRecommendationFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'meal_id',
        'recommended_date',
    ];

    public function meal(){
        return $this->belongsTo(Meal::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
