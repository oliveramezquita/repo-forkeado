<?php

namespace App\Models\Admin;

use App\Models\Syllabi\Course;
use App\Models\Syllabi\Degree;
use App\Models\Syllabi\Speciality;
use App\Models\Syllabi\Subject;
use App\Models\Syllabi\Syllabi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SchoolYear extends Model implements Auditable
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
    ];

    public function syllabis()
    {
        return $this->hasMany(Syllabi::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function degrees()
    {
        return $this->hasMany(Degree::class);
    }

    public function specialities()
    {
        return $this->hasMany(Speciality::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    /**
     * Get the active SchoolYear
     */
    public static function getSchoolYear()
    {
        return SchoolYear::where('is_active', true)->first();
    }

    /**
     * Get the school year's active, next school year if it's not null
     */
    public static function getNextSchoolYear()
    {
        $activeSchoolYear = SchoolYear::where('is_active', true)->first();
        $nextSchoolYear = null;

        try {
            $nextSchoolYear = SchoolYear::where('start_year', $activeSchoolYear->end_year)->first();
        }
        catch (\Exception $e) {
            // Do nothing
        }

        return $nextSchoolYear;
    }

    /**
     * Create ScholarYear, creates the current schol year if it doesnt exist
     */
    public static function createScholarYear($current_enrollment_year)
    {
        try {
            SchoolYear::create([
                'start_year' => $current_enrollment_year,
                'end_year' => $current_enrollment_year+1,
                'is_active' => true,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al crear el año escolar actual.');
        }

        return;
    }

    /**
     * Create nextScholarYear, creates the next schol year if it doesnt exist
     */
    public static function createNextScholarYear()
    {
        $activeSchoolYear = SchoolYear::getSchoolYear();

        try {
            SchoolYear::create([
                'start_year' => $activeSchoolYear->end_year,
                'end_year' => $activeSchoolYear->end_year + 1,
                'is_active' => false,
            ]);
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors('Error al crear el próxmo año escolar.');
        }

        return;
    }
}
