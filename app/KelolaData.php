<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class KelolaData extends Model
{
    protected $table='tb_all_raw_data';
    protected $primaryKey='imageID';
    public $incrementing =false;
    public $timestamps=true; 
    protected $fillable = [
      'imageID','userID','plantType','plantOrgan','generalIdent','symptomName','currentDate','ImageURL','ImageComment','lastUpdateBy','updated_at', 'created_at'
    ];

    public static function getListData(){
      return $data = DB::table('tb_all_raw_data')
      ->select('*')
      ->get();
    }

    public static function getListDataAll(){
      return $data = DB::table('tb_all_raw_data')
      ->join('users', 'tb_all_raw_data.userID','=','users.id')
      ->select('tb_all_raw_data.*', 'users.*')
      ->get();
    }

    public static function getListDataAllBalitsa(){
      return $data = DB::table('tb_all_raw_data')
      ->join('users', 'tb_all_raw_data.userID','=','users.id')
      ->select('tb_all_raw_data.*', 'users.*')
      ->orWhere('tb_all_raw_data.generalIdent','Pest')
      ->get();
    }

    public static function getListDataAllEwindo(){
      return $data = DB::table('tb_all_raw_data')
      ->join('users', 'tb_all_raw_data.userID','=','users.id')
      ->select('tb_all_raw_data.*', 'users.*')
      ->orWhere('tb_all_raw_data.generalIdent','Disease')
      ->get();
    }

    public static function getListDataAllById($id){
      return $data = DB::table('tb_all_raw_data')
      ->join('users', 'tb_all_raw_data.userID','=','users.id')
      ->select('tb_all_raw_data.*', 'users.*')
      ->where('tb_all_raw_data.imageID',$id)
      ->get();
    }

    public static function getListDataAllInUpdate($id){
      return $data = DB::table('tb_all_raw_data')
      ->join('users', 'tb_all_raw_data.lastUpdateBy','=','users.id')
      ->select('users.name' , 'users.role')
      ->where('tb_all_raw_data.imageID',$id)
      ->first();
    }

    public static function getListDataAllInUpdate2($id){
      return $data = DB::table('tb_all_raw_data')
      ->join('users', 'tb_all_raw_data.userID','=','users.id')
      ->select('users.name' , 'users.role')
      ->where('tb_all_raw_data.imageID',$id)
      ->first();
    }

    public static function getListDataHeader($id){
      return $data = DB::table('tb_all_raw_data')
      ->join('users', 'tb_all_raw_data.userID','=','users.id')
      ->select('tb_all_raw_data.*', 'users.*')
      ->where('tb_all_raw_data.imageID', $id)
      ->first();
    }
}
