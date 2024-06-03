<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name'=>'string',
        'first_name'=>'string',
        'middle_name'=>'string',
        'last_name'=>'string',
        'guest_id'=>'string',
        'visitorOfPID'=>'string',
        'student'=>'boolean',
        'email'=>'string',
        'phone_number'=> 'string',
        'password'=>'string',
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'password'=> 'hashed',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
