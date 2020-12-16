<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KelolaData extends Model
{
    protected $table='tb_all_raw_data';
    protected $primaryKey='imageID';
    public $incrementing =false;
    public $timestamps=true; 
    protected $fillable = [
      'imageID','plantType','plantOrgan','generalIdent','status','currentDate','ImageURL','ImageComment', 'updated_at', 'created_at'
    ];
}
