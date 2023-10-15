<?php

namespace App\Models\Syllabi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\SchoolYear;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

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
        return $this->hasMany(Syllabi::class);
    }

    public function school_year()
    {
        return $this->belongsTo(SchoolYear::class);
    }
}
