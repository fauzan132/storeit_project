<?php

namespace App\Http\Controllers;

use App\KelolaData;
use App\KelolaDataCrop;
use App\PlantTypeModel;
use App\GeneralIdentModel;
use App\SymptomNameModel;
use Auth;
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
        $id = Auth::user()->id;
        $data = KelolaData::select('*')->where('userID', $id)->get();
        return view('tanaman.tanaman-data.list_data')
        ->with('data', $data);
    }

    public function index_all()
    {
        if(Auth::user()->role == "Expert EWINDO"){
            $data = KelolaData::getListDataAllEwindo();
        } else if( Auth::user()->role == "Expert BALITSA" ){
            $data = KelolaData::getListDataAllBalitsa();
        }else{
            $data = KelolaData::getListDataAll();
        }
        
        return view('tanaman.tanaman-data.list_data_all')
        ->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $planttype = PlantTypeModel::get();
        return view('tanaman.tanaman-data.form_data')->with('planttype', $planttype);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->input('tmp_plant') == "03" && $request->input('tmp_general') == '0105' || $request->input('tmp_general') == '0205' || $request->input('tmp_general') == '0305' &&
        $request->input('tmp_symptom') == '0101006' || $request->input('tmp_symptom') == '0102006' || $request->input('tmp_symptom') == '0105001' || 
        $request->input('tmp_symptom') == '0201006' || $request->input('tmp_symptom') == '0202006' || $request->input('tmp_symptom') == '0205001' || 
        $request->input('tmp_symptom') == '0301008' || $request->input('tmp_symptom') == '0302008' || $request->input('tmp_symptom') == '0305001'){
            $plant = "Other - ". $request->input('other_plant');
            $general = "Other - ". $request->input('other_general');
            $symptom = "Other - ". $request->input('other_symptom');
        } else{
            $plant = PlantTypeModel::select('nama_plant_type')->where('id', $request->planttype)->value('nama_plant_type');
            $general = GeneralIdentModel::select('nama_general_ident')->where('id', intval($request->generalident))->value('nama_general_ident');
            $symptom = SymptomNameModel::select('nama_symptom_name')->where('id', intval($request->symptomname))->value('nama_symptom_name');
        }

        $userid = Auth::user()->id;
        $lastupdateby = Auth::user()->id;
        $planttype= $plant;
        $plantorgan=$request->input('plantorgan');
        $generalident= $general;
        $symptomname= $symptom;
        $imagecomment=$request->input('imagecomment');
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $request->file('file')->move('images/',$filename);
        $status = "Uncropped & Unverified";
        
        $data=new KelolaData();
        $data->userID = $userid;
        $data->plantType = $planttype;
        $data->plantOrgan = $plantorgan;
        $data->generalIdent = $generalident;
        $data->symptomName = $symptomname;
        $data->ImageURL = $filename;
        $data->ImageComment = $imagecomment;
        $data->lastUpdateBy = $lastupdateby;
        $data->status = $status;

        \LogActivity::addToLog('Menambahkan data Tanaman');

        $data->save();
        return redirect('tanaman-data/index');
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
        $data4 = KelolaDataCrop::select('ImageURL')->where('imageID_raw', $id)->latest()->first();
        return view('tanaman.tanaman-data.detail_data')
        ->with('data', $data)
        ->with('data2', $data2)
        ->with('data3', $data3)
        ->with('data4', $data4);
    }

    public function show_all($id)
    {
        $data = KelolaData::find($id);
        $data2 = KelolaData::getListDataAllInUpdate($id);
        $data3 = KelolaData::getListDataAllInUpdate2($id);
        $data4 = KelolaDataCrop::select('ImageURL')->where('imageID_raw', $id)->latest()->first();
        return view('tanaman.tanaman-data.detail_data_all')
        ->with('data', $data)
        ->with('data2', $data2)
        ->with('data3', $data3)
        ->with('data4', $data4);
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
        return view('tanaman.tanaman-data.formubah_data')
        ->with('data', $data)
        ->with('data2', $data2);
    }

    public function edit_all($id)
    {
        $data = KelolaData::find($id);
        $data2 = KelolaData::getListDataAllInUpdate($id);
        $data3 = KelolaData::getListDataAllInUpdate2($id);
        return view('tanaman.tanaman-data.formubah_data_all')
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
        if($request->input('tmp_plant') == null && $request->input('tmp_general') == null && $request->input('tmp_symptom') == null){
            $plant = $request->input('planttype');
            $general = $request->input('generalident');
            $symptom = $request->input('symptomname');
        } else{
            if($request->input('tmp_plant') == "03" && $request->input('tmp_general') == '0105' || $request->input('tmp_general') == '0205' || $request->input('tmp_general') == '0305' &&
            $request->input('tmp_symptom') == '0101006' || $request->input('tmp_symptom') == '0102006' || $request->input('tmp_symptom') == '0105001' || 
            $request->input('tmp_symptom') == '0201006' || $request->input('tmp_symptom') == '0202006' || $request->input('tmp_symptom') == '0205001' || 
            $request->input('tmp_symptom') == '0301008' || $request->input('tmp_symptom') == '0302008' || $request->input('tmp_symptom') == '0305001'){
                $plant = "Other - ". $request->input('other_plant');
                $general = "Other - ". $request->input('other_general');
                $symptom = "Other - ". $request->input('other_symptom');
            } else{
                $plant = PlantTypeModel::select('nama_plant_type')->where('id', $request->planttype)->value('nama_plant_type');
                $general = GeneralIdentModel::select('nama_general_ident')->where('id', intval($request->generalident))->value('nama_general_ident');
                $symptom = SymptomNameModel::select('nama_symptom_name')->where('id', intval($request->symptomname))->value('nama_symptom_name');
            }
        }

        $userid = $request->user_id;
        $lastupdateby = Auth::user()->id;
        $planttype= $plant;
        $plantorgan=$request->input('plantorgan');
        $generalident= $general;
        $symptomname=$symptom;
        $imagecomment=$request->input('imagecomment');
        $img = $request->tmp_image;
        
        $data = KelolaData::where('imageID', $id)->first();
        $data->userID = $userid;
        $data->plantType = $planttype;
        $data->plantOrgan = $plantorgan;
        $data->generalIdent = $generalident;
        $data->symptomName = $symptomname;
        $data->ImageURL = $img;
        $data->ImageComment = $imagecomment;
        $data->lastUpdateBy = $lastupdateby;

        \LogActivity::addToLog('Mengubah data Tanaman');

        $data->save();
        return redirect('tanaman-data/index');
    }

    public function update_all(Request $request, $id)
    {
        if($request->input('tmp_plant') == null && $request->input('tmp_general') == null && $request->input('tmp_symptom') == null){
            $plant = $request->input('planttype');
            $general = $request->input('generalident');
            $symptom = $request->input('symptomname');
        } else{
            if($request->input('tmp_plant') == "03" && $request->input('tmp_general') == '0105' || $request->input('tmp_general') == '0205' || $request->input('tmp_general') == '0305' &&
            $request->input('tmp_symptom') == '0101006' || $request->input('tmp_symptom') == '0102006' || $request->input('tmp_symptom') == '0105001' || 
            $request->input('tmp_symptom') == '0201006' || $request->input('tmp_symptom') == '0202006' || $request->input('tmp_symptom') == '0205001' || 
            $request->input('tmp_symptom') == '0301008' || $request->input('tmp_symptom') == '0302008' || $request->input('tmp_symptom') == '0305001'){
                $plant = "Other - ". $request->input('other_plant');
                $general = "Other - ". $request->input('other_general');
                $symptom = "Other - ". $request->input('other_symptom');
            } else{
                $plant = PlantTypeModel::select('nama_plant_type')->where('id', $request->planttype)->value('nama_plant_type');
                $general = GeneralIdentModel::select('nama_general_ident')->where('id', intval($request->generalident))->value('nama_general_ident');
                $symptom = SymptomNameModel::select('nama_symptom_name')->where('id', intval($request->symptomname))->value('nama_symptom_name');
            }
        }

        $userid = $request->user_id;
        $lastupdateby = Auth::user()->id;
        $planttype= $plant;
        $plantorgan=$request->input('plantorgan');
        $generalident= $general;
        $symptomname=$symptom;
        $imagecomment=$request->input('imagecomment');
        $img = $request->tmp_image;
        
        $data = KelolaData::where('imageID', $id)->first();
        $data->userID = $userid;
        $data->plantType = $planttype;
        $data->plantOrgan = $plantorgan;
        $data->generalIdent = $generalident;
        $data->symptomName = $symptomname;
        $data->ImageURL = $img;
        $data->ImageComment = $imagecomment;
        $data->lastUpdateBy = $lastupdateby;

        \LogActivity::addToLog('Mengubah data Tanaman milik user lain');

        $data->save();
        return redirect('tanaman-data/index_all');
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
        \LogActivity::addToLog('Menghapus data Tanaman');
        return redirect('tanaman-data/index');
    }

    public function destroy_all($id)
    {
        KelolaData::find($id)->delete();
        \LogActivity::addToLog('Menghapus data Tanaman milik user lain');
        return redirect('tanaman-data/index_all');
    }

    public function cropping($id)
    {
        $data = KelolaData::find($id);
        return view('tanaman.tanaman-data.cropper')
        ->with('data', $data);
        // $temp = KelolaDataCrop::getListDataAll($id);
        // print_r($data);
    }
    public function cropping_all($id)
    {
        $data = KelolaData::find($id);
        //print_r($data->imageID);
        return view('tanaman.tanaman-data.cropper_all')
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

        $user_id = Auth::user()->id;

        $data=new KelolaDataCrop();
        $data->imageID_raw = $id;
        $data->ImageURL = $temp;
        $data->croppedBy = $user_id;
        $data->lastUpdatedBy = $user_id;
        $data->save();

        \LogActivity::addToLog('Melakukan crop data Tanaman');
        
        //$temp = KelolaDataCrop::getListDataAll($id);
        $temp1 = KelolaData::find($id);
        if($temp1->status == "Uncropped & Unverified"){
            $status = "Cropped & Unverified";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }else if($temp1->status == "Uncropped & Verified"){
            $status = "Cropped & Verified";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }else if($temp1->status == "Cropped & Unverified"){
            $status = "Cropped & Unverified";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }else if($temp1->status == "Cropped & Verified"){
            $status = "Cropped & Verified";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }else{
            $status = "Error";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }

        return response()->json(['success'=>'success']);
    }

    public function upload_all(Request $request,$id)
    {
        $folderPath = public_path('upload/');
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $temp = uniqid() . '.png';
        $file = $folderPath . $temp;
        file_put_contents($file, $image_base64);

        $user_id = Auth::user()->id;

        $data=new KelolaDataCrop();
        $data->imageID_raw = $id;
        $data->ImageURL = $temp;
        $data->croppedBy = $user_id;
        $data->lastUpdatedBy = $user_id;
        $data->save();

        \LogActivity::addToLog('Melakukan crop data Tanaman milik user lain');

        //$temp = KelolaDataCrop::getListDataAll($id);
        $temp1 = KelolaData::find($id);
        if($temp1->status == "Uncropped & Unverified"){
            $status = "Cropped & Unverified";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }else if($temp1->status == "Uncropped & Verified"){
            $status = "Cropped & Verified";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }else if($temp1->status == "Cropped & Unverified"){
            $status = "Cropped & Unverified";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }else if($temp1->status == "Cropped & Verified"){
            $status = "Cropped & Verified";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }else{
            $status = "Error";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }

        return response()->json(['success'=>'success']);
    }

    public function verifikasi($id)
    {
        $temp1 = KelolaData::find($id);
        if($temp1->status == "Uncropped & Unverified"){
            $status = "Uncropped & Verified";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }else if($temp1->status == "Cropped & Unverified"){
            $status = "Cropped & Verified";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }else{
            $status = "Error";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }

        \LogActivity::addToLog('Mengubah status data tanaman menjadi verified');

        $data->save();
        return redirect('tanaman-data/index_all');
    }

    public function unverifikasi($id)
    {
        $temp1 = KelolaData::find($id);
        if($temp1->status == "Uncropped & Verified"){
            $status = "Uncropped & Unverified";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }else if($temp1->status == "Cropped & Verified"){
            $status = "Cropped & Unverified";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }else{
            $status = "Error";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }

        \LogActivity::addToLog('Mengubah status data tanaman menjadi unverified');

        $data->save();
        return redirect('tanaman-data/index_all');
    }
}

