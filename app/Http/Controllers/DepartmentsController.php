<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;
use DB;
use Session; 

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('departments')
            ->join('companies', 'departments.company', '=', 'companies.company_id')
            ->select('departments.*', 'companies.commercial_name AS company_name')
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
        $data = Department::where('Department_id', '=', $id)->first();
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
        $data = Department::where('Department_id', '=', $id)->first()->users;
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
        $data = Department::where('Department_id', '=', $id)->first();
        return view('pages.edit_department', ['department' => $data]);
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
        
        $department = Department::where('Department_id', '=', $id)->first();
        $department->fill($attributes);
        $department->save();

        Session::flash('update', 200);
        // return back();
        return redirect("/departments/$id/edit");

        
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::where('Department_id', '=', $id)->first();
        if (!$department) {
            return Response::json(['code'=>404,'message' => 'Not Found' ,'data' => []], 404);
            exit;
        }

        $department->active = 0;
        $department->save();

        return Response::json(['code'=>200,'message' => 'OK' , 'data' => "$id DISABLED"] , 200);
        
    }

    public function transformCollection($departments)
    {
        if(is_array($departments)){
            return $departments;
        }
        return array_map([$this, 'transform'] , $departments->toArray());
    }

    private function transform ($department)
    {
        return $department;
    }
}
