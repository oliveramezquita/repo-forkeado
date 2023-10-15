<?php

namespace App\Models\Syllabi\SyllabiBP;

use App\Models\Admin\SchoolYear;
use App\Models\Syllabi\Course;
use App\Models\Syllabi\Degree;
use App\Models\Syllabi\Speciality;
use App\Models\Syllabi\Subject;
use App\Models\Syllabi\Syllabi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\DB;

class SyllabiBP extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'syllabis_blueprint';

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

    public function specialities()
    {
        return $this->belongsToMany(SpecialityBP::class, 'speciality_syllabi_blueprint', 'syllabi_id', 'speciality_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(SubjectBP::class, 'subject_syllabi_blueprint', 'syllabi_id', 'subject_id')
                ->withPivot('is_mandatory', 'school_hours', 'price', 'student_ratio', 'is_speciality')
                ->withTimestamps();
    }

    public function degree()
    {
        return $this->belongsTo(DegreeBP::class);
    }

    public function course()
    {
        return $this->belongsTo(CourseBP::class);
    }

    /**
     * duplicateSyllabi duplicates each syllabi, and its relations, from the fromYear to the nextYear
     */
    public static function archiveSyllabis(SchoolYear $givenYear)
    {
        try {
            DB::beginTransaction();

            $syllabi_blueprint = SyllabiBP::all(); // Aquí, obtienes todos los syllabis del año actual.

            $degreeMapping = [];
            $usedDegrees = $syllabi_blueprint->pluck('degree_id')->unique();
            foreach ($usedDegrees as $degreeId) {
                $degree = DegreeBP::find($degreeId)->toArray();
                $degree['school_year_id'] = $givenYear->id;
                $degree['archived_at'] = now();
                $archivedDegree = Degree::create($degree);
                $degreeMapping[$degreeId] = $archivedDegree->id;
            }

            $courseMapping = [];
            $usedCourses = $syllabi_blueprint->pluck('course_id')->unique();
            foreach ($usedCourses as $courseId) {
                $course = CourseBP::find($courseId)->toArray();
                $course['school_year_id'] = $givenYear->id;
                $course['archived_at'] = now();
                $archivedCourse = Course::create($course);
                $courseMapping[$courseId] = $archivedCourse->id;
            }

            $usedSubjects = collect();
            $usedSpecialities = collect();
            foreach ($syllabi_blueprint as $syllabi) {
                $usedSubjects = $usedSubjects->concat($syllabi->subjects->pluck('id'));
                $usedSpecialities = $usedSpecialities->concat($syllabi->specialities->pluck('id'));
            }
            $usedSubjects = $usedSubjects->unique();
            $usedSpecialities = $usedSpecialities->unique();

            $specialityMapping = [];
            foreach ($usedSpecialities as $specialityId) {
                $speciality = SpecialityBP::find($specialityId)->toArray();
                $speciality['school_year_id'] = $givenYear->id;
                $speciality['archived_at'] = now();
                $archivedSpeciality = Speciality::create($speciality);

                $specialityMapping[$specialityId] = $archivedSpeciality->id;
            }

            $subjectMapping = [];
            foreach ($usedSubjects as $subjectId) {
                $subject = SubjectBP::find($subjectId);
                
                // Usamos el mapeo para obtener el ID archivado correcto para speciality_id
                $archivedSubjectData = $subject->toArray();
                $archivedSubjectData['school_year_id'] = $givenYear->id;
                $archivedSubjectData['archived_at'] = now();
                if (isset($specialityMapping[$archivedSubjectData['speciality_id']])) {
                    $archivedSubjectData['speciality_id'] = $specialityMapping[$archivedSubjectData['speciality_id']];
                }

                $archivedSubject = Subject::create($archivedSubjectData);

                // Aquí es donde creamos el mapeo para las asignaturas
                $subjectMapping[$subjectId] = $archivedSubject->id;
            }

            foreach ($syllabi_blueprint as $syllabi) {
                $archivedSyllabiData = $syllabi->toArray();
                $archivedSyllabiData['degree_id'] = $degreeMapping[$archivedSyllabiData['degree_id']];
                $archivedSyllabiData['course_id'] = $courseMapping[$archivedSyllabiData['course_id']];
                $archivedSyllabiData['school_year_id'] = $givenYear->id;
                $archivedSyllabiData['archived_at'] = now();
                $archivedSyllabi = Syllabi::create($archivedSyllabiData);
                
                // Archivar la relación entre Especialidades y Plan de Estudios
                $originalSpecialityIds = $syllabi->specialities->pluck('id')->toArray();
                $archivedSpecialityIds = array_map(function($id) use ($specialityMapping) {
                    return $specialityMapping[$id];
                }, $originalSpecialityIds);
                $archivedSyllabi->specialities()->attach($archivedSpecialityIds);
                            
                // Archivar la relación entre Asignaturas y Plan de Estudios
                foreach ($syllabi->subjects as $subject) {
                    $pivotData = $subject->pivot->toArray();
                    $archivedSubjectId = $subjectMapping[$subject->id];  // Asumiendo que tienes un mapeo similar para subjects (es decir, $subjectMapping)
                    $archivedSyllabi->subjects()->attach($archivedSubjectId, [
                        'is_mandatory' => $pivotData['is_mandatory'],
                        'school_hours' => $pivotData['school_hours'],
                        'price' => $pivotData['price'],
                        'student_ratio' => $pivotData['student_ratio'],
                        'is_speciality' => $pivotData['is_speciality'],
                    ]);
                }
            }
    
            DB::commit();

            Log::info('Syllabis for the school year ' . $givenYear->year . ' have been successfully archived.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('An error occurred while archiving syllabis for the school year ' . $givenYear->year . ': ' . $e->getMessage());
        }
    }
}
