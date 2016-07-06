<?php

namespace App\Http\Controllers;

use App\Onepage;

use App\OnePageTarget;
use App\OneCriticalNumber;
use App\OnePageInfo;
use App\OnePageAction;
use App\OneProfitX;
use App\OneBHAG;
use App\OnePageKeyThrust;
use App\OnePageBrandPromiseKPI;
use App\OnePageGoal;
use App\OnePageKeyInitiative;
use App\OnePageMakeBuy;
use App\OnePageSell;
use App\OnePageRecordKeeping;
use App\OnePageEmployee;
use App\OnePageClient;
use App\OnePageColaborator;
use App\OnePageVirtue;

use App\ObjectiveCategory;
use App\Priority;
use App\Period;
use App\Position;
use App\User;
use App\MeasuringUnit;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use DB;
use Session; 
use Uuid; 
use Hash; 
use Auth; 

class OnepagesController extends Controller
{
    private $company;
    function __construct() {
        $this->company = '';
        $this->department = '';
        if ( session('company')) {
            $this->company = session('company');
        }

        if ( session('department')) {
            $this->department = session('department');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('one_page')->get();

        if (!$data) {
            return HomeController::returnError(404);
        }
        return Response::json(['code'=>200,'message' => 'OK' , 'data' => $this->transformCollection($data)], 200);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function team()
    {
        if ( ! Auth::user()->can("edit-objectives")){
            return HomeController::returnError(403);
        }


        $user = Auth::user();
        
        $data = $user->priorities;
        
        
        $position = Position::where('position_id', '=', $user->position)->first();

        $users = [];

        if (!empty($position) && $position->boss || Auth::user()->can("edit-companies")) {
            $users = User::where('department', '=', $this->department)->get(['user_id']);

            $data = DB::table('priorities')
                ->leftJoin('users', 'priorities.user', '=', 'users.user_id')
                ->leftJoin('periods', 'priorities.period', '=', 'periods.period_id')
                ->select('priorities.*', 'users.name AS user_name','periods.name AS period_name', 'users.lastname AS user_lastname')
                ->where('users.department','=', $this->department)
                ->get();

        }

        if (!$data) {
            return HomeController::returnError(404);
        }
        return Response::json(['code'=>200,'message' => 'OK' , 'data' => $this->transformCollection($data)], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( ! session('company')){
            return HomeController::returnError(403, trans('general.http.select_company'), route('companies'));
        }

        $periods = Period::where('company','=',$this->company)->get();
        $virtues = OnePageVirtue::where('company','=',$this->company)->get();
        return view('pages.create_one_page', ['id' => Uuid::generate(4), 'periods' => $periods, 'virtues' => $virtues]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDepartmentSummary($id)
    {

        $period = Period::where('company', '=', $this->company)->first();
        $whereClause = ['objectives.period' => $period->period_id, 'objectives.type' => 'DEPARTAMENTO', 'objectives.department' => $id];
        $objectives = DB::table('objectives')
        ->where($whereClause)
        ->get();

        foreach ($objectives as $objective) {
            $whereClause = ['objectives_progress.objective' => $objective->objective_id];
            $objective->real = DB::table('objectives_progress')
            ->where($whereClause)
            ->sum('objectives_progress.value');
        }

        return Response::json(['code'=>200, 'message' => 'OK' , 'data' => $objectives] , 200);
    }

    public function getObjectiveSummary($id)
    {

        $objective = Objective::where('objective_id','=',$id)->first();
        
        $whereClause = ['objectives_progress.objective' => $objective->objective_id];
        $objective->real = DB::table('objectives_progress')
        ->where($whereClause)
        ->sum('objectives_progress.value');

        return Response::json(['code'=>200, 'message' => 'OK' , 'data' => $objective] , 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validateto = [
                'one_page_id' => 'required|unique:one_page',
                'period' => 'required',
                'one_page_date' => 'date_format:Y-m-d|after:yesterday',
        ];
        
        $this->validate($request, $validateto);
        $attributes = $request->all();

        if($this->addOnePageInfo($attributes)){
            return redirect(route('onepages'));
        }
        
    
    }

    function addOnePageInfo($attributes, $update = false)
    {
        $attributes['company'] = $this->company;

        if (!$update) {
            $fields = HomeController::returnTableColumns('one_page');
            Onepage::create(array_intersect_key($attributes, $fields));
        }
        
        foreach ($attributes['one_page_actions'] as $action) {
            if (!$action) continue;
            OnePageAction::create(
                array(
                    'one_page_action_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'description' => $action,
                )
            );
        }

        foreach ($attributes['one_page_profit_x'] as $profit_x) {
            if (!$profit_x) continue;
            OneProfitX::create(
                array(
                    'one_page_profit_x_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'description' => $profit_x,
                )
            );
        }

        foreach ($attributes['one_page_bhag'] as $bhag) {
            if (!$bhag) continue;
            OneBHAG::create(
                array(
                    'one_page_bhag_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'description' => $bhag,
                )
            );
        }


        for ($i=0; $i < count($attributes['one_page_targets_name']) ; $i++) { 
            OnePageTarget::create(
                array(
                    'one_page_target_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'name' => $attributes['one_page_targets_name'][$i],
                    'description' => $attributes['one_page_targets_description'][$i],
                )
            );
        }

        
        OnePageInfo::create(
            array(
                'one_page_general_info_id' => Uuid::generate(4),
                'company' => $attributes['company'],
                'one_page_id' => $attributes['one_page_id'],
                'purpose' => $attributes['purpose'],
                'sandbox' => $attributes['one_page_sandbox'],
                'period' => $attributes['period'],
                'date' => $attributes['one_page_date']
            )
        );

        foreach ($attributes['one_page_key_thrusts'] as $key_thrusts) {
            if (!$key_thrusts) continue;
            OnePageKeyThrust::create(
                array(
                    'one_page_key_thursts_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'description' => $key_thrusts,
                )
            );
        }
        foreach ($attributes['one_page_brand_promise_kpis'] as $brand_promise_kpis) {
            if (!$brand_promise_kpis) continue;
            OnePageBrandPromiseKPI::create(
                array(
                    'one_page_bp_kpis_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'description' => $brand_promise_kpis,
                )
            );
        }
        foreach ($attributes['one_page_goals_1_yr'] as $goals_1_yr) {
            if (!$goals_1_yr) continue;
            OnePageGoal::create(
                array(
                    'one_page_goals_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'description' => $goals_1_yr,
                )
            );
        }
        foreach ($attributes['one_page_key_initiatives'] as $key_initiatives) {
            if (!$key_initiatives) continue;
            OnePageKeyInitiative::create(
                array(
                    'one_page_key_initiatives_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'description' => $key_initiatives,
                )
            );
        }


        OneCriticalNumber::create(
            array(

                'one_page_key_criticals_id' => Uuid::generate(4),
                'company' => $attributes['company'],
                'one_page_id' => $attributes['one_page_id'],
                'description' => $attributes['one_page_critical_people_ggren'],
                'level' => 0,
                'number_type' => 'people', // people | process
                'critical_type' => 'company', // company | period | personal
                'period' => $attributes['period'],

            )
        );
        OneCriticalNumber::create(
            array(

                'one_page_key_criticals_id' => Uuid::generate(4),
                'company' => $attributes['company'],
                'one_page_id' => $attributes['one_page_id'],
                'description' => $attributes['one_page_critical_people_lgreen'],
                'level' => 1,
                'number_type' => 'people', // people | process
                'critical_type' => 'company', // company | period | personal
                'period' => $attributes['period'],

            )
        );
        OneCriticalNumber::create(
            array(

                'one_page_key_criticals_id' => Uuid::generate(4),
                'company' => $attributes['company'],
                'one_page_id' => $attributes['one_page_id'],
                'description' => $attributes['one_page_critical_people_yellow'],
                'level' => 2,
                'number_type' => 'people', // people | process
                'critical_type' => 'company', // company | period | personal
                'period' => $attributes['period'],

            )
        );
        OneCriticalNumber::create(
            array(

                'one_page_key_criticals_id' => Uuid::generate(4),
                'company' => $attributes['company'],
                'one_page_id' => $attributes['one_page_id'],
                'description' => $attributes['one_page_critical_people_red'],
                'level' => 3,
                'number_type' => 'people', // people | process
                'critical_type' => 'company', // company | period | personal
                'period' => $attributes['period'],

            )
        );
        OneCriticalNumber::create(
            array(

                'one_page_key_criticals_id' => Uuid::generate(4),
                'company' => $attributes['company'],
                'one_page_id' => $attributes['one_page_id'],
                'description' => $attributes['one_page_critical_process_ggren'],
                'level' => 0,
                'number_type' => 'process', // people | process
                'critical_type' => 'company', // company | period | personal
                'period' => $attributes['period'],

            )
        );
        OneCriticalNumber::create(
            array(

                'one_page_key_criticals_id' => Uuid::generate(4),
                'company' => $attributes['company'],
                'one_page_id' => $attributes['one_page_id'],
                'description' => $attributes['one_page_critical_process_lgreen'],
                'level' => 1,
                'number_type' => 'process', // people | process
                'critical_type' => 'company', // company | period | personal
                'period' => $attributes['period'],

            )
        );
        OneCriticalNumber::create(
            array(

                'one_page_key_criticals_id' => Uuid::generate(4),
                'company' => $attributes['company'],
                'one_page_id' => $attributes['one_page_id'],
                'description' => $attributes['one_page_critical_process_yellow'],
                'level' => 2,
                'number_type' => 'process', // people | process
                'critical_type' => 'company', // company | period | personal
                'period' => $attributes['period'],

            )
        );
        OneCriticalNumber::create(
            array(

                'one_page_key_criticals_id' => Uuid::generate(4),
                'company' => $attributes['company'],
                'one_page_id' => $attributes['one_page_id'],
                'description' => $attributes['one_page_critical_process_red'],
                'level' => 3,
                'number_type' => 'process', // people | process
                'critical_type' => 'company', // company | period | personal
                'period' => $attributes['period'],

            )
        );

        foreach ($attributes['one_page_make_buy'] as $make_buy) {
            if (!$make_buy) continue;
            OnePageMakeBuy::create(
                array(
                    'one_page_make_buy_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'description' => $make_buy,
                )
            );
        }
        foreach ($attributes['one_page_sell'] as $sell) {
            if (!$sell) continue;
            OnePageSell::create(
                array(
                    'one_page_sell_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'description' => $sell,
                )
            );
        }
        foreach ($attributes['one_page_record_keeping'] as $record_keeping) {
            if (!$record_keeping) continue;
            OnePageRecordKeeping::create(
                array(
                    'one_page_recrod_keeping_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'description' => $record_keeping,
                )
            );
        }
        foreach ($attributes['one_page_employees'] as $employees) {
            if (!$employees) continue;
            OnePageEmployee::create(
                array(
                    'one_page_employees_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'description' => $employees,
                )
            );
        }
        foreach ($attributes['one_page_clients'] as $clients) {
            if (!$clients) continue;
            OnePageClient::create(
                array(
                    'one_page_customers_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'description' => $clients,
                )
            );
        }
        foreach ($attributes['one_page_colaborators'] as $colaborators) {
            if (!$colaborators) continue;
            OnePageColaborator::create(
                array(
                    'one_page_colaborators_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'description' => $colaborators,
                )
            );
        }

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ( ! Auth::user()->can("edit-objectives")){
            return HomeController::returnError(403);
        }

        $data = Priority::where('priority_id', '=', $id)->first();

        if (!$data) {
            return HomeController::returnError(404);
        }
        return Response::json(['code'=>200,'message' => 'OK' , 'data' => $this->transform($data->toArray())], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if( ! session('company')){
            return $this->returnError(403, trans('general.http.select_company'), route('companies'));
        }


        $onepagetargets = OnePageTarget::where('one_page_id','=',$id)->get();
        $matchThese = ['one_page_id' => $id, 'number_type' => 'people', 'critical_type' => 'company'];
        $onecritical_people_company_numbers = OneCriticalNumber::where($matchThese)->orderBy('level', 'asc')->get();
        $matchThese = ['one_page_id' => $id, 'number_type' => 'process', 'critical_type' => 'company'];
        $onecritical_process_company_numbers = OneCriticalNumber::where($matchThese)->orderBy('level', 'asc')->get();
        $onepageinfo = OnePageInfo::where('one_page_id','=',$id)->first();
        $onepageactions = OnePageAction::where('one_page_id','=',$id)->get();
        $oneprofitxs = OneProfitX::where('one_page_id','=',$id)->get();
        $onebhags = OneBHAG::where('one_page_id','=',$id)->get();
        $onepagekeythrusts = OnePageKeyThrust::where('one_page_id','=',$id)->get();
        $onepagebrandpromisekpis = OnePageBrandPromiseKPI::where('one_page_id','=',$id)->get();
        $onepagegoals = OnePageGoal::where('one_page_id','=',$id)->get();
        $onepagekeyinitiatives = OnePageKeyInitiative::where('one_page_id','=',$id)->get();
        $onepagemakebuys = OnePageMakeBuy::where('one_page_id','=',$id)->get();
        $onepagesells = OnePageSell::where('one_page_id','=',$id)->get();
        $onepagerecordkeepings = OnePageRecordKeeping::where('one_page_id','=',$id)->get();
        $onepageemployees = OnePageEmployee::where('one_page_id','=',$id)->get();
        $onepageclients = OnePageClient::where('one_page_id','=',$id)->get();
        $onepagecolaborators = OnePageColaborator::where('one_page_id','=',$id)->get();
        $onepagevirtues = OnePageVirtue::where('one_page_id','=',$id)->get();



        $periods = Period::where('company','=',$this->company)->get();
        $virtues = OnePageVirtue::where('company','=',$this->company)->get();
        $params = array(
            'id' => $id,
            'periods' => $periods,
            'virtues' => $virtues,
            'onepagetargets' => $onepagetargets,
            'onecritical_people_company_numbers' => $onecritical_people_company_numbers,
            'onecritical_process_company_numbers' => $onecritical_process_company_numbers,
            'onepageinfo' => $onepageinfo,
            'onepageactions' => $onepageactions,
            'oneprofitxs' => $oneprofitxs,
            'onebhags' => $onebhags,
            'onepagekeythrusts' => $onepagekeythrusts,
            'onepagebrandpromisekpis' => $onepagebrandpromisekpis,
            'onepagegoals' => $onepagegoals,
            'onepagekeyinitiatives' => $onepagekeyinitiatives,
            'onepagemakebuys' => $onepagemakebuys,
            'onepagesells' => $onepagesells,
            'onepagerecordkeepings' => $onepagerecordkeepings,
            'onepageemployees' => $onepageemployees,
            'onepageclients' => $onepageclients,
            'onepagecolaborators' => $onepagecolaborators,
            'onepagevirtues' => $onepagevirtues
        );
        return view('pages.edit_one_page', $params);
        // var_dump($onepageinfo->period);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $validateto = [
                'one_page_id' => 'required',
                'period' => 'required',
                'one_page_date' => 'date_format:Y-m-d',
        ];
        
        $this->validate($request, $validateto);
        $attributes = $request->all();

        $onepagetargets = OnePageTarget::where('one_page_id','=',$id)->delete();
        $matchThese = ['one_page_id' => $id, 'number_type' => 'people', 'critical_type' => 'company'];
        $onecritical_people_company_numbers = OneCriticalNumber::where($matchThese)->delete();
        $matchThese = ['one_page_id' => $id, 'number_type' => 'process', 'critical_type' => 'company'];
        $onecritical_process_company_numbers = OneCriticalNumber::where($matchThese)->delete();
        $onepageinfo = OnePageInfo::where('one_page_id','=',$id)->first();
        $onepageactions = OnePageAction::where('one_page_id','=',$id)->delete();
        $oneprofitxs = OneProfitX::where('one_page_id','=',$id)->delete();
        $onebhags = OneBHAG::where('one_page_id','=',$id)->delete();
        $onepagekeythrusts = OnePageKeyThrust::where('one_page_id','=',$id)->delete();
        $onepagebrandpromisekpis = OnePageBrandPromiseKPI::where('one_page_id','=',$id)->delete();
        $onepagegoals = OnePageGoal::where('one_page_id','=',$id)->delete();
        $onepagekeyinitiatives = OnePageKeyInitiative::where('one_page_id','=',$id)->delete();
        $onepagemakebuys = OnePageMakeBuy::where('one_page_id','=',$id)->delete();
        $onepagesells = OnePageSell::where('one_page_id','=',$id)->delete();
        $onepagerecordkeepings = OnePageRecordKeeping::where('one_page_id','=',$id)->delete();
        $onepageemployees = OnePageEmployee::where('one_page_id','=',$id)->delete();
        $onepageclients = OnePageClient::where('one_page_id','=',$id)->delete();
        $onepagecolaborators = OnePageColaborator::where('one_page_id','=',$id)->delete();
        $onepagevirtues = OnePageVirtue::where('one_page_id','=',$id)->delete();

        if($this->addOnePageInfo($attributes, true)){
            return redirect(route('onepages'));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( ! Auth::user()->can("edit-objectives")){
            return HomeController::returnError(403);
        }

        $objective = Task::where('task_id', '=', $id);
        if (!$objective) {
            return HomeController::returnError(404);
        }

        $objective->delete();

        return Response::json(['code'=>204,'message' => 'OK' , 'data' => "$id " . trans('general.http.204')] , 204);
        
    }

    public function transformCollection($positions)
    {
        if(is_array($positions)){
            return $positions;
        }
        return array_map([$this, 'transform'] , $positions->toArray());
    }

    private function transform ($position)
    {
        return $position;
    }
}
