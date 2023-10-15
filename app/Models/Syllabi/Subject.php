<?php

namespace App\Models\Syllabi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\Admin\SchoolYear;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';

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

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

    public function syllabis()
    {
        return $this->belongsToMany(Syllabi::class, 'subject_syllabi')
                ->withPivot('is_mandatory', 'school_hours', 'price', 'student_ratio', 'is_speciality')
                ->withTimestamps();
    }

    public function school_year()
    {
        return $this->belongsTo(SchoolYear::class);
    }
}
