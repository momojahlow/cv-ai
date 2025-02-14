<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'company',
        'location',
        'startDate',
        'endDate',
        'description',
        'curriculum_id'
    ];

    protected $casts = [
        'startDate' => 'date',
        'endDate' => 'date',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
