<?php

namespace App\Http\Controllers;

use App\Onepage;

use App\OnePageStrength;
use App\OnePageWeakness;
use App\OnePageTrend;
use App\OnePageTheme;
use App\OnePageCelebration;
use App\OnePageReward;

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

    /**
     * @return Session
     */
    public function store_extras(Request $request)
    {

        $validateto = [
            'type' => 'required',
            'new_extra_name' => 'required',
            'new_extra_date' => 'required|date_format:Y-m-d'
        ];
        $this->validate($request, $validateto);
        $attributes = $request->all();
        $active = ( isset($attributes['active']) && $attributes['active'] ) ? $attributes['active'] : false;
        switch( $attributes['type'] ){

            case 'core_value':
                if ( ! Auth::user()->can('edit-one_page') ) return HomeController::returnError(403);
                $one_page_virtues_id = Uuid::generate(4);
                $insert =  array(
                        'company' => $this->company,
                        'one_page_virtues_id' => $one_page_virtues_id->string,
                        'active' => $active,
                        'description' => $attributes['new_extra_name'],
                        'target_date' => $attributes['new_extra_date']

                    );
                DB::table('one_page_virtues')->insert($insert);
                return Response::json([  'data' =>  ['id' => $insert['one_page_virtues_id'], 'name' => $insert['description']]  ] , 200);
                break;
            case 'company_objectives':
                if ( ! Auth::user()->can('edit-one_page') ) return HomeController::returnError(403);
                $one_page_objectives_id = Uuid::generate(4);
                $insert =  array(
                    'company' => $this->company,
                    'one_page_objectives_id' => $one_page_objectives_id->string,
                    'one_page_id' => $attributes['one_page_id'],
                    'selected' => false,
                    'active' => true,
                    'type' => 'company',
                    'description' => $attributes['new_extra_name'],
                    'target_date' => $attributes['new_extra_date']

                );
                DB::table('one_page_objectives')->insert($insert);
                return Response::json([  'data' =>  ['id' => $insert['one_page_objectives_id'], 'name' => $insert['description']]  ] , 200);
                break;
            case 'company_priorities':
                if ( ! Auth::user()->can('edit-one_page') ) return HomeController::returnError(403);
                $one_page_priorities_id = Uuid::generate(4);
                $insert =  array(
                    'company' => $this->company,
                    'one_page_priorities_id' => $one_page_priorities_id->string,
                    'one_page_id' => $attributes['one_page_id'],
                    'selected' => false,
                    'active' => true,
                    'type' => 'company',
                    'description' => $attributes['new_extra_name'],
                    'target_date' => $attributes['new_extra_date']

                );
                DB::table('one_page_priorities')->insert($insert);
                return Response::json([  'data' =>  ['id' => $insert['one_page_priorities_id'], 'name' => $insert['description']]  ] , 200);
                break;
            case 'user_objectives':
                $one_page_objectives_id = Uuid::generate(4);
                $insert =  array(
                    'company' => $this->company,
                    'one_page_objectives_id' => $one_page_objectives_id->string,
                    'one_page_id' => $attributes['one_page_id'],
                    'selected' => false,
                    'active' => true,
                    'user' => Auth::user()->user_id,
                    'type' => 'user',
                    'description' => $attributes['new_extra_name'],
                    'target_date' => $attributes['new_extra_date']

                );
                DB::table('one_page_objectives')->insert($insert);
                return Response::json([  'data' =>  ['id' => $insert['one_page_objectives_id'], 'name' => $insert['description']]  ] , 200);
                break;
            case 'user_priorities':
                $one_page_priorities_id = Uuid::generate(4);
                $insert =  array(
                    'company' => $this->company,
                    'one_page_priorities_id' => $one_page_priorities_id->string,
                    'one_page_id' => $attributes['one_page_id'],
                    'selected' => false,
                    'active' => true,
                    'user' => Auth::user()->user_id,
                    'type' => 'user',
                    'description' => $attributes['new_extra_name'],
                    'target_date' => $attributes['new_extra_date']

                );
                DB::table('one_page_priorities')->insert($insert);
                return Response::json([  'data' =>  ['id' => $insert['one_page_priorities_id'], 'name' => $insert['description']]  ] , 200);
                break;
            default:
                die('error');
        }

    }

    function updateCriticalNumber($one_page_id, $description, $level, $number_type, $critical_type, $period){
        OneCriticalNumber::create(
            array(
                'one_page_key_criticals_id' => Uuid::generate(4),
                'company' => $this->company,
                'one_page_id' => $one_page_id,
                'description' => $description,
                'level' => $level,
                'number_type' => $number_type,
                'critical_type' => $critical_type,
                'period' => $period
            )
        );
    }


    function updateMyOnePage($attributes, $id){

        DB::table('one_page_objectives')->where(['one_page_id' => $id, 'type' => 'user'])->update(array('selected' => FALSE));
        DB::table('one_page_priorities')->where(['one_page_id' => $id, 'type' => 'user'])->update(array('selected' => FALSE));

        if (isset($attributes['one_page_user_priorities']) ){
            DB::table('one_page_priorities')
                ->whereIn('one_page_priorities_id', $attributes['one_page_user_priorities'])
                ->update(array('selected' => TRUE));
        }

        if (isset($attributes['one_page_user_objectives']) ){
            DB::table('one_page_objectives')
                ->whereIn('one_page_objectives_id', $attributes['one_page_user_objectives'])
                ->update(array('selected' => TRUE));
        }

        OneCriticalNumber::where( ['one_page_id' => $attributes['one_page_id'], 'critical_type' => 'personal'] )->delete();

        if ($attributes['one_page_critical_people_personal_period_ggren']) {
                $this->updateCriticalNumber($attributes['one_page_id'], $attributes['one_page_critical_people_personal_period_ggren'], 0, 'people', 'personal', $attributes['period'] );
        }

        if ($attributes['one_page_critical_people_personal_period_lgreen']) {
                $this->updateCriticalNumber($attributes['one_page_id'], $attributes['one_page_critical_people_personal_period_lgreen'], 1, 'people', 'personal', $attributes['period'] );
        }

        if ($attributes['one_page_critical_people_personal_period_yellow']) {
                $this->updateCriticalNumber($attributes['one_page_id'], $attributes['one_page_critical_people_personal_period_yellow'], 2, 'people', 'personal', $attributes['period'] );
        }

        if ($attributes['one_page_critical_people_personal_period_red']) {
                $this->updateCriticalNumber($attributes['one_page_id'], $attributes['one_page_critical_people_personal_period_red'], 3, 'people', 'personal', $attributes['period'] );
        }

        if ($attributes['one_page_critical_process_personal_period_ggren']) {
                $this->updateCriticalNumber($attributes['one_page_id'], $attributes['one_page_critical_process_personal_period_ggren'], 0, 'process', 'personal', $attributes['period'] );
        }

        if ($attributes['one_page_critical_process_personal_period_lgreen']) {
                $this->updateCriticalNumber($attributes['one_page_id'], $attributes['one_page_critical_process_personal_period_lgreen'], 1, 'process', 'personal', $attributes['period'] );
        }

        if ($attributes['one_page_critical_process_personal_period_yellow']) {
                $this->updateCriticalNumber($attributes['one_page_id'], $attributes['one_page_critical_process_personal_period_yellow'], 2, 'process', 'personal', $attributes['period'] );
        }

        if ($attributes['one_page_critical_process_personal_period_red']) {
                $this->updateCriticalNumber($attributes['one_page_id'], $attributes['one_page_critical_process_personal_period_red'], 3, 'process', 'personal', $attributes['period'] );
        }

        return true;
    }

    function updateCompanyPeriod($attributes, $id){

        DB::table('one_page_objectives')->where(['one_page_id' => $id, 'type' => 'company'])->update(array('selected' => FALSE));
        DB::table('one_page_priorities')->where(['one_page_id' => $id, 'type' => 'company'])->update(array('selected' => FALSE));
        if (isset($attributes['one_page_company_priorities']) ){
            DB::table('one_page_priorities')
                ->whereIn('one_page_priorities_id', $attributes['one_page_company_priorities'])
                ->update(array('selected' => TRUE));
        }

        if (isset($attributes['one_page_company_objectives']) ){
            DB::table('one_page_objectives')
                ->whereIn('one_page_objectives_id', $attributes['one_page_company_objectives'])
                ->update(array('selected' => TRUE));
        }
        OneCriticalNumber::where( ['one_page_id' => $attributes['one_page_id'], 'critical_type' => 'company_period'] )->delete();

        OnePageTheme::where( ['one_page_id' => $attributes['one_page_id']] )->delete();
        OnePageCelebration::where( ['one_page_id' => $attributes['one_page_id']] )->delete();


        OnePageTheme::create(

            array(
                'one_page_theme_id' => Uuid::generate(4),
                'company' => $this->company,
                'one_page_id' => $attributes['one_page_id'],
                'description' => $attributes['one_page_company_period_tema'],
                'dead_line' => $attributes['one_page_company_period_deadline'],
                'critical_number' => $attributes['one_page_company_period_numero_critico']
            )
        );

        OnePageCelebration::create(

            array(
                'one_page_celebration_id' => Uuid::generate(4),
                'company' => $this->company,
                'one_page_id' => $attributes['one_page_id'],
                'period' => $attributes['period'],
                'description' => $attributes['one_page_company_period_celebration']
            )
        );

        if ($attributes['one_page_critical_people_company_period_ggren']) {
                $this->updateCriticalNumber($attributes['one_page_id'], $attributes['one_page_critical_people_company_period_ggren'], 0, 'people', 'company_period', $attributes['period'] );
        }

        if ($attributes['one_page_critical_people_company_period_lgreen']) {
                $this->updateCriticalNumber($attributes['one_page_id'], $attributes['one_page_critical_people_company_period_lgreen'], 1, 'people', 'company_period', $attributes['period'] );
        }

        if ($attributes['one_page_critical_people_company_period_yellow']) {
                $this->updateCriticalNumber($attributes['one_page_id'], $attributes['one_page_critical_people_company_period_yellow'], 2, 'people', 'company_period', $attributes['period'] );
        }

        if ($attributes['one_page_critical_people_company_period_red']) {
                $this->updateCriticalNumber($attributes['one_page_id'], $attributes['one_page_critical_people_company_period_red'], 3, 'people', 'company_period', $attributes['period'] );
        }

        if ($attributes['one_page_critical_process_company_period_ggren']) {
                $this->updateCriticalNumber($attributes['one_page_id'], $attributes['one_page_critical_process_company_period_ggren'], 0, 'process', 'company_period', $attributes['period'] );
        }

        if ($attributes['one_page_critical_process_company_period_lgreen']) {
                $this->updateCriticalNumber($attributes['one_page_id'], $attributes['one_page_critical_process_company_period_lgreen'], 1, 'process', 'company_period', $attributes['period'] );
        }

        if ($attributes['one_page_critical_process_company_period_yellow']) {
                $this->updateCriticalNumber($attributes['one_page_id'], $attributes['one_page_critical_process_company_period_yellow'], 2, 'process', 'company_period', $attributes['period'] );
        }

        if ($attributes['one_page_critical_process_company_period_red']) {
                $this->updateCriticalNumber($attributes['one_page_id'], $attributes['one_page_critical_process_company_period_red'], 3, 'process', 'company_period', $attributes['period'] );
        }

        return true;


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
                'description' => $attributes['one_page_critical_people_company_ggren'],
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
                'description' => $attributes['one_page_critical_people_company_lgreen'],
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
                'description' => $attributes['one_page_critical_people_company_yellow'],
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
                'description' => $attributes['one_page_critical_people_company_red'],
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
                'description' => $attributes['one_page_critical_process_company_ggren'],
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
                'description' => $attributes['one_page_critical_process_company_lgreen'],
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
                'description' => $attributes['one_page_critical_process_company_yellow'],
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
                'description' => $attributes['one_page_critical_process_company_red'],
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

        foreach ($attributes['one_page_strengths'] as $strength) {
            if (!$strength) continue;
            OnePageStrength::create(
                array(
                    'one_page_strengths_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'description' => $strength,
                )
            );
        }
        foreach ($attributes['one_page_weaknesses'] as $weakness) {
            if (!$weakness) continue;
            OnePageWeakness::create(
                array(
                    'one_page_weaknesses_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'description' => $weakness,
                )
            );
        }
        foreach ($attributes['one_page_trends'] as $trend) {
            if (!$trend) continue;
            OnePageTrend::create(
                array(
                    'one_page_trends_id' => Uuid::generate(4),
                    'company' => $attributes['company'],
                    'one_page_id' => $attributes['one_page_id'],
                    'description' => $trend,
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

        $matchThese = ['one_page_id' => $id, 'number_type' => 'people', 'critical_type' => 'company_period'];
        $onecritical_people_company_period_numbers = OneCriticalNumber::where($matchThese)->orderBy('level', 'asc')->get();
        $matchThese = ['one_page_id' => $id, 'number_type' => 'process', 'critical_type' => 'company_period'];
        $onecritical_process_company_period_numbers = OneCriticalNumber::where($matchThese)->orderBy('level', 'asc')->get();

        $matchThese = ['one_page_id' => $id, 'number_type' => 'people', 'critical_type' => 'personal'];
        $onecritical_people_personal_numbers = OneCriticalNumber::where($matchThese)->orderBy('level', 'asc')->get();
        $matchThese = ['one_page_id' => $id, 'number_type' => 'process', 'critical_type' => 'personal'];
        $onecritical_process_personal_numbers = OneCriticalNumber::where($matchThese)->orderBy('level', 'asc')->get();

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
        $onepagestrengths = OnePageStrength::where('one_page_id','=',$id)->get();
        $onepageweaknesses = OnePageWeakness::where('one_page_id','=',$id)->get();
        $onepagetrends = OnePageTrend::where('one_page_id','=',$id)->get();
        $onepagecelebration = OnePageCelebration::where('one_page_id','=',$id)->first();
        $onepagetheme = OnePageTheme::where('one_page_id','=',$id)->first();
        $onepagereward = OnePageReward::where('one_page_id','=',$id)->first();

        $onepagevirtues = DB::table('one_page_virtues')
            ->leftJoin('one_page_core_values', 'one_page_virtues.one_page_virtues_id', '=', 'one_page_core_values.one_page_virtues_id')
            ->select('one_page_virtues.*','one_page_core_values.one_page_id')
            ->where('one_page_virtues.company','=', $this->company)
            ->get();

        foreach ($onepagevirtues as $item) {
            $item->selected = FALSE;
            if ($item->one_page_id === $id){
                $item->selected = TRUE;
            }
        }
        $core_values = DB::table('one_page_core_values')
            ->where('company','=', $this->company)
            ->get();

        $company_objectives = DB::table('one_page_objectives')
            ->where([
                    'one_page_id' => $id,
                    'type' => 'company',
                    'active' => TRUE
                ])
            ->get();

        $company_priorities= DB::table('one_page_priorities')
            ->where([
                    'one_page_id' => $id,
                    'type' => 'company',
                    'active' => TRUE
                ])
            ->get();

        $user_objectives = DB::table('one_page_objectives')
            ->where([
                    'one_page_id' => $id,
                    'type' => 'user',
                    'user' => Auth::user()->user_id,
                    'active' => TRUE
                ])
            ->get();

        $user_priorities= DB::table('one_page_priorities')
            ->where([
                    'one_page_id' => $id,
                    'type' => 'user',
                    'user' => Auth::user()->user_id,
                    'active' => TRUE
                ])
            ->get();

        $periods = Period::where('company','=',$this->company)->get();
        $virtues = OnePageVirtue::where('company','=',$this->company)->get();
        $params = array(
            'id' => $id,
            'periods' => $periods,
            'virtues' => $virtues,
            'onepagetargets' => $onepagetargets,
            'onecritical_people_company_numbers' => $onecritical_people_company_numbers,
            'onecritical_people_company_period_numbers' => $onecritical_people_company_period_numbers,
            'onecritical_people_personal_numbers' => $onecritical_people_personal_numbers,
            'onecritical_process_company_numbers' => $onecritical_process_company_numbers,
            'onecritical_process_company_period_numbers' => $onecritical_process_company_period_numbers,
            'onecritical_process_personal_numbers' => $onecritical_process_personal_numbers,
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
            'onepagevirtues' => $onepagevirtues,
            'onepagestrengths' => $onepagestrengths,
            'onepageweaknesses' => $onepageweaknesses,
            'onepagetrends' => $onepagetrends,
            'onepagetheme' => $onepagetheme,
            'onepagecelebration' => $onepagecelebration,
            'onepagereward' => $onepagereward,
            'core_values' => $core_values,
            'company_objectives' => $company_objectives,
            'company_priorities' => $company_priorities,
            'user_objectives' => $user_objectives,
            'user_priorities' => $user_priorities,
        );

        return view('onepage.edit', $params);
//        echo json_encode($params);
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
                'onepage_type' => 'required',
                'one_page_id' => 'required',
                'one_page_date' => 'date_format:Y-m-d',
        ];

        $this->validate($request, $validateto);
        $attributes = $request->all();
        if ($attributes['onepage_type'] == 'company') {
            if ($this->updateSummary($attributes, $id)) return redirect(route('onepages'));

        }

        if ($attributes['onepage_type'] == 'company_period'){
            if ($this->updateCompanyPeriod($attributes, $id)) return redirect(route('onepages'));
        }

        if ($attributes['onepage_type'] == 'my_one_page'){
            if ($this->updateMyOnePage($attributes, $id)) return redirect(route('onepages'));
        }


    }

    public function updateSummary($attributes, $id)
    {
        if ( Auth::user()->can('edit-one_page') ) {

            DB::table('one_page_core_values')->where('one_page_id','=', $id)->delete();

            if (isset($attributes['one_page_virtues'])){

                foreach ($attributes['one_page_virtues'] as $one_page_virtue) {

                    DB::table('one_page_core_values')->insert(
                        array(
                            'one_page_core_values_id' => Uuid::generate(4),
                            'one_page_id' => $id,
                            'company' => $this->company,
                            'one_page_virtues_id' => $one_page_virtue
                        )
                    );
                }
            }


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
//            $onepagevirtues = OnePageVirtue::where('one_page_id','=',$id)->delete();
            $onepagestrengths = OnePageStrength::where('one_page_id','=',$id)->delete();
            $onepageweaknesses = OnePageWeakness::where('one_page_id','=',$id)->delete();
            $onepagetrends = OnePageTrend::where('one_page_id','=',$id)->delete();

            if($this->addOnePageInfo($attributes, true)){
                return true;
            }
        }else{
            return HomeController::returnError(403);
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

        if ( Auth::user()->can('edit-one_page') ) {

            Onepage::where(['one_page_id' => $id])->delete();
            OnePageStrength::where(['one_page_id' => $id])->delete();
            OnePageWeakness::where(['one_page_id' => $id])->delete();
            OnePageTrend::where(['one_page_id' => $id])->delete();
            OnePageTheme::where(['one_page_id' => $id])->delete();
            OnePageCelebration::where(['one_page_id' => $id])->delete();
            OnePageReward::where(['one_page_id' => $id])->delete();
            OnePageTarget::where(['one_page_id' => $id])->delete();
            OneCriticalNumber::where(['one_page_id' => $id])->delete();
            OnePageInfo::where(['one_page_id' => $id])->delete();
            OnePageAction::where(['one_page_id' => $id])->delete();
            OneProfitX::where(['one_page_id' => $id])->delete();
            OneBHAG::where(['one_page_id' => $id])->delete();
            OnePageKeyThrust::where(['one_page_id' => $id])->delete();
            OnePageBrandPromiseKPI::where(['one_page_id' => $id])->delete();
            OnePageGoal::where(['one_page_id' => $id])->delete();
            OnePageKeyInitiative::where(['one_page_id' => $id])->delete();
            OnePageMakeBuy::where(['one_page_id' => $id])->delete();
            OnePageSell::where(['one_page_id' => $id])->delete();
            OnePageRecordKeeping::where(['one_page_id' => $id])->delete();
            OnePageEmployee::where(['one_page_id' => $id])->delete();
            OnePageClient::where(['one_page_id' => $id])->delete();
            OnePageColaborator::where(['one_page_id' => $id])->delete();

            return Response::json(['code'=>204,'message' => 'OK' , 'data' => "$id " . trans('general.http.204')] , 204);
        }else{
            return HomeController::returnError(403);
        }

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
