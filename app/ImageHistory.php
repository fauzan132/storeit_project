<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ImageHistory extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'imageID', 'user_id', 'comment', 'date', 'created_at', 'updated_at'
    ];

    public static function dataHistory($id){
        return $data = DB::table('image_histories')
        ->join('users', 'image_histories.user_id','=','users.id')
        ->select('image_histories.*', 'users.*')
        ->where('image_histories.imageID', $id)
        ->get();
    }
}
