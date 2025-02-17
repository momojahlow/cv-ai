<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'curriculum_id',
        'name',
        'level',
        'code',
        'description'
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
