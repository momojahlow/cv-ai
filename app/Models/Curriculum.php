<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Curriculum extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_of_birth',
        'nationality',
        'civility',
        'study_level',
        'phone',
        'email',
        'address',
        'city',
        'country',
        'resume',
        'experience',
        'education',
        'languages',
        'avatar',
        'user_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'experience' => 'array',
        'education' => 'array',
        'languages' => 'array',
    ];

    /**
     * Get the user that owns the curriculum.
     * This is a one-to-one relationship, each curriculum belongs to exactly one user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
