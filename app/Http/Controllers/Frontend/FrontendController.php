<?php

namespace App\Http\Controllers\Frontend;
use App\Exports\ActivityCashLeagueDSKExport;
use App\Exports\ActivityCashLeagueMSKExport;
use App\Exports\ActivityContestExport;
use App\Exports\ActivityLeagueDSKExport;
use App\Exports\ActivityLeagueDWSExport;
use App\Exports\ActivityLeagueMSKExport;
use App\Exports\ActivityLeagueMWPExport;
use App\Exports\ActivityLeagueMWSExport;
use App\Exports\ActivityLeagueRDSKExport;
use App\Exports\ActivityLeagueRKWPExport;
use App\Exports\ActivityLeagueRMWSExport;
use App\Models\ActivityLeagueDWSData;
use App\Models\QuizQuestion;
use App\Models\SpecialTasksAnswer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FrontendUserProfile;
use App\Mail\ContactForm;
use App\Models\Activity;
use App\Models\ActivityCashLeagueDataDSK;
use App\Models\ActivityCashLeagueDataMSK;
use App\Models\ActivityEdition;
use App\Models\ActivityLeagueDSKData;
use App\Models\ActivityLeagueMSKData;
use App\Models\ActivityLeagueRDSKData;
use App\Models\ActivityLeagueRMWSData;
use App\Models\ActivityLeagueRKWPData;
use App\Models\ActivityLeagueMWSData;
use App\Models\ActivityLeagueMWPData;
use App\Models\ActivitySpecialTasks;
use App\Models\CMSMenu;
use App\Models\CMSSection;
use App\Models\Contest;
use App\Models\Duel;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;


class FrontendController extends Controller
{

    protected string $nepu = '0000';
    protected string $title;
    protected string $permission;

    protected int $userPermission = 0;
    public \stdClass|string $user;
    public \stdClass|string $bsrUser;

