<?php

namespace App\Http\Controllers;

use App\Priority;
use App\Period;
use App\Position;
use App\Assessment;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FileController;
use DB;
use Session; 
use Uuid; 
use Hash; 
use Auth; 

class AssessmentsController extends Controller
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
        if ( ! Auth::user()->can("list-assessments")){
            return HomeController::returnError(403);
        }

        $whereClause = ['assessments.department' => $this->department, 'assessments.deleted_at' => NULL];

        $data = DB::table('assessments')
            ->join('users', 'assessments.user', '=', 'users.user_id')
            ->select('users.user_id', 'users.name AS user_name', 'users.lastname AS user_lastname', 'assessments.*')
            ->where($whereClause)
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
        if ( ! Auth::user()->can("edit-assessments")){
            return HomeController::returnError(403);
        }

        $user = Auth::user();
        $position = Position::where('position_id', '=', $user->position)->first();
        $periods = Period::where('company','LIKE',"%".$this->company."%")->get();
        if(Auth::user()->hasRole('champion') || Auth::user()->hasRole('super-admin' ) || Auth::user()->hasRole('team_lead' )){
            $users = User::where('department', '=', $this->department)->get();
        }else{
            $users = [$user];
        }
        return view('pages.create_priority', ['id' => Uuid::generate(4), 'user' => Auth::user(), 'periods' => $periods, 'users' => $users ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( ! Auth::user()->can("edit-assessments")){
            return HomeController::returnError(403);
        }

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
        if ( ! Auth::user()->can("edit-assessments")){
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
        if ( ! Auth::user()->can("edit-assessments")){
            return HomeController::returnError(403);
        }

        $user = Auth::user();
        $position = Position::where('position_id', '=', $user->position)->first();
        $periods = Period::where('company','LIKE',"%".$this->company."%")->get();
        if($position->boss){
            $users = User::where('department', '=', $user->department)->get();
        }else{
            $users = [$user];
        }

        $data = Priority::where('priority_id', '=', $id)->first();
        if (!$data) {
            return HomeController::returnError(404);
        }

        return view('pages.edit_priority', ['id' => $id, 'priority' => $data, 'user' => $user, 'periods' => $periods, 'users' => $users]);
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
        if ( ! Auth::user()->can("edit-assessments")){
            return HomeController::returnError(403);
        }

        
        $attributes = $request->all();

        $attributes["company"] = $this->company;
        $attributes["department"] = $this->department;

        $priority = Priority::where('priority_id', '=', $id)->first();
        if (array_key_exists('progress', $attributes) && $priority) {
            unset($attributes['progress']);

            $attributes = $attributes['data'];
            $attributes["progress"] = (array_key_exists('progress', $attributes)) ? intval($attributes["progress"]) : 0;
            $attributes = [$attributes['week'] => $attributes['progress']];
            
            $priority->fill($attributes);
            $priority->save();

            // Session::flash('update', ['code' => 200, 'message' => 'Position info was updated']);
            return Response::json(['code'=>200,'message' => 'OK' , 'data' => 'Saved'], 200);
        }else{
            if ($priority) {
                $priority->fill($attributes);
                Session::flash('update', ['code' => 200, 'message' => 'Priority info was updated']);
                $priority->save();
            }else{
                $attributes["priority_id"] = $id;
                $fields = HomeController::returnTableColumns('priorities');
                Priority::create(array_intersect_key($attributes, $fields));
                Session::flash('update', ['code' => 200, 'message' => 'Priority was added']);
            }

            return redirect("/priorities/");
        }



        
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( ! Auth::user()->can("edit-assessments")){
            return HomeController::returnError(403);
        }

        $assessment = Assessment::find($id);
        if (!$assessment) {
            return HomeController::returnError(404);
        }
        $fileCtrl = new FileController();
        $fileCtrl->deleteFile($assessment->file);
        $assessment->delete();

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