<?php

use App\User;
use App\Education_level;
use App\Position;
use App\Department;
use App\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
use App\Role;
use App\Permission;

class EntrustTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$super_admin = new Role();
		$super_admin->name         = 'super-admin';
		$super_admin->display_name = 'Super Admin';
		$super_admin->save();
		$super_admin = Role::where('name','=','super-admin')->first();

		$ceo = new Role();
		$ceo->name         = 'ceo';
		$ceo->display_name = 'Ceo';
		$ceo->save();
		$ceo = Role::where('name','=','ceo')->first();

        $champion = new Role();
		$champion->name         = 'champion';
		$champion->display_name = 'Champion';
		$champion->save();
		$champion = Role::where('name','=','champion')->first();

        $coach = new Role();
		$coach->name         = 'coach';
		$coach->display_name = 'Coach';
		$coach->save();
		$coach = Role::where('name','=','coach')->first();

		$lead = new Role();
		$lead->name         = 'team_lead';
		$lead->display_name = 'Team Lead';
		$lead->save();
		$lead = Role::where('name','=','team_lead')->first();

		$employee = new Role();
		$employee->name         = 'employee';
		$employee->display_name = 'Employee';
		$employee->save();
		$employee = Role::where('name','=','employee')->first();


		$list_users = new Permission(); $list_users->name = 'list-users'; $list_users->save(); $list_users = Permission::where('name','=','list-users')->first();
		$edit_users = new Permission(); $edit_users->name = 'edit-users'; $edit_users->save(); $edit_users = Permission::where('name','=','edit-users')->first();
		$list_companies = new Permission(); $list_companies->name = 'list-companies'; $list_companies->save(); $list_companies = Permission::where('name','=','list-companies')->first();
		$edit_companies = new Permission(); $edit_companies->name = 'edit-companies'; $edit_companies->save(); $edit_companies = Permission::where('name','=','edit-companies')->first();
		$list_departments = new Permission(); $list_departments->name = 'list-departments'; $list_departments->save(); $list_departments = Permission::where('name','=','list-departments')->first();
		$edit_departments = new Permission(); $edit_departments->name = 'edit-departments'; $edit_departments->save(); $edit_departments = Permission::where('name','=','edit-departments')->first();
		$list_objectives = new Permission(); $list_objectives->name = 'list-objectives'; $list_objectives->save(); $list_objectives = Permission::where('name','=','list-objectives')->first();
		$edit_objectives = new Permission(); $edit_objectives->name = 'edit-objectives'; $edit_objectives->save(); $edit_objectives = Permission::where('name','=','edit-objectives')->first();
		$progress_objectives = new Permission(); $progress_objectives->name = 'progress-objectives'; $progress_objectives->save(); $progress_objectives = Permission::where('name','=','progress-objectives')->first();
		$list_priorities = new Permission(); $list_priorities->name = 'list-priorities'; $list_priorities->save(); $list_priorities = Permission::where('name','=','list-priorities')->first();
		$edit_priorities = new Permission(); $edit_priorities->name = 'edit-priorities'; $edit_priorities->save(); $edit_priorities = Permission::where('name','=','edit-priorities')->first();
		$progress_priorities = new Permission(); $progress_priorities->name = 'progress-priorities'; $progress_priorities->save(); $progress_priorities = Permission::where('name','=','progress-priorities')->first();
		$list_industries = new Permission(); $list_industries->name = 'list-industries'; $list_industries->save(); $list_industries = Permission::where('name','=','list-industries')->first();
		$edit_industries = new Permission(); $edit_industries->name = 'edit-industries'; $edit_industries->save(); $edit_industries = Permission::where('name','=','edit-industries')->first();
		$list_countries = new Permission(); $list_countries->name = 'list-countries'; $list_countries->save(); $list_countries = Permission::where('name','=','list-countries')->first();
		$edit_countries = new Permission(); $edit_countries->name = 'edit-countries'; $edit_countries->save(); $edit_countries = Permission::where('name','=','edit-countries')->first();
		$list_languages = new Permission(); $list_languages->name = 'list-languages'; $list_languages->save(); $list_languages = Permission::where('name','=','list-languages')->first();
		$edit_languages = new Permission(); $edit_languages->name = 'edit-languages'; $edit_languages->save(); $edit_languages = Permission::where('name','=','edit-languages')->first();
		$list_positions = new Permission(); $list_positions->name = 'list-positions'; $list_positions->save(); $list_positions = Permission::where('name','=','list-positions')->first();
		$edit_positions = new Permission(); $edit_positions->name = 'edit-positions'; $edit_positions->save(); $edit_positions = Permission::where('name','=','edit-positions')->first();
		$list_education = new Permission(); $list_education->name = 'list-education'; $list_education->save(); $list_education = Permission::where('name','=','list-education')->first();
		$edit_education = new Permission(); $edit_education->name = 'edit-education'; $edit_education->save(); $edit_education = Permission::where('name','=','edit-education')->first();
		$list_periods = new Permission(); $list_periods->name = 'list-periods'; $list_periods->save(); $list_periods = Permission::where('name','=','list-periods')->first();
		$edit_periods = new Permission(); $edit_periods->name = 'edit-periods'; $edit_periods->save(); $edit_periods = Permission::where('name','=','edit-periods')->first();
		$edit_emotions = new Permission(); $edit_emotions->name = 'edit-emotions'; $edit_emotions->save(); $edit_emotions = Permission::where('name','=','edit-emotions')->first();

		$super_admin->attachPermissions(array($edit_emotions, $progress_objectives, $progress_priorities,$list_users , $edit_users , $list_companies , $edit_companies , $list_departments , $edit_departments , $list_objectives , $edit_objectives , $list_priorities , $edit_priorities , $list_industries , $edit_industries , $list_countries , $edit_countries , $list_languages , $edit_languages , $list_positions , $edit_positions , $list_education , $edit_education , $list_periods , $edit_periods ));
		$coach->attachPermissions(array($edit_emotions, $progress_objectives, $progress_priorities,$list_users , $edit_users , $list_companies , $edit_companies , $list_departments , $edit_departments , $list_objectives , $edit_objectives , $list_priorities , $edit_priorities , $list_industries , $edit_industries , $list_countries , $edit_countries , $list_languages , $edit_languages , $list_positions , $edit_positions , $list_education , $edit_education , $list_periods , $edit_periods ));
		$ceo->attachPermissions(array($progress_objectives, $progress_priorities,$list_users, $list_departments, $list_objectives, $edit_objectives, $list_priorities, $edit_priorities, $list_industries, $edit_industries));
		$champion->attachPermissions(array($edit_emotions, $progress_objectives, $progress_priorities,$list_users, $edit_users, $list_departments, $edit_departments, $list_objectives, $edit_objectives, $list_priorities, $edit_priorities, $list_positions, $edit_positions, $list_education, $edit_education, ));
		$lead->attachPermissions(array($edit_objectives, $progress_objectives, $progress_priorities,$list_objectives, $edit_priorities, $list_priorities, $list_users, $list_departments));
		$employee->attachPermissions(array($progress_objectives, $progress_priorities,$list_objectives, $edit_priorities, $list_priorities, $list_departments));

		$alex = User::where('email','=','ageofzetta@gmail.com')->first();
    	$alex->attachRole($super_admin);
		$karla = User::where('email','=','kreyes@fabricadesoluciones.com')->first();
    	$karla->attachRole($coach);


    	$ceo_user =  User::where('email','=','ceo@gmail.com')->first();
    	$ceo_user->attachRole($ceo);
    	
    	$champion_user =  User::where('email','=','champion@gmail.com')->first();
    	$champion_user->attachRole($champion);

    	$coach_user =  User::where('email','=','coach@gmail.com')->first();
    	$coach_user->attachRole($coach);
    	
    	$boss_user =  User::where('email','=','team_lead@gmail.com')->first();
    	$boss_user->attachRole($lead);
    	
    	$employee_user =  User::where('email','=','employee@gmail.com')->first();
    	$employee_user->attachRole($employee);


    }
}
