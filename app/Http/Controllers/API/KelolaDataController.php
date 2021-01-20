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

        if($data->save()){
            return response()->json(['success'=>$result]);
        }else{
            return response()->json(['error'=>'Data Kosong']);
        }
    }
    public function update_userprofile(Request $request, $id)
    {
        $data = User::where('id', $id)->first();
        $data->telp =  $request->telp;
        $data->role =  $request->role;
        \LogActivity::addToLog('Mengubah data user');
        if($data->save()){
            return response()->json(['success'=>$result]);
        }else{
            return response()->json(['error'=>'Data Kosong']);
        }
    }
    public function destroy_image($id)
    {
        $gambar = KelolaData::where('imageID',$id)->first();
        File::delete('images/'.$gambar->ImageURL);
    
        KelolaData::find($id)->delete();
        \LogActivity::addToLog('Menghapus data Tanaman');
        return response()->json(['success'=>'Data berhasil dihapus']);
    }
    public function store(){
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

        if($data->save()){
            return response()->json(['success'=>$result]);
        }else{
            return response()->json(['error'=>'Data Kosong']);
        }
    }

}
        