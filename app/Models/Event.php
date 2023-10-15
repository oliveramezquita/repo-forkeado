<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scholar\Enrollment;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

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

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public static function parseDayFromAbbreviation($abbreviatedDay)
    {
        $dayMap = [
            'LUN' => 'monday',
            'MAR' => 'tuesday',
            'MIE' => 'wednesday',
            'JUE' => 'thursday',
            'VIE' => 'friday',
            'SAB' => 'saturday',
            'DOM' => 'sunday',
        ];

        return $dayMap[$abbreviatedDay] ?? null;
    }
}
