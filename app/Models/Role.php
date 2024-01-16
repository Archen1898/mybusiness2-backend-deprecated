<?php

namespace App\Models;

//GLOBAL IMPORT
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

//LOCAL IMPORT
use App\Traits\Uuid;

class Role extends SpatieRole
{
    use HasFactory,Uuid;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

}
