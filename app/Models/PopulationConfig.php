<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopulationConfig extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $casts = [
        'days' => 'array',

    ];

    public function  populations(){
        return $this->belongsTo(Population::class,'population_id')->withDefault();
    }
}
