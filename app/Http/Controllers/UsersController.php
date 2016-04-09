<?php

namespace App\Http\Controllers;
use App\User;
use App\TrueAssessment;
use App\Company;
use App\UserDetail;
use App\Position;
use App\Virtue;
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
use Storage;

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

    public function save(){
        $disk = Storage::disk('s3')->exists('5d8f91c6-8009-3dc7-b163-e9362e299a36/assessments/aa7bb5f7-df55-468d-9f00-12db20446cce.pdf');
        // $filename = 'DB-Dreamz.pdf';
        // $contents = Storage::disk('local')->read($filename);
        // $disk = Storage::disk('s3')->put('DB-Dreamz.pdf', $contents);
        // $exists = Storage::disk('s3')->exists($filename);

        // header("Content-type:application/octet-stream");
        // header("Content-Disposition:attachment;filename=".$filename);

        var_dump($disk);
        // return $file;

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

    public function loginOriginal()
    {
        if( Session::get('original_user') ){
            $olduser = User::find( Session::pull('original_user') );
            if ( ! $olduser) {
                return HomeController::returnError(404);
            }

            Auth::login($olduser);
            Session::flash('update', ['code' => 200, 'message' => 'Welcome back '.$olduser->name.' '.$olduser->lastname]);
            return redirect('/home');
            
        }else{
            return redirect('/logout');
        }
    }

    public function otherUsers()
    {
        
        $data = User::where('department','=', Auth::user()->department )->get();
        $whereClause = ['virtues.company' => session('company'), 'active' => TRUE];
        $virtues = DB::table('virtues')
            ->select('virtues.*')
            ->where($whereClause)
            ->get();

        if (!$data) {
            return HomeController::returnError(404);
        }

        if (!$virtues) {
            $virtues = false;
        }

        
        return view('pages.other_users', ['users' => $data , 'virtues' => $virtues] );
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
                ->leftJoin('true_assessments', 'users.user_id', '=', 'true_assessments.user')
                ->select('users.*', 'user_details.*', 'positions.name AS position_name', 'departments.name AS department_name','true_assessments.*')
                ->where('user_id', '=', $id)
                ->first();
            if (!$data) {
                return HomeController::returnError(404);
            }
            $education_levels = EducationLevel::where('company','=', $this->company)->get();
            return view('pages.edit_user', ['user' => $data, 'education_levels' => $education_levels]);
            // echo json_encode(['user' => $data, 'education_levels' => $education_levels]);
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
            $validateto['employee_number'] = 'required|unique:users';
        }

        $this->validate($request, $validateto);

        $attributes = $request->all();
        $user_assessments = array(
            'disc_d' => $attributes['disc_d'],
            'disc_i' => $attributes['disc_i'],
            'disc_s' => $attributes['disc_s'],
            'disc_c' => $attributes['disc_c'],
            'adapted_disc_d' => $attributes['adapted_disc_d'],
            'adapted_disc_i' => $attributes['adapted_disc_i'],
            'adapted_disc_s' => $attributes['adapted_disc_s'],
            'adapted_disc_c' => $attributes['adapted_disc_c'],
            'welth_dynamics' => $attributes['welth_dynamics'],
            'strengths_finder_1' => $attributes['strengths_finder_1'],
            'strengths_finder_2' => $attributes['strengths_finder_2'],
            'strengths_finder_3' => $attributes['strengths_finder_3'],
            'strengths_finder_4' => $attributes['strengths_finder_4']
        );

        unset($attributes['disc_d']);
        unset($attributes['disc_i']);
        unset($attributes['disc_s']);
        unset($attributes['disc_c']);
        unset($attributes['adapted_disc_d']);
        unset($attributes['adapted_disc_i']);
        unset($attributes['adapted_disc_s']);
        unset($attributes['adapted_disc_c']);
        unset($attributes['welth_dynamics']);
        unset($attributes['strengths_finder_1']);
        unset($attributes['strengths_finder_2']);
        unset($attributes['strengths_finder_3']);
        unset($attributes['strengths_finder_4']);

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
        $champion = (array_key_exists('champion', $user_attributes)) ? intval($user_attributes["champion"]) : 0;
        $user_attributes["high_potential"] = (array_key_exists('high_potential', $user_attributes)) ? intval($user_attributes["high_potential"]) : 0;
        $user_details_attributes = array_diff($attributes, $user_attributes);

        unset($user_attributes['champion']);

        $user = User::where('user_id', '=', $id)->first();
        if ($user) {
            unset($user_attributes["user_id"]);

            $user->fill($user_attributes);
            Session::flash('update', ['code' => 200, 'message' => trans('general.http.200u')]);

            $whereClause = ['position_id'=> $user_attributes['position'],  'deleted_at' => NULL];
            $position = Position::where($whereClause)->first();

            $user->detachRoles($user->roles);

            if ($champion) {
                $role = Role::where('name','=','champion')->first();
            }
            else if ($position && $position->boss) {
                $role = Role::where('name','=','team_lead')->first();
            }else{
                $role = Role::where('name','=','employee')->first();
            }
                $user->attachRole($role);
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

        $user_true_assessment = TrueAssessment::where('user', '=', $id)->first();
        $user_details = UserDetail::where('user', '=', $id)->first();
        $user_true_assessment_create = array(
            'true_assessment_id' => Uuid::generate(4),
            'user' => $attributes['user_id'],
            'disc_d' => (isset($user_assessments['disc_d'])) ? $user_assessments['disc_d'] : 0,
            'disc_i' => (isset($user_assessments['disc_i'])) ? $user_assessments['disc_i'] : 0,
            'disc_s' => (isset($user_assessments['disc_s'])) ? $user_assessments['disc_s'] : 0,
            'disc_c' => (isset($user_assessments['disc_c'])) ? $user_assessments['disc_c'] : 0,
            'adapted_disc_d' => (isset($user_assessments['adapted_disc_d'])) ? $user_assessments['adapted_disc_d'] : "",
            'adapted_disc_i' => (isset($user_assessments['adapted_disc_i'])) ? $user_assessments['adapted_disc_i'] : "",
            'adapted_disc_s' => (isset($user_assessments['adapted_disc_s'])) ? $user_assessments['adapted_disc_s'] : "",
            'adapted_disc_c' => (isset($user_assessments['adapted_disc_c'])) ? $user_assessments['adapted_disc_c'] : "",
            'welth_dynamics' => (isset($user_assessments['welth_dynamics'])) ? $user_assessments['welth_dynamics'] : "",
            'strengths_finder_1' => (isset($user_assessments['strengths_finder_1'])) ? $user_assessments['strengths_finder_1'] : "",
            'strengths_finder_2' => (isset($user_assessments['strengths_finder_2'])) ? $user_assessments['strengths_finder_2'] : "",
            'strengths_finder_3' => (isset($user_assessments['strengths_finder_3'])) ? $user_assessments['strengths_finder_3'] : "",
            'strengths_finder_4' => (isset($user_assessments['strengths_finder_4'])) ? $user_assessments['strengths_finder_4'] : "",
            'strengths_finder_5' => (isset($user_assessments['strengths_finder_5'])) ? $user_assessments['strengths_finder_5'] : "",
        );

        if ($user_true_assessment) {
            $user_true_assessment->fill($user_true_assessment_create);
            Session::flash('update', ['code' => 200, 'message' => trans('general.http.200u')]);
            $user_true_assessment->save();
        }else{

            TrueAssessment::create($user_true_assessment_create);

        }
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
