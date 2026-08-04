<?php

namespace App;

class Quarter extends Model
{
    protected $fillable = [
        'school_year_id', 'quarter_number', 'name', 'start_date', 'end_date', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function quarterlyGrades()
    {
        return $this->hasMany(QuarterlyGrade::class);
    }

    public function componentScores()
    {
        return $this->hasMany(QuarterlyComponentScore::class);
    }
}
