<?php

namespace App;

class SchoolYear extends Model
{
    protected $fillable = [
        'school_id', 'name', 'start_date', 'end_date', 'is_active', 'user_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function quarters()
    {
        return $this->hasMany(Quarter::class)->orderBy('quarter_number');
    }
}
