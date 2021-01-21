<?php

namespace App\Http\Controllers;

use App\KelolaData;
use App\KelolaDataCrop;
use App\PlantTypeModel;
use App\GeneralIdentModel;
use App\SymptomNameModel;
use App\DetailRawData;
use Auth;
use File;
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
        $data = KelolaData::select('*')->where('userID', $id)->latest()->get();
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
        if($request->input('tmp_plant') == "03"){
            $plant = "Other - ". $request->input('other_plant');
            if($request->input('tmp_general') == '0105' || $request->input('tmp_general') == '0205' || $request->input('tmp_general') == '0305'){
                $general = "Other - ". $request->input('other_general');
                if($request->input('tmp_symptom') == '0101006' || $request->input('tmp_symptom') == '0102006' || $request->input('tmp_symptom') == '0105001' || 
                $request->input('tmp_symptom') == '0201006' || $request->input('tmp_symptom') == '0202006' || $request->input('tmp_symptom') == '0205001' || 
                $request->input('tmp_symptom') == '0301008' || $request->input('tmp_symptom') == '0302008' || $request->input('tmp_symptom') == '0305001'){
                    $symptom = "Other - ". $request->input('other_symptom');
                }else{
                    $symptom = SymptomNameModel::select('nama_symptom_name')->where('id', intval($request->symptomname))->value('nama_symptom_name');
                }
            }else{
                $general = GeneralIdentModel::select('nama_general_ident')->where('id', intval($request->generalident))->value('nama_general_ident');
                if($request->input('tmp_symptom') == '0101006' || $request->input('tmp_symptom') == '0102006' || $request->input('tmp_symptom') == '0105001' || 
                $request->input('tmp_symptom') == '0201006' || $request->input('tmp_symptom') == '0202006' || $request->input('tmp_symptom') == '0205001' || 
                $request->input('tmp_symptom') == '0301008' || $request->input('tmp_symptom') == '0302008' || $request->input('tmp_symptom') == '0305001'){
                    $symptom = "Other - ". $request->input('other_symptom');
                }else{
                    $symptom = SymptomNameModel::select('nama_symptom_name')->where('id', intval($request->symptomname))->value('nama_symptom_name');
                }
            }
        } else{
            $plant = PlantTypeModel::select('nama_plant_type')->where('id', $request->planttype)->value('nama_plant_type');
            if($request->input('tmp_general') == '0105' || $request->input('tmp_general') == '0205' || $request->input('tmp_general') == '0305'){
                $general = "Other - ". $request->input('other_general');
                if($request->input('tmp_symptom') == '0101006' || $request->input('tmp_symptom') == '0102006' || $request->input('tmp_symptom') == '0105001' || 
                $request->input('tmp_symptom') == '0201006' || $request->input('tmp_symptom') == '0202006' || $request->input('tmp_symptom') == '0205001' || 
                $request->input('tmp_symptom') == '0301008' || $request->input('tmp_symptom') == '0302008' || $request->input('tmp_symptom') == '0305001'){
                    $symptom = "Other - ". $request->input('other_symptom');
                }else{
                    $symptom = SymptomNameModel::select('nama_symptom_name')->where('id', intval($request->symptomname))->value('nama_symptom_name');
                }
            }else{
                $general = GeneralIdentModel::select('nama_general_ident')->where('id', intval($request->generalident))->value('nama_general_ident');
                if($request->input('tmp_symptom') == '0101006' || $request->input('tmp_symptom') == '0102006' || $request->input('tmp_symptom') == '0105001' || 
                $request->input('tmp_symptom') == '0201006' || $request->input('tmp_symptom') == '0202006' || $request->input('tmp_symptom') == '0205001' || 
                $request->input('tmp_symptom') == '0301008' || $request->input('tmp_symptom') == '0302008' || $request->input('tmp_symptom') == '0305001'){
                    $symptom = "Other - ". $request->input('other_symptom');
                }else{
                    $symptom = SymptomNameModel::select('nama_symptom_name')->where('id', intval($request->symptomname))->value('nama_symptom_name');
                }
            }
        }

        if($files = $request->file('images')){
            foreach($files as $file){
                $userid = Auth::user()->id;
                $lastupdateby = Auth::user()->id;
                $planttype= $plant;
                $plantorgan=$request->input('plantorgan');
                $generalident= $general;
                $symptomname= $symptom;
                $imagecomment=$request->input('imagecomment');
                $name = uniqid() . '_' . $planttype . '_' .$plantorgan . '_' .$generalident . '_' .$symptomname . '.' . $file->getClientOriginalExtension();
                $file->move('images/',$name);
                $status = "Uncropped & Unverified";
    
                $data= new KelolaData();
                $data->userID = $userid;
                $data->plantType = $planttype;
                $data->plantOrgan = $plantorgan;
                $data->generalIdent = $generalident;
                $data->symptomName = $symptomname;
                $data->ImageURL = 'http://storeit.ganesalens.id/public/images/'.$name;
                $data->ImageComment = $imagecomment;
                $data->lastUpdateBy = $lastupdateby;
                $data->status = $status;
                $data->save();

                $data4 = KelolaData::select('imageID')->where('userID', $userid)->latest()->first();
                \DetailRawData::addToHistory($data4->imageID,'Data ditambahkan');
                //print_r($files);
            }
        }

        \LogActivity::addToLog('Menambahkan data Tanaman');
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
        $data_temp = KelolaDataCrop::select('ImageURL')->where('imageID_raw', $id)->latest()->first();
        if($data_temp != null){
            $data4 = $data_temp;
        }else{
            $data4 = "Data belum pernah dicrop";
        }
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
        $data_temp = KelolaDataCrop::select('ImageURL')->where('imageID_raw', $id)->latest()->first();
        if($data_temp != null){
            $data4 = $data_temp;
        }else{
            $data4 = "Data belum pernah dicrop";
        }
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
        \DetailRawData::addToHistory($id, 'Data diubah');

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
        \DetailRawData::addToHistory($id, 'Data diubah');

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
        $gambar = KelolaData::where('imageID',$id)->first();
        File::delete('images/'.$gambar->ImageURL);
    
        KelolaData::find($id)->delete();
        \LogActivity::addToLog('Menghapus data Tanaman');
        return redirect('tanaman-data/index');
    }

    public function destroy_all($id)
    {
        $gambar = KelolaData::where('imageID',$id)->first();
        File::delete('images/'.$gambar->ImageURL);
        
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
        $data->ImageURL = 'http://storeit.ganesalens.id/public/upload/'.$temp;
        $data->croppedBy = $user_id;
        $data->lastUpdatedBy = $user_id;
        $data->save();

        \LogActivity::addToLog('Melakukan crop data Tanaman');
        \DetailRawData::addToHistory($id, 'Data dicrop');
        
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
        $data->ImageURL = 'http://storeit.ganesalens.id/public/upload/'.$temp;
        $data->croppedBy = $user_id;
        $data->lastUpdatedBy = $user_id;
        $data->save();

        \LogActivity::addToLog('Melakukan crop data Tanaman milik user lain');
        \DetailRawData::addToHistory($id, 'Data dicrop');

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
        \DetailRawData::addToHistory($temp1->imageID,'Status diubah menjadi verified');

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
        \DetailRawData::addToHistory($temp1->imageID,'Status diubah menjadi unverified');

        $data->save();
        return redirect('tanaman-data/index_all');
    }

    public function riwayat($id)
    {
        $data = DetailRawData::dataHistory($id);
        return view('tanaman.tanaman-data.list_riwayat')
        ->with('data', $data)
        ->with('id', $id);
    }

    public function riwayat_all($id)
    {
        $data = DetailRawData::dataHistory($id);
        return view('tanaman.tanaman-data.list_riwayat_all')
        ->with('data', $data)
        ->with('id', $id);
    }

    public function caridata(Request $request)
    {
        $id = Auth::user()->id;

        if($request->planttype != "- Pilih -"){
            if($request->plantorgan != "- Pilih -"){
                if($request->generalident != "- Pilih -"){
                    if($request->symptomname != "- Pilih -"){
                        //print_r("1111");
                        $data = KelolaData::select('*')->where('userID', $id)
                        ->where('plantType', 'like', '%'.$request->planttype.'%')
                        ->where('plantOrgan', 'like', '%'.$request->plantorgan.'%')
                        ->where('generalIdent', 'like', '%'.$request->generalident.'%')
                        ->where('symptomName', 'like', '%'.$request->symptomname.'%')
                        ->latest()->get();
                    }else{
                        //print_r("1110");
                        $data = KelolaData::select('*')->where('userID', $id)
                        ->where('plantType', 'like', '%'.$request->planttype.'%')
                        ->where('plantOrgan', 'like', '%'.$request->plantorgan.'%')
                        ->where('generalIdent', 'like', '%'.$request->generalident.'%')
                        ->latest()->get();
                    }
                }else{
                    if($request->symptomname != "- Pilih -"){
                        //print_r("1101");
                        $data = KelolaData::select('*')->where('userID', $id)
                        ->where('plantType', 'like', '%'.$request->planttype.'%')
                        ->where('plantOrgan', 'like', '%'.$request->plantorgan.'%')
                        ->where('symptomName', 'like', '%'.$request->symptomname.'%')
                        ->latest()->get();
                    }else{
                        //print_r("1100");
                        $data = KelolaData::select('*')->where('userID', $id)
                        ->where('plantType', 'like', '%'.$request->planttype.'%')
                        ->where('plantOrgan', 'like', '%'.$request->plantorgan.'%')
                        ->latest()->get();
                    }
                }
            }else{
                if($request->generalident != "- Pilih -"){
                    if($request->symptomname != "- Pilih -"){
                        //print_r("1011");
                        $data = KelolaData::select('*')->where('userID', $id)
                        ->where('plantType', 'like', '%'.$request->planttype.'%')
                        ->where('generalIdent', 'like', '%'.$request->generalident.'%')
                        ->where('symptomName', 'like', '%'.$request->symptomname.'%')
                        ->latest()->get();
                    }else{
                        //print_r("1010");
                        $data = KelolaData::select('*')->where('userID', $id)
                        ->where('plantType', 'like', '%'.$request->planttype.'%')
                        ->where('generalIdent', 'like', '%'.$request->generalident.'%')
                        ->latest()->get();
                    }
                }else{
                    if($request->symptomname != "- Pilih -"){
                        //print_r("1001");
                        $data = KelolaData::select('*')->where('userID', $id)
                        ->where('plantType', 'like', '%'.$request->planttype.'%')
                        ->where('symptomName', 'like', '%'.$request->symptomname.'%')
                        ->latest()->get();
                    }else{
                        //print_r("1000");
                        $data = KelolaData::select('*')->where('userID', $id)
                        ->where('plantType', 'like', '%'.$request->planttype.'%')
                        ->latest()->get();
                    }
                }
            }
        }else{
            if($request->plantorgan != "- Pilih -"){
                if($request->generalident != "- Pilih -"){
                    if($request->symptomname != "- Pilih -"){
                        //print_r("0111");
                        $data = KelolaData::select('*')->where('userID', $id)
                        ->where('plantOrgan', 'like', '%'.$request->plantorgan.'%')
                        ->where('generalIdent', 'like', '%'.$request->generalident.'%')
                        ->where('symptomName', 'like', '%'.$request->symptomname.'%')
                        ->latest()->get();
                    }else{
                        //print_r("0110");
                        $data = KelolaData::select('*')->where('userID', $id)
                        ->where('plantOrgan', 'like', '%'.$request->plantorgan.'%')
                        ->where('generalIdent', 'like', '%'.$request->generalident.'%')
                        ->latest()->get();
                    }
                }else{
                    if($request->symptomname != "- Pilih -"){
                        //print_r("0101");
                        $data = KelolaData::select('*')->where('userID', $id)
                        ->where('plantOrgan', 'like', '%'.$request->plantorgan.'%')
                        ->where('symptomName', 'like', '%'.$request->symptomname.'%')
                        ->latest()->get();
                    }else{
                        //print_r("0100");
                        $data = KelolaData::select('*')->where('userID', $id)
                        ->where('plantOrgan', 'like', '%'.$request->plantorgan.'%')
                        ->latest()->get();
                    }
                }
            }else{
                if($request->generalident != "- Pilih -"){
                    if($request->symptomname != "- Pilih -"){
                        //print_r("0011");
                        $data = KelolaData::select('*')->where('userID', $id)
                        ->where('generalIdent', 'like', '%'.$request->generalident.'%')
                        ->where('symptomName', 'like', '%'.$request->symptomname.'%')
                        ->latest()->get();
                    }else{
                        //print_r("0010");
                        $data = KelolaData::select('*')->where('userID', $id)
                        ->where('generalIdent', 'like', '%'.$request->generalident.'%')
                        ->latest()->get();
                    }
                }else{
                    if($request->symptomname != "- Pilih -"){
                        //print_r("0001");
                        $data = KelolaData::select('*')->where('userID', $id)
                        ->where('symptomName', 'like', '%'.$request->symptomname.'%')
                        ->latest()->get();
                    }else{
                        //print_r("0000");
                        $data = KelolaData::select('*')->where('userID', $id)
                        ->latest()->get();
                    }
                }       
            }
        }
        
        return view('tanaman.tanaman-data.list_data')
        ->with('data', $data);
    }

    public function caridata_all(Request $request)
    {
        // $temp = "Tom";
        // $data = KelolaData::select('*')
        // ->where('plantType', 'like', '%'.$temp.'%')
        // ->get();
        // print_r($data);

        if($request->planttype != "- Pilih -"){
            if($request->plantorgan != "- Pilih -"){
                if($request->generalident != "- Pilih -"){
                    if($request->symptomname != "- Pilih -"){
                        //print_r("1111");
                        $data = KelolaData::select('*')
                        ->where('plantType', 'like', '%'.$request->planttype.'%')
                        ->where('plantOrgan', 'like', '%'.$request->plantorgan.'%')
                        ->where('generalIdent', 'like', '%'.$request->generalident.'%')
                        ->where('symptomName', 'like', '%'.$request->symptomname.'%')
                        ->latest()->get();
                    }else{
                        //print_r("1110");
                        $data = KelolaData::select('*')
                        ->where('plantType', 'like', '%'.$request->planttype.'%')
                        ->where('plantOrgan', 'like', '%'.$request->plantorgan.'%')
                        ->where('generalIdent', 'like', '%'.$request->generalident.'%')
                        ->latest()->get();
                    }
                }else{
                    if($request->symptomname != "- Pilih -"){
                        //print_r("1101");
                        $data = KelolaData::select('*')
                        ->where('plantType', 'like', '%'.$request->planttype.'%')
                        ->where('plantOrgan', 'like', '%'.$request->plantorgan.'%')
                        ->where('symptomName', 'like', '%'.$request->symptomname.'%')
                        ->latest()->get();
                    }else{
                        //print_r("1100");
                        $data = KelolaData::select('*')
                        ->where('plantType', 'like', '%'.$request->planttype.'%')
                        ->where('plantOrgan', 'like', '%'.$request->plantorgan.'%')
                        ->latest()->get();
                    }
                }
            }else{
                if($request->generalident != "- Pilih -"){
                    if($request->symptomname != "- Pilih -"){
                        //print_r("1011");
                        $data = KelolaData::select('*')
                        ->where('plantType', 'like', '%'.$request->planttype.'%')
                        ->where('generalIdent', 'like', '%'.$request->generalident.'%')
                        ->where('symptomName', 'like', '%'.$request->symptomname.'%')
                        ->latest()->get();
                    }else{
                        //print_r("1010");
                        $data = KelolaData::select('*')
                        ->where('plantType', 'like', '%'.$request->planttype.'%')
                        ->where('generalIdent', 'like', '%'.$request->generalident.'%')
                        ->latest()->get();
                    }
                }else{
                    if($request->symptomname != "- Pilih -"){
                        //print_r("1001");
                        $data = KelolaData::select('*')
                        ->where('plantType', 'like', '%'.$request->planttype.'%')
                        ->where('symptomName', 'like', '%'.$request->symptomname.'%')
                        ->latest()->get();
                    }else{
                        //print_r("1000");
                        $data = KelolaData::select('*')
                        ->where('plantType', 'like', '%'.$request->planttype.'%')
                        ->latest()->get();
                    }
                }
            }
        }else{
            if($request->plantorgan != "- Pilih -"){
                if($request->generalident != "- Pilih -"){
                    if($request->symptomname != "- Pilih -"){
                        //print_r("0111");
                        $data = KelolaData::select('*')
                        ->where('plantOrgan', 'like', '%'.$request->plantorgan.'%')
                        ->where('generalIdent', 'like', '%'.$request->generalident.'%')
                        ->where('symptomName', 'like', '%'.$request->symptomname.'%')
                        ->latest()->get();
                    }else{
                        //print_r("0110");
                        $data = KelolaData::select('*')
                        ->where('plantOrgan', 'like', '%'.$request->plantorgan.'%')
                        ->where('generalIdent', 'like', '%'.$request->generalident.'%')
                        ->latest()->get();
                    }
                }else{
                    if($request->symptomname != "- Pilih -"){
                        //print_r("0101");
                        $data = KelolaData::select('*')
                        ->where('plantOrgan', 'like', '%'.$request->plantorgan.'%')
                        ->where('symptomName', 'like', '%'.$request->symptomname.'%')
                        ->latest()->get();
                    }else{
                        //print_r("0100");
                        $data = KelolaData::select('*')
                        ->where('plantOrgan', 'like', '%'.$request->plantorgan.'%')
                        ->latest()->get();
                    }
                }
            }else{
                if($request->generalident != "- Pilih -"){
                    if($request->symptomname != "- Pilih -"){
                        //print_r("0011");
                        $data = KelolaData::select('*')
                        ->where('generalIdent', 'like', '%'.$request->generalident.'%')
                        ->where('symptomName', 'like', '%'.$request->symptomname.'%')
                        ->latest()->get();
                    }else{
                        //print_r("0010");
                        $data = KelolaData::select('*')
                        ->where('generalIdent', 'like', '%'.$request->generalident.'%')
                        ->latest()->get();
                    }
                }else{
                    if($request->symptomname != "- Pilih -"){
                        //print_r("0001");
                        $data = KelolaData::select('*')
                        ->where('symptomName', 'like', '%'.$request->symptomname.'%')
                        ->latest()->get();
                    }else{
                        //print_r("0000");
                        $data = KelolaData::select('*')
                        ->latest()->get();
                    }
                }       
            }
        }

        return view('tanaman.tanaman-data.list_data_all')
        ->with('data', $data);
    }

    public function reject(Request $request, $id)
    {
        $lastupdateby = Auth::user()->id;
        $imagecomment=$request->input('imagecomment');

        $data = KelolaData::where('imageID', $id)->first();
        $data->ImageComment = $imagecomment;
        $data->lastUpdateBy = $lastupdateby;
        $data->status = "Reject";

        \LogActivity::addToLog('Reject data Tanaman');
        \DetailRawData::addToHistory($id, 'Data direject');

        $data->save();
        return redirect('tanaman-data/index');
    }
}

