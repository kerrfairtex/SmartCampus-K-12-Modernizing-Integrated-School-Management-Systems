<?php

namespace App;

class ParentStudent extends Model
{
    protected $fillable = ['parent_id', 'student_id', 'school_id'];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
