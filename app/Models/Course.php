<?php

namespace App\Models;

//GLOBAL IMPORT
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//LOCAL IMPORT
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    use HasFactory, Uuid;
    protected $table = 'ac.courses';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'code'=>'string',
        'references_number'=>'string', //course id of panther soft
        'name'=>'string',
        'credit'=>'float',
        'hour'=>'float',
        'description'=>'string',
        'department_id'=>'uuid',
        'program_id'=>'uuid',
        'active'=>'boolean'
    ];

    public function department():BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function program():BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
