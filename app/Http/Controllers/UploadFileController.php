<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UploadFile;

class UploadFileController extends Controller
{
    //
    public function UploadFile(Request $request){
        if(request()->has('csvFile')){
            $data = array_map('str_getcsv', file(request()->csvFile));
            $header = $data[0];
            unset($data[0]);

            
            foreach($data as $key => $value){
                $saveData = array_combine($header, $value);                
                UploadFile::create($saveData);
            }


            return $data;
        }
    }
}
