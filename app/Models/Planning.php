<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    protected $fillable = [
        'id',
        'code',
        'user_id',
        'activity_id',
        'start_time',
        'end_time',
        'source' ,
        'employe',
        'employee_contract',
        'employee_mat',
        'duration',
        'planning_version',
        'status',



    ];
    public function users()
    {
        return $this->belongsTo(User::class,'user_id')->withDefault();
    }
    public function activities()
    {
        return $this->belongsTo(Activity::class,'activity_id')->withDefault();
    }
    public function planning_version()
    {
        return $this->hasMany('App\PlanningVersion','parent_version')->withDefault();
    }

}
