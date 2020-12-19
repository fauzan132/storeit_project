<?php

namespace App\Http\Controllers;

use App\KelolaData;
use App\KelolaDataCrop;
use Illuminate\Http\Request;

class KelolaDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = KelolaData::get();
        return view('admin.admin-data.list_data')
        ->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admin-data.form_data');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $planttype=$request->input('planttype');
        $plantorgan=$request->input('plantorgan');
        $generalident=$request->input('generalident');
        $status=$request->input('status');
        $imagecomment=$request->input('imagecomment');
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $request->file('file')->move('images/',$filename);
        
        $data=new KelolaData();
        $data->plantType = $planttype;
        $data->plantOrgan = $plantorgan;
        $data->generalIdent = $generalident;
        $data->status = $status;
        $data->ImageURL = $filename;
        $data->ImageComment = $imagecomment;

        $data->save();
        return redirect('admin-data/index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = KelolaData::find($id);
        return view('admin.admin-data.detail_data')
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
        $data = KelolaData::find($id);
        return view('admin.admin-data.formubah_data')
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
        $planttype=$request->input('planttype');
        $plantorgan=$request->input('plantorgan');
        $generalident=$request->input('generalident');
        $status=$request->input('status');
        $imagecomment=$request->input('imagecomment');
        $img = $request->tmp_image;
        
        $data = KelolaData::where('imageID', $id)->first();
        $data->plantType = $planttype;
        $data->plantOrgan = $plantorgan;
        $data->generalIdent = $generalident;
        $data->status = $status;
        $data->ImageURL = $img;
        $data->ImageComment = $imagecomment;

        $data->save();
        return redirect('admin-data/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        KelolaData::find($id)->delete();
        return redirect('admin-data/index');
    }

<<<<<<< HEAD
    public function cropping($id)
    {
        $data = KelolaData::find($id);
        //print_r($data->imageID);
        return view('admin.admin-data.cropper')
        ->with('data', $data);
    }

    public function upload(Request $request,$id)
    {
        $folderPath = public_path('upload/');
=======
    public function cropping()
    {
        return view('admin.admin-data.cropper');
    }

    public function upload(Request $request)
    {
        $folderPath = public_path('upload/');

>>>>>>> aadc8ec153b8a99c80f2e6e17cbec5c02373f657
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
<<<<<<< HEAD
        $temp = uniqid() . '.png';
        $file = $folderPath . $temp;
        file_put_contents($file, $image_base64);

        $data=new KelolaDataCrop();
        $data->imageID_raw = $id;
        $data->ImageURL = $temp;
        $data->save();
=======
        $file = $folderPath . uniqid() . '.png';

        file_put_contents($file, $image_base64);
>>>>>>> aadc8ec153b8a99c80f2e6e17cbec5c02373f657

        return response()->json(['success'=>'success']);
    }
}
