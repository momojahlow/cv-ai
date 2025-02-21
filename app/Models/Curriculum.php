<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Language;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    protected $fillable = [
        'date_of_birth',
        'nationality',
        'civility',
        'title',
        'study_level',
        'phone',
        'address',
        'city',
        'country',
        'resume',
        'avatar',
        'family_status',
        'user_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
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

    /**
     * Get the language records for the curriculum.
     */
    public function languages()
    {
        return $this->hasMany(Language::class);
    }
}
