<?php

namespace App\Http\Controllers;

use App\MeasuringUnit;
use App\Period;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use DB;
use Session; 
use Auth; 
use Uuid; 

class MeasuringUnitController extends Controller
{
    private $company;
    function __construct() {
        $this->company = '';
        if ( session('company')) {
            $this->company = session('company');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( ! Auth::user()->can("edit-departments")){
            return HomeController::returnError(403);
        }
        $data = MeasuringUnit::where('company','=',$this->company)->get();
        if (!$data) {
            return HomeController::returnError(404);
        }
        return Response::json(['code'=>200,'message' => 'OK', 'company' => $this->company , 'data' => $this->transformCollection($data)], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( ! Auth::user()->can("edit-departments")){
            return HomeController::returnError(403);
        }

        return view('pages.create_measuring_unit', ['id' => Uuid::generate(4), 'company' => Session::get('company') ]);
        
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( ! Auth::user()->can("edit-departments")){
            return HomeController::returnError(403);
        }
        
        $attributes = $request->all();


         $required = [
            "measuring_unit_id" => 'required',
            "name" => 'required',
        ];
        $this->validate($request, $required);

        $attributes = $request->all();
        $attributes['company'] = $this->company;

        $fields = HomeController::returnTableColumns('measuring_units');
        MeasuringUnit::create(array_intersect_key($attributes, $fields));

        return redirect("/measuring_units/".$attributes['measuring_unit_id']."/edit");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ( ! Auth::user()->can("edit-departments")){
            return HomeController::returnError(403);
        }
        $data = Department::where('department_id', '=', $id)->first();
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
        if ( ! Auth::user()->can("edit-departments")){
            return HomeController::returnError(403);
        }
        $data = MeasuringUnit::where('measuring_unit_id', '=', $id)->first();
        if (!$data) {
            return HomeController::returnError(404);
        }
        return view('pages.edit_measuring_unit', ['measuring_unit' => $data]);
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
        if ( ! Auth::user()->can("edit-departments")){
            return HomeController::returnError(403);
        }
        
        $attributes = $request->all();
        $required = [
            "name" => 'required',
        ];

        $this->validate($request, $required);

        $attributes = $request->all();

        $measuring_unit = MeasuringUnit::where('measuring_unit_id', '=', $id)->first();

        $fields = DB::table('measuring_units')->first();
        $fields = (array) $fields;
        $attributes['company'] = $this->company;

        $measuring_unit->fill(array_intersect_key($attributes, $fields));
        $measuring_unit->save();

        Session::flash('update', ['code' => 200, 'message' => 'Education info was updated']);
        return redirect("/measuring_units/$id/edit");

        ///

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( ! Auth::user()->can("edit-departments")){
            return HomeController::returnError(403);
        }
        $education_level = MeasuringUnit::where('measuring_unit_id', '=', $id)->first();
        if (!$education_level) {
            return HomeController::returnError(404);
        }

        $education_level->delete();

        return Response::json(['code'=>204,'message' => 'OK' , 'data' => "$id " . trans('general.http.204b')] , 204);
        
    }

    public function transformCollection($departments)
    {
        if(is_array($departments)){
            return $departments;
        }
        return array_map([$this, 'transform'] , $departments->toArray());
    }

    private function transform ($department)
    {
        return $department;
    }
}
