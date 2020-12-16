<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'telp' => 'required',
            'role' => 'required',
            'password' => 'required|string|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
            // return $validator;
        }
        
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'telp' => $request->telp,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);

        if($user->save()){
            return response()->json(['msg'=> '0', 'items' => $user]);
        }else{
            return response()->json(['msg'=> '1', 'error' => 'Gagal Register!']);
        }
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    // public function signup(Request $request){
    //     $nama = $request->input('nama');
    //     $email = $request->input('email');
    //     $no_hp = $request->input('no_hp');
    //     $role = $request->input('role');
    //     $password = $request->input('password');
    //     $confirm_password = $request->input('confirm_password');
    //     $status = false;
    //     if($password == $confirm_password){
    //         $status = true;
    //     }else{
    //         return response()->json(['msg'=>'1', 'error'=>'Konfirmasi password berbeda']);
    //     }
    //     if($status==true){
    //         $data = new User();
    //         $data->name = $nama;
    //         $data->email = $email;
    //         $data->password = bcrypt($password);
    //         $data->telp = $no_hp;
    //         $data->role = $role;
    //         if($data->save()){
    //             return response()->json(['msg'=>'0', 'items'=>$data]);
    //         }else{
    //             return response()->json(['msg'=>'1', 'error'=>'Gagal Sign Up']);
    //         }
    //     }
    // }

    // public function login(Request $request){
    //     $email = $request->input('email');
    //     $password = $request->input('password');
        
    //     if(Auth::attempt(['email'=>$email, 'password'=>$password])){
    //         $user = Auth::user();
    //         $success['token'] =  $user->createToken('nApp')->accessToken;
    //         $data = User::dataLogin(Auth::user()->id);
    //         return response()->json(['msg'=>'0', 'items'=>$data]);
    //     }else{
    //         return response()->json(['msg'=>'1', 'error'=>'Gagal Login']);
    //     }
    // }

    // public function logout(){
    //     if(Auth::check()){
    //         return 'ada';
    //     }
    // }
}
