<?php

namespace App\Http\Controllers;

use DB;
use App\Company;
use App\Department;
use App\User;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth; 
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

        return view('welcome');
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