    public function __construct()
    {
        $this->user = new \stdClass();
        $this->bsrUser = new \stdClass();

        if (env("CAS_ENABLED",true)) {
            cas()->authenticate();
            $this->user = cas()->user();

            $attr = cas()->getAttributes();
            $this->nepu = Arr::get($attr,'msplPZUMIISNEPU') ?? '';
            if ($this->nepu) {
                $this->bsrUser = User::where('nepu', $this->nepu)
                    ->where('is_validated', 1)
                    ->first();
            }

            $casPermissions = Arr::get($attr,'MemberOf');
            foreach ($casPermissions as $casPermission) {
                $p = explode(',',$casPermission);
                if (!is_array($p)) {
                    continue;
                }
                foreach ($p as $sPermission) {
                    switch(strtolower(str_replace('CN=','',$sPermission))) {
                        case 'liga_bsr_rdsk':
                            $this->userPermission = 0;
                            break;
                        case 'liga_bsr_agent':
                            $this->userPermission = 0;
                            break;
                        case 'liga_bsr_agent_plus':
                            $this->userPermission = 0;
                            break;
                        case 'liga_bsr_dsk':
                            $this->userPermission = 0;
                            break;
                    }
                }
            }

            $this->title = Arr::get($attr,'title') ?? '';
            if ($this->title!='') {
                switch($this->title) {
                    case 'Kierownik - Starszy Menedżer ds. Sprzedaży Korporacyjnej':
                    case 'Kierownik - Menedżer ds. Sprzedaży Korporacyjnej':
                        $this->permission = 'msk';
                        $this->userPermission = 1;
                    break;
                    case 'Dyrektor Sprzedaży Korporacyjnej':
                        $this->permission = 'dsk';
                        $this->userPermission = 2;
                        break;
                    case 'Koordynator - Menedżer ds. Ubezpieczeń Grupowych dla Klientów Strategicznych':
                        $this->permission = 'dws';
                        $this->userPermission = 3;
                        break;
                    case 'Menedżer ds. Wdrożeń i Portfela':
                        $this->permission = 'mwp';
                        $this->userPermission = 4;
                        break;
                    case 'Koordynator - Menedżer Wsparcia Sieci Sprzedaży Korporacyjnej':
                        $this->permission = 'mws';
                        $this->userPermission = 5;
                        break;
                    case 'Regionalny Dyrektor Sprzedaży Korporacyjnej':
                        $this->permission = 'rdsk';
                        $this->userPermission = 6;
                        break;
                    case 'Regionalny Kierownik ds. Wdrożeń i Portfela':
                        $this->permission = 'rkwp';
                        $this->userPermission = 7;
                        break;
                    case 'Koordynator - Regionalny Menedżer Wsparcia Sieci Sprzedaży Korporacyjnej':
                        $this->permission = 'rmws';
                        $this->userPermission = 8;
                        break;
                }

                #emulacje
                $emulationUser = Arr::get($attr,'Imie').' '.Arr::get($attr,'Nazwisko');
                switch ($emulationUser) {
                    case 'Jarosław Pięta':
                        $this->permission = 'msk';
                        $this->userPermission = 1;
                        $this->nepu = '01172586';
                        $this->user->name='Elwira';
                        $this->user->lastname='Wtorek';
                        break;
                    case 'Paweł Toporek':
                        $this->permission = 'msk';
                        $this->userPermission = 1;
                        $this->nepu = '01610401';
                        break;
                    case 'Kacper Sulima':
                        $this->permission = 'msk';
                        $this->userPermission = 1;
                        $this->nepu = '01630708';
                        break;
                    case 'Justyna Sobolewska':
                        $this->permission = 'msk';
                        $this->userPermission = 1;
                        $this->nepu = '01630211';
                        break;
                    case 'Wojciech Borowski':
                        $this->permission = 'msk';
                        $this->userPermission = 1;
                        $this->nepu = '01172586';
                        $this->user->name='Elwira';
                        $this->user->lastname='Wtorek';
                        break;
                    case 'Sebastian Grzybowski':
                        $this->permission = 'dsk';
                        $this->userPermission = 2;
                        $this->nepu = '00341716';
                        break;
                case 'Alan Pszonczenko':
                        $this->permission = 'msk';
                        $this->userPermission = 1;
                        $this->nepu = '01172586';
                        $this->user->name='Elwira';
                        $this->user->lastname='Wtorek';
                        break;
                case 'Krzysztof Pietrzak':
                        $this->permission = 'msk';
                        $this->userPermission = 1;
                        $this->nepu = '01172586';
                        $this->user->name='Elwira';
                        $this->user->lastname='Wtorek';
                        break;
               case 'Rafał Adamiak':
                        $this->permission = 'msk';
                        $this->userPermission = 1;
                        $this->nepu = '00555892';
                        break;
                case 'Izabela Bilska':
                        $this->permission = 'dsk';
                        $this->userPermission = 2;
                        $this->nepu = '02129598';
                        break;
                case 'Karolina Postój':
                        $this->permission = 'dws';
                        $this->userPermission = 3;
                        $this->nepu = '01226094';
                        break;
                case 'Marcin Cichocki':
                        $this->permission = 'mws';
                        $this->userPermission = 5;
                        $this->nepu = '01313532';
                        break;
                case 'Magdalena Chacińska':
                        $this->permission = 'rmws';
                        $this->userPermission = 8;
                        $this->nepu = '01389878';
                        break;
                }
        }
        }
	else {
            if (env("CAS_USE_CASMANAGER",false)) {
	    } else {
              #local dev
              $this->userPermission = 1;
              #$this->bsrUser->nepu = '01172586';
              $this->bsrUser->nepu = '12345678';
              $this->user->name='Rafał';
              $this->user->lastname='Rakowski';
              $this->nepu = '12345678';
              $this->bsrUser->id = '1';
              $this->permission = 'dsk';
            }
    	}
    }

    private function checkActivityPermissions($activity_id, $edition_id=0)
    {
        return true;
    }

    public function noaccess() {
        return view('frontend.nouser');
    }

