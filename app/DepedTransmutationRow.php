<?php

namespace App;

class DepedTransmutationRow extends Model
{
    protected $fillable = [
        'deped_transmutation_table_id', 'from_score', 'to_score', 'transmuted_grade',
    ];

    public function table()
    {
        return $this->belongsTo(DepedTransmutationTable::class, 'deped_transmutation_table_id');
    }
}
