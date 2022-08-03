<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Societe extends Model
{
    protected $table = 'ref01_i_gta_societe';


    protected $fillable = [
        'id',
        'name',
        'adresse',
        'user_id',
        'created_at',
        'updated_at',
        


    ];

    public function users()
    {
        return $this->belongsTo('App\Models\User','created_by')->withDefault();
    }

   

}
