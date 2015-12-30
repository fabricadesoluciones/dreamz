<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use DB;
use Auth; 
use Session; 
use Uuid; 

class PositionsController extends Controller
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
        if ( ! Auth::user()->can("list-positions")){
            return HomeController::returnError(403);
        }
        $data = DB::table('positions')
            ->join('companies', 'positions.company', '=', 'companies.company_id')
            ->select('positions.*', 'companies.commercial_name AS company_name')
            ->where('positions.company','LIKE',"%".$this->company."%")
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
        if ( ! Auth::user()->can("edit-positions")){
            return HomeController::returnError(403);
        }

        if ( ! Session::get('company') ) {
            return HomeController::returnError(403, trans('general.http.select_company'), route('home'));

        }

        return view('pages.create_position', ['id' => Uuid::generate(4), 'user' => Auth::user() ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( ! Auth::user()->can("edit-positions")){
            return HomeController::returnError(403);
        }

        $this->validate($request, [
            'position_id' => 'required|unique:positions',
            'name' => 'required',
        ]);


        $attributes = $request->all();
        $position_attributes = [ 'position_id' => $attributes['position_id'], 'name' => $attributes['name'], 'boss' => (isset($attributes['boss']) ? $attributes['boss'] : 0), 'active' => (isset($attributes['boss']) ? $attributes['boss'] : 0), 'company' => $this->company ];

        $user = Position::create($position_attributes);
        Session::flash('update', ['code' => 200, 'message' => 'Position was added']);
        return redirect("/positions/".$attributes['position_id']."/edit");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ( ! Auth::user()->can("edit-positions")){
            return HomeController::returnError(403);
        }

        $data = Position::where('position_id', '=', $id)->first();
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
        if ( ! Auth::user()->can("edit-positions")){
            return HomeController::returnError(403);
        }

        $data = Position::where('position_id', '=', $id)->first()->users;
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
        if ( ! Auth::user()->can("edit-positions")){
            return HomeController::returnError(403);
        }

        $data = Position::where('position_id', '=', $id)->first();
        if (!$data) {
            return HomeController::returnError(404);
        }
        return view('pages.edit_position', ['position' => $data]);
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


        if ( ! Auth::user()->can("edit-positions")){
            return HomeController::returnError(403);
        }

        $this->validate($request, [
            'name' => 'required',
        ]);

        
        $attributes = $request->all();
        $attributes["active"] = (array_key_exists('active', $attributes)) ? intval($attributes["active"]) : 0;
        $attributes["boss"] = (array_key_exists('boss', $attributes)) ? intval($attributes["boss"]) : 0;
        
        $position = Position::where('position_id', '=', $id)->first();
        $position->fill($attributes);
        $position->save();

        Session::flash('update', ['code' => 200, 'message' => 'Position info was updated']);
        // return back();
        return redirect("/positions/$id/edit");

        
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( ! Auth::user()->can("edit-positions")){
            return HomeController::returnError(403);
        }

        $position = Position::where('position_id', '=', $id)->first();
        if (!$position) {
            return HomeController::returnError(404);
        }

        $position->active = 0;
        $position->save();

        return Response::json(['code'=>204,'message' => 'OK' , 'data' => "$id " . trans('general.http.204b')] , 204);
        
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
