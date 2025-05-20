<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\UserVerification;
use App\Models\File;
use App\Models\User;
use App\Models\UserPermission;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use http\Client\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\SoftDeletes;


class UsersController extends Controller
{
    public function index()
    {
        return User::with('new_photo')->with('photo')->get()->toArray();
    }

    public function store(UserRequest $request)
    {
        $User = User::create($request->validated());
        $User->save();
        return new UserResource($User);
    }

    public function show(User $User)
    {
        return User::where('id',$User->id)->with('new_photo')->with('photo')->first();
    }

    public function update(UserRequest $request, User $User)
    {
        $request->validated();
        $User->name = $request["name"];
        $User->email = $request["email"];
        $User->save();
        return response(new UserResource($User), Response::HTTP_OK);
    }

    public static function generateVerificationToken($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    public function sendVerificationEmail($UserId)
    {
        $User= User::where('id',$UserId)->first();
        if ($User) {
            if ($User->is_validated!=1) {
                $User->verification_token = $this->generateVerificationToken(16);
                $data = array(
                    'verification_token'=> $User->verification_token,
                    'mail_to' => $User->email
                );
                $response = Mail::send(new UserVerification($data), $data, function($message) use ($User) {
                    $message->to($User->email)->subject('Weryfikacja w serwisie Liga Mistrzów BSR');
                    $message->from(env('MAIL_FROM_ADRESS',env('MAIL_FROM_NAME')));
                });
                if (!$response) {
                    return response()->json([
                        'errors' => 'Nie udało się wysłać wiadomości'
                    ],422);
                }else{
                    $User->last_verification_email = Carbon::now();
                    $User->save();
                    return response()->json([
                        'errors' => 'Wysłano wiadomość'
                    ],200);
                }
            }
        } else
        {
            return response()->json([
                'errors' => 'Nie znaleziono użytkownika'
            ],422);
        }
    }

    public function updateUserPhoto(UserRequest $request, $id,$v)
    {
        $user = User::where('id',$id)->first();
        if ($v == 2) {
            File::where('activity_id', $user->id)
                ->where('type', 'user-new-avatar')
                ->orderBy('created_at')
                ->limit(1)
                ->update(['type' => 'user-avatar']);
            File::where('activity_id', $user->id)
                ->where('type', 'user-new-avatar')
                ->delete();
            $user->save();
        }
        if ($v == 1) {
            File::where('activity_id', $user->id)
                ->where('type', 'user-new-avatar')
                ->delete();
            $user->last_comment = $request["last_comment"];
            $user->save();
        }
    }

    public function destroy(User $User)
    {
        $User->delete();
        return response()->noContent();
    }

    public function getAllPermissions()
    {
        return(DB::table('user_permissions')->select('id','name')->get());
    }
}
