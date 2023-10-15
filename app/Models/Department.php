<?php

namespace App\Models;

use App\Models\Admin\SchoolYear;
use App\Models\Syllabi\SyllabiBP\SubjectBP;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Syllabi\Subject;

class Department extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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

    public function inCharge()
    {
        return $this->belongsTo(User::class, 'in_charge')->withDefault('');
    }

    public function subjects_bp()
    {
        return $this->hasMany(SubjectBP::class);
    }

    public function active_subjects_bp()
    {
        return $this->hasMany(SubjectBP::class)->where('is_active', true);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function current_subjects()
    {
        $school_year = SchoolYear::getSchoolYear();
        return $this->hasMany(Subject::class)->where('school_year_id', $school_year->id);
    }
}
