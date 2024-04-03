<?php

namespace App\Models;

//GLOBAL IMPORT
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

//LOCAL IMPORT
use App\Traits\Uuid;

class Session extends Model
{
    use HasFactory, Uuid;
    protected $table = 'ac.sessions';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'code'=>'string',
        'active'=>'boolean'
    ];

    public function section():BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
