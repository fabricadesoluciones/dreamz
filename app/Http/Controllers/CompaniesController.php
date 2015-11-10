<?php

namespace App\Http\Controllers;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Company::all();
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
        $data = Company::where('company_id', '=', $id)->first();
        if (!$data) {
            return Response::json(['code'=>'13','message' => 'Not Found' ,'data' => []], 404);
        }
        return Response::json(['code'=>'10','message' => 'OK' , 'data' => $this->transform($data->toArray())], 200);
    }

     /**
     * Display the users for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function users($id)
    {
        $data = Company::where('company_id', '=', $id)->first()->users;
        if (!$data) {
            return Response::json(['code'=>'13','message' => 'Not Found' ,'data' => []], 404);
        }
        return Response::json(['code'=>'10','message' => 'OK' , 'data' => $this->transform($data->toArray())], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::where('company_id', '=', $id)->first();
        if (!$company) {
            return Response::json(['code'=>'13','message' => 'Not Found' ,'data' => []], 404);
            exit;
        }

        $company->delete();

        return Response::json(['code'=>'10','message' => 'OK' , 'data' => "$id DELETED"] , 200);
        
    }

    public function transformCollection($companys)
    {
        return array_map([$this, 'transform'] , $companys->toArray());
    }

    private function transform ($company)
    {
        return $company;
    }
}
