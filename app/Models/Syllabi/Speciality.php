<?php

namespace App\Models\Syllabi;

use App\Models\Scholar\Enrollment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\SchoolYear;

class Speciality extends Model
{
    use HasFactory;

    protected $table = 'specialities';

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

    public function syllabis()
    {
        return $this->belongsToMany(Syllabi::class, 'speciality_syllabi');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function school_year()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function enrollments()
    {
        return $this->belongsToMany(Enrollment::class, 'enrollment_speciality', 'speciality_id', 'enrollment_id');
    }
}
