<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class DetailRawData extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'imageID', 'user_id', 'subject', 'date', 'created_at', 'updated_at'
    ];

    public static function dataHistory($id){
        return $data = DB::table('detail_raw_datas')
        ->join('users', 'detail_raw_datas.user_id','=','users.id')
        ->select('detail_raw_datas.*', 'users.*')
        ->where('detail_raw_datas.imageID', $id)
        ->get();
    }
}
