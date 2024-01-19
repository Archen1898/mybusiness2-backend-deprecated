<?php

namespace App\Models;

//GLOBAL IMPORT
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//LOCAL IMPORT
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Instructor extends Model
{
    use HasFactory, Uuid;
    protected $table = 'ac.instructors';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'user_id'=>'uuid',
        'primary_instructor'=>'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function meetingPatterns():BelongsToMany
    {
        return $this->belongsToMany(MeetingPattern::class, 'ac.instructor_meeting_patterns', 'instructor_id', 'meeting_pattern_id');
    }
}
