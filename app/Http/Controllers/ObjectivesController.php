<?php

namespace App\Http\Controllers;

use App\Objective;
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

class ObjectivesController extends Controller
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
        if ( ! Auth::user()->can("list-objectives")){
            return HomeController::returnError(403);
        }

        $data = DB::table('objectives')
            ->join('users', 'objectives.user', '=', 'users.user_id')
            ->join('measuring_units', 'objectives.measuring_unit', '=', 'measuring_units.measuring_unit_id')
            ->select('users.user_id', 'users.name AS user_name', 'measuring_units.name AS measuring_unit_name','users.lastname AS user_lastname', 'objectives.*')
            ->where('objectives.department','=', $this->department)
            ->get();
        if (!$data) {
            return HomeController::returnError(404);
        }
        return Response::json(['code'=>200,'message' => 'OK' , 'data' => $this->transformCollection($data)], 200);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function team()
    {
        if ( ! Auth::user()->can("edit-objectives")){
            return HomeController::returnError(403);
        }


        $user = Auth::user();
        
        $data = $user->priorities;
        
        
        $position = Position::where('position_id', '=', $user->position)->first();

        $users = [];

        if (!empty($position) && $position->boss || Auth::user()->can("edit-companies")) {
            $users = User::where('department', '=', $this->department)->get(['user_id']);

            $data = DB::table('priorities')
                ->leftJoin('users', 'priorities.user', '=', 'users.user_id')
                ->leftJoin('periods', 'priorities.period', '=', 'periods.period_id')
                ->select('priorities.*', 'users.name AS user_name','periods.name AS period_name', 'users.lastname AS user_lastname')
                ->where('users.department','=', $this->department)
                ->get();

        }

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
        if ( ! Auth::user()->can("edit-objectives")){
            return HomeController::returnError(403);
        }

        $user = Auth::user();
        $periods = Period::where('company','LIKE',"%".$this->company."%")->get();
        $measuring_units = MeasuringUnit::where('company','LIKE',"%".$this->company."%")->get();
        $categories = ObjectiveCategory::where('company','LIKE',"%".$this->company."%")->get();
        return view('pages.create_objective', ['id' => Uuid::generate(4), 'user' => Auth::user(), 'measuring_units' => $measuring_units, 'periods' => $periods, 'categories' => $categories]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDepartmentSummary($id)
    {

        $period = Period::where('company', '=', $this->company)->first();
        $whereClause = ['objectives.period' => $period->period_id, 'objectives.type' => 'DEPARTAMENTO', 'objectives.department' => $id];
        $objectives = DB::table('objectives')
        ->where($whereClause)
        ->get();

        foreach ($objectives as $objective) {
            $whereClause = ['objectives_progress.objective' => $objective->objective_id];
            $objective->real = DB::table('objectives_progress')
            ->where($whereClause)
            ->sum('objectives_progress.value');
        }

        return Response::json(['code'=>200, 'message' => 'OK' , 'data' => $objectives] , 200);
    }

    public function getObjectiveSummary($id)
    {

        $objective = Objective::where('objective_id','=',$id)->first();
        
        $whereClause = ['objectives_progress.objective' => $objective->objective_id];
        $objective->real = DB::table('objectives_progress')
        ->where($whereClause)
        ->sum('objectives_progress.value');

        return Response::json(['code'=>200, 'message' => 'OK' , 'data' => $objective] , 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( ! Auth::user()->can("edit-objectives")){
            return HomeController::returnError(403);
        }

        

        $validateto = [
                'objective_id' => 'required|unique:objectives',
                'period' => 'required',
                'name' => 'required',
                // 'category' => 'required',
                'description' => 'required',
                'measuring_unit' => 'required',
                'type' => 'required',
                'period_objective' => 'required',
                'period_green' => 'required',
                'period_yellow_ceil' => 'required',
                'period_yellow_floor' => 'required',
                'period_red' => 'required',
                'daily_objective' => 'required',
                'daily_green' => 'required',
                'daily_yellow_ceil' => 'required',
                'daily_yellow_floor' => 'required',
                'daily_red' => 'required',
        ];
        
        
        $this->validate($request, $validateto);
        $attributes = $request->all();
        
        $fields = DB::table('objectives')->first();
        $fields = (array) $fields;

        $attributes['company'] = $this->company;
        $attributes['department'] = $this->department;
        $attributes['user'] = Auth::user()->user_id;

        $fields = HomeController::returnTableColumns('objectives');
        Objective::create(array_intersect_key($attributes, $fields));

        return redirect("/objectives/".$attributes['objective_id']."/edit");
    
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
        if ( ! Auth::user()->can("edit-objectives")){
            return HomeController::returnError(403);
        }

        $data = Objective::where('objective_id', '=', $id)->first();
        $data = DB::table('objectives')
            ->join('periods', 'objectives.period', '=', 'periods.period_id')
            ->join('measuring_units', 'objectives.measuring_unit', '=', 'measuring_units.measuring_unit_id')
            ->join('objective_categories', 'objectives.category', '=', 'objective_categories.category_id')
            ->select('objectives.*','periods.name AS period_name' ,'measuring_units.name AS measuring_unit_name' ,'objective_categories.name AS objective_categorie_name')
            ->where('objectives.objective_id','=', $id)
            ->first();
        if (!$data) {
            return HomeController::returnError(404);
        }

        $periods = Period::where('company','LIKE',"%".$this->company."%")->get();
        $measuring_units = MeasuringUnit::where('company','LIKE',"%".$this->company."%")->get();
        $categories = ObjectiveCategory::where('company','LIKE',"%".$this->company."%")->get();


        return view('pages.edit_objective', ['id' => $id, 'objective' => $data, 'measuring_units' => $measuring_units, 'periods' => $periods, 'categories' => $categories]);
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
        if ( ! Auth::user()->can("edit-objectives")){
            return HomeController::returnError(403);
        }

        

        $validateto = [
                'period' => 'required',
                'name' => 'required',
                'category' => 'required',
                'description' => 'required',
                'measuring_unit' => 'required',
                'type' => 'required',
                'period_objective' => 'required',
                'period_green' => 'required',
                'period_yellow_ceil' => 'required',
                'period_yellow_floor' => 'required',
                'period_red' => 'required',
                'daily_objective' => 'required',
                'daily_green' => 'required',
                'daily_yellow_ceil' => 'required',
                'daily_yellow_floor' => 'required',
                'daily_red' => 'required',
        ];
        
        
        $this->validate($request, $validateto);
        $attributes = $request->all();
        $attributes["active"] = (array_key_exists('active', $attributes)) ? intval($attributes["active"]) : 0;

        $objective = Objective::where('objective_id', '=', $id)->first();
        $objective->fill($attributes);
        $objective->save();

        Session::flash('update', ['code' => 200, 'message' => 'Objective was updated']);
        return redirect("/objectives/$id/edit");
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( ! Auth::user()->can("edit-objectives")){
            return HomeController::returnError(403);
        }

        $objective = Objective::where('objective_id', '=', $id);
        if (!$objective) {
            return HomeController::returnError(404);
        }

        $objective->delete();

        return Response::json(['code'=>204,'message' => 'OK' , 'data' => "$id " . trans('general.http.204')] , 204);
        
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
