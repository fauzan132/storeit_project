<?php

namespace App\Http\Controllers;

use App\KelolaData;
use App\KelolaDataCrop;
use Auth;
use App\PlantTypeModel;
use App\GeneralIdentModel;
use App\SymptomNameModel;
use Illuminate\Http\Request;

class KelolaDataCropController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function awal($id)
    {
        $data = KelolaData::getListDataHeader($id);
        $data2 = KelolaDataCrop::getListDataAll($id);
        return view('tanaman.tanaman-data.crop.list_data_crop')
        ->with('data', $data)
        ->with('data2', $data2);
    }

    public function awal_all($id)
    {
        $data = KelolaData::getListDataHeader($id);
        $data2 = KelolaDataCrop::getListDataAll($id);
        return view('tanaman.tanaman-data.crop.list_data_crop_all')
        ->with('data', $data)
        ->with('data2', $data2);
    }

    public function show($id)
    {
        $data = KelolaDataCrop::find($id);
        $data2 = KelolaDataCrop::getListDataAllInForm($id);
        $data3 = KelolaDataCrop::getListDataAllInForm2($id);
        return view('tanaman.tanaman-data.crop.detail_data_crop')
        ->with('data', $data)
        ->with('data2', $data2)
        ->with('data3', $data3);
    }

    public function show_all($id)
    {
        $data = KelolaDataCrop::find($id);
        $data2 = KelolaDataCrop::getListDataAllInForm($id);
        $data3 = KelolaDataCrop::getListDataAllInForm2($id);
        return view('tanaman.tanaman-data.crop.detail_data_crop_all')
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
        $data = KelolaDataCrop::find($id);
        $data2 = KelolaDataCrop::getListDataAllInForm($id);
        $data3 = KelolaDataCrop::getListDataAllInForm2($id);
        return view('tanaman.tanaman-data.crop.formubah_data_crop')
        ->with('data', $data)
        ->with('data3', $data3)
        ->with('data2', $data2);
    }

    public function edit_all($id)
    {
        $data = KelolaDataCrop::find($id);
        $data2 = KelolaDataCrop::getListDataAllInForm($id);
        $data3 = KelolaDataCrop::getListDataAllInForm2($id);
        return view('tanaman.tanaman-data.crop.formubah_data_crop_all')
        ->with('data', $data)
        ->with('data3', $data3)
        ->with('data2', $data2);
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

        $imageid_raw = $request->imageid_raw;
        $lastupdateby = Auth::user()->id;
        $planttype= $plant;
        $plantorgan=$request->input('plantorgan');
        $generalident= $general;
        $symptomname=$symptom;
        $imagecomment=$request->input('imagecomment');
        $img = $request->tmp_image;
        
        $data = KelolaDataCrop::where('imageID', $id)->first();
        $data->imageID_raw = $imageid_raw;
        $data->plantType = $planttype;
        $data->plantOrgan = $plantorgan;
        $data->generalIdent = $generalident;
        $data->symptomName = $symptomname;
        $data->ImageURL = $img;
        $data->ImageComment = $imagecomment;
        $data->lastUpdatedBy = $lastupdateby;

        \LogActivity::addToLog('Mengubah data crop Tanaman');

        $data->save();
        return redirect('tanaman-data/crop/awal/'. $imageid_raw);
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

        $imageid_raw = $request->imageid_raw;
        $lastupdateby = Auth::user()->id;
        $planttype= $plant;
        $plantorgan=$request->input('plantorgan');
        $generalident= $general;
        $symptomname=$symptom;
        $imagecomment=$request->input('imagecomment');
        $img = $request->tmp_image;
        
        $data = KelolaDataCrop::where('imageID', $id)->first();
        $data->imageID_raw = $imageid_raw;
        $data->plantType = $planttype;
        $data->plantOrgan = $plantorgan;
        $data->generalIdent = $generalident;
        $data->symptomName = $symptomname;
        $data->ImageURL = $img;
        $data->ImageComment = $imagecomment;
        $data->lastUpdatedBy = $lastupdateby;

        \LogActivity::addToLog('Mengubah data crop Tanaman milik user lain');

        $data->save();
        return redirect('tanaman-data/crop/awal_all/'. $imageid_raw);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gambar = KelolaDataCrop::where('imageID',$id)->first();
        File::delete('upload/'.$gambar->ImageURL);

        $image_raw = KelolaDataCrop::select('imageID_raw')->where('imageID', $id)->value('imageID_raw');
        KelolaDataCrop::find($id)->delete();
        \LogActivity::addToLog('Mengahpus data crop Tanaman');
        return redirect('tanaman-data/crop/awal/'. $image_raw);
    }

    public function destroy_all($id)
    {
        $gambar = KelolaDataCrop::where('imageID',$id)->first();
        File::delete('upload/'.$gambar->ImageURL);

        $image_raw = KelolaDataCrop::select('imageID_raw')->where('imageID', $id)->value('imageID_raw');
        KelolaDataCrop::find($id)->delete();
        \LogActivity::addToLog('Menghapus data crop Tanaman milik user lain');
        return redirect('tanaman-data/crop/awal_all/'. $image_raw);
    }
}
