<?php

namespace App\Http\Controllers;

use App\KelolaData;
use App\KelolaDataCrop;
use Illuminate\Http\Request;

class KelolaDataCropITBController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function awal($id)
    {
        $data = KelolaData::find($id);
        $data2 = KelolaDataCrop::select('*')->where('imageID_raw', $id)->get();
        //print_r($data2);
        return view('expert_itb.itb-data.crop.list_data_crop')
        ->with('data', $data)
        ->with('data2', $data2);
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
        return view('expert_itb.itb-data.crop.formubah_data_crop')
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
        $imageid_raw = $request->imageid_raw;
        $planttype=$request->input('planttype');
        $plantorgan=$request->input('plantorgan');
        $generalident=$request->input('generalident');
        $status=$request->input('status');
        $imagecomment=$request->input('imagecomment');
        $img = $request->tmp_image;
        
        $data = KelolaDataCrop::where('imageID', $id)->first();
        $data->imageID_raw = $imageid_raw;
        $data->plantType = $planttype;
        $data->plantOrgan = $plantorgan;
        $data->generalIdent = $generalident;
        $data->status = $status;
        $data->ImageURL = $img;
        $data->ImageComment = $imagecomment;

        $data->save();
        return redirect('itb-data/crop/awal/'. $imageid_raw);
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
        return redirect('itb-data/crop/awal/'. $image_raw);
    }
}
