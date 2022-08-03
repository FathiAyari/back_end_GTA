<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigGroup extends Model
{
    protected $table = 'ref01_custom_c_config_group';


    protected $fillable = [
        'id',
        'name',
        'applies_to',
        'applies_at',
    ];

    public function config()
    {
        return $this->belongsToMany(Config::class);

    }
    public function population()
    {
        return $this->belongsToMany(Population::class);

    }

}
