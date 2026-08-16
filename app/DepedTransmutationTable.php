<?php

namespace App;

class DepedTransmutationTable extends Model
{
    protected $fillable = [
        'school_id', 'name', 'description', 'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function rows()
    {
        return $this->hasMany(DepedTransmutationRow::class)
            ->orderBy('from_score', 'desc');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
