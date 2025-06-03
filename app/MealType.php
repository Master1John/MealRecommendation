<?php

namespace App;

enum MealType: string
{
    case Breakfast = 'breakfast';
    case Dinner = 'dinner';
    case Lunch = 'lunch';
    case Snack = 'snack';
}
