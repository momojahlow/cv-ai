<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'startDate',
        'endDate',
        'description',
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
