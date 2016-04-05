<?php

namespace App\Http\Controllers;
/*
use App\Objective; use App\ObjectiveCategory; use App\ObjectiveSubcategory; use App\ObjectiveProgress; use App\Priority; use App\Period; use App\Position; use App\User; use App\MeasuringUnit; use Illuminate\Http\Request; use App\Http\Requests; use Response; use App\Http\Controllers\Controller; use App\Http\Controllers\HomeController; use DB; use Session; use Uuid; use Hash; use Auth;
$whereClause = ['objectives_progress.objective' => '67ed4e41-1871-3b58-9f45-732df68a106f'];
$objective_progress = DB::table('objectives_progress')->select('objectives_progress_id','value','updated_at')->where($whereClause)->get();
*/
use App\Objective;
use App\ObjectiveCategory;
use App\ObjectiveSubcategory;
use App\ObjectiveProgress;
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

        $whereClause = ['objectives.department' => $this->department, 'objectives.period' => session('period') , 'objectives.deleted_at' => NULL];

        $data = DB::table('objectives')
            ->join('users', 'objectives.user', '=', 'users.user_id')
            ->join('periods', 'objectives.period', '=', 'periods.period_id')
            ->join('measuring_units', 'objectives.measuring_unit', '=', 'measuring_units.measuring_unit_id')
            ->select('users.user_id', 'users.name AS user_name', 'measuring_units.name AS measuring_unit_name','periods.name AS period_name' ,'users.lastname AS user_lastname', 'objectives.*')
            ->where($whereClause)
            ->get();
        if (!$data) {
            return HomeController::returnError(404);
        }
        return Response::json(['code'=>200,'message' => 'OK' , 'data' => $this->transformCollection($data)], 200);

    }

    public function progress()
    {
        return view('pages.show_my_objectives');

    }

    public function addProgress($id)
    {
        $whereClause = ['objectives.objective_id' => $id, 'objectives.deleted_at' => NULL];
        $objective = DB::table('objectives')
            ->join('users', 'objectives.user', '=', 'users.user_id')
            ->join('periods', 'objectives.period', '=', 'periods.period_id')
            ->join('objective_subcategories', 'objectives.subcategory', '=', 'objective_subcategories.subcategory_id')
            ->join('objective_categories', 'objective_subcategories.parent', '=', 'objective_categories.category_id')
            ->join('measuring_units', 'objectives.measuring_unit', '=', 'measuring_units.measuring_unit_id')
            ->select('users.user_id','users.name AS user_name', 'measuring_units.name AS measuring_unit_name','periods.name AS period_name' ,'users.lastname AS user_lastname', 'objectives.*', 'objective_subcategories.name AS objective_subcategory_name', 'objective_categories.name AS objective_category_name')
            ->where($whereClause)
            ->first();
        $whereClause = ['objectives_progress.objective' => $objective->objective_id, 'objectives_progress.deleted_at' => NULL];
            $objective->real = DB::table('objectives_progress')
            ->where($whereClause)
            ->sum('objectives_progress.value');

            $objective->objectives_progress_results = ObjectiveProgress::where($whereClause)->get();

        return view('pages.progress_objective',['objective' => $objective]);

    }

    public function updateProgress(Request $request, $id)
    {
        $validateto = [
                'objective' => 'required',
                'value' => 'required',
                'progress_date:Y-m-d|after:yesterday',
        ];

        $this->validate($request, $validateto);

        $whereClause = ['objectives.objective_id' => $id, 'objectives.deleted_at' => NULL];
        $objective = Objective::where($whereClause)
            ->first();

        if (!$objective) {
            return HomeController::returnError(404);
        }
        
        $attributes = $request->all();
        $whereClause = ['objective' => $id, 'progress_date' => $attributes['progress_date']];
        $objective_progress = ObjectiveProgress::where($whereClause)->first();

        if ($objective_progress) {
            $attributes['objectives_progress_id'] = $objective_progress->objectives_progress_id;
            $objective_progress->fill($attributes);
            $objective_progress->save();
        }else{

            ObjectiveProgress::create([

                'objectives_progress_id' => Uuid::generate(4),
                'progress_date' => date('Y-m-d H:i:s'),
                'objective' => $objective->objective_id,
                'value' => $attributes['value'],
                'company' => $objective->company,
                'department' => $objective->department,
                'progress_date' => $request['progress_date']
            ]);

        }


        Session::flash('update', ['code' => 200, 'message' => 'Progress was added']);
        return redirect('/objectives/progress/');

    }

    public function onlymine()
    {
        if ( ! Auth::user()->can("list-objectives")){
            return HomeController::returnError(403);
        }

        $whereClause = ['objectives.user' => Auth::user()->user_id, 'objectives.period' => session('period') , 'objectives.deleted_at' => NULL];
        $data = DB::table('objectives')
            ->join('users', 'objectives.user', '=', 'users.user_id')
            ->join('periods', 'objectives.period', '=', 'periods.period_id')
            ->join('objective_subcategories', 'objectives.subcategory', '=', 'objective_subcategories.subcategory_id')
            ->join('objective_categories', 'objective_subcategories.parent', '=', 'objective_categories.category_id')
            ->join('measuring_units', 'objectives.measuring_unit', '=', 'measuring_units.measuring_unit_id')
            ->select('users.user_id','users.name AS user_name', 'measuring_units.name AS measuring_unit_name','periods.name AS period_name' ,'users.lastname AS user_lastname', 'objectives.*', 'objective_subcategories.name AS objective_subcategory_name', 'objective_categories.name AS objective_category_name')
            ->where($whereClause)
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
        if (Session::has('original_user')){
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

        $user = Auth::user();
        $periods = Period::where('company','=',$this->company)->get();
        $measuring_units = MeasuringUnit::where('company','=',$this->company)->get();
        $categories = ObjectiveCategory::where('company','=',$this->company)->get();
        $subcategories = ObjectiveSubcategory::where('company','=',$this->company)->get();

        return view('pages.create_objective', ['id' => Uuid::generate(4), 'user' => Auth::user(), 'measuring_units' => $measuring_units, 'periods' => $periods, 'categories' => $categories, 'subcategories' => $subcategories]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDepartmentSummary($id)
    {

        $period = Period::where('period_id' ,'=', session('period'))->first();
        $whereClause = ['objectives.period' => $period->period_id, 'objectives.ignore' => false, 'objectives.department' => $id, 'objectives.deleted_at' => NULL ];
        $objectives = DB::table('objectives')
        ->where($whereClause)
        ->get();

        foreach ($objectives as $objective) {
            $whereClause = ['objectives_progress.objective' => $objective->objective_id, 'objectives_progress.deleted_at' => NULL ];
            $objective->real = DB::table('objectives_progress')
            ->where($whereClause)
            ->sum('objectives_progress.value');
            $objective->days = session('elapsed_days') ? session('elapsed_days')  : 0;
        }

        return Response::json(['code'=>200, 'message' => 'OK' , 'data' => $objectives] , 200);
    }

    public function getSubordinateSummary($id)
    {

        $period = Period::where('period_id' ,'=', session('period'))->first();
        $whereClause = ['objectives.period' => $period->period_id, 'objectives.user' => $id, 'objectives.deleted_at' => NULL ];
        $objectives = DB::table('objectives')
        ->where($whereClause)
        ->get();

        foreach ($objectives as $objective) {
            $whereClause = ['objectives_progress.objective' => $objective->objective_id, 'objectives_progress.deleted_at' => NULL ];
            $objective->real = DB::table('objectives_progress')
            ->where($whereClause)
            ->sum('objectives_progress.value');
            $objective->days = session('elapsed_days') ? session('elapsed_days')  : 0;
        }

        return Response::json(['code'=>200, 'message' => 'OK' , 'data' => $objectives] , 200);
    }

    public function getCompanySummary()
    {

        $period = Period::where('period_id' ,'=', session('period'))->first();
        $whereClause = ['objectives.period' => $period->period_id, 'objectives.ignore' => false, 'objectives.deleted_at' => NULL ];
        $objectives = DB::table('objectives')
        ->where($whereClause)
        ->get();

        foreach ($objectives as $objective) {
            $whereClause = ['objectives_progress.objective' => $objective->objective_id, 'objectives_progress.deleted_at' => NULL ];
            $objective->real = DB::table('objectives_progress')
            ->where($whereClause)
            ->sum('objectives_progress.value');
            $objective->days = session('elapsed_days') ? session('elapsed_days')  : 0;
        }

        return Response::json(['code'=>200, 'message' => 'OK' , 'data' => $objectives] , 200);
    }

    public function createCategory()
    {
        if ( ! Auth::user()->hasRole('super-admin') && ! Auth::user()->hasRole('coach') && ! Auth::user()->hasRole('champion')) { return HomeController::returnError(403); }

        return view('pages.create_objective_category', ['id' => Uuid::generate(4), 'user' => Auth::user()] );
    }

    public function storeCategory(Request $request, $id)
    {
        if ( ! Auth::user()->hasRole('super-admin') && ! Auth::user()->hasRole('coach') && ! Auth::user()->hasRole('champion')) { return HomeController::returnError(403); }
        $attributes = $request->all();


         $required = [
            "category_id" => 'required|unique:objective_categories',
            "name" => 'required',
        ];
        $this->validate($request, $required);

        $attributes = $request->all();
        $attributes['company'] = $this->company;
        $attributes['active'] = 1;
        $fields = HomeController::returnTableColumns('objective_categories');
        ObjectiveCategory::create(array_intersect_key($attributes, $fields));
        Session::flash('update', ['code' => 200, 'message' => 'Category was added']);
        return redirect('/objectives/');
    }

    public function createSubcategory()
    {
        if ( ! Auth::user()->hasRole('super-admin') && ! Auth::user()->hasRole('coach') && ! Auth::user()->hasRole('champion')) { return HomeController::returnError(403); }
        $categories = ObjectiveCategory::where('company','=',$this->company)->get();
        return view('pages.create_objective_subcategory', ['id' => Uuid::generate(4), 'user' => Auth::user(), 'categories' => $categories] );
    }

    public function storeSubcategory(Request $request, $id)
    {
        if ( ! Auth::user()->hasRole('super-admin') && ! Auth::user()->hasRole('coach') && ! Auth::user()->hasRole('champion')) { return HomeController::returnError(403); }
        $attributes = $request->all();


         $required = [
            "subcategory_id" => 'required|unique:objective_subcategories',
            "name" => 'required',
            "parent" => 'required',
        ];
        $this->validate($request, $required);

        $attributes = $request->all();
        $attributes['company'] = $this->company;
        $attributes['active'] = 1;
        $fields = HomeController::returnTableColumns('objective_subcategories');
        ObjectiveSubcategory::create(array_intersect_key($attributes, $fields));
        Session::flash('update', ['code' => 200, 'message' => 'Category was added']);
        return redirect('/objectives/');
    }

    public function getObjectiveSummary($id)
    {

        $objective = Objective::where('objective_id','=',$id)->first();
        
        $whereClause = ['objectives_progress.objective' => $objective->objective_id];
        $objective->real = DB::table('objectives_progress')
        ->where($whereClause)
        ->sum('objectives_progress.value');
        $objective->days = session('elapsed_days') ? session('elapsed_days')  : 0;
        $objective->results = DB::table('objectives_progress')
            ->select('objectives_progress_id','value','progress_date')
            ->where($whereClause)
            ->orderBy('objectives_progress.progress_date', 'ASC')
            ->get();
        $whereClause = ['periods.period_id' => $objective->period];
        $objective->period = DB::table('periods')
            ->where($whereClause)
            ->first();

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

        $validateto = [
                'objective_id' => 'required|unique:objectives',
                'period' => 'required',
                'name' => 'required',
                'subcategory' => 'required',
                'description' => 'required',
                'measuring_unit' => 'required',
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
        $attributes["ignore"] = (array_key_exists('ignore', $attributes)) ? intval($attributes["ignore"]) : 0;
        $attributes["type"] = (array_key_exists('type', $attributes)) ? 'inverted' : 'normal';

        // die(json_encode($attributes));
        
        $fields = DB::table('objectives')->first();
        $fields = (array) $fields;

        $attributes['company'] = $this->company;
        $attributes['department'] = $this->department;
        $attributes['user'] = Auth::user()->user_id;

        $fields = HomeController::returnTableColumns('objectives');
        Objective::create(array_intersect_key($attributes, $fields));

        return redirect(route('objectives'));
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Session::has('original_user')){
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
    public function get_subcategories($id)
    {
        $data = ObjectiveSubcategory::where('parent', '=', $id)->get();
        if (!$data) {
            return HomeController::returnError(404);
        }
        return Response::json(['code'=>200,'message' => 'OK' , 'data' => $this->transformCollection($data)], 200);
    }
    public function edit($id)
    {

        $data = DB::table('objectives')
            ->join('periods', 'objectives.period', '=', 'periods.period_id')
            ->join('measuring_units', 'objectives.measuring_unit', '=', 'measuring_units.measuring_unit_id')
            ->join('objective_subcategories', 'objectives.subcategory', '=', 'objective_subcategories.subcategory_id')
            ->join('objective_categories', 'objective_subcategories.parent', '=', 'objective_categories.category_id')
            ->select('objectives.*','periods.name AS period_name' ,'measuring_units.name AS measuring_unit_name' ,'objective_categories.name AS objective_categorie_name','objective_categories.category_id AS objective_categorie_id','objective_subcategories.name AS objective_subcategorie_name')
            ->where('objectives.objective_id','=', $id)
            ->first();
        if (!$data) {
            return HomeController::returnError(404);
        }

        $periods = Period::where('company','=',$this->company)->get();
        $measuring_units = MeasuringUnit::where('company','=',$this->company)->get();
        $categories = ObjectiveCategory::where('company','=',$this->company)->get();
        $subcategories = ObjectiveSubcategory::where('company','=',$this->company)->get();


        return view('pages.edit_objective', ['id' => $id, 'objective' => $data, 'measuring_units' => $measuring_units, 'periods' => $periods, 'categories' => $categories, 'subcategories' => $subcategories]);
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
        if (Session::has('original_user')){
            return HomeController::returnError(403);
        }

        

        $validateto = [
                'period' => 'required',
                'name' => 'required',
                'subcategory' => 'required',
                'description' => 'required',
                'measuring_unit' => 'required',
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
        $attributes["ignore"] = (array_key_exists('ignore', $attributes)) ? intval($attributes["ignore"]) : 0;

        $objective = Objective::where('objective_id', '=', $id)->first();
        $objective->fill($attributes);
        $objective->save();

        Session::flash('update', ['code' => 200, 'message' => 'Objective was updated']);
        return redirect(route('objectives'));
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Session::has('original_user')){
            return HomeController::returnError(403);
        }
        
        $whereClause = [ 'objective_id' => $id,  'objectives.user' =>  Auth::user()->user_id];
        $objective = Objective::where($whereClause);
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
