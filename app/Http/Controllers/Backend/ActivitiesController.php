<?php

namespace App\Http\Controllers\Backend;

use App\Exports\ActivityCashLeagueDSKExport;
use App\Exports\ActivityCashLeagueMSKExport;
use App\Exports\ActivityContestExport;
use App\Exports\ActivityLeagueDSKExport;
use App\Exports\ActivityLeagueDWSExport;
use App\Exports\ActivityLeagueMSKExport;
use App\Exports\ActivityLeagueMWPExport;
use App\Exports\ActivityLeagueRDSKExport;
use App\Exports\ActivityLeagueRKWPExport;
use App\Exports\ActivityLeagueRMWSExport;
use App\Exports\ActivityLeagueMWSExport;
use App\Exports\ActivityRankingExport;
use App\Exports\DuelsEditionExport;
use App\Exports\DuelsEditionsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityEditionRequest;
use App\Http\Requests\SpecialTaskRequest;
use App\Http\Resources\ActivityEditionResource;
use App\Imports\ActivityCashLeagueDSKImport;
use App\Imports\ActivityCashLeagueMSKImport;
use App\Imports\ActivityContestImport;
use App\Imports\ActivityLeagueDSKImport;
use App\Imports\ActivityLeagueDWSImport;
use App\Imports\ActivityLeagueMSKImport;
use App\Imports\ActivityLeagueMWPImport;
use App\Imports\ActivityLeagueRDSKImport;
use App\Imports\ActivityLeagueRKWPImport;
use App\Imports\ActivityLeagueRMWSImport;
use App\Imports\ActivityLeagueMWSImport;
use App\Imports\ActivityRankingImport;
use App\Imports\DuelsEditionImport;
use App\Models\Activity;
use App\Http\Requests\ActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\ActivityEdition;
use App\Models\ActivityRankingData;
use App\Models\ActivitySpecialTasks;
use App\Models\SpecialTaskPoints;
use App\Models\UserPermission;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class ActivitiesController extends Controller
{
    public function index()
    {
        return ActivityResource::collection(Activity::with('permissions')->with('header')->get()->toArray());
    }

    public function store(ActivityRequest $request)
    {
        $activity = Activity::create($request->validated());
        $activity->save();
        return new ActivityResource($activity);
    }

    public function show(Activity $activity)
    {
        return ActivityResource::make(Activity::with('permissions')
            ->with('editions')
            ->without('description')
            ->with('header')
            ->where('id', $activity["id"])
            ->first());
    }

    public function update(ActivityRequest $request, Activity $activity)
    {
        $request->validated();

        UserPermission::where('activity_id','=', $activity->id)->where('permission_type','=','activity')->delete();
        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                $newPermission = UserPermission::create([
                    'activity_id' => $activity->id,
                    'user_permission_id' => $permission['id'],
                    'permission_type' => 'activity',
                ]);
                $newPermission->save();

            }
        }

        $activity->name = $request["name"];
        $activity->status = $request["status"];
        $activity->active_from = $request["active_from"];
        $activity->active_to = $request["active_to"];
        $activity->save();
        return response(new ActivityResource($activity), Response::HTTP_OK);
    }

    public function destroy(Activity $activity)
    {
        #damy soft delete
        #$activity->delete();
        return response()->noContent();
    }

    public function getActivityPermissions(Activity $activity)
    {
        return $activity->permissions();
    }

    public function getAllPermissions()
    {
        return UserPermission::select('name', 'id as user_permission_id')->get();
    }

    public function getActivityEditions($activity_id)
    {
        return ActivityEdition::where('activity_id', $activity_id)->get();
    }

    public function getActivityEdition($activity_edition)
    {
        return ActivityEdition::where('id', $activity_edition)->with('activity')->with('permissions')->get();
    }

    public function storeActivityEdition(Request $request)
    {
        $now = Carbon::now()->addMonth();
        $startDate = $now->startOfMonth('Y-m-d');
        $endDate = $now->endOfMonth()->format('Y-m-d');

        $activityEdition = new ActivityEdition;
        $activityEdition->name = 'Nowa edycja';
        $activityEdition->activity_id = 3;
        $activityEdition->status = 0;
        $activityEdition->active_from = $startDate;
        $activityEdition->active_to = $endDate;
        $activityEdition->slug = 'nowa-edycja';
        $activityEdition->save();
        return new ActivityEditionResource($activityEdition);

    }

    public function updateActivityEdition(ActivityEditionRequest $request, ActivityEdition $activityEdition)
    {
        $request->validated();

        UserPermission::where('activity_id','=',$activityEdition->id)->where('permission_type','=','activityEdition')->delete();
        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                $newPermission = UserPermission::create([
                    'activity_id' => $activityEdition->id,
                    'user_permission_id' => $permission['id'],
                    'permission_type' => 'activityEdition',
                ]);
                $newPermission->save();

            }
        }

        $activityEdition->name = $request["name"];
        $activityEdition->slug = $request["slug"];
        $activityEdition->status = $request["status"];
        $activityEdition->active_from = $request["active_from"];
        $activityEdition->active_to = $request["active_to"];
        $activityEdition->save();

        return response(new ActivityEditionResource($activityEdition), Response::HTTP_OK);
    }

    public function destroyActivityEdition(ActivityEdition $edition)
    {

    }

    public function getActivitySpecialTasksTask($id)
    {
        return ActivitySpecialTasks::where('id','=',$id)->with('header')->with('permissions')->first();
    }

    public function getActivitySpecialTasksTasks($id)
    {
        return ActivitySpecialTasks::where('edition_id','=',$id)->get();
    }

    public function addActivitySpecialTasksTask($id,$type)
    {
        $newTask = new ActivitySpecialTasks;
        $newTask->edition_id = $id;
        $newTask->type = $type;
        $newTask->activity_id = '3';
        $newTask->save();
    }

    private function getActivityDataType($type,$ie,$edition_id=0)
    {
        switch ($type)
        {
            case 'LeagueMWS':
                return $ie == 'import'? new ActivityLeagueMWSImport() : new ActivityLeagueMWSExport();
            case 'LeagueMWP':
                return $ie == 'import'? new ActivityLeagueMWPImport() : new ActivityLeagueMWPExport();
            case 'LeagueRMWS':
                return $ie == 'import'? new ActivityLeagueRMWSImport() : new ActivityLeagueRMWSExport();
            case 'LeagueRKWP':
                return $ie == 'import'? new ActivityLeagueRKWPImport() : new ActivityLeagueRKWPExport();
            case 'LeagueMSK':
                return $ie == 'import'? new ActivityLeagueMSKImport() : new ActivityLeagueMSKExport();
            case 'LeagueDSK':
                return $ie == 'import'? new ActivityLeagueDSKImport() : new ActivityLeagueDSKExport();
            case 'LeagueRDSK':
                return $ie == 'import'? new ActivityLeagueRDSKImport() : new ActivityLeagueRDSKExport();
            case 'LeagueDWS':
                return $ie == 'import'? new ActivityLeagueDWSImport() : new ActivityLeagueDWSExport();
            case 'CASHLeagueMSK':
                return $ie == 'import'? new ActivityCashLeagueMSKImport() : new ActivityCashLeagueMSKExport();
            case 'CASHLeagueDSK':
                return $ie == 'import'? new ActivityCashLeagueDSKImport() : new ActivityCashLeagueDSKExport();
            case 'duelEdition':
                return $ie == 'import'? new DuelsEditionImport() : new DuelsEditionExport($edition_id);
            case 'contest':
                return $ie == 'import'? new ActivityContestImport() : new ActivityContestExport($edition_id);
            case 'ranking':
                return $ie == 'import'? new ActivityRankingImport() : new ActivityRankingExport($edition_id);
            case 'duelEditions':
                return new DuelsEditionsExport();
            default:
                return 'Niepoprawny typ importu';
        }
    }

    public function dataImport(Request $request)
    {

        $activityImport = $this->getActivityDataType($request->type,'import',$request["edition_id"]);
        if (is_object($activityImport)) {
            $activityImport->activity_id = $request["activity_id"];
            $activityImport->edition_id = $request["edition_id"];
            try {
                Excel::import($activityImport, $request->file('data-file')->store('temp'));
            } catch(Exception $e) {
                return (array(
                    'zonk' => 'Niepoprawny plik importu',
                ));
            }
        }
        else {
            return (array(
                'zonk' => 'Niepoprawny plik importu',
            ));
        }

        return (array(
            'rowsTotal' => $activityImport->data->rowsTotal,
            'rowsValid' => $activityImport->data->rowsValid,
            'rowsInvalid' => $activityImport->data->rowsInvalid,
        ));
    }

    public function dataExport($type,$activity_id,$edition_id)
    {
        $activityExport = $this->getActivityDataType($type,'export',$edition_id);
        if (is_object($activityExport)) {
            $activityExport->activity_id = $activity_id;
            $activityExport->edition_id = $edition_id;

            return Excel::download($activityExport, 'aktywnosc-'.$type.'-'.$activity_id.'.xlsx');
        }
        else
        {
            return 'Niepoprawny plik eksportu';
        }
    }

    public function getTaskRankingData($edition_id)
    {
        $activityData = ActivityRankingData::select('uczestnik','stanowisko','wartosc','punkty')
            ->where('edition_id',$edition_id)
            ->orderBy('punkty','desc')
            ->get()
            ->toArray();
        $tableData = array();
        if ($activityData) {
            foreach ($activityData as $k => $v) {
                $tableData[] = array_values($v);
            }
        }
        return $tableData;
    }

    public function getActivityLeagueData($activity_id, $activity_type) {
        $activityData = $this->getActivityDataType($activity_type,'export');
        if (is_object($activityData)) {
            $tableData = array();
            foreach ($activityData->collection()->toArray() as $k => $v) {
                $tableData[] = array_values($v);
            }
            return $tableData;
        } else {
            return $activityData;
        }
    }

    public function getActivityLeagueHeaders($activity_id, $activity_type) {
        $activityData = $this->getActivityDataType($activity_type,'export');
        if (is_object($activityData)) {
            return $activityData->headings();
        } else {
            return $activityData;
        }
    }

    public function updateActivitySpecialTasksTask(SpecialTaskRequest $request) {

        $request->validated();

        UserPermission::where('activity_id','=',$request->id)->where('permission_type','=','task')->delete();
        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                $newPermission = UserPermission::create([
                    'activity_id' => $request->id,
                    'user_permission_id' => $permission['id'],
                    'permission_type' => 'task',
                ]);
                $newPermission->save();
            }
        }

        $task = ActivitySpecialTasks::where('id','=',$request->id)->first();
        $task->name = $request["name"];
        $task->status = $request["status"];
        $task->slug = $request["slug"];
        $task->active_from = $request["active_from"];
        $task->active_to = $request["active_to"];
        $task->quiz_time = $request["quiz_time"];
        $task->quiz_percentage_points = $request["quiz_percentage_points"];
        $task->quiz_ranking_points = $request["quiz_percentage_points"];
        $task->save();

        return response($task, Response::HTTP_OK);
    }

    public function updateActivitySpecialTasksTaskDescription(Request $request) {
        $task = ActivitySpecialTasks::where('id','=',$request->id)->first();
        $task->description = $request["description"];
        $task->task_description = $request["task_description"];
        $task->save();
    }

    public function createActivitySpecialTaskEdition()
    {

    }

    public function storeTaskPointsDefinition(Request $request)
    {
        $tp = new SpecialTaskPoints();
        $tp->task_id = $request["task_id"];
        $tp->name = $request["name"];
        $tp->points = $request["points"];
    }

    public function getTaskPointsDefinitions($task_id) {
        return SpecialTaskPoints::where('task_id',$task_id)->get();
    }

    public function destroyTaskPointsDefinition($id) {
        return SpecialTaskPoints::where('id',$id)->delete();
    }
}
