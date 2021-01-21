<?php
namespace App\Http\Controllers\API;

use App\KelolaData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class KelolaDataController extends Controller
{

    public function index(){
        $data=KelolaData::getListData();
        if(count($data) > 0){ //mengecek apakah data kosong atau tidak
            return response()->json(['items'=>$data]);
        }
        else{
            return response()->json(['error'=>'Data Kosong']);
        }
    }

    public function store(Request $request){

        // if($files = $request->file('images')){
        //     foreach($files as $key => $value) {
        //         $userid = $request->input('userid');;
        //         $lastupdateby = $request->input('lastupdateby');;
        //         $planttype= $request->input('planttype');;
        //         $plantorgan=$request->input('plantorgan');
        //         $generalident= $request->input('generalident');;
        //         $symptomname= $request->input('symptomname');;
        //         $imagecomment=$request->input('imagecomment');
        //         $name = uniqid() . '_' . $planttype . '_' .$plantorgan . '_' .$generalident . '_' .$symptomname . '.' . $value->getClientOriginalExtension();
        //         $value->move('images/',$name);
        //         $status = "Uncropped & Unverified";
        //         //$temp = '2';

        //         KelolaData::create([
        //             'userID' => $userid[$key],
        //             'plantType' => $planttype[$key],
        //             'plantOrgan' => $plantorgan[$key],
        //             'generalIdent' => $generalident[$key],
        //             'symptomName' => $symptomname[$key],
        //             'ImageURL' => $name[$key],
        //             'ImageComment' => $imagecomment[$key],
        //             'lastUpdateBy' => $lastupdateby[$key],
        //             'status' => $status[$key]
        //         ]);   
        //     } 
        //     return response()->json(['success'=> 'Berhasil Masuk']);
        // }else{
        //     return response()->json(['error'=> 'Gagal Masuk']);
        // }

        //if($files = $request->file('images')){
            //foreach($files as $file){
                $files = $request->file('images');
                $userid = $request->input('userid');
                $lastupdateby = $request->input('lastupdateby');
                $planttype= $request->input('planttype');
                $plantorgan=$request->input('plantorgan');
                $generalident= $request->input('generalident');
                $symptomname= $request->input('symptomname');
                $imagecomment=$request->input('imagecomment');
                $name = uniqid() . '_' . $planttype . '_' .$plantorgan . '_' .$generalident . '_' .$symptomname . '.' . $files->getClientOriginalExtension();
                $files->move('images/',$name);
                $status = "Uncropped & Unverified";
    
                $data = new KelolaData();
                $data->userID = $userid;
                $data->plantType = $planttype;
                $data->plantOrgan = $plantorgan;
                $data->generalIdent = $generalident;
                $data->symptomName = $symptomname;
                $data->ImageURL = $name;
                $data->ImageComment = $imagecomment;
                $data->lastUpdateBy = $lastupdateby;
                $data->status = $status;
                $data->save();
            //}
            return response()->json(['success'=> 'Berhasil Masuk']);
        //}
    }
}
        