<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PlantTypeModel;
use App\GeneralIdentModel;
use App\SymptomNameModel;

class DropDownController extends Controller
{
    
    //memunculkan data plant type
    public function selectPlantType($name)
    {
        $planttype = PlantTypeModel::get();
        return $planttype;
    }

    //memunculkan data general ident by id plant type
    public function selectGeneralIdent($id)
    {
        $generalident = GeneralIdentModel::where('id_plant_type',$id)->get();       
        return $generalident;
    }

    //memunculkan data symptom name by id general ident
    public function selectSymptomName($id)
    {
        $symptomname = SymptomNameModel::where('id_general_ident',$id)->get();
        return $symptomname;
    }
}
