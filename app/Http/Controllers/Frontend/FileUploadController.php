<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function __construct()
    {
        if (env("CAS_ENABLED", true)) {
            cas()->authenticate();
        }
    }

    public function avatarUpload(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'data-file' => 'required|mimes:jpg,png,jpeg|max:2048',
        ],[
            'data-file' => 'Obraz nie może przekroczyć rozmiaru 2Mb i musi być w jednym z formatów jpg, png, jpeg',
        ]);

        if($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $user = (new FrontendController)->getAuthUserData();
        $bsrUser = User::where('nepu',$user->nepu)->first();

        if ($bsrUser) {
            if ($file = $request->file('data-file')) {
                $name = $file->hashName();
                $path = $request->file('data-file')->storePubliclyAs(
                    'files',
                    $name
                );
                $save = new File();
                $save->type = 'user-new-avatar';
                $save->activity_id = $bsrUser->id;
                $save->file_name = $name;
                $save['org_name'] = $file->getClientOriginalName();
                $save['file_path'] = '/'.$path;
                $save->save();

                return response()->json([
                    "message" => "Zapisano plik",
                    "file" => $file
                ],201);
            }
        }
        else {
            return response()->json([
                "success" => false,
                "message" => "Nieznany użytkownik",
            ],401);
        }

    }
}
