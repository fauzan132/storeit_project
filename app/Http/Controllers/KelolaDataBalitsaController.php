<?php

namespace App\Http\Controllers;

use App\KelolaData;
use App\KelolaDataCrop;
use Auth;
use Illuminate\Http\Request;

class KelolaDataBalitsaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $data = KelolaData::select('*')->where('userID', $id)->get();
        return view('expert_balitsa.balitsa-data.list_data')
        ->with('data', $data);
    }

    public function index_all()
    {
        $data = KelolaData::getListDataAll();
        return view('expert_balitsa.balitsa-data.list_data_all')
        ->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expert_balitsa.balitsa-data.form_data');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userid = Auth::user()->id;
        $lastupdateby = Auth::user()->id;
        $planttype=$request->input('planttype');
        $plantorgan=$request->input('plantorgan');
        $generalident=$request->input('generalident');
        $status=$request->input('status');
        $imagecomment=$request->input('imagecomment');
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $request->file('file')->move('images/',$filename);
        
        $data=new KelolaData();
        $data->userID = $userid;
        $data->plantType = $planttype;
        $data->plantOrgan = $plantorgan;
        $data->generalIdent = $generalident;
        $data->status = $status;
        $data->ImageURL = $filename;
        $data->ImageComment = $imagecomment;
        $data->lastUpdateBy = $lastupdateby;

        $data->save();
        return redirect('balitsa-data/index');
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
        $data2 = KelolaData::getListDataAllInUpdate($id);
        $data3 = KelolaData::getListDataAllInUpdate2($id);
        return view('expert_balitsa.balitsa-data.detail_data')
        ->with('data', $data)
        ->with('data2', $data2)
        ->with('data3', $data3);
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
        $data2 = KelolaData::getListDataAllInUpdate($id);
        return view('expert_balitsa.balitsa-data.formubah_data')
        ->with('data', $data)
        ->with('data2', $data2);
    }

    public function edit_all($id)
    {
        $data = KelolaData::find($id);
        $data2 = KelolaData::getListDataAllInUpdate($id);
        $data3 = KelolaData::getListDataAllInUpdate2($id);
        return view('expert_balitsa.balitsa-data.formubah_data_all')
        ->with('data', $data)
        ->with('data2', $data2)
        ->with('data3', $data3);
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
        $userid = $request->user_id;
        $lastupdateby = Auth::user()->id;
        $planttype=$request->input('planttype');
        $plantorgan=$request->input('plantorgan');
        $generalident=$request->input('generalident');
        $status=$request->input('status');
        $imagecomment=$request->input('imagecomment');
        $img = $request->tmp_image;
        
        $data = KelolaData::where('imageID', $id)->first();
        $data->userID = $userid;
        $data->plantType = $planttype;
        $data->plantOrgan = $plantorgan;
        $data->generalIdent = $generalident;
        $data->status = $status;
        $data->ImageURL = $img;
        $data->ImageComment = $imagecomment;
        $data->lastUpdateBy = $lastupdateby;

        $data->save();
        return redirect('balitsa-data/index');
    }

    public function update_all(Request $request, $id)
    {
        $userid = $request->user_id;
        $lastupdateby = Auth::user()->id;
        $planttype=$request->input('planttype');
        $plantorgan=$request->input('plantorgan');
        $generalident=$request->input('generalident');
        $status=$request->input('status');
        $imagecomment=$request->input('imagecomment');
        $img = $request->tmp_image;
        
        $data = KelolaData::where('imageID', $id)->first();
        $data->userID = $userid;
        $data->plantType = $planttype;
        $data->plantOrgan = $plantorgan;
        $data->generalIdent = $generalident;
        $data->status = $status;
        $data->ImageURL = $img;
        $data->ImageComment = $imagecomment;
        $data->lastUpdateBy = $lastupdateby;

        $data->save();
        return redirect('balitsa-data/index_all');
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
        return redirect('balitsa-data/index');
    }

    public function destroy_all($id)
    {
        KelolaData::find($id)->delete();
        return redirect('balitsa-data/index_all');
    }

    public function cropping($id)
    {
        $data = KelolaData::find($id);
        //print_r($data->imageID);
        return view('expert_balitsa.balitsa-data.cropper')
        ->with('data', $data);
    }

    public function upload(Request $request,$id)
    {
        $folderPath = public_path('upload/');
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $temp = uniqid() . '.png';
        $file = $folderPath . $temp;
        file_put_contents($file, $image_base64);

        $data=new KelolaDataCrop();
        $data->imageID_raw = $id;
        $data->ImageURL = $temp;
        $data->save();

        return response()->json(['success'=>'success']);
    }
}