    public function getDuels()
    {
        if (isset($this->bsrUser->nepu)) {
            $duels = Duel::where('first_nepu',$this->bsrUser->nepu)
                ->whereOr('second_nepu',$this->bsrUser->nepu)
                ->whereHas('permissions',function($q) {
                    $q->where('user_permission_id', '=', $this->userPermission);
                })
                #->join(DB::raw('(SELECT round(avg(wynik_msk)) as first_score from duels_data where nepu_dsk=(select nepu_dsk from duels_data where nepu_msk=duels.first_nepu and edition_id=duels.edition_id limit 1))'))
                #->join(DB::raw('(SELECT round(avg(wynik_msk)) as second_score from duels_data where nepu_dsk=(select nepu_dsk from duels_data where nepu_msk=duels.first_nepu and edition_id=duels.edition_id limit 1))'))
                ->where('status','=',1)
                ->with('firstContender')
                ->with('edition')
                ->with('secondContender')
                ->get();
            return($duels);
        }
    }

    public function index() {

        //if (!$this->nepu) {
        //    return view('frontend.nouser');
        //}

        if (!$this->userPermission > 0) {
            Redirect::to('noaccess')->send();
        }

        return view('frontend.frontend');
    }

    private function getPageId($slug)
    {
        $page = CMSMenu::where('slug',$slug)
            ->whereHas('permissions',function($q) {
                $q->where('user_permission_id', '=', $this->userPermission);
            })
            ->where('published','=',1)
            ->first();
        if ($page) {
            return $page->id;
        }
        else {
            #page not found view
        }
    }

    public function getMenus($menu_id)
    {
        return CMSMenu::where('parent_id',$menu_id)
            ->with(['submenus' => function($q){
                $q->whereHas('permissions',function($q) {
                    $q->where('user_permission_id', '=', $this->userPermission);
                });
            }])
            ->whereHas('permissions',function($q) {
                $q->where('user_permission_id', '=', $this->userPermission);
             })
            ->where('published','=',1)
            ->orderBy('order_id','asc')
            ->get();
    }

    public function getSections($slug)
    {
        $menuid = $this->getPageId($slug);
        if ($menuid>0) {
            return CMSSection::where('menu_id',$menuid)
                ->with('data')
                ->with('component')
                ->with('page')
                ->orderBy('order_id','asc')
                ->get();
        }
    }

    public function getSpecialTaskEditions($id) {
        return ActivityEdition::where('activity_id',$id)
            ->where('status','=',true)
            ->with('tasks')
            ->WithTimeLeft()
            ->whereHas('permissions',function($q) {
                $q->where('user_permission_id', '=', $this->userPermission);
            })
            ->get();
    }

    public function getUserSpecialTaskAccess($slug)
    {
        $task = ActivitySpecialTasks::where('slug',$slug)->first();
        if (!$this->bsrUser) {
            return 0;
        }
        $userAnswer = SpecialTasksAnswer::where('task_id',$task->id)
        ->where('user_id',$this->bsrUser->id)
        ->first();

        if ($userAnswer) {
            return 1;
        } else {
            return 2;
        }
    }

    public function getQuizQuestions($id)
    {
        return QuizQuestion::where('special_task_id',$id)->with('options')->first()->toArray();
    }

    public function storeUserSpecialTaskAnswer (Request $request)
    {
        if (!$this->bsrUser) {
            return 0;
        }

        if ($request["answer"] && $request["task_id"]) {
            $task = ActivitySpecialTasks::where('id',$request["task_id"])->first();
            $userAnswer = SpecialTasksAnswer::where('task_id',$task->id)
                ->where('user_id',$this->bsrUser->id)
                ->first();
            if ($userAnswer) {
                return 1;
            } else {
                $answer = new SpecialTasksAnswer();
                $answer->task_id = $task->id;
                $answer->answer = $request["answer"];
                $answer->user_id = $this->bsrUser->id;
                $answer->manual = 1;
                $answer->save();
            }
        }
    }

