<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlantTypeModel extends Model
{
    protected $table='plant_type';
    protected $primaryKey='id';
    public $incrementing =false;
    public $timestamps=true; 
    protected $fillable = [
      'id','nama_plant_type',

    ];
}
