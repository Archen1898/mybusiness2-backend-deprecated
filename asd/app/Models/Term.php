<?php

namespace App\Models;

//GLOBAL IMPORT
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//LOCAL IMPORT
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Term extends Model
{
    use HasFactory, Uuid;
    protected $table = 'ac.terms';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'term'=>'string',
        'semester'=>'string',
        'year'=>'integer',
        'academic_year'=>'string',
        'fiu_academic_year'=>'string',
        'description'=>'string',
        'description_short'=>'string',
        'begin_dt_for_apt'=>'datetime',
        'begin_dt'=>'datetime',
        'end_dt'=>'datetime',
        'close_end_dt'=>'datetime',
        'fas_begin_dt'=>'datetime',
        'fas_end_dt'=>'datetime',
        'session'=>'string',
        'academic_year_full'=>'string',
        'fiu_grade_date'=>'datetime',
        'fiu_grade_date_a'=>'datetime',
        'fiu_grade_date_b'=>'datetime',
        'fiu_grade_date_c'=>'datetime',
        'p180_status_term_id'=>'string',
        'active'=>'boolean'
    ];

    public function programEffective(): HasMany
    {
        return $this->hasMany(Program::class,'term_effective');
    }
    public function programDiscontinue(): HasMany
    {
        return $this->hasMany(Program::class,'term_discontinue');
    }
    public function accessPeriod():HasMany
    {
        return $this->hasMany(AccessPeriod::class);
    }
    public function section():HasMany
    {
        return $this->hasMany(Section::class);
    }
}
