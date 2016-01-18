<?php

use App\User;
use App\Period;
use App\Dream;
use App\Company;
use App\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class DreamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        $companies = Company::all();

        foreach ($companies as $company) {
        	$periods = Period::where('company', $company->company_id)->get();
	        foreach ($periods as $period) {
	        	$users = User::where('company', $company->company_id)->get();
	        	foreach ($users as $user) {
			        foreach (range(1, 4) as $x) {
		        		Dream::create([
							'dreams_id' => $faker->uuid,
							'company' => $company->company_id,
							'department' => $user->department,
							'period' => $period->period_id,
							'user' => $user->user_id,
							'description' => $faker->sentence($nbWords = 4)
	        			]);
			        }
	        	}
	        }
        }
    }
}