<?php

namespace App;

class QuarterlyGrade extends Model
{
    protected $fillable = [
        'quarter_id', 'course_id', 'student_id',
        'written_work_percent', 'performance_task_percent', 'quarterly_assessment_percent',
        'initial_grade', 'transmuted_grade', 'descriptor', 'remarks',
        'teacher_id', 'user_id', 'computed_at',
    ];

    protected $casts = [
        'computed_at' => 'datetime',
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
}
