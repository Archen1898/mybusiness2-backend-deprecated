<?php

namespace App\Models;

//GLOBAL IMPORT
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//LOCAL IMPORT
use App\Traits\Uuid;

class CombinedSection extends Model
{
    use HasFactory, Uuid;
    protected $table = 'ac.combined_sections';
    protected $primaryKey = 'id';
    protected $keyType = 'string';


    protected $fillable = [
        'section_id'=>'uuid'
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
