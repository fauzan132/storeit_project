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
        