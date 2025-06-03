<?php

namespace App;

enum GoalType: string
{
    case LoseWeight = 'lose_weight';
    case GainMuscle = 'gain_muscle';
    case MaintainWeight = 'maintain_weight';
    case ImproveEndurance = 'improve_endurance';
    case GeneralHealth = 'general_health';
}
