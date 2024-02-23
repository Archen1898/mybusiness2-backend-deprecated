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
        'caps'=>'boolean',
        'term_id'=>'uuid',
        'course_id'=>'uuid',
        'sec_code'=>'string',
        'sec_number'=>'string',
        'cap'=>'integer',
        'instructor_mode_id'=>'uuid',
        'campus_id'=>'uuid',
        'starting_date'=>'datetime',
        'ending_date'=>'datetime',
        'program_id'=>'uuid',
        'cohorts'=>'string',
        'status'=>'string',
        'combined'=>'boolean',
        'comment'=>'string',
        'internal_note'=>'string'
    ];

    public function term():BelongsTo
    {
        return $this->belongsTo(Term::class);
    }
    public function instructorMode():BelongsTo
    {
        return $this->belongsTo(InstructorMode::class);
    }
    public function campus():BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }
    public function program():BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
    public function meetingPatterns(): HasMany
    {
        return $this->hasMany(MeetingPattern::class);
    }
}
