<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;
use DB;
use Auth; 
use Session; 

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
            return Response::json(['code'=>403,'message' => 'User can not access this resource' ,'data' => []], 403);
            exit;
        }
        $data = DB::table('positions')
            ->join('companies', 'positions.company', '=', 'companies.company_id')
            ->select('positions.*', 'companies.commercial_name AS company_name')
            ->where('positions.company','LIKE',"%".$this->company."%")
            ->get();

        if (!$data) {
            return Response::json(['code'=>404,'message' => 'Not Found' ,'data' => []], 404);
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
            return Response::json(['code'=>403,'message' => 'User can not access this resource' ,'data' => []], 403);
            exit;
        }

        //
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
            return Response::json(['code'=>403,'message' => 'User can not access this resource' ,'data' => []], 403);
            exit;
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
        if ( ! Auth::user()->can("edit-positions")){
            return Response::json(['code'=>403,'message' => 'User can not access this resource' ,'data' => []], 403);
            exit;
        }

        $data = Position::where('position_id', '=', $id)->first();
        if (!$data) {
            return Response::json(['code'=>404,'message' => 'Not Found' ,'data' => []], 404);
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
            return Response::json(['code'=>403,'message' => 'User can not access this resource' ,'data' => []], 403);
            exit;
        }

        $data = Position::where('position_id', '=', $id)->first()->users;
        if (!$data) {
            return Response::json(['code'=>404,'message' => 'Not Found' ,'data' => []], 404);
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
            return Response::json(['code'=>403,'message' => 'User can not access this resource' ,'data' => []], 403);
            exit;
        }

        $data = Position::where('position_id', '=', $id)->first();
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
            return Response::json(['code'=>403,'message' => 'User can not access this resource' ,'data' => []], 403);
            exit;
        }

        
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
            return Response::json(['code'=>403,'message' => 'User can not access this resource' ,'data' => []], 403);
            exit;
        }

        $position = Position::where('position_id', '=', $id)->first();
        if (!$position) {
            return Response::json(['code'=>404,'message' => 'Not Found' ,'data' => []], 404);
            exit;
        }

        $position->active = 0;
        $position->save();

        return Response::json(['code'=>204,'message' => 'OK' , 'data' => "$id DISABLED"] , 204);
        
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
