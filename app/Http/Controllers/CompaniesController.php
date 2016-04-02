<?php

namespace App\Http\Controllers;
use App\Company;
use App\Industry;
use App\Emotion;
use App\ActiveEmotion;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use DB;
use Session; 
use Auth; 
use Uuid; 

class CompaniesController extends Controller
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
        if ( ! Auth::user()->can("list-companies")){
            return HomeController::returnError(403);
        }
        $data = Company::all();
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
        if ( ! Auth::user()->can("edit-companies")){
            return HomeController::returnError(403);
        }

        $industries = Industry::all();

        return view('pages.create_company', ['id' => Uuid::generate(4), 'user' => Auth::user(), 'industries' => $industries ]);
        
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( ! Auth::user()->hasRole('super-admin')  ){
            return HomeController::returnError(403);
        }

        $required = [
            "company_id" => 'required|unique:companies',
            "commercial_name" => 'required',
            "slogan" => 'required',
            "logo" => 'required',
            "country" => 'required',
            "language" => 'required',
        ];
        $this->validate($request, $required);

        $attributes = $request->all();
        $fields = HomeController::returnTableColumns('companies');
        Company::create(array_intersect_key($attributes, $fields));

        $emotions = Emotion::all();
        foreach ($emotions as $emotion) {
                ActiveEmotion::create([
                    'active_emotion_id' => Uuid::generate(4),
                    'company' => $attributes['company_id'],
                    'emotion' => $emotion->emotion_id,
                    'active' => 0 ,
                ]);
            }

        Session::flash('update', ['code' => 200, 'message' => 'Company was created,  please enable emotions for it']);
        Session::set('company', $attributes['company_id']);
        Session::set('company_name', $attributes['commercial_name']);
        Session::set('company_logo', $attributes['logo']);
        return redirect('/emotions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ( ! Auth::user()->can("list-companies")){
            return HomeController::returnError(403);
        }

        $data = Company::where('company_id', '=', $id)->first();
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

        $data = Company::where('company_id', '=', $id)->first()->users;
        if (!$data) {
            return HomeController::returnError(404);
        }
        return Response::json(['code'=>200,'message' => 'OK' , 'data' => $this->transform($data->toArray())], 200);
    }

    /**
     * Display the departments for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function departments($id)
    {
        $data = Company::where('company_id', '=', $id)->first()->departments;
        if (!$data) {
            return HomeController::returnError(404);
        }
        return Response::json(['code'=>200,'message' => 'OK' , 'data' => $this->transform($data->toArray())], 200);
    }

    /**
     * Display the positions for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function positions($id)
    {
        $data = Company::where('company_id', '=', $id)->first()->positions;
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
        if ( ! Auth::user()->can("edit-companies")){
            return HomeController::returnError(403);
        }

        $company = Company::where('company_id', '=', $id)->first();
        $industries = Industry::all();
        if (!$company) {
            return HomeController::returnError(404);
        }
        return view('pages.edit_company', ['company' => $company, 'industries' => $industries]);
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
        
        if ( ! Auth::user()->can("edit-companies")){
            return HomeController::returnError(403);
        }

        $this->validate($request, [
            "commercial_name" => 'required',
            "rfc" => 'required',
            "slogan" => 'required',
            "logo" => 'required',
            "country" => 'required',
            "language" => 'required',
        ]);

        $attributes = $request->all();
        $attributes["active"] = (array_key_exists('active', $attributes)) ? intval($attributes["active"]) : 0;
        
        $company = Company::where('company_id', '=', $id)->first();
        $company->fill($attributes);
        $company->save();

        Session::flash('update', ['code' => 200, 'message' => 'Company was updated']);
        return redirect(route('companies'));

        
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( ! Auth::user()->can("edit-companies")){
            return HomeController::returnError(403);
        }
        
        $company = Company::where('company_id', '=', $id)->first();
        if (!$company) {
            return HomeController::returnError(404);
        }

        $company->delete();

        return Response::json(['code'=>204,'message' => 'OK' , 'data' => "$id " . trans('general.http.204b')] , 204);
        
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
