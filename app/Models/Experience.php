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
        'description'
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
