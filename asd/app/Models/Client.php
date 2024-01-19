<?php

namespace App\Models;

//GLOBAL IMPORT
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\Client as PassportClient;

//LOCAL IMPORT
use App\Traits\Uuid;

class Client extends PassportClient
{
    use Uuid;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
}
