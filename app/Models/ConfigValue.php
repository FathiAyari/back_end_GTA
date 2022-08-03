<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigValue extends Model
{
    protected $table = 'ref01_custom_c_config_value';


    protected $fillable = [
        'id',
        'config',
        'group',
        'value',
        


    ];


}

