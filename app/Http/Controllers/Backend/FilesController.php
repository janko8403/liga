<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

class FilesController extends Controller
{
    public function uploadPublicFile(Request $request) {

        $rules = array(
            'file-upload' => ['mimes: jpeg,png,jpg,gif,svg,pdf','max:4096','required'],
            'type' => 'string|required',
            'activity_id' => 'numeric|required',
        );
        $messages = array(
            'file-upload' => 'Plik może mieć maksymalny rozmiar 4Mb. Dopuszczalne formaty plików to JPEG, PNG, JPG, GIF,  SVG i PDF',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        #TODO removed clamscan

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }
        else {
            $file = $request->file('file-upload');
            $name = $file->hashName();
            $path = $request->file('file-upload')->storePubliclyAs(
                'files',
                $name
            );

            $f = new File();
            $f['file_name'] = $name;
            $f['activity_id'] = $request->activity_id;
            $f['type'] = $request->type;
            $f['org_name'] = $file->getClientOriginalName();
            $f['file_path'] = '/'.$path;

            $f->save();

            return $f['file_path'];
        }
    }

    public function uploadHeaderFile(Request $request) {

        $rules = array(
            'header-file' => 'mimes: jpeg,png,jpg,gif,svg|max:4096|required',
            'type' => 'string|required',
            'activity_id' => 'integer|required',
        );
        $messages = array(
            'header-file' => 'Nagłówek może mieć maksymalny rozmiar 4Mb. Dopuszczalne formaty plików to JPEG, PNG, JPG, GIF i SVG',
        );
        #TODO removed clamscan

        $validator = Validator::make($request->all(), $rules, $messages);

        if (!$validator->fails()) {
            $file = $request->file('header-file');
            if ($file) {
                $name = $file->hashName();
                $path = $request->file('header-file')->storePubliclyAs(
                    'files',
                    $name
                );

                $f = new File();
                $f['file_name'] = $name;
                $f['activity_id'] = $request["activity_id"];
                $f['type'] = $request["type"];
                $f['org_name'] = $file->getClientOriginalName();
                $f['file_path'] = '/' . $path;
                $f->save();
                return response($f['file_path'], 200);
            }

        }
        throw new \Illuminate\Validation\ValidationException($validator);
    }

    public function index(Request $request)
    {
        if ($request["activity_id"] && $request["type"])
        {
            return File::where('activity_id',$request["activity_id"])
                ->where('type',$request["type"])
                ->get()->toArray();
        }
        else {
            return [];
        }
    }

    public function destroy($file)
    {
        File::where('id',$file)->delete();
        return response()->noContent();
    }

}
