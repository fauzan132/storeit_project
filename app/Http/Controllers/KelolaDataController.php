<?php

namespace App\Http\Controllers;

use App\KelolaData;
use App\KelolaDataCrop;
use App\PlantTypeModel;
use App\GeneralIdentModel;
use App\SymptomNameModel;
use App\DetailRawData;
use App\ImageHistory;
use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\User;

class KelolaDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $id = Auth::user()->id;
        $data = KelolaData::select('*')->where('userID', $id)->latest()->get();
        return view('tanaman.tanaman-data.list_data')
        ->with('data', $data);
    }
    public function index_all()
    {
        $id = Auth::user()->id;
        if(Auth::user()->role == "Expert EWINDO"){
            $data = KelolaData::getListDataAllEwindo();
        } else if( Auth::user()->role == "Expert BALITSA" ){
            $data = KelolaData::getListDataAllBalitsa();
        }else if( Auth::user()->role == "Cropper" ){
            $data = KelolaData::getListDataAllCropper($id);
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
        $temp = "Gambar yang Gagal diupload: ";
        $temp1 = "Gambar yang Berhasil diupload: ";
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

                $cek = KelolaData::select('*')->where('ImageOriginalName', $file->getClientOriginalName())->count();
                if($cek > 0){
                    $temp = $temp . $file->getClientOriginalName() . " - ";
                } else{
                    $data= new KelolaData();
                    $data->userID = $userid;
                    $data->plantType = $planttype;
                    $data->plantOrgan = $plantorgan;
                    $data->generalIdent = $generalident;
                    $data->symptomName = $symptomname;
                    $data->ImageURL = 'http://127.0.0.1:8000/images/'.$name;
                    $data->ImageOriginalName = $file->getClientOriginalName();
                    $data->ImageComment = $imagecomment;
                    $data->lastUpdateBy = $lastupdateby;
                    $data->status = $status;
                    //tambahkan if disini buat validasi duplicate gambar yg sama
                    $data->save();

                    $temp1 = $temp1 . $file->getClientOriginalName() . " - ";

                    $data4 = KelolaData::select('imageID')->where('userID', $userid)->latest()->first();
                    \DetailRawData::addToHistory($data4->imageID,'Data ditambahkan');
                    \ImageHistory::addToRiwayat($data4->imageID, $imagecomment);
                    //print_r($files);
                    }
            }
        \LogActivity::addToLog('Menambahkan data Tanaman');
        }

        if($temp != "Gambar yang Gagal diupload: " && $temp1 != "Gambar yang Berhasil diupload: "){
            return redirect('tanaman-data/index')
            ->with('error', $temp)
            ->with('success', $temp1);
        }else if($temp1 != "Gambar yang Berhasil diupload: "){
            return redirect('tanaman-data/index')
            ->with('success', $temp1);
        }else if($temp != "Gambar yang Gagal diupload: "){
            return redirect('tanaman-data/index')
            ->with('error', $temp);
        }
        

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
        $data->lastUpdateBy = $lastupdateby;
        
        if($data->ImageComment == $imagecomment){
            $data->ImageComment = $data->ImageComment;
        } else{
            $data->ImageComment = $imagecomment;
            \ImageHistory::addToRiwayat($id, $imagecomment);
        }

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
        $data->lastUpdateBy = $lastupdateby;

        if($data->ImageComment == $imagecomment){
            $data->ImageComment = $data->ImageComment;
        } else{
            $data->ImageComment = $imagecomment;
            \ImageHistory::addToRiwayat($id, $imagecomment);
        }

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
        $data->ImageURL = 'http://127.0.0.1:8000/upload/'.$temp;
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
            $status = "Reject";
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
        $data->ImageURL = 'http://127.0.0.1:8000/upload/'.$temp;
        $data->croppedBy = $user_id;
        $data->lastUpdatedBy = $user_id;
        $data->save();

        \LogActivity::addToLog('Melakukan crop data Tanaman milik user lain');
        \DetailRawData::addToHistory($id, 'Data dicrop');

        //$temp = KelolaDataCrop::getListDataAll($id);
        if(Auth::user()->role == "Cropper"){
            $data = KelolaData::where('imageID', $id)->first();
            $data->cropperID = $user_id;
            $data->save();
        }
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
            $status = "Reject";
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
            $status = "Reject";
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
        }else if($temp1->status == "Uncropped & Unverified"){
            $status = "Uncropped & Unverified";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }else if($temp1->status == "Cropped & Unverified"){
            $status = "Cropped & Unverified";
            $data = KelolaData::where('imageID', $id)->first();
            $data->status = $status;
            $data->save();
        }else{
            $status = "Reject";
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

    public function riwayat_image($id)
    {
        $data = ImageHistory::dataHistory($id);
        return view('tanaman.tanaman-data.list_riwayat_image')
        ->with('data', $data)
        ->with('id', $id);
    }

    public function riwayat_image_all($id)
    {
        $data = ImageHistory::dataHistory($id);
        return view('tanaman.tanaman-data.list_riwayat_image_all')
        ->with('data', $data)
        ->with('id', $id);
    }

    public function caridata(Request $request)
    {
        $id = Auth::user()->id;

        $data = KelolaData::query();

        if ($request->planttype != "- Pilih -") {
            $data = $data->where('plantType', 'like', '%'.$request->planttype.'%');
        }

        if ($request->plantorgan != "- Pilih -") {
            $data = $data->where('plantOrgan', 'like', '%'.$request->plantorgan.'%');
        }

        if ($request->generalident != "- Pilih -") {
            $data = $data->where('generalIdent', 'like', '%'.$request->generalident.'%');
        }

        if ($request->symptomname != "- Pilih -") {
            $data = $data->where('symptomName', 'like', '%'.$request->symptomname.'%');
        }

        if ($request->status != "- Pilih -") {
            $data = $data->where('status', 'like', '%'.$request->status.'%');
        }

        $data = $data->where('userID', $id)->get();
        return view('tanaman.tanaman-data.list_data')
        ->with('data', $data);
    }

    public function caridata_all(Request $request)
    {
        $data = KelolaData::query();

        if ($request->planttype != "- Pilih -") {
            $data = $data->where('plantType', 'like', '%'.$request->planttype.'%');
        }

        if ($request->plantorgan != "- Pilih -") {
            $data = $data->where('plantOrgan', 'like', '%'.$request->plantorgan.'%');
        }

        if ($request->generalident != "- Pilih -") {
            $data = $data->where('generalIdent', 'like', '%'.$request->generalident.'%');
        }

        if ($request->symptomname != "- Pilih -") {
            $data = $data->where('symptomName', 'like', '%'.$request->symptomname.'%');
        }

        if ($request->status != "- Pilih -") {
            $data = $data->where('status', 'like', '%'.$request->status.'%');
        }

        $data = $data->get();

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


        \ImageHistory::addToRiwayat($id, 'Reject - '.$imagecomment);
        \LogActivity::addToLog('Reject data Tanaman');
        \DetailRawData::addToHistory($id, 'Data direject');

        $data->save();
        return redirect('tanaman-data/index_all');
    }

    public function tolak($id)
    {
        $data = KelolaData::find($id);
        $data2 = KelolaData::getListDataAllInUpdate($id);
        $data3 = KelolaData::getListDataAllInUpdate2($id);
        return view('tanaman.tanaman-data.reject_data')
        ->with('data', $data)
        ->with('data2', $data2)
        ->with('data3', $data3);
    }

    public function statistik(){
        $id = Auth::user()->id;
        $data = KelolaData::jumlahRawData($id);
        $data1 = KelolaData::jumlahCropRawData($id);
        $data2 = KelolaData::jumlahVerifiedRawData($id);
        $data3 = KelolaData::jumlahUncropRawData($id);
        $data4 = KelolaData::jumlahUnverifiedRawData($id);
        $data5 = KelolaData::jumlahRejectRawData($id);
        $data6 = KelolaData::jumlahCropAllData($id);
        $user = User::orderBy('role')->get();
        return view('tanaman.tanaman-data.statistik_data')
        ->with('user', $user)
        ->with('data', $data)
        ->with('data1', $data1)
        ->with('data2', $data2)
        ->with('data3', $data3)
        ->with('data4', $data4)
        ->with('data5', $data5)
        ->with('data6', $data6);
    }

    public function statistik_cari(Request $request)
    {
        $id = Auth::user()->id;

        $user = User::orderBy('role')->get();
        $data = KelolaData::query();
        $data1 = KelolaData::query();
        $data2= KelolaData::query();
        $data3 = KelolaData::query();
        $data4 = KelolaData::query();
        $data5 = KelolaData::query();
        $data6 = KelolaDataCrop::query();

        if ($request->pengguna != "- Pilih -") {
            $data = $data->where('userID', 'like', '%'.$request->pengguna.'%');
            $data1 = $data1->where('userID', 'like', '%'.$request->pengguna.'%');
            $data2 = $data2->where('userID', 'like', '%'.$request->pengguna.'%');
            $data3 = $data3->where('userID', 'like', '%'.$request->pengguna.'%');
            $data4 = $data4->where('userID', 'like', '%'.$request->pengguna.'%');
            $data5 = $data5->where('userID', 'like', '%'.$request->pengguna.'%');
            $data6 = $data6->where('croppedBy', 'like', '%'.$request->pengguna.'%');
        }else{
            $data = $data->where('userID', 'like', '%'.$id.'%');
            $data1 = $data1->where('userID', 'like', '%'.$id.'%');
            $data2 = $data2->where('userID', 'like', '%'.$id.'%');
            $data3 = $data3->where('userID', 'like', '%'.$id.'%');
            $data4 = $data4->where('userID', 'like', '%'.$id.'%');
            $data5 = $data5->where('userID', 'like', '%'.$id.'%');
            $data6 = $data6->where('croppedBy', 'like', '%'.$id.'%');
        }

        if (!empty($request->tgl)) {
            $data = $data->where('currentDate', 'like', '%'.$request->tgl);
            $data1 = $data1->where('currentDate', 'like', '%'.$request->tgl);
            $data2 = $data2->where('currentDate', 'like', '%'.$request->tgl);
            $data3 = $data3->where('currentDate', 'like', '%'.$request->tgl);
            $data4 = $data4->where('currentDate', 'like', '%'.$request->tgl);
            $data5 = $data5->where('currentDate', 'like', '%'.$request->tgl);
            $data6 = $data6->where('currentDate', 'like', '%'.$request->tgl);
        }

        $data = $data->count();
        $data1 = $data1->where('status', 'Cropped & Unverified')->orWhere('status', 'Cropped & Verified')->count();
        $data2 = $data2->where('status', 'Uncropped & Verified')->orWhere('status', 'Cropped & Verified')->count();
        $data3 = $data3->where('status', 'Uncropped & Unverified')->orWhere('status', 'Uncropped & Verified')->count();
        $data4 = $data4->where('status', 'Cropped & Unverified')->orWhere('status', 'Uncropped & Unverified')->count();
        $data5 = $data5->where('status', 'Reject')->count();
        $data6 = $data6->count();

        return view('tanaman.tanaman-data.statistik_data')
        ->with('user', $user)
        ->with('data', $data)
        ->with('data1', $data1)
        ->with('data2', $data2)
        ->with('data3', $data3)
        ->with('data4', $data4)
        ->with('data5', $data5)
        ->with('data6', $data6);
    }
}

