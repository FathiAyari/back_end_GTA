<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    protected $guarded=[];

    public function plannings()
    {
        return $this->hasMany(Planning::class, 'planning_id');
    }

    /*    public function users()
        {
            return $this->belongsTo('App\Models\User','created_by')->withDefault();
        }

        public function planning_version()
        {
            return $this->hasMany('App\PlanningVersion', 'activity')->withDefault('id');
        }*/

}
