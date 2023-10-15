<?php

namespace App\Models\Syllabi\SyllabiBP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Department;

class SubjectBP extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'subjects_blueprint';

    /**
     * Attributes to exclude from the Audit.
     *
     * @var array
     */
    protected $auditExclude = [
        'created_at',
        'updated_at'
    ];

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
        return $this->belongsTo(SpecialityBP::class);
    }

    public function syllabis()
    {
        return $this->belongsToMany(SyllabiBP::class, 'subject_syllabi_blueprint', 'subject_id', 'syllabi_id')
                ->withPivot('is_mandatory', 'school_hours', 'price', 'student_ratio', 'is_speciality')
                ->withTimestamps();
    }
}
