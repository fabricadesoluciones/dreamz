<?php

namespace App\Http\Controllers;

use App\Task;
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

class TasksController extends Controller
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

        if( ! session('department')){
            return HomeController::returnError(403, trans('general.http.select_department'), route('departments'));
        }
        if (Auth::user()->hasRole('coach') || Auth::user()->hasRole('champion') || Auth::user()->hasRole('team_lead')) {
            $whereClause = ['tasks.department' => $this->department];
        }else{
            $whereClause = ['tasks.owner' => Auth::user()->user_id];
        }
        $whereClause['tasks.deleted_at'] = NULL;

        $data = DB::table('tasks')
            ->join('users', 'tasks.owner', '=', 'users.user_id')
            ->select( 'users.name AS user_name', 'users.lastname AS user_lastname', 'tasks.*')
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
        if( ! session('department')){
            return HomeController::returnError(403, trans('general.http.select_department'), route('departments'));
        }
        $user = Auth::user();
        $all_dept_users = User::where('department','=',$this->department)->get();

        if (Auth::user()->hasRole('coach') || Auth::user()->hasRole('champion') || Auth::user()->hasRole('team_lead')) {
            $owners = $all_dept_users;
        }else{
            $owners = [$user];
            $whereClause = ['tasks.owner' => Auth::user()->user_id];
        }

        if ($owners) {
            return view('pages.create_task', ['id' => Uuid::generate(4), 'owners' => $owners, 'all_dept_users' => $all_dept_users ]);
        }else{
            return HomeController::returnError(403);
        }
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

        $validateto = [
                'task_id' => 'unique:tasks',
                'name' => 'required',
                'owner' => 'required',
                'status' => 'required',
                'priority' => 'required',
                'due_date' => 'date_format:Y-m-d|after:yesterday',
        ];
        
        $this->validate($request, $validateto);
        $attributes = $request->all();
        $attributes['company'] = $this->company;
        $attributes['department'] = $this->department;

        $fields = HomeController::returnTableColumns('tasks');

        Task::create(array_intersect_key($attributes, $fields));

        Session::flash('update', ['code' => 200, 'message' => 'Task was created']);
        return redirect("/tasks/".$attributes['task_id']."/edit");
    
    
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
        if( ! session('department')){
            return HomeController::returnError(403, trans('general.http.select_department'), route('departments'));
        }
        $user = Auth::user();
        $all_dept_users = User::where('department','=',$this->department)->get();
        $participants = DB::table('task_participants')
                ->leftJoin('users', 'task_participants.user', '=', 'users.user_id')
                ->select('task_participants.*', 'users.name AS user_name', 'users.lastname AS user_lastname')
                ->where('user_id', '=', $id)
                ->get();

        $task = Task::where('task_id','=',$id)->first();
        if (Auth::user()->hasRole('coach') || Auth::user()->hasRole('champion') || Auth::user()->hasRole('team_lead')) {
            $owners = $all_dept_users;
        }else{
            $owners = [$user];
            $whereClause = ['tasks.owner' => Auth::user()->user_id];
        }

        if ($owners && $task) {
            return view('pages.edit_task', ['task'=>$task, 'owners' => $owners, 'participants'=> $participants, 'all_dept_users' => $all_dept_users ]);
        }else{
            return HomeController::returnError(403);
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
        $validateto = [
                'name' => 'required',
                'owner' => 'required',
                'status' => 'required',
                'priority' => 'required',
                'due_date' => 'date_format:Y-m-d|after:yesterday',
        ];
        
        $this->validate($request, $validateto);
        $attributes = $request->all();
        $attributes['company'] = $this->company;
        $attributes['department'] = $this->department;

        $objective = Task::where('task_id', '=', $id)->first();
        $objective->fill($attributes);
        $objective->save();

        Session::flash('update', ['code' => 200, 'message' => 'Task was updated']);
        return redirect("/tasks/$id/edit");
    
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

        $objective = Task::where('task_id', '=', $id);
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
