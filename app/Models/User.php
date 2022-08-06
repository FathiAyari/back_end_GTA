<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded=[];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        // 'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function plannings()
    {
        return $this->hasMany('App\Planning','planning_id')->withDefault();
    }
    public function planning_version()
    {
        return $this->hasMany('App\PlanningVersion','created_by')->withDefault();
    }


    public function population()
    {
        return $this->belongsTo(Population::class,'population_id')->withDefault();
    }
    public function role()
    {
        return $this->hasOne(Roles::class);
    }
}
