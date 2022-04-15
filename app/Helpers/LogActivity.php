<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;
use App\Models\LogActivity as LogActivityModel;

class LogActivity
{


    public static function addToLog($log)
    {
		LogActivityModel::create($log);
    }


    // public static function logActivityLists()
    // {
    // 	return LogActivityModel::latest()->get();
    // }


}