<?php

namespace App\Models;

//GLOBAL IMPORT
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//LOCAL IMPORT
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory, Uuid;
    protected $table = 'gn.departments';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'code'=>'string',
        'name'=>'string',
        'description'=>'string',
        'college_id'=>'uuid',
        'active'=>'boolean'
    ];
    public function college():BelongsTo
    {
        return $this->belongsTo(College::class);
    }
    public function course(): HasMany
    {
        return $this->hasMany(Course::class);
    }
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
