<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Population extends Model
{
    protected $table = 'ref01_custom_c_population';


    protected $fillable = [
        'id',
        'name',
        'created_at',
        'created_by',
        


    ];

    public function users()
    {
        return $this->hasMany(User::class, 'fk_population')->withDefault('id');
    }
    public function groupe()
    {
        return $this->belongsToMany(ConfigGroup::class);

    }

}

