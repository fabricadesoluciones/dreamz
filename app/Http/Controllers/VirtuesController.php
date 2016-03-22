<?php

namespace App\Http\Controllers;

use App\File;
use App\Virtue;
use App\VirtueGiver;
use App\User;
use App\Company;
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

class VirtuesController extends Controller
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
        if ( ! Auth::user()->can("list-virtues")){
            return HomeController::returnError(403);
        }

        $whereClause = ['virtues.company' => session('company')];

        $data = DB::table('virtues')
            ->join('files', 'virtues.file', '=', 'files.file_id')
            ->select('files.public_url', 'virtues.*')
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
        if ( ! Auth::user()->can("edit-virtues")){
            return HomeController::returnError(403);
        }

        if( ! session('company')){
            return $this->returnError(403, trans('general.http.select_department'), route('departments'));
        }


        return view('pages.create_virtue', ['id' => Uuid::generate(4)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( ! Auth::user()->can("edit-virtues")){
            return HomeController::returnError(403);
        }

        if( ! session('company')){
            return $this->returnError(403, trans('general.http.select_company'), route('companies'));
        }

        $totalVirtues = Virtue::where('company','=',session('company'))->get();

        if (count($totalVirtues) > 5) {
            Session::flash('update', ['code' => 500, 'title' => 'Hierarchy constraint violation', 'message' => "Trying to add too many virtues, max number is 6. "]);
            return redirect(route('virtues'));
        }

        $validateto = [
                'virtue_id' => 'required|unique:virtues',
                'name' => 'required',
                'weight' => 'required',
                'attachment' => 'required|mimes:jpeg,jpg,png,gif,svg|max:10000',
        ];

        $this->validate($request, $validateto);
        $attributes = $request->all();
        $attributes["active"] = (array_key_exists('active', $attributes)) ? intval($attributes["active"]) : 0;
        

		$file = FRequest::file('attachment');
		$extension = $file->getClientOriginalExtension();
		$uuid = Uuid::generate(4);
		$filename = $uuid.'.'.$extension;
		$path = session('company').'/virtues/'.$filename;

		$savelocal = Storage::disk('local')->put($path,  FFile::get($file));
		if (!$savelocal) {
			return HomeController::returnError(404);
		}
		$contents = Storage::disk('local')->read($path);
		$save = Storage::disk('s3')->put($path, $contents);
		if ($save) {
			Storage::disk('local')->delete($path);

            Storage::disk('s3')->setVisibility( $path , 'public');
            $bucket = Config::get('filesystems.disks.s3.bucket');
            $s3 = Storage::disk('s3');
            $url = $s3->getDriver()->getAdapter()->getClient()->getObjectUrl($bucket, $path);

			Session::flash('update', ['code' => 200, 'message' => 'File was uploaded']);


			File::create([

				'file_id' => $uuid,
                'company' => session('company'),
                'type' => 'virtues',
                'path' => $path,
                'name' => $filename,
                'public_url' => $url,

            ]);
            Virtue::create([

                'virtue_id' => $attributes['virtue_id'],
                'company' => session('company'),
                'name' => $attributes['name'],
                'description' => $attributes['description'],
                'file' => $uuid,
                'weight' => $attributes['weight'],
                'active' => $attributes["active"],
        	]);

        	Session::flash('update', ['code' => 200, 'message' => 'Core Value was added']);
		}else{
    	   return HomeController::returnError(404);
		}


		return redirect(route('virtues'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ( ! Auth::user()->can("edit-virtues")){
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
        if ( ! Auth::user()->can("edit-virtues")){
            return HomeController::returnError(403);
        }

        $data = Virtue::find($id);
        if (!$data) {
            return HomeController::returnError(404);
        }

        return view('pages.edit_virtue', ['id' => $id, 'virtue' => $data]);
    }

    public function give(Request $request){

        $validateto = [
                'user' => 'required',
                'story' => 'required',
                'virtue' => 'required',
                'type' => 'required',
        ];

        $this->validate($request, $validateto);
        $attributes = $request->all();

        $approved = true;
        $is_value = true;
        if ($attributes['type'] == 'anti') {
            $approved = false;
            $is_value = false;
        }



        $virtue = ['true'];
        $virtue = VirtueGiver::create([
            'given_virtue_id' => Uuid::generate(4),
            'company' => session('company'),
            'department' => session('department'),
            'period' => session('period'),
            'virtue' => $attributes['virtue'],
            'is_value' => $is_value,
            'approved' => $approved,
            'giver' => Auth::user()->user_id,
            'receiver' => $attributes['user'],
            'story' => $attributes['story'],
        ]);

        if ($virtue) {
            return Response::json(['code'=>200,'message' => 'Added virtue' , 'data' => $this->transformCollection($virtue)], 200);
        }else{
            return HomeController::returnError(404);
        }
    }

    public function received()
    {
        $whereClause = ['given_virtues.receiver' => Auth::user()->user_id, 'given_virtues.period' => session('period'), 'virtues.active' => TRUE ,'given_virtues.approved' => true ];
        $data = DB::table('given_virtues')
            ->join('users', 'given_virtues.giver', '=', 'users.user_id')
            ->join('virtues', 'given_virtues.virtue', '=', 'virtues.virtue_id')
            ->join('files', 'virtues.file', '=', 'files.file_id')
            ->select('files.public_url', 'given_virtues.is_value AS virtue_is_value', 'virtues.name AS virtue_name', 'users.lastname AS user_lastname', 'users.name AS user_name', 'given_virtues.*')
            ->where($whereClause)
            ->get();
        if (!$data) {
            return HomeController::returnError(404);
        }

        return view('pages.show_received_virtues', [ 'received_virtues' => $data]);
        // echo json_encode($data);
    }

    public function getDepartmentSummary($id)
    {
        $whereClause = ['given_virtues.department' => $id, 'period' => session('period'),'given_virtues.approved' => true];
        $virtues_received = DB::table('given_virtues')
             ->select(DB::raw('given_virtues.virtue, count(*) as virtue_count'))
             ->join('virtues', 'given_virtues.virtue', '=', 'virtues.virtue_id')
             ->groupBy('virtue')
             ->where($whereClause)
             ->get();

        return Response::json(['code'=>200, 'message' => 'OK' , 'data' => $virtues_received] , 200);
    }

    public function getCompanySummary()
    {
        $whereClause = ['given_virtues.company' => session('company'),'period' => session('period'),'given_virtues.approved' => true];
        $virtues_received = DB::table('given_virtues')
             ->select(DB::raw('given_virtues.virtue, count(*) as virtue_count'))
             ->join('virtues', 'given_virtues.virtue', '=', 'virtues.virtue_id')
             ->groupBy('virtue')
             ->where($whereClause)
             ->get();

        return Response::json(['code'=>200, 'message' => 'OK' , 'data' => $virtues_received] , 200);
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
        if ( ! Auth::user()->can("edit-virtues")){
            return HomeController::returnError(403);
        }

        $virtue = Virtue::find($id);

        if ( ! $virtue ) {
            return HomeController::returnError(404);
        }

        $validateto = [
                'virtue_id' => 'required',
                'name' => 'required',
                'weight' => 'required',
        ];

        $this->validate($request, $validateto);
        $attributes = $request->all();
        $attributes["active"] = (array_key_exists('active', $attributes)) ? intval($attributes["active"]) : 0;

        $virtue->fill($attributes);
        $virtue->save();

        Session::flash('update', ['code' => 200, 'message' => 'Core Value was updated']);
        return redirect(route('virtues'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function destroy($id)
    {
        if ( ! Auth::user()->can("edit-virtues")){
            return HomeController::returnError(403);
        }

        $virtue =Virtue::find($id);
        if (!$virtue) {
            return HomeController::returnError(404);
        }
        $fileCtrl = new FileController();
        $fileCtrl->deleteFile($virtue->file);
        $virtue->delete();

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