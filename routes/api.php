<?php

use App\Http\Controllers\Api\AdminsController;
use App\Http\Controllers\Frontend\FileUploadController;
use App\Http\Controllers\Backend\FilesController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/cities', [CityController::class, 'cities']);
Route::get('/frontend/menus/{id}', [FrontendController::class, 'getMenus']);
Route::get('/me', [FrontendController::class, 'getAuthUserData']);
Route::post('/frontend/contact',[FrontendController::class,'sendContactMessage']);
Route::get('/frontend/cms/section/{id}', [FrontendController::class, 'getSection']);
Route::get('/frontend/cms/sections/{id}', [FrontendController::class, 'getSections']);
Route::get('/frontend/cms/activity-data/{id}', [FrontendController::class, 'getActivityData']);
Route::get('/frontend/cms/activity-info/{id}', [FrontendController::class, 'getActivityInfo']);
Route::get('/frontend/cms/activity-results/{activity_id}/{limit}', [FrontendController::class, 'getActivityResults']);
Route::get('/frontend/cms/special-tasks-editions/{id}', [FrontendController::class, 'getSpecialTaskEditions']);
Route::get('/frontend/cms/special-tasks/{id}', [FrontendController::class, 'getSpecialTask']);
Route::get('/frontend/cms/special-tasks-answers/{id}', [FrontendController::class, 'getUserSpecialTaskAccess']);
Route::post('/frontend/cms/special-tasks-answers/', [FrontendController::class, 'storeUserSpecialTaskAnswer']);
Route::get('/frontend/cms/quiz-questions/{id}', [FrontendController::class, 'getQuizQuestions']);
Route::get('/frontend/cms/users-data/{id}', [FrontendController::class, 'getActivityUsers']);
Route::get('/frontend/cms/contests', [FrontendController::class, 'getContests']);
Route::get('/frontend/cms/contests/{id}', [FrontendController::class, 'getContest']);
Route::post('/frontend/avatar-upload', [FileUploadController::class, 'avatarUpload'])->name('frontend.avatar');
Route::get('/frontend/files/{activity_id}/{type}', [FilesController::class, 'index'])->name('frontend.index');
Route::get('/frontend/duels', [FrontendController::class, 'getDuels']);
Route::get('/frontend/my-team', [FrontendController::class, 'getDuelTeam']);
Route::get('/frontend/my-team/{city}', [FrontendController::class, 'getDuelTeamByCity']);
Route::get('/frontend/data-export/{activity_id}', [FrontendController::class, 'dataExport'])->name('frontend-export');
Route::get('/frontend/data-export/{activity_id}/{edition_id}', [FrontendController::class, 'dataExport'])->name('frontend-edition-export');

Route::get('/frontend/top/{activity_id}', [FrontendController::class, 'getTopResults'])->name('frontend.topresults');
Route::get('/frontend/activity-info/{activity_id}', [FrontendController::class, 'getActivityInfo'])->name('frontend.activityInfo');
Route::get('/frontend/activity-info/{activity_id}/{edition_id}', [FrontendController::class, 'getActivityInfo'])->name('frontend.activityEditionInfo');






