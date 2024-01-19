<?php

namespace App\Models;

//GLOBAL IMPORT
use App\Models\delete\MeetingPattern;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

//LOCAL IMPORT

class Room extends Model
{
    use HasFactory, Uuid;
    protected $table = 'gn.rooms';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'name'=>'string',
        'capacity'=>'integer',
        'building_id'=>'uuid',
        'active'=>'boolean'
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function meetingPatterns():HasMany
    {
        return $this->hasMany(MeetingPattern::class,['day','hour','room_id']);
    }
}
