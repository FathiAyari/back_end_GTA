<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function activities()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function planning_version()
    {
        return $this->hasMany('App\PlanningVersion', 'parent_version')->withDefault();
    }

}
