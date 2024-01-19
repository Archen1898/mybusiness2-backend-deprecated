<?php

namespace App\Models;
//GLOBAL IMPORT
use App\Models\delete\InstructorSection;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

//LOCAL IMPORT


class Section extends Model
{
    use HasFactory, Uuid;

    protected $table = 'ac.sections';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'status'=>'string',
        'term_id'=>'uuid',
        'caps'=>'boolean',
        'course_id'=>'uuid',
        'session_id'=>'uuid',
        'cap'=>'integer',
        'instructor_mode_id'=>'uuid',
        'campus_id'=>'uuid',
        'starting_date'=>'datetime',
        'ending_date'=>'datetime',
        'program_id'=>'uuid',
        'cohorts'=>'string',
        'combined'=>'boolean',
        'comment'=>'string',
        'internal_note'=>'string'
    ];

//    public function instructorSections(): HasMany
//    {
//        return $this->HasMany(InstructorSection::class);
//    }
    public function meetingPatterns(): HasMany
    {
        return $this->hasMany(MeetingPattern::class);
    }
     public function term():BelongsTo
     {
         return $this->belongsTo(Term::class);
     }
}
