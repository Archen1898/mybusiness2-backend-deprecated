<?php

namespace App\Models;

//GLOBAL IMPORT
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//LOCAL IMPORT
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InstructorMeetingPattern extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_pattern_id'=>'uuid',
        'instructor_id'=>'uuid'
    ];
    public function meetingPattern():BelongsTo
    {
        return $this->belongsTo(MeetingPattern::class);
    }
    public function instructor():BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }
}
