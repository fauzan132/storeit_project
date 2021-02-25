<?php

namespace App;

use Illuminate\Support\Carbon;
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
      ->select('tb_all_raw_data.*', 'users.role', 'users.name')
      ->orderBy('currentDate','DESC')
      ->get();
    }

    public static function getListDataAllBalitsa(){
      return $data = DB::table('tb_all_raw_data')
      ->join('users', 'tb_all_raw_data.userID','=','users.id')
      ->select('tb_all_raw_data.*', 'users.*')
      ->orWhere('tb_all_raw_data.generalIdent','Pest')
      ->orderBy('currentDate','DESC')
      ->get();
    }

    public static function getListDataAllEwindo(){
      return $data = DB::table('tb_all_raw_data')
      ->join('users', 'tb_all_raw_data.userID','=','users.id')
      ->select('tb_all_raw_data.*', 'users.*')
      ->orWhere('tb_all_raw_data.generalIdent','Disease')
      ->orderBy('currentDate','DESC')
      ->get();
    }

    public static function getListDataAllCropper($id){
      return $data = DB::table('tb_all_raw_data')
      ->join('users', 'tb_all_raw_data.userID','=','users.id')
      ->select('tb_all_raw_data.*', 'users.*')
      ->orWhere('tb_all_raw_data.cropperID', $id)
      ->orWhere('tb_all_raw_data.cropperID', null)
      ->orderBy('currentDate','DESC')
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
    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
          ->format('l, d F Y H:i');
    }

    public static function jumlahRawData($id){
      return $data = DB::table('tb_all_raw_data')
      ->select('*')
      ->where('userID', $id)
      ->count();
    }

    public static function jumlahCropRawData($id){
      return $data = DB::table('tb_all_raw_data')
      ->select('*')
      ->where('userID', $id)
      ->where('status', 'Cropped & Unverified')
      ->orWhere('status', 'Cropped & Verified')
      ->count();
    }

    public static function jumlahVerifiedRawData($id){
      return $data = DB::table('tb_all_raw_data')
      ->select('*')
      ->where('userID', $id)
      ->where('status', 'Uncropped & Verified')
      ->orWhere('status', 'Cropped & Verified')
      ->count();
    }

    public static function jumlahUncropRawData($id){
      return $data = DB::table('tb_all_raw_data')
      ->select('*')
      ->where('userID', $id)
      ->where('status', 'Uncropped & Unverified')
      ->orWhere('status', 'Uncropped & Verified')
      ->count();
    }

    public static function jumlahUnverifiedRawData($id){
      return $data = DB::table('tb_all_raw_data')
      ->select('*')
      ->where('userID', $id)
      ->where('status', 'Uncropped & Unverified')
      ->orWhere('status', 'Cropped & Unverified')
      ->count();
    }

    public static function jumlahRejectRawData($id){
      return $data = DB::table('tb_all_raw_data')
      ->select('*')
      ->where('userID', $id)
      ->where('status', 'Reject')
      ->count();
    }

    public static function jumlahCropAllData($id){
      return $data = DB::table('tb_all_crop_data')
      ->select('*')
      ->where('croppedBy', $id)
      ->count();
    }
}
