<?php

use App\User;
use App\EducationLevel;
use App\Position;
use App\Department;
use App\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();
        $department1 = Department::all()->random(1);
        $where1 = ['company' => $department1->company, 'boss' => 1];
        $position1 = Position::where($where1)->first();
        $department2 = Department::all()->random(1);
        $where2 = ['company' => $department2->company, 'boss' => 1];
        $position2 = Position::where($where2)->first();

    	$alex = User::create(['name' => 'Alejandro', 'lastname' => 'Tapia', 'email' => 'ageofzetta@gmail.com', 'password' => Hash::make('admin'), 'active' => 1, 'user_id' => $faker->uuid, 'thumbnail' => 'https://randomuser.me/api/portraits/thumb/men/96.jpg']);
        $karla_company = Company::first();
    	$karla = User::create(['name' => 'Karla', 'lastname' => 'Reyes', 'email' => 'kreyes@fabricadesoluciones.com', 'password' => Hash::make('admin'), 'active' => 1, 'user_id' => $faker->uuid, 'thumbnail' => 'https://randomuser.me/api/portraits/thumb/women/96.jpg']);
    	$ceo = User::create([
    		'name' => 'Bill',
			'lastname' => 'CEO',
    		'email' => 'ceo@gmail.com',
    		'sex'=> $faker->randomElement($array = array ('M','F')),
    		'company' => $department2->company,
    		'department' => $department2->department_id,
    		'position' => $position2->position_id,
    		'password' => Hash::make('admin'),
			'active' => 1,
			'company' => $karla_company->company_id,
			'user_id' => $faker->uuid,
			'employee_number' => $faker->uuid,
			'thumbnail' => 'https://randomuser.me/api/portraits/thumb/men/95.jpg'

    	]);

    	$coach = User::create([
    		'name' => 'Bill',
			'lastname' => 'Coach',
    		'email' => 'coach@gmail.com',
    		'sex'=> $faker->randomElement($array = array ('M','F')),
    		'password' => Hash::make('admin'),
			'active' => 1,
			'user_id' => $faker->uuid,
			'employee_number' => $faker->uuid,
			'thumbnail' => 'https://randomuser.me/api/portraits/thumb/men/94.jpg'

    	]);

    	$coach1 = User::create([
    		'name' => 'Coach1',
			'lastname' => 'Coach',
    		'email' => 'coach1@gmail.com',
    		'sex'=> $faker->randomElement($array = array ('M','F')),
    		'password' => Hash::make('admin'),
			'active' => 1,
			'user_id' => $faker->uuid,
			'employee_number' => $faker->uuid,
			'thumbnail' => 'https://randomuser.me/api/portraits/thumb/men/94.jpg'

    	]);

    	$coach2 = User::create([
    		'name' => 'Coach2',
			'lastname' => 'Coach',
    		'email' => 'coach2@gmail.com',
    		'sex'=> $faker->randomElement($array = array ('M','F')),
    		'password' => Hash::make('admin'),
			'active' => 1,
			'user_id' => $faker->uuid,
			'employee_number' => $faker->uuid,
			'thumbnail' => 'https://randomuser.me/api/portraits/thumb/men/94.jpg'

    	]);

    	$coach3 = User::create([
    		'name' => 'Coach3',
			'lastname' => 'Coach',
    		'email' => 'coach3@gmail.com',
    		'sex'=> $faker->randomElement($array = array ('M','F')),
    		'password' => Hash::make('admin'),
			'active' => 1,
			'user_id' => $faker->uuid,
			'employee_number' => $faker->uuid,
			'thumbnail' => 'https://randomuser.me/api/portraits/thumb/men/94.jpg'

    	]);

    	$champion = User::create([
    		'name' => 'Bill',
			'lastname' => 'Champion',
    		'email' => 'champion@gmail.com',
    		'sex'=> $faker->randomElement($array = array ('M','F')),
    		'company' => $department2->company,
    		'department' => $department2->department_id,
    		'position' => $position2->position_id,
    		'password' => Hash::make('admin'),
			'active' => 1,
			'company' => $karla_company->company_id,
			'user_id' => $faker->uuid,
			'employee_number' => $faker->uuid,
			'thumbnail' => 'https://randomuser.me/api/portraits/thumb/men/93.jpg'

    	]);

    	$boss = User::create([
    		'name' => 'Patrick',
			'lastname' => 'Team Lead',
    		'email' => 'team_lead@gmail.com',
    		'sex'=> $faker->randomElement($array = array ('M','F')),
    		'company' => $department2->company,
    		'department' => $department2->department_id,
    		'position' => $position2->position_id,
    		'password' => Hash::make('admin'),
			'active' => 1,
			'company' => $karla_company->company_id,
			'user_id' => $faker->uuid,
			'employee_number' => $faker->uuid,
			'thumbnail' => 'https://randomuser.me/api/portraits/thumb/men/92.jpg'

    	]);

    	$employee = User::create([
    		'name' => 'John',
			'lastname' => 'Doe',
    		'email' => 'employee@gmail.com',
    		'sex'=> $faker->randomElement($array = array ('M','F')),
    		'company' => $department2->company,
    		'department' => $department2->department_id,
    		'position' => $position2->position_id,
    		'password' => Hash::make('admin'),
			'active' => 1,
			'company' => $karla_company->company_id,
			'user_id' => $faker->uuid,
			'employee_number' => $faker->uuid,
			'thumbnail' => 'https://randomuser.me/api/portraits/thumb/men/91.jpg'

    	]);
        $i = 0;

		

        $companies = Company::all();

        foreach ($companies as $company) {
            
            $departments = Department::where('company','=', $company->company_id)->get();
            foreach ($departments as $department) {
            	$i = 0;
		        foreach (range(1, 10) as $user) {
	            	if(!$i){
	            		$position = Position::where('name', '=', 'boss')->where('company','=',$company->company_id)->first()->position_id;
	            	}else{
	            		$position = Position::where('name', '=', 'employee')->where('company','=',$company->company_id)->first()->position_id;
	            	}
		    		$i++;
		        	User::create([
		        		'name' => $faker->firstName($gender = null|'male'|'female'),
		        		'email' => $faker->freeEmail,
		        		'sex'=> $faker->randomElement($array = array ('M','F')),
		        		'password' => Hash::make('admin'),
						'lastname' => $faker->lastName,
						'active' => $faker->boolean(70),
						'high_potential' => $faker->boolean(30),
						'company' => $company->company_id,
						'user_id' => $faker->uuid,
						'employee_number' => $faker->uuid,
						'department' => $department->department_id,
						'position' => $position,
						'thumbnail' => 'https://randomuser.me/api/portraits/thumb/'.$faker->randomElement(['women','men']).'/'. $faker->numberBetween($min = 1, $max = 95) .'.jpg'


						/*
			             TODO: Move to User Assesments

						'd_s' => $faker->randomDigitNotNull,
						'i_s' => $faker->randomDigitNotNull,
						's_s' => $faker->randomDigitNotNull,
						'c_s' => $faker->randomDigitNotNull,
						'd_a' => $faker->randomDigitNotNull,
						'i_a' => $faker->randomDigitNotNull,
						's_a' => $faker->randomDigitNotNull,
						'c_a' => $faker->randomDigitNotNull,
						'welth_dynamics' => $faker->word,
						'stengths_finder_1' => $faker->word,
						'stengths_finder_2' => $faker->word,
						'stengths_finder_3' => $faker->word,
						'stengths_finder_4' => $faker->word,
						'stengths_finder_5' => $faker->word
						*/
		        	]);
		        }
            }
        }

        
    }
}


