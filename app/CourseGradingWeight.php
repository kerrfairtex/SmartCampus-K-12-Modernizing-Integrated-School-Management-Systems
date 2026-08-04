<?php

namespace App;

class CourseGradingWeight extends Model
{
    protected $fillable = [
        'course_id', 'grading_component_type_id', 'weight_percent',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function componentType()
    {
        return $this->belongsTo(GradingComponentType::class, 'grading_component_type_id');
    }
}
