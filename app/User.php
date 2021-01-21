<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'telp', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function dataLogin($id){
        return $data = DB::table('users')
        ->select('name', 'email', 'telp', 'role')
        ->where('id', $id)
        ->get();
    }

    public static function dataLog(){
        return $data = DB::table('log_activities')
        ->join('users', 'log_activities.user_id','=','users.id')
        ->select('log_activities.*', 'users.*')
        ->orderBy('date', 'DESC')
        ->get();
    }
}
