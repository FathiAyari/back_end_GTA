<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{   
    public $timestamps = false;
    protected $table = 'ref01_i_gta_planning';
    protected $fillable = [
       'id',
       'code',
       'user_id',
       'activity',
       'start_time',
       'end_time', 
       'source' ,
        'employe',
        'employee_contract',
        'employee_mat',
        'duration',
        'planning_version',
        'status',
         'created_at',
          'updated_at'
        

    ];
    public function users()
    {
        return $this->belongsTo('App\Models\User','user_id')->withDefault();
    }
    public function activites()
    {
        return $this->belongsTo('App\Models\Activite','activite')->withDefault();
    }
    public function planning_version()
    {
        return $this->hasMany('App\PlanningVersion','parent_version')->withDefault();
    }
    
}
