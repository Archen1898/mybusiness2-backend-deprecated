<?php

namespace App\Models;

//GLOBAL IMPORT
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

//LOCAL IMPORT
use App\Traits\Uuid;

class Permission extends SpatiePermission
{
    use HasFactory,Uuid;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected function getDefaultGuardName(): string { return 'api'; }
}
