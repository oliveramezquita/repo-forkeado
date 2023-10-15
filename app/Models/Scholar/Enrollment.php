<?php

namespace App\Models\Scholar;

use App\Models\Syllabi\Speciality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\User;
use App\Models\Event;;

class Enrollment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'enrollments';

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialities()
    {
        return $this->belongsToMany(Speciality::class, 'enrollment_speciality', 'enrollment_id', 'speciality_id');
    }

    // Given an identifier, return true if it exists in the database.
    public static function identifierExists($identifier)
    {
        return Enrollment::where('identifier', $identifier)->exists();
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
