<?php

namespace App;

class QuarterlyComponentScore extends Model
{
    protected $fillable = [
        'quarter_id', 'course_id', 'student_id', 'grading_component_type_id',
        'raw_score', 'max_score', 'teacher_id', 'user_id',
    ];

    public function quarter()
    {
        return $this->belongsTo(Quarter::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function componentType()
    {
        return $this->belongsTo(GradingComponentType::class, 'grading_component_type_id');
    }
}
