<?php

namespace App\Http\Controllers;

use App\File;
use App\Period;
use App\Position;
use App\Assessment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FRequest;

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
use Input;
use Storage; 
use Config; 
use File as FFile; 

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

        $whereClause = ['assessments.department' => session('department')];

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

    public function my_assessments($user_id)
    {
        $whereClause = ['assessments.user' => Auth::user()->user_id];

        $data = DB::table('assessments')
            ->join('users', 'assessments.user', '=', Auth::user()->user_id)
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

        if( ! session('department')){
            return $this->returnError(403, trans('general.http.select_department'), route('departments'));
        }

        $users = User::where('department','=', session('department'))->get();
        return view('pages.create_assessment', ['id' => Uuid::generate(4), 'users' => $users]);
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

        if( ! session('company')){
            return $this->returnError(403, trans('general.http.select_company'), route('companies'));
        }

        $validateto = [
                'assessment_id' => 'required|unique:assessments',
                'name' => 'required',
                'submit_date' => 'required',
                'user' => 'required',
                'attachment' => 'required|max:10000',
        ];

        $this->validate($request, $validateto);
        $attributes = $request->all();

        $user = User::find($attributes['user']);
        if (!$user) {
    	   return HomeController::returnError(404);
        }

		$file = FRequest::file('attachment');
		$extension = $file->getClientOriginalExtension();
		$uuid = Uuid::generate(4);
		$filename = $uuid.'.'.$extension;
		$path = session('company').'/assessments/'.$filename;

		$savelocal = Storage::disk('local')->put($path,  FFile::get($file));
		if (!$savelocal) {
			return HomeController::returnError(404);
		}
		$contents = Storage::disk('local')->read($path);
		$save = Storage::disk('s3')->put($path, $contents);
		if ($save) {
			Storage::disk('local')->delete($path);
			Session::flash('update', ['code' => 200, 'message' => 'File was uploaded']);


			File::create([

				'file_id' => $uuid,
				'company' => $user->company,
				'department' => $user->department,
				'user' => $user->user_id,
				'type' => 'assessments',
				'path' => $path,
				'name' => $filename,

			]);
			Assessment::create([

				'assessment_id' => $attributes['assessment_id'],
				'company' => $user->company,
				'department' => $user->department,
				'user' => $user->user_id,
				
				'name' => $attributes['name'],
				'submit_date' => $attributes['submit_date'], 
				'file' => $uuid,

        	]);
        	Session::flash('update', ['code' => 200, 'message' => 'Assessment was added']);
		}else{
    	   return HomeController::returnError(404);
		}


		return redirect(route('assessments'));
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