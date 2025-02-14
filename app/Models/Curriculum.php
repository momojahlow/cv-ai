<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Education;
use App\Models\Experience;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    protected $fillable = [
        'date_of_birth',
        'nationality',
        'civility',
        'study_level',
        'phone',
        'address',
        'city',
        'country',
        'resume',
        'languages',
        'avatar',
        'family_status',
        'user_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'languages' => 'array',
    ];

    /**
     * Get the user that owns the curriculum.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the education records for the curriculum.
     */
    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    /**
     * Get the experience records for the curriculum.
     */
    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }
}