    public function getSpecialTask($slug) {
        $task = ActivitySpecialTasks::where('slug',$slug)
            ->where('status',1)
            ->WithTimeLeft()
            ->first();
        return($task);
        if ($task) {
            $taskEdition = ActivityEdition::where('activity_id', $task->edition_id)
                ->where('status', '=', 1)
                ->whereHas('permissions', function ($q) {
                    $q->where('user_permission_id', '=', $this->userPermission);
                })
                ->first();
            if ($taskEdition) {
                if ($taskEdition->id > 0) {
                    return ($task);
                }
            }
        }
    }

    public function getAuthUserData()
    {
        $user = new \stdClass();

        if (env('CAS_ENABLED')) {
            $attr = cas()->getAttributes();
            $user->name = Arr::get($attr,'Imie');
            $user->lastname = Arr::get($attr,'Nazwisko');
            $user->email = Arr::get($attr,'Email');
            $user->mobile = Arr::get($attr,'Mobile');
            $user->nepu = Arr::get($attr,'msplPZUMIISNEPU');
        }
        else {
            $user->name = $this->user->name;
            $user->lastname = $this->user->lastname;
            $user->nepu = $this->nepu;
            $user->permission = $this->permission;
        }
        $bsrUser = User::where('nepu',$user->nepu)
            ->with('photo')
            ->with('new_photo')
            ->first();
        if ($bsrUser) {
            $user->photo = $bsrUser->photo;
            $user->new_photo = $bsrUser->new_photo;
        }
        return $user;
    }

    public function sendContactMessage(Request $request)
    {
        $user = $this->getAuthUserData();
        $data = array(
            'content' => $request["message"],
            'name' => $request["name"],
            'lastname' => $request["lastname"],
            'org_name' => $user->name,
            'org_lastname' => $user->lastname,
        );

        Mail::send(new ContactForm($data), $data, function($message) {
            $message->subject('Wiadomość z serwisu Liga Mistrzów BSR');
            $message->from(env('MAIL_FROM_ADRESS',env('MAIL_FROM_NAME')));
        });
        return back();
    }

    public function getSection($section_id)
    {
        return CMSSection::where('id',$section_id)
            ->with('data')
            ->with('component')
            ->first();
    }

    public function getActivityData($activity_id)
    {
        return Activity::where('id',$activity_id)
            ->where('status','1')
            ->with('header')
            ->WithTimeLeft()
            ->whereHas('permissions', function ($q) {
                $q->where('user_permission_id', '=', $this->userPermission);
            })
            ->first();
    }

    public function getContests()
    {
        if ($this->nepu) {
            return Contest::where('status','1')
                ->with('header')
                ->WithTimeLeft()
                ->WithScore($this->nepu)
                ->WithAward($this->nepu)
                ->whereHas('permissions', function ($q) {
                    $q->where('user_permission_id', '=', $this->userPermission);
                })
                ->get();
        }
    }

    public function getContest($id)
    {
        return Contest::where('id',$id)
            ->where('status','1')
            ->with('header')
            ->WithTimeLeft()
            ->WithScore($this->nepu)
            ->WithAward($this->nepu)
            ->whereHas('permissions', function ($q) {
                $q->where('user_permission_id', '=', $this->userPermission);
            })
            ->first();
    }

