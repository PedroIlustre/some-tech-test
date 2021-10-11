<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Models\Upload;
use App\Http\Controllers\ContactController;

class UploadContactFileController extends Controller
{
    public function uploadFile (Request $request) 
    {
       
        try {
            $file_handle = fopen($file, 'r');
            while (!feof($file_handle)) {
                $file_lines[] = fgetcsv($file_handle, 0, ','  );
            }

            $header = $file_lines[0];
            array_shift($file_lines);

            return view('validate_file_fields', ['file_lines'=> $file_lines, 'header' => $header, 'url_file' => $file]);
        } 
        catch (Exception $e){
            dd($e);
            return redirect('/')->with('error', 'An error in processing your file:'.$e->getMessage());
        }
    }
}
