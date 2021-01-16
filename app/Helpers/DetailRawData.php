<?php

namespace App\Helpers;
use Request;
use Auth;
use App\DetailRawData as DetailRawDataModel;


class DetailRawData
{

    public static function addToHistory($id,$subject)
    {
    	$log = [];
    	$log['imageID'] = $id;
		$log['user_id'] = Auth::user()->id;
		$log['subject'] = $subject;
    	DetailRawDataModel::create($log);
    }

    public static function detailRawDataLists()
    {
    	return DetailRawDataModel::latest()->get();
    }


}