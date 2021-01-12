<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SymptomNameModel extends Model
{
    protected $table='symptom_name';
    protected $primaryKey='id';
    public $incrementing =false;
    public $timestamps=false; 
    protected $fillable = [
      'id','id_general_ident','nama_symptom_name',

    ];
}
