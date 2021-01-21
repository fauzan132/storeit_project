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
    public function update_image(Request $request, $id)
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
        