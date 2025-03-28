<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'curriculum_id',
        'title',
        'company',
        'location',
        'start_date',
        'end_date',
        'city',
        'country',
        'description'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
