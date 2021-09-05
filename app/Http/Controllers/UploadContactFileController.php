<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Models\Upload;
use App\Http\Controllers\ContactController;

class UploadContactFileController extends Controller
{
    public function uploadFile ($request) 
    {
        $file = $request->file('file_uploaded');

        try {
            if(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION) != 'csv')
                return redirect('/')->with('status', 'Extension not supported, only upload CSV files!');

            
            $file_handle = fopen($file, 'r');
            while (!feof($file_handle)) {
                $file_lines[] = fgetcsv($file_handle, 0, ','  );
            }

            $header = $file_lines[0];
            array_shift($file_lines);

            return view('validate_file_fields', ['file_lines'=> $file_lines, 'header' => $header, 'url_file' => $file]);
        } 
        catch (Exception $e){
            return redirect('/')->with('status', 'An error in processing your file:'.$e->getMessage());
        }
    }
}