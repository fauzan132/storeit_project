<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;

class AuthController extends Controller
{
    public function signup(Request $request){
        $nama = $request->input('nama');
        $email = $request->input('email');
        $no_hp = $request->input('no_hp');
        $role = $request->input('role');
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');
        $status = false;
        if($password == $confirm_password){
            $status = true;
        }else{
            return response()->json(['msg'=>'1', 'error'=>'Konfirmasi password berbeda']);
        }
        if($status==true){
            $data = new User();
            $data->name = $nama;
            $data->email = $email;
            $data->password = bcrypt($password);
            $data->telp = $no_hp;
            $data->role = $role;
            if($data->save()){
                return response()->json(['msg'=>'0', 'items'=>$data]);
            }else{
                return response()->json(['msg'=>'1', 'error'=>'Gagal Sign Up']);
            }
        }
    }

    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        
        if(Auth::attempt(['email'=>$email, 'password'=>$password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('nApp')->accessToken;
            $data = User::dataLogin(Auth::user()->id);
            return response()->json(['msg'=>'0', 'items'=>$data]);
        }else{
            return response()->json(['msg'=>'1', 'error'=>'Gagal Login']);
        }
    }

    public function logout(){
        if(Auth::check()){
            return 'ada';
        }
        // if(Auth::destroy()){
        //     return response()->json(['msg'=>'0', 'success'=>'Berhasil Logout']);
        // }else{
        //     return response()->json(['msg'=>'1', 'error'=>'Gagal Logout']);
        // }
    }
}
