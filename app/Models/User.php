<?php

namespace App\Models;

//GLOBAL IMPORT
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

//LOCAL IMPORT
use App\Traits\Uuid;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPermissions,Uuid;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'=>'string',
        'user_name'=>'string',
        'first_name'=>'string',
        'last_name'=>'string',
        'middle_name'=>'string',
        'panther_id'=>'string',
        'instructor'=>'boolean',
        'student'=>'boolean',
        'email'=>'string',
        'password'=>'string',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function department():BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function meetingPattern():BelongsTo
    {
        return $this->belongsTo(MeetingPattern::class);
    }
}
