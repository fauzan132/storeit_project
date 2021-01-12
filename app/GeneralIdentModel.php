<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralIdentModel extends Model
{
    protected $table='general_ident';
    protected $primaryKey='id';
    public $incrementing =false;
    public $timestamps=true; 
    protected $fillable = [
      'id','id_plant_type','nama_general_ident',

    ];
}
