<?php

namespace App\Models;

use App\Models\Staff\Position;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Scholar\Enrollment;

class User extends Authenticatable implements Auditable, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use \OwenIt\Auditing\Auditable;

    /**
     * Attributes to exclude from the Audit.
     *
     * @var array
     */
    protected $auditExclude = [
        'remember_token',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'surname',
        'dni',
        'birth_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function metadata()
    {
        return $this->hasOne(Metadata::class);
    }

    public function departmentsInCharge()
    {
        return $this->hasMany(Department::class, 'in_charge');
    }

    public function guardians()
    {
        return $this->belongsToMany(User::class, 'user_guardian', 'child_id', 'guardian_id');
    }

    public function dependents()
    {
        return $this->belongsToMany(User::class, 'user_guardian', 'guardian_id', 'child_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public static function getStudents() 
    {
        return self::role('student')->get();
    }

    public static function getTeachers() 
    {
        return self::role('teacher')->get();
    }

    public function assignPosition(...$positionNames)
    {
        foreach ($positionNames as $positionName) {
            $position = Position::where('name', $positionName)->first();
    
            if (!$position) {
                // Opcionalmente puedes manejar el error aquí si la posición no se encuentra
                continue;
            }
    
            // Verifica si el usuario ya tiene esa posición
            if (!$this->positions->contains($position->id)) {
                $this->positions()->attach($position);
            }
        }
    }

    // A user belongs to many positions.
    public function positions()
    {
        if ($this->hasRole('admin') || $this->hasRole('student') || $this->hasRole('guardian') || $this->hasRole('partner')) {
            return null;
        }
        return $this->belongsToMany(Position::class, 'user_position');
    }
}
