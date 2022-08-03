<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Config extends Model
{
    protected $table = 'ref01_custom_c_config';


    protected $fillable = [
        'id',
        'name',
        


    ];

    public function config_group()
    {
        return $this->belongsToMany(ConfigGroup::class);

    }

}
