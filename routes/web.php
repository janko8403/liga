<?php

use App\Http\Controllers\Auth\AdminAuthController;

use App\Http\Controllers\Backend\ActivitiesController;
use App\Http\Controllers\Frontend\FrontendController;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BackendController;


Route::get('/logout', [\App\Http\Controllers\LogoutController::class, 'logout'])->name('logoutuser');

# backend auth
Route::get('/backend/login', [AdminAuthController::class, 'showLoginForm'])->name('backend.show');
Route::post('/backend/login', [AdminAuthController::class, 'login'])->name('backend.login');
Route::get('/backend/logout', [AdminAuthController::class, 'logout'])->name('backend.logout');

#backend
Route::group(['middleware' => ['auth:admin']], function() {
    Route::prefix('/api')->group(__DIR__.'/backend-api.php');
    Route::post('/backend/data-import', [ActivitiesController::class, 'dataImport'])->name('data-import');
    Route::get('/backend/data-export/{type}/{activity_id}/{edition_id}', [ActivitiesController::class, 'dataExport'])->name('data-export');
    Route::get('/backend/', [BackendController::class, 'index'])->name('backend');
    Route::get('/backend/{any}', [BackendController::class, 'index'])->where('any', '.*');
});

Route::get('files/{filename}', function ($filename)
{
    $path = storage_path('app/files/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

# frontend
Auth::routes();
Route::post('/api/frontend/confirm', [FrontendController::class, 'validateUserToken'])->name('userprofile.save');
Route::get('/confirm/{userToken}', [FrontendController::class, 'userRegisterUserPage']);
Route::get('/witamy', [FrontendController::class, 'showRegistrationWelcome']);
Route::get('/blad-rejestracji', [FrontendController::class, 'showRegistrationError']);
Route::get('/noaccess', [FrontendController::class, 'noaccess'])->name('noaccess');
Route::get('/', [FrontendController::class, 'index']);
Route::get('/{any}', [FrontendController::class, 'index'])->where('any', '.*');

//Route::group(['middleware' => ['auth']], function() {
//});





#def

