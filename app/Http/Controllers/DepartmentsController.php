<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use DB;
use Session; 
use Auth; 
use Uuid; 

class DepartmentsController extends Controller
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
        if ( ! Auth::user()->can("list-departments")){
            return HomeController::returnError(403);
        }
        $data = DB::table('departments')
            ->join('companies', 'departments.company', '=', 'companies.company_id')
            ->select('departments.*', 'companies.commercial_name AS company_name')
            ->where('departments.company','LIKE',"%".$this->company."%")
            ->get();
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
        if ( ! Auth::user()->can("edit-departments")){
            return HomeController::returnError(403);
        }

        return view('pages.create_department', ['id' => Uuid::generate(4), 'company' => Session::get('company') ]);
        
    
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
            "department_id" => 'required',
            "name" => 'required',
        ];
        $this->validate($request, $required);

        $attributes = $request->all();
        $attributes["parent"] = (array_key_exists('parent', $attributes)) ? $attributes["parent"] : 0;
        $attributes['company'] = $this->company;

        $parent = Department::where('department_id', '=', $attributes['parent'])->first();
        
        $parents = $this->checkParent($parent, $attributes['department_id']);
        if ($parents) {
            return $parents;
        }

        $fields = HomeController::returnTableColumns('departments');
        Department::create(array_intersect_key($attributes, $fields));

        Session::flash('update', ['code' => 200, 'message' => 'Department was updated']);
        return redirect(route('departments'));
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
     * Display the users for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function users($id)
    {
        if ( ! Auth::user()->can("edit-departments")){
            return HomeController::returnError(403);
        }
        $data = Department::where('department_id', '=', $id)->first()->users;
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
        $data = Department::where('department_id', '=', $id)->first();
        if (!$data) {
            return HomeController::returnError(404);
        }
        return view('pages.edit_department', ['department' => $data]);
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

        $parent = Department::where('department_id', '=', $attributes['parent'])->first();
        $parents = $this->checkParent($parent, $id);
        if ($parents) {
            return $parents;
        }

        $attributes["active"] = (array_key_exists('active', $attributes)) ? intval($attributes["active"]) : 0;
        $attributes["parent"] = (array_key_exists('parent', $attributes)) ? $attributes["parent"] : 0;

        $department = Department::where('department_id', '=', $id)->first();

        $fields = DB::table('departments')->first();
        $fields = (array) $fields;
        $attributes['company'] = $this->company;

        $department->fill(array_intersect_key($attributes, $fields));
        $department->save();

        Session::flash('update', ['code' => 200, 'message' => 'Department info was updated']);
        return redirect(route('departments'));
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
        $department = Department::where('department_id', '=', $id)->first();
        if (!$department) {
            return HomeController::returnError(404);
        }

        $department->active = 0;
        $department->save();

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
    private function checkParent ($parent = 0, $id)
    {
        

        $parents_objs = [];
        $parents = [];

        if ($parent) {
            $grandfather = Department::where('department_id', '=', $parent->parent)->first();
            array_push($parents,$parent->department_id);
            array_push($parents_objs,$parent);
        }
        if (isset($grandfather) && $grandfather) {
            $grand_grandfather = Department::where('department_id', '=', $grandfather->parent)->first();
            array_push($parents,$grandfather->department_id);
            array_push($parents_objs,$grandfather);
        }
        if (isset($grand_grandfather) && $grand_grandfather) {
            $grand_grand_grandfather = Department::where('department_id', '=', $grand_grandfather->parent)->first();
            array_push($parents,$grand_grandfather->department_id);
            array_push($parents_objs,$grand_grandfather);
        }
        if (isset($grand_grand_grandfather) && $grand_grand_grandfather) {
            $grand_grand_grand_grandfather = Department::where('department_id', '=', $grand_grand_grandfather->parent)->first();
            array_push($parents,$grand_grand_grandfather->department_id);
            array_push($parents_objs,$grand_grand_grandfather);
        }
        if (isset($grand_grand_grand_grandfather) && $grand_grand_grand_grandfather) {
            
            Session::flash('update', ['code' => 500, 'title' => 'Hierarchy constraint violation', 'message' => "Trying to add too many children, max level is 5: "]);
            return redirect("/departments/$id/edit");

        }

        if (in_array($id, $parents)) {
            echo $parents_objs[array_search($id, $parents)]->name;

            Session::flash('update', ['code' => 500, 'title' => 'Hierarchy constraint violation', 'message' => "Parent pointing to child as parent, change ".$parents_objs[array_search($id, $parents) -1]->name."'s parent first"]);

            return redirect("/departments/$id/edit");

        }

        return false;
    }
}
