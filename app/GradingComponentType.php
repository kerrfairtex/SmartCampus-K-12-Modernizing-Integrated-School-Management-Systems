<?php

namespace App;

class GradingComponentType extends Model
{
    protected $fillable = [
        'code', 'name', 'description', 'default_weight_percent',
    ];

    public function courseWeights()
    {
        return $this->hasMany(CourseGradingWeight::class);
    }
}
