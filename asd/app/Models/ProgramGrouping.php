<?php

namespace App\Models;

//GLOBAL IMPORT
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//LOCAL IMPORT
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramGrouping extends Model
{
    use HasFactory, Uuid;
    protected $table = 'ac.program_groupings';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'code'=>'string',
        'name'=>'string',
        'active'=>'boolean'
    ];
    public function program(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
