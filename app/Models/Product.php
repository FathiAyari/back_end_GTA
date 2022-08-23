<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
protected $guarded=[];
    public function orders()
    {
        return $this->hasMany(Orders::class,'product_id')->withDefault();
    }
    public function preorders()
    {
        return $this->hasMany(PreOrder::class,'product_id')->withDefault();
    }

}
