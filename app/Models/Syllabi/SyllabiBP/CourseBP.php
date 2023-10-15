<?php

namespace App\Models\Syllabi\SyllabiBP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CourseBP extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'courses_blueprint';

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

    public function syllabis()
    {
        return $this->hasMany(SyllabiBP::class);
    }

    public static function allowedNamesToDict() 
    {
        return [
            '0' => 'Preparatorio',
            '1' => 'Primero',
            '2' => 'Segundo',
            '3' => 'Tercero',
            '4' => 'Cuarto',
            '5' => 'Quinto',
            '6' => 'Sexto',
            '7' => 'Séptimo',
            '8' => 'Octavo',
            '9' => 'Noveno',
            '10' => 'Décimo',
        ];
    }
}
