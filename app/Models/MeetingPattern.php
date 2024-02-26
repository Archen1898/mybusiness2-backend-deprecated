<?php

namespace App\Models;

//GLOBAL IMPORT
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

//LOCAL IMPORT
use App\Traits\Uuid;

class MeetingPattern extends Model
{
    use HasFactory, Uuid;
    protected $table = 'ac.meeting_patterns';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'day'=>'string',
        'start_time'=>'string',
        'end_time'=>'string',
        'facility_id'=>'uuid',
        'section_id'=>'uuid',
        'user_id'=>'uuid',
        'primary_instructor'=>'boolean',
    ];
    public function facility(): HasMany
    {
        return $this->hasMany(Facility::class);
    }
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
    public function user():HasMany
    {
        return $this->hasMany(User::class);
    }
}
