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
        return view('pages.show_users');
    }

    public function companies()
    {
        return view('pages.show_companies');
    }

    public function departments()
    {
        return view('pages.show_departments');
    }

    public function positions()
    {
        return view('pages.show_positions');
    }

    public function priorities()
    {
        return view('pages.show_priorities');
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
}
