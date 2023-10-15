<?php

namespace App\Models\Syllabi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\SchoolYear;

class Syllabi extends Model
{
    use HasFactory;

    protected $table = 'syllabis';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'is_active' => 'boolean',
    ];

    public function specialities()
    {
        return $this->belongsToMany(Speciality::class, 'speciality_syllabi');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_syllabi')
                ->withPivot('is_mandatory', 'school_hours', 'price', 'student_ratio', 'is_speciality')
                ->withTimestamps();
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function school_year()
    {
        return $this->belongsTo(SchoolYear::class);
    }
}
