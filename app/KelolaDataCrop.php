<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KelolaDataCrop extends Model
{
    protected $table='tb_all_crop_data';
    protected $primaryKey='imageID';
    public $incrementing =false;
    public $timestamps=true; 
    protected $fillable = [
      'imageID','imageID_raw','plantType','plantOrgan','generalIdent','symptomName','status','currentDate','ImageURL','ImageComment', 'updated_at', 'created_at'
    ];
}
