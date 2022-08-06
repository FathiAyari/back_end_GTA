<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Population extends Model
{

protected $guarded=[];
    public function user()
    {
        return $this->hasMany(User::class, 'population_id')->withDefault('id');
    }
    public function groupe()
    {
        return $this->belongsToMany(ConfigGroup::class);

    }

}

