<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Curriculum;

class Education extends Model
{
    protected $table = 'education';

    protected $fillable = [
        'curriculum_id',
        'level',
        'type',
        'status',
        'start_date',
        'end_date',
        'school',
        'diploma',
        'description'
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }

    
}
