<?php

namespace App\Http\Controllers;

use App\EducationLevel;
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

class EducationLevelController extends Controller
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
        $data = EducationLevel::where('company','=',$this->company)->get();
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

        return view('pages.create_education_level', ['id' => Uuid::generate(4), 'company' => Session::get('company') ]);
        
    
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
            "education_level_id" => 'required',
            "name" => 'required',
        ];
        $this->validate($request, $required);

        $attributes = $request->all();
        $fields = DB::table('education_levels')->first();
        $fields = (array) $fields;
        $attributes['company'] = $this->company;
        EducationLevel::create(array_intersect_key($attributes, $fields));

        return redirect("/education/".$attributes['education_level_id']."/edit");
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
        $data = EducationLevel::where('education_level_id', '=', $id)->first();
        if (!$data) {
            return HomeController::returnError(404);
        }
        return view('pages.edit_education_level', ['education' => $data]);
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

        $education = EducationLevel::where('education_level_id', '=', $id)->first();

        $fields = DB::table('education_levels')->first();
        $fields = (array) $fields;
        $attributes['company'] = $this->company;

        $education->fill(array_intersect_key($attributes, $fields));
        $education->save();

        Session::flash('update', ['code' => 200, 'message' => 'Education info was updated']);
        return redirect("/education/$id/edit");

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
        $education_level = EducationLevel::where('education_level_id', '=', $id)->first();
        if (!$education_level) {
            return HomeController::returnError(404);
        }

        $education_level->active = 0;
        $education_level->save();

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
