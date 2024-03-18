<?php

namespace App\Models;

//GLOBAL IMPORT
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//LOCAL IMPORT
use App\Traits\Uuid;

class InstructorMode extends Model
{
    use HasFactory, Uuid;
    protected $table = 'ac.instructor_modes';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'code'=>'string',
        'name'=>'string',
        'active'=>'boolean'
    ];


}
