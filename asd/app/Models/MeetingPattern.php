<?php

namespace App\Models;

//GLOBAL IMPORT
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//LOCAL IMPORT
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MeetingPattern extends Model
{
    use HasFactory, Uuid;
    protected $table = 'ac.meeting_patterns';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'day'=>'string',
        'hour'=>'string',
        'section_id'=>'uuid',
        'room_id'=>'uuid'
    ];
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
    public function instructors():BelongsToMany
    {
        return $this->belongsToMany(Instructor::class, 'ac.instructor_meeting_patterns', 'meeting_pattern_id', 'instructor_id');
    }
}
