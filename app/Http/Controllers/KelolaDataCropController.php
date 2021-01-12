<?php

namespace App\Http\Controllers;

use App\KelolaData;
use App\KelolaDataCrop;
use Auth;
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
        $imageid_raw = $request->imageid_raw;
        $lastupdateby = Auth::user()->id;
        $planttype=$request->input('planttype');
        $plantorgan=$request->input('plantorgan');
        $generalident=$request->input('generalident');
        $symptomname=$request->input('symptomName');
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

        $data->save();
        return redirect('tanaman-data/crop/awal/'. $imageid_raw);
    }

    public function update_all(Request $request, $id)
    {
        $imageid_raw = $request->imageid_raw;
        $lastupdateby = Auth::user()->id;
        $planttype=$request->input('planttype');
        $plantorgan=$request->input('plantorgan');
        $generalident=$request->input('generalident');
        $symptomname=$request->input('symptomName');
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
        $image_raw = KelolaDataCrop::select('imageID_raw')->where('imageID', $id)->value('imageID_raw');
        KelolaDataCrop::find($id)->delete();
        return redirect('tanaman-data/crop/awal/'. $image_raw);
    }

    public function destroy_all($id)
    {
        $image_raw = KelolaDataCrop::select('imageID_raw')->where('imageID', $id)->value('imageID_raw');
        KelolaDataCrop::find($id)->delete();
        return redirect('tanaman-data/crop/awal_all/'. $image_raw);
    }
}
