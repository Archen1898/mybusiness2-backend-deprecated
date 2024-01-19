<?php

namespace App\Models;

//GLOBAL IMPORT
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//LOCAL IMPORT
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccessPeriod extends Model
{
    use HasFactory, Uuid;
    protected $table = 'ac.access_periods';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'term_id'=>'uuid',
        'admin_beginning_date'=>'datetime',
        'admin_ending_date'=>'datetime',
        'admin_cancel_section_date'=>'datetime',
        'depart_beginning_date'=>'datetime',
        'depart_ending_date'=>'datetime'
    ];

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

}
