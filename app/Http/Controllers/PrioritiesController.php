<?php

namespace App\Http\Controllers;

use App\Priority;
use App\Period;
use App\Position;
use App\User;
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

class PrioritiesController extends Controller
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
        if ( ! Auth::user()->can("list-priorities")){
            return HomeController::returnError(403);
        }


        $user = Auth::user();
        
        $data = $user->priorities;
         if (!$data) {
            return HomeController::returnError(404);
        }
        
        $position = Position::where('position_id', '=', $user->position)->first();

        $users = [];

        if (!empty($position) && $position->boss) {
            $users = User::where('department', '=', $this->department)->get(['user_id']);
        }

        if ( ! $users ) {
            die('no users');
        }

        return Response::json(['code'=>200,'message' => 'OK' , 'data' => 
            ['priorities' => $this->transform($data->toArray()), 'department' => $this->department, 'subordinates' => $users]
            ], 200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function team()
    {
        if ( ! Auth::user()->can("edit-priorities")){
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
        if ( ! Auth::user()->can("edit-priorities")){
            return HomeController::returnError(403);
        }

        $user = Auth::user();
        $position = Position::where('position_id', '=', $user->position)->first();
        $periods = Period::where('company','LIKE',"%".$this->company."%")->get();
        if(isset($position) && $position->boss){
            $users = User::where('department', '=', $user->department)->get();
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
        if ( ! Auth::user()->can("edit-priorities")){
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
        if ( ! Auth::user()->can("edit-priorities")){
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
        if ( ! Auth::user()->can("edit-priorities")){
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
        if ( ! Auth::user()->can("edit-priorities")){
            return HomeController::returnError(403);
        }

        
        $attributes = $request->all();

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
            }else{
                $attributes["priority_id"] = $id;
                $priority = Priority::create($attributes);
                Session::flash('update', ['code' => 200, 'message' => 'Priority was added']);
            }
            $priority->save();


            // return redirect("/priorities/$id/edit");

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
        if ( ! Auth::user()->can("edit-priorities")){
            return HomeController::returnError(403);
        }

        $priority = Priority::where('priority_id', '=', $id);
        if (!$priority) {
            return HomeController::returnError(404);
        }

        $priority->delete();

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
