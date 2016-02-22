<?php

namespace App\Http\Controllers;
use App\User;
use App\Company;
use App\UserDetail;
use App\Position;
use App\EducationLevel;
use App\Role;
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
class UsersController extends Controller
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

        
        $data = DB::table('users')
            ->join('positions', 'users.position', '=', 'positions.position_id')
            ->join('departments', 'users.department', '=', 'departments.department_id')
            ->select('users.*', 'positions.name AS position_name', 'departments.name AS department_name')
            ->where('users.company', '=', $this->company)
            ->get();
        if (!$data) {
            return HomeController::returnError(404);
        }
        return Response::json(['code'=>200,'message' => 'OK' , 'data' => $this->transformCollection($data)], 200);
    }

    public function setUser($id)
    {
        $newuser = User::find($id);
        if (! $newuser) {
            return HomeController::returnError(404);
        }

        Session::set('original_user', Auth::user()->user_id);
        Auth::login($newuser);
        Session::flash('update', ['code' => 200, 'message' => 'Now logged as '.$newuser->name.' '.$newuser->lastname]);
        return redirect('/home');
    }

    public function otherUsers()
    {
        
        $data = User::where('departmen','=', Auth::user()->department );

        if (!$data) {
            return HomeController::returnError(404);
        }

        
        return view('pages.other_users', ['users' => $data] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ( ! Auth::user()->can("edit-users")){
            return HomeController::returnError(403);
        }
        return view('pages.create_user', ['id' => Uuid::generate(4), 'user' => Auth::user() ]);
        
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
            ->leftJoin('positions', 'users.position', '=', 'positions.position_id')
            ->leftJoin('departments', 'users.department', '=', 'departments.department_id')
            ->select('users.*', 'positions.position_id AS pst_id','departments.department_id AS dpt_id', 'positions.name AS position_name', 'departments.name AS department_name')
            ->where('user_id', '=', $id)
            ->first();
        if (!$data) {
            return HomeController::returnError(404);
        }
        return Response::json(['code'=>200,'message' => 'OK' , 'data' => $this->transform($data)], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createCoach()
    {
        $companies = Company::all();
        return view('pages.create_coach', ['id' => Uuid::generate(4), 'companies' => $companies ]);
    }
    public function storeCoach(Request $request, $id)
    {

        $validateto = [
                'user_id' => 'required',
                'name' => 'required',
                'lastname' => 'required',
                'email' => 'required|email|unique:users',
            ];
        $this->validate($request, $validateto);
        $post = $request->all();
        $attributes = ['user_id' => $post['user_id'], 'name' => $post['name'], 'lastname' => $post['lastname'], 'email' => $post['email']];
        $attributes["active"] = (array_key_exists('active', $post)) ? intval($post["active"]) : 0;
        $fields = HomeController::returnTableColumns('users');
        User::create(array_intersect_key($attributes, $fields));
        UserDetail::create([
                'user_details_id' => Uuid::generate(4),
                'user' => $id,
                'birth_date' => '1988-05-30', 
                'mobile' => '',
                'alergies' => '',
                'blood_type' => '',
                'emergency_contact' => '',
                'phone' => '',
                'admission_date' => '1988-05-30', 
                'facebook' => "facebook.com/",
                'twitter' => "twitter.com/@",
                'instagram' => "instagram.com/",
                'linkedin' => "linkedin.com/",
                'googlep' => "googlep.com/"

            ]);
        $coach_role = Role::where('name','=','coach')->first();
        $coach_user = User::where('email','=', $post['email'])->first();
        $coach_user->attachRole($coach_role);

        if ( isset($post['companies'])) {
            foreach ($post['companies'] as $company) {
                $updatedcompany = Company::where('company_id','=', $company)->first();
                $updatedcompany->coach = $id;
                $updatedcompany->save();
            }
        }
        Session::flash('update', ['code' => 200, 'message' => 'Coach was added']);
        return redirect('/coaches');
    }

    public function updateCoach(Request $request, $id)
    {
        if ( ! Auth::user()->hasRole('super-admin')) {
            return HomeController::returnError(403);
        }
        $whereClause = ['users.user_id'=> $id,  'roles.name' => 'coach' ];
        $coach = DB::table('users')
                ->join('role_user', 'users.user_id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->select('users.*')
                ->where($whereClause)
                ->first();
        if ( ! $coach ) {
            return HomeController::returnError(404);
        }

        $user_details = UserDetail::where('user', '=', $id)->first();
        $user = User::where('user_id', '=', $id)->first();

        $validateto = [
                'name' => 'required',
                'email' => 'required|email',
            ];

        $this->validate($request, $validateto);
        
        $post = $request->all();
        $companies = $post['companies'];
        $user->name = $post['name'];
        $user->email = $post['email'];
        $user->active = (array_key_exists('active', $post)) ? intval($post["active"]) : 0;
        $user_details->birth_date = $post['birth_date'];
        $user->save();
        $user_details->save();
        $companies = $post['companies'];
        Company::where('coach', '=', $id)->update(['coach' => NULL]);

        foreach ($companies as $company) {
            $updatedcompany = Company::where('company_id','=', $company)->first();
            $updatedcompany->coach = $id;
            $updatedcompany->save();
        }
        Session::flash('update', ['code' => 200, 'message' => 'Coach updated']);
        return redirect("/coaches");


    }
    public function editcoach($id)
    {
        if ( ! Auth::user()->hasRole('super-admin')) {
            return HomeController::returnError(403);
        }
        $companies = Company::all();
        $coach_companies = Company::where('coach', '=', $id)->get();
        $coach = User::find($id);
        if ($coach) {
            return view('pages.edit_coach',['coach' => $coach, 'coachdetails' =>  $coach->details, 'companies' => $companies , 'coach_companies' => $coach_companies]);

        }
        
    }
    public function edit($id)
    {
        if ( Auth::user()->user_id == $id || Auth::user()->can("edit-users")){
            $data = DB::table('users')
                ->leftJoin('positions', 'users.position', '=', 'positions.position_id')
                ->leftJoin('departments', 'users.department', '=', 'departments.department_id')
                ->leftJoin('user_details', 'users.user_id', '=', 'user_details.user')
                ->select('users.*', 'user_details.*', 'positions.name AS position_name', 'departments.name AS department_name')
                ->where('user_id', '=', $id)
                ->first();
            if (!$data) {
                return HomeController::returnError(404);
            }
            $education_levels = EducationLevel::where('company','=', $this->company)->get();
            return view('pages.edit_user', ['user' => $data, 'education_levels' => $education_levels]);
        } else {
        return HomeController::returnError(403);
        }
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
        if ( Auth::user()->user_id == $id || Auth::user()->can("edit-users")){

        $user_details = UserDetail::where('user', '=', $id)->first();

        $validateto = [
                'user_id' => 'required',
                'employee_number' => 'required',
                'lastname' => 'required',
                'department' => 'required',
                'position' => 'required',
                'email' => 'required|email',
            ];
        
        if (!$user_details) {
            $validateto['email'] = 'required|email|unique:users';
        }

        $this->validate($request, $validateto);

        $attributes = $request->all();
        $user_attributes = $attributes;

        if ( ! Auth::user()->can("edit-users") && Auth::user()->user_id == $id){
            $user_attributes['email'] = Auth::user()->email;
            $user_attributes['active'] = Auth::user()->active;
            $user_attributes['high_potential'] = Auth::user()->high_potential;
            $user_attributes['position'] = Auth::user()->position;
            $user_attributes['department'] = Auth::user()->department;
            $user_attributes['admission_date'] = $user_details->admission_date;
            
        }

        unset($user_attributes['user']);
        unset($user_attributes['mobile']);
        unset($user_attributes['phone']);
        unset($user_attributes['birth_date']);
        unset($user_attributes['education']);
        unset($user_attributes['blood_type']);
        unset($user_attributes['alergies']);
        unset($user_attributes['emergency_contact']);
        unset($user_attributes['admission_date']);
        unset($user_attributes['facebook']);
        unset($user_attributes['twitter']);
        unset($user_attributes['instagram']);
        unset($user_attributes['linkedin']);
        unset($user_attributes['googlep']);

        $user_attributes["user_id"] = $id;
        $user_attributes["active"] = (array_key_exists('active', $user_attributes)) ? intval($user_attributes["active"]) : 0;
        $user_attributes["high_potential"] = (array_key_exists('high_potential', $user_attributes)) ? intval($user_attributes["high_potential"]) : 0;
        $user_details_attributes = array_diff($attributes, $user_attributes);

        $user = User::where('user_id', '=', $id)->first();
        if ($user) {
            unset($user_attributes["user_id"]);

            $user->fill($user_attributes);
            Session::flash('update', ['code' => 200, 'message' => trans('general.http.200u')]);

            $whereClause = ['position_id'=> $user_attributes['position'],  'deleted_at' => NULL];
            $position = Position::where($whereClause)->first();

            $user->detachRoles($user->roles);

            if ($position && $position->boss) {
                $lead = Role::where('name','=','team_lead')->first();
                $user->attachRole($lead);
            }else{
                $employee = Role::where('name','=','employee')->first();
                $user->attachRole($employee);
            }
        }else{
            $whereClause = ['company' => $this->company, 'boss' => 0 ,  'deleted_at' => NULL];
            $position = Position::where($whereClause)->first();
            $user_attributes['password'] = Hash::make(rand());
            $user_attributes['company'] = $this->company;
            // $user_attributes['position'] = $position->position_id;
            $user = User::create($user_attributes);
            Session::flash('update', ['code' => 200, 'message' => trans('general.http.200up')]);
        }
        $user->save();

        $user_details2 = UserDetail::first();
        $user_details = UserDetail::where('user', '=', $id)->first();
        if ($user_details) {
            $user_details->fill($user_details_attributes);
            Session::flash('update', ['code' => 200, 'message' => trans('general.http.200u')]);
            $user_details->save();
        }else{
            UserDetail::create([
                'user_details_id' => Uuid::generate(4),
                'user' => $id,
                'birth_date' => '1988-05-30', 
                'mobile' => '',
                'alergies' => '',
                'blood_type' => '',
                'emergency_contact' => '',
                'phone' => '',
                'admission_date' => '1988-05-30', 
                'facebook' => "facebook.com/",
                'twitter' => "twitter.com/@",
                'instagram' => "instagram.com/",
                'linkedin' => "linkedin.com/",
                'googlep' => "googlep.com/"

            ]);
        }

        // return back();
        return redirect("/users/$id/edit");

        }else{
            return HomeController::returnError(403);
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
        if ( ! Auth::user()->can("edit-users")){
            return HomeController::returnError(403);
        }

        $user = User::where('user_id', '=', $id)->first();
        if (!$user) {
            return HomeController::returnError(404);
        }

        $user->delete();

        return Response::json(['code'=>204,'message' => 'OK' , 'data' => "$id " . trans('general.http.204')] , 204);
        
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
