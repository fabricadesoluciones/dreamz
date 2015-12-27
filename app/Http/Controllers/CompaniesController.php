<?php

namespace App\Http\Controllers;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;
use DB;
use Session; 
use Auth; 

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( ! Auth::user()->can("list-companies")){
            return Response::json(['code'=>403,'message' => trans('general.http.403') ,'data' => []], 403);
            exit;
        }
        $data = Company::all();
        if (!$data) {
            return Response::json(['code'=>404,'message' => trans('general.http.404') ,'data' => []], 404);
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
        if ( ! Auth::user()->can("edit-companies")){
            return Response::json(['code'=>403,'message' => trans('general.http.403') ,'data' => []], 403);
            exit;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( ! Auth::user()->can("edit-companies")){
            return Response::json(['code'=>403,'message' => trans('general.http.403') ,'data' => []], 403);
            exit;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ( ! Auth::user()->can("list-companies")){
            return Response::json(['code'=>403,'message' => trans('general.http.403') ,'data' => []], 403);
            exit;
        }

        $data = Company::where('company_id', '=', $id)->first();
        if (!$data) {
            return Response::json(['code'=>404,'message' => trans('general.http.404') ,'data' => []], 404);
        }
        return Response::json(['code'=>200,'message' => 'OK' , 'data' => $this->transform($data->toArray())], 200);
    }

     /**
     * Display the users for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function users($id)
    {

        $data = Company::where('company_id', '=', $id)->first()->users;
        if (!$data) {
            return Response::json(['code'=>404,'message' => trans('general.http.404') ,'data' => []], 404);
        }
        return Response::json(['code'=>200,'message' => 'OK' , 'data' => $this->transform($data->toArray())], 200);
    }

    /**
     * Display the departments for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function departments($id)
    {
        $data = Company::where('company_id', '=', $id)->first()->departments;
        if (!$data) {
            return Response::json(['code'=>404,'message' => trans('general.http.404') ,'data' => []], 404);
        }
        return Response::json(['code'=>200,'message' => 'OK' , 'data' => $this->transform($data->toArray())], 200);
    }

    /**
     * Display the positions for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function positions($id)
    {
        $data = Company::where('company_id', '=', $id)->first()->positions;
        if (!$data) {
            return Response::json(['code'=>404,'message' => trans('general.http.404') ,'data' => []], 404);
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
        if ( ! Auth::user()->can("edit-companies")){
            return Response::json(['code'=>403,'message' => trans('general.http.403') ,'data' => []], 403);
            exit;
        }

        $data = Company::where('company_id', '=', $id)->first();
        return view('pages.edit_company', ['company' => $data]);
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
        
        if ( ! Auth::user()->can("edit-companies")){
            return Response::json(['code'=>403,'message' => trans('general.http.403') ,'data' => []], 403);
            exit;
        }

        $attributes = $request->all();
        $attributes["active"] = (array_key_exists('active', $attributes)) ? intval($attributes["active"]) : 0;
        
        $company = Company::where('company_id', '=', $id)->first();
        $company->fill($attributes);
        $company->save();

        Session::flash('update', ['code' => 200, 'message' => 'Company info was updated']);
        // return back();
        return redirect("/companies/$id/edit");

        
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( ! Auth::user()->can("edit-companies")){
            return Response::json(['code'=>403,'message' => trans('general.http.403') ,'data' => []], 403);
            exit;
        }
        
        $company = Company::where('company_id', '=', $id)->first();
        if (!$company) {
            return Response::json(['code'=>404,'message' => trans('general.http.404') ,'data' => []], 404);
            exit;
        }

        $company->active = 0;
        $company->save();

        return Response::json(['code'=>204,'message' => 'OK' , 'data' => "$id " . trans('general.http.204b')] , 204);
        
    }

    public function transformCollection($companys)
    {
        return array_map([$this, 'transform'] , $companys->toArray());
    }

    private function transform ($company)
    {
        return $company;
    }
}
