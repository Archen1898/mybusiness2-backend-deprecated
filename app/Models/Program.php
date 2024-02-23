<?php

namespace App\Models;

//GLOBAL IMPORT
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//LOCAL IMPORT
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory, Uuid;
    protected $table = 'ac.programs';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'code'=>'string',
        'name'=>'string',
        'degree'=>'string',
        'offering'=>'string',
        'program_level_id' => 'uuid',
        'program_grouping_id' => 'uuid',
        'term_effective' => 'uuid',
        'term_discontinue' => 'uuid',
        'fte' => 'boolean',
        'active'=>'boolean'
    ];

    public function programLevel() : BelongsTo
    {
        return $this->belongsTo(ProgramLevel::class);
    }
    public function programGrouping (): BelongsTo
    {
        return $this->belongsTo(ProgramGrouping::class);
    }

    public function termEffective(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }
    public function termDiscontinue(): BelongsTo
    {
        return $this->BelongsTo(Term::class);
    }
    public function course(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
