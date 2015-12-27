<?php

namespace App\Http\Controllers;

use App\Period;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;
use DB;
use Session; 
use Uuid; 
use Hash; 
use Auth; 

class PeriodsController extends Controller
{
    private $company;
    function __construct() {
        $this->company = '';
        if ( session('company')) {
            $this->company = session('company');
        }else{
            $this->company = Auth::user()->company;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( ! Auth::user()->can("list-periods")){
            return Response::json(['code'=>403,'message' => trans('general.http.403') ,'data' => []], 403);
            exit;
        }

        $data = Period::where('company','LIKE',"%".$this->company."%")->get();
        
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
        if ( ! Auth::user()->can("edit-periods")){
            return Response::json(['code'=>403,'message' => trans('general.http.403') ,'data' => []], 403);
            exit;
        }

        return view('pages.create_period', ['id' => Uuid::generate(4), 'user' => Auth::user()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( ! Auth::user()->can("edit-periods")){
            return Response::json(['code'=>403,'message' => trans('general.http.403') ,'data' => []], 403);
            exit;
        }

        $this->validate($request, [
            'period_id' => 'required',
            'name' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);


        $attributes = $request->all();
        $period_attributes = [ 'period_id' => $attributes['period_id'], 'name' => $attributes['name'], 'start' => $attributes['start'], 'end' => $attributes['end'], 'company' => Auth::user()->company ];

        $user = Period::create($period_attributes);
        Session::flash('update', ['code' => 200, 'message' => 'Period was added']);
        // return redirect("/users/$id/edit");
        return redirect("/periods/");


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ( ! Auth::user()->can("edit-periods")){
            return Response::json(['code'=>403,'message' => trans('general.http.403') ,'data' => []], 403);
            exit;
        }

        $data = Period::where('period_id', '=', $id)->first();
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
        if ( ! Auth::user()->can("edit-periods")){
            return Response::json(['code'=>403,'message' => trans('general.http.403') ,'data' => []], 403);
            exit;
        }

        $data = Period::where('period_id', '=', $id)->first();
        return view('pages.edit_period', ['period' => $data]);
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
    if ( ! Auth::user()->can("edit-periods")){
            return Response::json(['code'=>403,'message' => trans('general.http.403') ,'data' => []], 403);
            exit;
        }

        $attributes = $request->all();
        $attributes["active"] = (array_key_exists('active', $attributes)) ? intval($attributes["active"]) : 0;
        
        $period = Period::where('period_id', '=', $id)->first();
        $period->fill($attributes);
        $period->save();

        Session::flash('update', ['code' => 200, 'message' => 'Department info was updated']);
        // return back();
        return redirect("/periods/$id/edit");

        
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( ! Auth::user()->can("edit-periods")){
            return Response::json(['code'=>403,'message' => trans('general.http.403') ,'data' => []], 403);
            exit;
        }

        $period = Period::where('period_id', '=', $id)->first();
        if (!$period) {
            return Response::json(['code'=>404,'message' => trans('general.http.404') ,'data' => []], 404);
            exit;
        }

        $period->delete();

        return Response::json(['code'=>204,'message' => 'OK' , 'data' => "$id " . trans('general.http.204')] , 204);
        
    }

    public function transformCollection($periods)
    {
        if(is_array($periods)){
            return $periods;
        }
        return array_map([$this, 'transform'] , $periods->toArray());
    }

    private function transform ($period)
    {
        return $period;
    }
}
