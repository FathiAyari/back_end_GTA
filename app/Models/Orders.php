<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded=[];
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id')->withDefault();
    }
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id')->withDefault();
    }
}
