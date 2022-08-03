<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    protected $table = 'ref01_i_gta_activity';


    protected $fillable = [
        'id',
        'name',
        'description',
        'type',
        'code',
        'color',
        'created_at',
        'created_by',
        


    ];

    public function users()
    {
        return $this->belongsTo('App\Models\User','created_by')->withDefault();
    }

    public function plannings()
    {
        return $this->hasMany('App\Planning', 'planning_id')->withDefault('id');
    }
    public function planning_version()
    {
        return $this->hasMany('App\PlanningVersion', 'activity')->withDefault('id');
    }

}
