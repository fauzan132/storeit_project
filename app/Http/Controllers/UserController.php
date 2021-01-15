<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();
        return view('user.list')
        ->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.form_tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request data
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            //'password_confirmation' => 'required|same:password',
            'telp' => 'required',
            'role' => 'required'
        ]);
        // save into table
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'telp' => $request->telp,
            'role' => $request->role
        ]);
        // redirect to home
        \LogActivity::addToLog('Menambahkan data user');

        return redirect('admin/user/index')
        ->with(['success' => 'User berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::find($id);
        return view('user.detail')
        ->with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::find($id);
        return view('user.form_ubah')
        ->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = User::where('id', $id)->first();
        $data->telp =  $request->telp;
        $data->role =  $request->role;
        \LogActivity::addToLog('Mengubah data user');
   		if($data->save()){
            return redirect('admin/user/index')
            ->with(['success' => 'Data user berhasil diubah']);
        }else{
            return redirect('admin/user/index')
            ->with(['error' => 'Data user gagal diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        \LogActivity::addToLog('Menghapus data user');
        return redirect('admin/user/index');
    }

    public function profile()
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        return view('user.profile')
        ->with('data', $data);
    }

    public function edit_profile($id)
    {
        $data = User::find($id);
        return view('user.profile_ubah')
        ->with('data', $data);
    }

    public function ubah_profile(Request $request, $id)
    {
        $data = User::where('id', $id)->first();
        $data->name = $request->name;
        $data->telp = $request->telp;
        
   		if($data->save()){
            \LogActivity::addToLog('Mengubah data profile');
            return redirect('profile/index')
            ->with(['success' => 'Profile berhasil diubah']);
        }else{
            return redirect('profile/index')
            ->with(['error' => 'Profile gagal diubah']);
        }
    }

    public function edit_login($id)
    {
        $data = User::find($id);
        return view('user.login_ubah')
        ->with('data', $data);
    }

    public function ubah_login(Request $request, $id)
    {
        $data = User::where('id', $id)->first();
        if($data->email == $request->email){
            $this->validate($request, [
                'password' => 'required|string|min:6|confirmed'
            ]);
        }else{
            $this->validate($request, [
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed'
            ]);
        }

        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        

   		if($data->save()){
            \LogActivity::addToLog('Mengubah data login');
            return redirect('profile/index')
            ->with(['success' => 'Data Login berhasil diubah']);
        }else{
            return redirect('profile/index')
            ->with(['error' => 'Data Login gagal diubah']);
        }
    }

    public function log_activity()
    {
        $data = User::dataLog();
        return view('user.log_activity')
        ->with('data', $data);;
    }
}
