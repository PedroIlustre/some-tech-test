<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\ContactFiles;
use App\Http\Controllers\Auth;
use App\Exceptions\FieldsException;
use App\Helpers\ValidateCreditCardHelper;
use App\Helpers\ValidateFieldsHelper;
use App\Helpers\ValidateFranchiseCreditCardHelper;

class SaveContactController extends Controller
{

    private $contact_files;
    private $file_id;

    public function __construct()
    {
        $this->middleware('auth');
        $this->contact_files = new ContactFiles();
    }

    public function save (Request $request) 
    {
        $fields = array_merge($request->all());
        $this->upload_id = $fields['upload_id'];
        $error_table_columns = [];

        try {
            if (is_array($fields)) {
                foreach ($fields['value_field'] as $k => $contact) {
                    foreach ($fields['table_column'][$k] as $table_column => $new_value_column){
                        if (is_null($new_value_column)) {
                            $error_table_columns[] = $table_column . ' is required';
                            continue;
                        }
                        $this->contact_files->{$table_column} = $contact[$new_value_column];
                    }

                    if (count($error_table_columns) > 0) {
                        throw new FieldsException ('', 0, null, $error_table_columns);
                    }
                   
                    $validate_fields = ValidateFieldsHelper::validateFields($this->contact_files->getAttributes());

                    if ($validate_fields['status'] == 'error') {
                        throw new FieldsException ('', 0, null, $validate_fields);
                    }

                    $this->contact_files->user_id = \Auth::user()->id;
                    $this->contact_files->upload_id = $this->upload_id;
                    $this->contact_files->save();
                }
            }
        } catch (FieldsException $e) {
            return redirect("/show_upload/{$this->upload_id}")->with('error', $e->getFields());
        }

        return redirect('/')->with('success', 'Your CSV file was saved');
    }

}
