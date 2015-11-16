<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;
use DB;
use Session; 
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('users')
            ->join('positions', 'users.position', '=', 'positions.position_id')
            ->join('departments', 'users.department', '=', 'departments.department_id')
            ->select('users.*', 'positions.name AS position_name', 'departments.name AS department_name')
            ->get();
        if (!$data) {
            return Response::json(['code'=>'13','message' => 'Not Found' ,'data' => []], 404);
        }
        return Response::json(['code'=>'10','message' => 'OK' , 'data' => $this->transformCollection($data)], 200);
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
    public function show($id)
    {
        $data = DB::table('users')
            ->join('positions', 'users.position', '=', 'positions.position_id')
            ->join('departments', 'users.department', '=', 'departments.department_id')
            ->select('users.*', 'positions.position_id AS pst_id','departments.department_id AS dpt_id', 'positions.name AS position_name', 'departments.name AS department_name')
            ->where('user_id', '=', $id)
            ->first();
        if (!$data) {
            return Response::json(['code'=>'13','message' => 'Not Found' ,'data' => []], 404);
        }
        return Response::json(['code'=>'10','message' => 'OK' , 'data' => $this->transform($data)], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('users')
            ->join('positions', 'users.position', '=', 'positions.position_id')
            ->join('departments', 'users.department', '=', 'departments.department_id')
            ->select('users.*', 'positions.name AS position_name', 'departments.name AS department_name')
            ->where('user_id', '=', $id)
            ->first();
        return view('pages.edit_user', ['user' => $data]);
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
        $attributes["high_potential"] = (array_key_exists('high_potential', $attributes)) ? intval($attributes["high_potential"]) : 0;
        
        $user = User::where('user_id', '=', $id)->first();
        $user->fill($attributes);
        $user->save();

        Session::flash('update', 200);
        // return back();
        return redirect("/users/$id/edit");

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('user_id', '=', $id)->first();
        if (!$user) {
            return Response::json(['code'=>'13','message' => 'Not Found' ,'data' => []], 404);
            exit;
        }

        $user->delete();

        return Response::json(['code'=>'10','message' => 'OK' , 'data' => "$id DELETED"] , 200);
        
    }

    public function transformCollection($users)
    {
        if (is_array($users)){
            return $users;
        }
        return array_map([$this, 'transform'] , $users->toArray());
    }

    private function transform ($user)
    {
        return $user;
    }
}
