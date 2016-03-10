<?php

namespace App\Http\Controllers;

use App\File;
use App\Virtue;
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

        $validateto = [
                'virtue_id' => 'required|unique:virtues',
                'name' => 'required',
                'type' => 'required',
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
                'name' => $attributes['weight'],
                'description' => $attributes['description'],
                'type' => $attributes['type'],
                'file' => $uuid,
                'weight' => $attributes['weight'],
                'active' => $attributes["active"],
        	]);

        	Session::flash('update', ['code' => 200, 'message' => 'Assessment was added']);
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
        if ( ! Auth::user()->can("edit-virtues")){
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