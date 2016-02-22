<?php

namespace App\Http\Controllers;

use App\Task;
use App\Dream;
use App\DreamCategory;
use App\DreamSubcategory;
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

class DreamsController extends Controller
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
        $data = Dream::where('user','=',Auth::user()->user_id)->get();
        $whereClause = ['user' => Auth::user()->user_id, 'period' =>  session('period')];
        $data = DB::table('dreams')
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
        $periods = Period::where('company','=',$this->company)->get();
        $categories = DreamCategory::where('company','=',$this->company)->get();
        $subcategories = DreamSubcategory::where('company','=',$this->company)->get();
        return view('pages.create_dream', ['id' => Uuid::generate(4), 'periods' => $periods, 'categories' => $categories, 'subcategories' => $subcategories]);
    }

    public function createCategory()
    {
        if ( ! Auth::user()->hasRole('super-admin') && ! Auth::user()->hasRole('coach') && ! Auth::user()->hasRole('champion')) { return HomeController::returnError(403); }

        return view('pages.create_dream_category', ['id' => Uuid::generate(4), 'user' => Auth::user()] );
    }

    public function storeCategory(Request $request, $id)
    {
        if ( ! Auth::user()->hasRole('super-admin') && ! Auth::user()->hasRole('coach') && ! Auth::user()->hasRole('champion')) { return HomeController::returnError(403); }
        $attributes = $request->all();


         $required = [
            "category_id" => 'required|unique:dreams_categories',
            "name" => 'required',
        ];
        $this->validate($request, $required);

        $attributes = $request->all();
        $attributes['company'] = $this->company;
        $attributes['active'] = 1;
        $fields = HomeController::returnTableColumns('dreams_categories');
        DreamCategory::create(array_intersect_key($attributes, $fields));
        Session::flash('update', ['code' => 200, 'message' => 'Category was added']);
        return redirect('/dreams/');
    }

    public function createSubcategory()
    {
        if ( ! Auth::user()->hasRole('super-admin') && ! Auth::user()->hasRole('coach') && ! Auth::user()->hasRole('champion')) { return HomeController::returnError(403); }
        $categories = DreamCategory::where('company','=',$this->company)->get();
        return view('pages.create_dream_subcategory', ['id' => Uuid::generate(4), 'user' => Auth::user(), 'categories' => $categories] );
    }

    public function storeSubcategory(Request $request, $id)
    {
        if ( ! Auth::user()->hasRole('super-admin') && ! Auth::user()->hasRole('coach') && ! Auth::user()->hasRole('champion')) { return HomeController::returnError(403); }
        $attributes = $request->all();


         $required = [
            "subcategory_id" => 'required|unique:dreams_subcategories',
            "name" => 'required',
            "parent" => 'required',
        ];
        $this->validate($request, $required);

        $attributes = $request->all();
        $attributes['company'] = $this->company;
        $attributes['active'] = 1;
        $fields = HomeController::returnTableColumns('dreams_subcategories');
        DreamSubcategory::create(array_intersect_key($attributes, $fields));
        Session::flash('update', ['code' => 200, 'message' => 'Category was added']);
        return redirect('/dreams/');
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
                'description' => 'required',
                'period' => 'required',
        ];
        
        $this->validate($request, $validateto);
        $attributes = $request->all();
        $attributes['company'] = $this->company;
        $attributes['department'] = $this->department;
        $attributes['user'] = Auth::user()->user_id;

        $fields = HomeController::returnTableColumns('dreams');
        Dream::create(array_intersect_key($attributes, $fields));

        Session::flash('update', ['code' => 200, 'message' => 'Dream was added']);
        return redirect("/dreams/".$attributes['dreams_id']."/edit");
        return redirect(route('dreams'));
    
    
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

    public function get_dream_subcategories($id)
    {
        if ( ! Auth::user()->can("edit-emotions")){
            return HomeController::returnError(403);
        }
        $data = DreamSubcategory::where('parent', '=', $id)->get();
        if (!$data) {
            return HomeController::returnError(404);
        }
        return Response::json(['code'=>200,'message' => 'OK' , 'data' => $this->transformCollection($data)], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $periods = Period::where('company','=',$this->company)->get();
        $dream = Dream::where('dreams_id','=',$id)->first();
        $data = DB::table('dreams')
            ->join('dreams_subcategories', 'dreams.subcategory', '=', 'dreams_subcategories.subcategory_id')
            ->join('dreams_categories', 'dreams_subcategories.parent', '=', 'dreams_categories.category_id')
            ->select('dreams.*','dreams_categories.name AS dream_categorie_name','dreams_categories.category_id AS dream_categorie_id','dreams_subcategories.name AS dream_subcategorie_name')
            ->where('dreams.dreams_id','=', $id)
            ->first();

        if (!$data) {
            return HomeController::returnError(404);
        }

        $categories = DreamCategory::where('company','=',$this->company)->get();
        $subcategories = DreamSubcategory::where('company','=',$this->company)->get();

        return view('pages.edit_dream', ['id'=> $id, 'dream' => $data, 'periods' => $periods, 'categories' => $categories, 'subcategories' => $subcategories]);

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
                'description' => 'required',
                'period' => 'required',
                'subcategory' => 'required',
        ];
        
        $this->validate($request, $validateto);
        $attributes = $request->all();
        $attributes['company'] = $this->company;
        $attributes['department'] = $this->department;
        $attributes['user'] = Auth::user()->user_id;

        $dreams = Dream::where('dreams_id', '=', $id)->first();
        // die(json_encode($dreams));
        // die(json_encode($attributes));
        $dreams->fill($attributes);
        $dreams->save();

        Session::flash('update', ['code' => 200, 'message' => 'Dream was updated']);
        return redirect("/dreams/$id/edit");
        return redirect(route('dreams'));
    
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
