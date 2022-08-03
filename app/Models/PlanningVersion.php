<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanningVersion extends Model
{   
    public $timestamps = false;
    protected $table = 'ref01_i_gta_planning_version';
    protected $fillable = [
       'id',
       'code',
        'start_time',
        'end_time',
        'activity',
        'status', 
        'tm' ,
        'yt',
        'employee',
        'employee_contract',
        'employee_mat',
        'created_by',
        'parent_version',
        'version_id',
         'source',
          'note'
        

    ];
    public function users()
    {
        return $this->belongsTo('App\Models\User','created_by')->withDefault();
    }
    public function activites()
    {
        return $this->belongsTo('App\Models\Activite','activity')->withDefault();
    }
    public function planning()
    {
        return $this->hasMany('App\Planning','parent_version')->withDefault();
    }
    
}
