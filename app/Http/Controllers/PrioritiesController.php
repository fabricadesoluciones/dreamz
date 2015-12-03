<?php

namespace App\Http\Controllers;

use App\Priority;
use App\Position;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;
use DB;
use Session; 
use Auth; 


class PrioritiesController extends Controller
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

        $user = Auth::user();
        
        $data = $user->priorities;
         if (!$data) {
            return Response::json(['code'=>404,'message' => 'Not Found' ,'data' => []], 404);
        }
        
        $user->position = 'dd21bddc-141e-3ca7-b9d3-9b330561b7a1';
        $user->department = '1a861e62-9905-38d6-987e-40d5593f643f';
        $position = Position::where('position_id', '=', $user->position)->first();

        $users = [];

        if (!empty($position) && $position->boss) {
            $users = User::where('department', '=', $user->department)->get(['user_id']);
        }

        return Response::json(['code'=>200,'message' => 'OK' , 'data' => 
            ['priorities' => $this->transform($data->toArray()), 'subordinates' => $users]
            ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        echo $user->user_id;
    }

     /**
     * Display the users for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function users($id)
    {
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
        $position = Position::where('position_id', '=', $id)->first();
        if (!$position) {
            return Response::json(['code'=>404,'message' => 'Not Found' ,'data' => []], 404);
            exit;
        }

        $position->active = 0;
        $position->save();

        return Response::json(['code'=>200,'message' => 'OK' , 'data' => "$id DISABLED"] , 200);
        
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