    public function getActivityUsers($activity_id)
    {
        $data= 0;
        switch($activity_id) {
            case '1':
                $data= DB::raw('
                SELECT
                    COUNT(DISTINCT(COALESCE(a.nepu,b.nepu,c.nepu,d.nepu,e.nepu,f.nepu,g.nepu))) AS users,
                FROM
                    activities_league_data_msk AS a,
                    FULL OUTER JOIN activities_league_data_dsk AS b USING(id),
                    FULL OUTER JOIN activities_league_data_sws AS c USING(id),
                    FULL OUTER JOIN activities_league_data_rdsk AS d USING(id),
                    FULL OUTER JOIN activities_league_data_rsws AS e USING(id),
                    FULL OUTER JOIN activities_league_data_dws_ks AS f USING(id),
                    FULL OUTER JOIN activities_league_data_dws_kz AS g USING(id),
                ');
                return $data;
                break;
            case '2':
                #liga cash
                $data= DB::raw('
                SELECT
                    COUNT(DISTINCT(COALESCE(a.nepu,b.nepu,c.nepu,d.nepu,e.nepu,f.nepu,g.nepu))) AS user,
                FROM
                    activities_league_data_msk AS a,
                FULL OUTER JOIN activities_cash_league_data_msk AS c USING(id);'
                );
                return $data;
                break;
            case '3':
                #zadania specjalne
                $data = 0;
                return $data;
                break;
            case '4':
                #konkursy
                $data = 0;
                return $data;
                break;
        }
        return $data;
    }

    private function getActivityLeagueResultsData($limit=1000)
    {
        switch ($this->permission)
        {
            case 'mws':
                return ActivityLeagueMWSData::select('miejsce','mws','k1','k2','k3','k4','k5','k6','suma')->orderBy('miejsce','asc')->take($limit)->get()->toArray();
                break;
            case 'dsk':
                return ActivityLeagueDSKData::select('miejsce','dsk','k1','k2','k3','k4','k5','k6','suma')->orderBy('miejsce','asc')->take($limit)->get()->toArray();
                break;
            case 'msk':
                return ActivityLeagueMSKData::select(['miejsce','msk','k1','k2','k3','k4','k5','k6','suma'])->orderBy('miejsce','asc')->take($limit)->get()->toArray();
                break;
            case 'rsws':
                return ActivityLeagueRMWSData::select('miejsce','rdsk','k1','k2','k3','k4','k5','k6','suma')->orderBy('miejsce','asc')->take($limit)->get()->toArray();
                break;
            case 'rdsk':
                return ActivityLeagueRDSKData::select('miejsce','rdsk','k1','k2','k3','k4','k5','k6','suma')->orderBy('miejsce','asc')->take($limit)->get()->toArray();
                break;
            case 'dws':
                return ActivityLeagueDWSData::select('miejsce','dws','k1','k2','k3','k4','k5','k6','suma')->orderBy('miejsce','asc')->take($limit)->get()->toArray();
                break;
            case 'mwp':
                return ActivityLeagueMWPData::select('miejsce','mws','k1','k2','k3','k4','k5','k6','suma')->orderBy('miejsce','asc')->take($limit)->get()->toArray();
                break;
            case 'rkwp':
                return ActivityLeagueRKWPData::select('miejsce','rdsk','k1','k2','k3','k4','k5','k6','suma')->orderBy('miejsce','asc')->take($limit)->get()->toArray();
                break;
        }
    }

    private function getActivityTopResults($activity_id,$col)
    {
        if ($activity_id == 1) {
            switch ($this->permission) {
                case 'mws':
                    return ActivityLeagueMWSData::select($col)->orderBy($col, 'desc')->limit(3)->get()->toArray();
                    break;
                case 'dsk':
                    return ActivityLeagueDSKData::select($col)->orderBy($col, 'desc')->limit(3)->get()->toArray();
                    break;
                case 'msk':
                    return ActivityLeagueMSKData::select($col)->orderBy($col, 'desc')->limit(3)->get()->toArray();
                    break;
                case 'rmws':
                    return ActivityLeagueRMWSData::select($col)->orderBy($col, 'desc')->limit(3)->get()->toArray();
                    break;
                case 'rdsk':
                    return ActivityLeagueRDSKData::select($col)->orderBy($col, 'desc')->limit(3)->get()->toArray();
                    break;
                case 'dws':
                    return ActivityLeagueDWSData::select($col)->orderBy($col, 'desc')->limit(3)->get()->toArray();
                    break;
                case 'mwp':
                    return ActivityLeagueMWPData::select($col)->orderBy($col, 'desc')->limit(3)->get()->toArray();
                    break;
                case 'rkwp':
                    return ActivityLeagueRKWPData::select($col)->orderBy($col, 'desc')->limit(3)->get()->toArray();
                    break;
            }
        }
        if ($activity_id == 2) {
            switch ($this->permission)
            {
                case 'msk':
                    return ActivityCashLeagueDataMSK::select($col)->where('nepu','!=',NULL)->orderBy($col,'desc')->limit(3)->get()->toArray();
                    break;
                case 'dsk':
                    return ActivityCashLeagueDataDSK::select($col)->where('nepu','!=',NULL)->orderBy($col,'desc')->limit(3)->get()->toArray();
                    break;
            }
        }
    }

    public function getActivityInfo($activity_id,$edition_id = 0)
    {
        $data = new \stdClass();
        $award = '';
        $place = '';
        if ($activity_id == 4) {
            if ($edition_id > 0)
            {
                $data->users = $this->getActivityModel($activity_id)::where('edition_id',$edition_id)->count();
                $myValue = $this->getActivityModel($activity_id)::select('wartosc','nagroda')
                    ->where('nepu',$this->nepu)
                    ->where('edition_id',$edition_id)
                    ->first();
                if ($myValue) {
                    $place = $this->getActivityModel($activity_id)::where('nepu', $this->nepu)
                        ->where('edition_id', $edition_id)
                        ->where('wartosc', '<', $myValue->wartosc)
                        ->count();
                    $award = $myValue->nagroda;
                }
            } else {
                $data->users = $this->getActivityModel($activity_id)::count();
            }
        }
        else {
            $data->users = $this->getActivityModel($activity_id)::count();
            $tmpplace = $this->getActivityModel($activity_id)::select('miejsce')->where('nepu',$this->nepu)->first();
            if($tmpplace) {$place = $tmpplace["miejsce"];}
        }
        $data->place = ($place?:'Brak');
        $data->award = ($award?:0);
        return($data);
    }

    public function getTopResults($activity_id)
    {
        $topResults = [];
        $columns = [];
        if ($activity_id == 1) {
            $columns = array('k1','k2','k3','k4','k5','k6');
        }
        if ($activity_id == 2) {
            if ($this->permission === 'msk') {
                $columns = array('k1','k2');
            }
            else {
                $columns = array('k1');
            }
        }
        foreach ($columns as $col)
        {
            $topResults[$col] = $this->getActivityTopResults($activity_id,$col);
        }
        $topResults["columns"] = $columns;
        return $topResults;
    }

    private function getActivityCashLeagueResultsData($limit=1000)
    {
        switch ($this->permission) {
            case 'msk':
                if ($limit > 0) {
                    return ActivityCashLeagueDataMSK::selectRaw("miejsce,uczestnik,k1,k2,pkt")->orderBy('miejsce','asc')->take($limit)->get()->toArray();
                } else {
                    return ActivityCashLeagueDataMSK::selectRaw("miejsce,uczestnik,k1,k2,pkt")->orderBy('miejsce','asc')->get()->toArray();
                }

                break;
            case 'dsk':
                if ($limit > 0) {
                    return ActivityCashLeagueDataDSK::selectRaw("miejsce,uczestnik,k1,' ' as k2,pkt")->orderBy('miejsce','asc')->take($limit)->get()->toArray();
                } else {
                    return ActivityCashLeagueDataDSK::selectRaw("miejsce,uczestnik,k1,' ' as k2,pkt")->orderBy('miejsce','asc')->get()->toArray();
                    break;
                }
        }
    }

    public function getActivityResults($activity_id,$limit=1000) {
        switch ($activity_id) {
            case '1':
                $activityData = $this->getActivityLeagueResultsData($limit);
                break;
            case '2':
                $activityData = $this->getActivityCashLeagueResultsData($limit);
                break;
            case '3':
                #zadania specjalne
                break;
            case '4':
                #konkursy
                break;
        }

        $tableData = array();
        if ($activityData) {
            foreach ($activityData as $k => $v) {
                $tableData[] = array_values($v);
            }
        }
        return $tableData;
    }

    public function dataExport($activity_id,$edition_id=0)
    {
        $activityExport = $this->getActivityDataType($activity_id,$edition_id);
        if (is_object($activityExport)) {
            $activityExport->activity_id = $activity_id;
            //$activityExport->edition_id = $edition_id;
            return Excel::download($activityExport, 'aktywnosc-'.strtoupper($this->permission).'-'.$activity_id.'.xlsx');
        }
        else
        {
            return 'Niepoprawny plik eksportu';
        }
    }

    private function getActivityModelName($activity_id) {
        if ($activity_id == 1) {
            switch ($this->permission) {
                case 'mws':
                    return 'ActivityLeagueMWSData';
                    break;
                case 'dsk':
                    return 'ActivityLeagueDSKData';
                    break;
                case 'msk':
                    return 'ActivityLeagueMSKData';
                    break;
                case 'rmws':
                    return 'ActivityLeagueRMWSData';
                    break;
                case 'rdsk':
                    return 'ActivityLeagueRDSKData';
                    break;
                case 'dws':
                    return 'ActivityLeagueDWSData';
                    break;
                case 'mwp':
                    return 'ActivityLeagueMWPData';
                    break;
                case 'rkwp':
                    return 'ActivityLeagueRKWPData';
                    break;
            }
        }

        if ($activity_id == 2) {
            switch ($this->permission)
            {
                case 'msk':
                    return 'ActivityCashLeagueDataMSK';
                    break;
                case 'dsk':
                    return 'ActivityCashLeagueDataDSK';
                    break;
            }
        }
        if ($activity_id == 4) {
            return 'ActivitySaleContestData';
        }
    }

    private function getActivityModel($activity_id) {
        $entity = $this->getActivityModelName($activity_id);
        return app(ucfirst('App\Models\\'.$entity));
    }

    private function getActivityDataType($activity_id,$edition_id=0)
    {
        if ($this->checkActivityPermissions($activity_id,$edition_id)) {
            if ($activity_id === '2') {
                switch ($this->permission) {
                    case 'msk':
                        return new ActivityCashLeagueMSKExport();
                    case 'dsk':
                        return new ActivityCashLeagueDSKExport();
                }
            }
            if ($activity_id === '1') {
                switch ($this->permission) {
                    case 'mws':
                        return new ActivityLeagueMWSExport();
                    case 'mwp':
                        return new ActivityLeagueMWPExport();
                    case 'rmws':
                        return new ActivityLeagueRMWSExport();
                    case 'rkwp':
                        return new ActivityLeagueRKWPExport();
                    case 'msk':
                        return new ActivityLeagueMSKExport();
                    case 'dsk':
                        return new ActivityLeagueDSKExport();
                    case 'rdsk':
                        return new ActivityLeagueRDSKExport();
                    case 'dws':
                        return new ActivityLeagueDWSExport();
                }
            }
            if ($activity_id === '4' && $edition_id > 0) {
                return new ActivityContestExport($edition_id);
            }
        }
    }

    public function userRegisterUserPage($token)
    {
        $User = User::where('is_validated',0)
            ->where('verification_token',$token)
            ->first();
        if ($User) {
            return view('frontend.user-validation')->with('user',$User);
        }
        else {
            return redirect('/blad-rejestracji');
        }
    }

    public function validateUserToken(FrontendUserProfile $request)
    {

        $request->validated();

        $User = User::where('is_validated',0)
            ->where('verification_token',$request["token"])
            ->first();
        if ($User) {
            if ($file = $request->file('avatar')) {
                if ($request->file('avatar')->isValid()) {
                    $name = $file->hashName();
                    $path = $request->file('avatar')->storePubliclyAs(
                        'files',
                        $name
                    );
                    $save = new File();
                    $save->type = 'user-new-avatar';
                    $save->activity_id = $User->id;
                    $save->file_name = $name;
                    $save['org_name'] = $file->getClientOriginalName();
                    $save['file_path'] = '/'.$path;
                    $save->save();
                }
            }
            $User->is_validated = 1;
            $User->verification_token = '';
            $User->save();
            return redirect('/witamy');
        }
        else {
            return redirect('/blad-rejestracji');
        }
    }

    public function showRegistrationWelcome()
    {
        return view('frontend.user-validation-success');

    }

    public function showRegistrationError()
    {
        return view('frontend.user-validation-error');
    }
}
