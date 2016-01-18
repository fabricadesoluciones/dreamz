<?php

namespace App\Http\Controllers;

use DB;
use App\Company;
use App\Period;
use App;
use App\Department;
use App\DailyEmotion;
use App\ActiveEmotion;
use App\User;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth; 
use Uuid; 
use Session; 
use Response;

class HomeController extends Controller
{
    function __construct()
    {
        if( ! session('company')){
            Session::set('name', Auth::user()->name ." ".Auth::user()->lastname);
            $company = Company::where('company_id', '=', Auth::user()->company)->first();
            $department = Department::where('department_id', '=', Auth::user()->department)->first();
            if ($company) {
                Session::set('company', Auth::user()->company);
                Session::set('company_name', $company->commercial_name);
                Session::set('company_logo', $company->logo);
            }
            if ($department) {
                Session::set('department', $department->department_id);
                Session::set('department_name', $department->name);
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( ! session('company')){
            // return $this->returnError(403, trans('general.http.select_company'), route('companies'));
            return redirect(route('companies'));
        }


        if ( ! Auth::user()->can("list-companies")){
            if ( ! session('feeling')) {
                $whereClause = ['active' => 1, 'company' => Auth::user()->company];

                $data = DB::table('active_emotions')
                ->join('emotions', 'active_emotions.emotion', '=', 'emotions.emotion_id')
                ->select('emotions.*', 'active_emotions.*')
                ->where($whereClause)
                ->get();

                return view('choose-feeling', ['emotions' => $data]);
            }else{

                if ( Auth::user()->can("list-departments")){

                    $departments = Department::where('company','=', Auth::user()->company)->get();
                }else{
                    $departments = Department::where('department_id','=', Auth::user()->department)->get();
                }

                return view('dashboard', ['user' => Auth::user(), 'departments' => $departments]);
            }

        }else{
            return redirect(route('companies'));
        }
    }

    public function users()
    {
        if ( ! Auth::user()->can("list-users")){
            return $this->returnError(403);
        }
        if( ! session('company')){
            return $this->returnError(403, trans('general.http.select_company'), route('companies'));
        }

        return view('pages.show_users');
    }

    public function companies()
    {
        if ( ! Auth::user()->can("list-companies")){
            return $this->returnError(403);
        }

        return view('pages.show_companies');
    }

    public function departments()
    {
        if ( ! Auth::user()->can("list-departments")){
            return $this->returnError(403);
        }
        if( ! session('company')){
            return $this->returnError(403, trans('general.http.select_company'), route('companies'));
        }

        return view('pages.show_departments');
    }

    public function positions()
    {
        if ( ! Auth::user()->can("list-positions")){
            return $this->returnError(403);
        }
        if( ! session('company')){
            return $this->returnError(403, trans('general.http.select_company'), route('companies'));
        }

        return view('pages.show_positions');
    }

    public function priorities()
    {
        if ( ! Auth::user()->can("list-priorities")){
            return $this->returnError(403);
        }
        if( ! session('department')){
            return $this->returnError(403, trans('general.http.select_department'), route('departments'));
        }

        return view('pages.show_priorities');
    }

    public function periods()
    {
        if ( ! Auth::user()->can("list-periods")){
            return $this->returnError(403);

        }
        if( ! session('company')){
            return $this->returnError(403, trans('general.http.select_company'), route('companies'));
        }

        return view('pages.show_periods');
    }

    public function objectives()
    {
        if ( ! Auth::user()->can("list-objectives")){
            return $this->returnError(403);

        }
        
        if( ! session('department')){
            return $this->returnError(403, trans('general.http.select_department'), route('departments'));
        }

        return view('pages.show_objectives');
    }

    public function tasks()
    {
        
        if( ! session('department')){
            return $this->returnError(403, trans('general.http.select_department'), route('departments'));
        }

        return view('pages.show_tasks');
    }

    public function dreams()
    {
        return view('pages.show_dreams');
    }

    public function emotions()
    {
        if ( ! Auth::user()->can("edit-emotions")){
            return $this->returnError(403);

        }

        if( ! session('company')){
            return $this->returnError(403, trans('general.http.select_company'), route('companies'));
        }

        return view('pages.show_emotions');
    }

    public function education()
    {
        if ( ! Auth::user()->can("edit-departments")){
            return $this->returnError(403);

        }

        if( ! session('company')){
            return $this->returnError(403, trans('general.http.select_company'), route('companies'));
        }

        return view('pages.show_education_levels');
    }

    public function measuring_units()
    {
        if ( ! Auth::user()->can("edit-departments")){
            return $this->returnError(403);

        }

        if( ! session('company')){
            return $this->returnError(403, trans('general.http.select_company'), route('companies'));
        }

        return view('pages.show_measuring_units');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setFeelingEnabled(Request $request, $id){
        $emotion = ActiveEmotion::where('active_emotion_id','=',$id)->first();
        $attributes = Request::all();
        if ( ! isset($attributes['active'] ) ) { return $this->returnError(403); }
        $active = filter_var($attributes['active'], FILTER_VALIDATE_BOOLEAN,[]);
        $emotion->active = $active;
        $emotion->save();
        return Response::json(['code' => 200, 'title' => 'Success', 'message' => 'Emotion was updated', 'type'=> 'success'], 200);

    }
    public function setFeeling($id)
    {
        $whereClause = ['emotion_date' => date('Y-m-d'), 'user' => Auth::user()->user_id];
        $todays_emotion = DB::table('daily_emotions')
                            ->where($whereClause)
                            ->first();
        if ( ! $todays_emotion) {
                
            $new_emotion = new DailyEmotion;
            $new_emotion->daily_emotion_id = Uuid::generate(4);
            $new_emotion->company = Auth::user()->company;
            $new_emotion->department = Auth::user()->department;
            $new_emotion->user = Auth::user()->user_id;
            $new_emotion->emotion = $id;
            $new_emotion->emotion_date = date('Y-m-d');
            $new_emotion->save();
            $insertedId = $new_emotion->id;
            $todays_emotion = DailyEmotion::where('daily_emotion_id','=', $insertedId)->first();

        }        
            Session::set('feeling', json_encode($todays_emotion));
            $Response = ['code'=>200,'message' => 'Se registró una emoción' ,'data' => []];
            return Response::json($Response, 200);
    }

    public static function setPeriod($company_id, $period_id = false)
    {
        if ($period_id) {
            $period = Period::where('period_id','=',$period_id)->first();
            if ($period) {
                Session::set('period', $period_id);
            }
        }else{

            $periods = Period::where('company','=', $company_id)->get();
            $today = (int) date('U');

            foreach ($periods as $period) {
                $start = strtotime($period->start);
                $end = strtotime($period->end);
                if ( ($today >= $start) && ($today <= $end) ) {
                    Session::set('period', $period->period_id);
                    break;
                }
            }

        }


    }
    public function setCompany($id)
    {
        if ( ! Auth::user()->can("list-companies")){
            return $this->returnError(403);
        }

        $company = Company::where('company_id', '=', $id)->first();

        if ($company) {
            Session::forget('company');
            Session::forget('company_name');
            Session::forget('company_logo');
            Session::forget('department');
            Session::forget('department_name');
            Session::set('company', $company->company_id);
            Session::set('company_name', $company->commercial_name);
            Session::set('company_logo', $company->logo);
            $this->setPeriod($company->company_id);
            Session::flash('update', ['code' => 200, 'message' => 'Company was updated']);

            return redirect("/companies/");
        }else{
            return $this->returnError(404);
        }
    }

    public function setDepartment($id)
    {
        if ( ! Auth::user()->can("list-departments")){
            return $this->returnError(403);
        }

        $department = Department::where('department_id', '=', $id)->first();

        if ($department) {
            Session::set('department', $department->department_id);
            Session::set('department_name', $department->name);

            Session::flash('update', ['code' => 200, 'message' => 'Department was updated']);
            return redirect("/departments/");
        }else{
            return $this->returnError(404);
        }
    }

    public function setLang($id)
    {

        if ($id == 'en') {
            App::setLocale('en');
            Session::set('language', $id);
        }else if ($id == 'es') {
            App::setLocale('es');
            Session::set('language', $id);
        }else{
            App::setLocale('en');
            Session::set('language', $id);
        }

        // Session::flash('notify', ['type' => 'success',  'title' => trans('general.success'), 'message' => trans('general.lang_updated') ]);
        return Response::json(['code'=>200,'message' => 'OK' , 'data' => trans('general.language') ], 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public static function returnTableColumns($table){
        $fields = [];
        $rawfields = DB::getSchemaBuilder()->getColumnListing($table);
        foreach ($rawfields as $field) {
            $fields[$field] = 0;
        }
        return $fields;
    }

    public static function returnError($errorCode = 404, $message = false, $callbackurl = false, $json = false)
    {
        $errorResponse = [];

        switch ($errorCode) {
            case 403:
                $errorResponse = ['code'=>403,'title' =>  trans('general.http.403t'), 'message' => trans('general.http.403') ,'data' => []];
                break;
            case 404:
                $errorResponse = ['code'=>404,'message' => trans('general.http.404') ,'data' => []];
                break;
            default:
                $errorResponse = ['code'=>404,'message' => trans('general.http.404') ,'data' => []];
                break;
        }

        if ($message) {
            $errorResponse['message'] = $message;
        }

        if (Request::ajax() || $json){
            return Response::json($errorResponse, $errorCode);
        }else{
            Session::flash('update', $errorResponse);

        }

        if ($callbackurl) {
            return redirect($callbackurl);
        }else{
            return view('pages.generic_error');
        }

    }
}
