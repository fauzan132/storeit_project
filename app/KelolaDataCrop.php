<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class KelolaDataCrop extends Model
{
    protected $table='tb_all_crop_data';
    protected $primaryKey='imageID';
    public $incrementing =false;
    public $timestamps=true; 
    protected $fillable = [
      'imageID','imageID_raw','plantType','plantOrgan','generalIdent','symptomName','currentDate','ImageURL','ImageComment','croppedBy','lastUpdatedBy','updated_at', 'created_at'
    ];

    public static function getListDataAll($id){
      return $data = DB::table('tb_all_crop_data')
      ->join('users', 'tb_all_crop_data.croppedBy','=','users.id')
      ->select('tb_all_crop_data.*', 'users.*')
      ->where('tb_all_crop_data.imageID_raw', $id)
      ->orderBy('currentDate','DESC')
      ->get();
    }

    public static function getListDataAllInForm($id){
      return $data = DB::table('tb_all_crop_data')
      ->join('users', 'tb_all_crop_data.lastUpdatedBy','=','users.id')
      ->select('users.name' , 'users.role')
      ->where('tb_all_crop_data.imageID',$id)
      ->first();
    }

    public static function getListDataAllInForm2($id){
      return $data = DB::table('tb_all_crop_data')
      ->join('users', 'tb_all_crop_data.croppedBy','=','users.id')
      ->select('users.name' , 'users.role')
      ->where('tb_all_crop_data.imageID',$id)
      ->first();
    }
}
