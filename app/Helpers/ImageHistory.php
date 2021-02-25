<?php

namespace App\Helpers;
use Request;
use Auth;
use App\ImageHistory as ImageHistoryModel;


class ImageHistory
{

    public static function addToRiwayat($id,$comment)
    {
    	$log = [];
    	$log['imageID'] = $id;
		$log['user_id'] = Auth::user()->id;
		$log['comment'] = $comment;
    	ImageHistoryModel::create($log);
    }

    public static function imageHistoryLists()
    {
    	return ImageHistoryModel::latest()->get();
    }

}