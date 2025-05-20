<?php
use App\Exports\UsersExport;
use App\Http\Controllers\Backend\ActivitiesController;
use App\Http\Controllers\Backend\AdminsController;
use App\Http\Controllers\Backend\CMSMenuController;
use App\Http\Controllers\Backend\CMSSectionsController;
use App\Http\Controllers\Backend\ContestsController;
use App\Http\Controllers\Backend\DuelsEditionsController;
use App\Http\Controllers\Backend\FilesController;
use App\Http\Controllers\Backend\NotificationsController;
use App\Http\Controllers\Backend\QuizQuestionsController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Backend\DuelsConfigController;
use App\Http\Controllers\Backend\DuelsController;
use Illuminate\Support\Facades\Route;


Route::get('/confirm/sendmail/{id}', [UsersController::class, 'sendVerificationEmail']);


Route::get('/backend/cms/sections/dictionary', [CMSSectionsController::class, 'getSectionsDefinitions']);

Route::get('/backend/cms/menus', [CMSMenuController::class, 'getMainMenu']);
Route::post('/backend/cms/menus', [CMSMenuController::class, 'store']);
Route::get('/backend/cms/sections/menu/{menu_id}', [CMSSectionsController::class, 'index']);
Route::get('/backend/cms/sections/data/{section_id}/{component_id}', [CMSSectionsController::class, 'getSectionData']);
Route::get('/backend/cms/sections/data/{section_id}', [CMSSectionsController::class, 'getSectionsData']);
Route::post('/backend/cms/sections/data/{section_id}', [CMSSectionsController::class, 'updateSectionData']);
Route::get('/backend/cms/sections/move/{section_id}/{direction}', [CMSSectionsController::class, 'moveSection']);

Route::patch('/backend/users/{id}/{v}', [UsersController::class, 'updateUserPhoto']);
Route::resource('/backend/admins', AdminsController::class);
Route::resource('/backend/users', UsersController::class);
Route::resource('/backend/cms', CMSMenuController::class);
#edycje aktywnosci
Route::get('/backend/activities/{activity_id}/editions/', [ActivitiesController::class, 'getActivityEditions']);
Route::get('/backend/activities/editions/{activity_edition}', [ActivitiesController::class, 'getActivityEdition']);
Route::patch('/backend/activities/editions/{activity_edition}', [ActivitiesController::class, 'updateActivityEdition']);
Route::post('/backend/activities/editions/new', [ActivitiesController::class, 'storeActivityEdition']);
#dane ligi
Route::get('/backend/activities/{activity_id}/data/{activity_type}', [ActivitiesController::class, 'getActivityLeagueData']);
Route::get('/backend/activities/{activity_id}/headers/{activity_type}', [ActivitiesController::class, 'getActivityLeagueHeaders']);
#zadania specjalne
Route::get('/backend/activities/tasks/edition/{id}', [ActivitiesController::class, 'getActivitySpecialTasksTasks']);
Route::get('/backend/activities/tasks/{id}', [ActivitiesController::class, 'getActivitySpecialTasksTask']);
Route::patch('/backend/activities/tasks/{id}', [ActivitiesController::class, 'updateActivitySpecialTasksTask']);
Route::delete('/backend/activities/tasks/{id}', [ActivitiesController::class, 'destroyActivitySpecialTasksTask']);
Route::get('/backend/activities/tasks/add/{id}/{type}', [ActivitiesController::class, 'addActivitySpecialTasksTask']);
Route::get('/backend/taskConfig', [ActivitiesController::class,'getTaskConfig'])->name('taskConfig.show');
Route::post('/backend/taskConfig/{duel_id}', [ActivitiesController::class,'updateTaskConfig'])->name('taskConfig.update');
Route::get('/backend/taskPoints/{task_id}',[ActivitiesController::class,'getTaskPointsDefinitions'])->name('getTaskPoints');
Route::get('/backend/taskPoints/{task_id}',[ActivitiesController::class,'storeTaskPointsDefinition'])->name('getTaskPoints');
Route::get('/backend/activities/tasks/ranking/{id}',[ActivitiesController::class,'getTaskRankingData'])->name('getTaskRankingData');
Route::delete('/backend/taskPoints/{id}',[ActivitiesController::class,'destroyTaskPointsDefinition'])->name('deleteTaskPoints');
Route::patch('/backend/activities/task-description/{id}', [ActivitiesController::class, 'updateActivitySpecialTasksTaskDescription']);


Route::resource('/backend/activities', ActivitiesController::class);
Route::resource('/backend/questions', QuizQuestionsController::class);
Route::resource('/backend/notifies', NotificationsController::class);
Route::get('/backend/questions/task/{task_id}', [QuizQuestionsController::class,'index']);
#question options
Route::get('/backend/questions/question-options/new/{id}', [QuizQuestionsController::class,'storeQuestionOption']);
Route::get('/backend/questions/question-options/{id}', [QuizQuestionsController::class,'getQuestionOptions']);
Route::patch('/backend/questions/question-options/{id}', [QuizQuestionsController::class,'updateQuestionOptions']);
Route::delete('/backend/questions/question-options/{id}', [QuizQuestionsController::class,'destroyQuestionOption']);


#resources
Route::resource('/backend/contests', ContestsController::class);
Route::resource('/backend/duels', DuelsController::class);
Route::resource('/backend/duels-editions', DuelsEditionsController::class);
Route::resource('/backend/settings', SettingsController::class);


Route::get('/backend/duelsConfig', [DuelsConfigController::class,'show'])->name('duelConfig.show');
Route::patch('/backend/duelsConfig/{duel_id}', [DuelsConfigController::class,'update'])->name('duelConfig.update');
Route::get('/backend/duels/edition/{edition_id}', [DuelsController::class,'getEditionDuels'])->name('duel.show');
Route::get('/backend/duels/edition/{edition_id}/msk-teams/{nepu1}/{nepu2}',[DuelsController::class,'getMSKTeams'])->name('duel_msk');
Route::get('/backend/duels/edition/{edition_id}/dsk-teams',[DuelsController::class,'getDSKTeams'])->name('duel_dsk');


Route::resource('/backend/cms/sections', CMSSectionsController::class);
Route::get('/backend/cms/menu/{id}', [CMSMenuController::class, 'getMenu']);

Route::post('/backend/upload-file', [FilesController::class, 'uploadPublicFile'])->name('backend.fileupload');
Route::post('/backend/upload-header-file', [FilesController::class, 'uploadHeaderFile'])->name('backend.headerfileupload');
Route::get('/backend/files/{activity_id}/{type}', [FilesController::class, 'index'])->name('backend.index');
Route::delete('/backend/files/{id}', [FilesController::class, 'destroy'])->name('backend.delete');

Route::get('/backend/users_permissions', [UsersController::class, 'getAllPermissions'])->name('users_permissions');
Route::get('/backend/admins_permissions', [AdminsController::class, 'getAllPermissions'])->name('admins_permissions');

Route::get('/backend/users-export', [UsersExport::class, 'export'])->name('users_export');
