<?php

namespace App\Http\Controllers;

use DB;
use App\Company;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth; 
use Session; 
use Response;

class HomeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::set('name', Auth::user()->name ." ".Auth::user()->lastname);

        return view('welcome');
    }

    public function users()
    {
        if ( ! Auth::user()->can("list-users")){
            return $this->returnForbidden();
        }

        return view('pages.show_users');
    }

    public function companies()
    {
        if ( ! Auth::user()->can("list-companies")){
            return $this->returnForbidden();
        }

        return view('pages.show_companies');
    }

    public function departments()
    {
        if ( ! Auth::user()->can("list-departments")){
            return $this->returnForbidden();
        }

        return view('pages.show_departments');
    }

    public function positions()
    {
        if ( ! Auth::user()->can("list-positions")){
            return $this->returnForbidden();
        }

        return view('pages.show_positions');
    }

    public function priorities()
    {
        if ( ! Auth::user()->can("list-priorities")){
            return $this->returnForbidden();
        }

        return view('pages.show_priorities');
    }

    public function periods()
    {
        if ( ! Auth::user()->can("list-periods")){
            return $this->returnForbidden();

        }

        return view('pages.show_periods');
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
    public function set($id)
    {
        $company = Company::where('company_id', '=', $id)->first();

        if ($company) {
            Session::forget('company');
            Session::forget('company_name');
            Session::set('company', $company->company_id);
            Session::set('company_name', $company->commercial_name);
            return $company->commercial_name;
        }else{
            return 0;
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

    public function returnForbidden()
    {
        Session::flash('update', ['code'=>403,'message' => 'User can not access this resource' ]);
        return view('pages.generic_error');

    }
}
