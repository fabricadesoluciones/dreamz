<?php

use App\Priority;
use App\Period;
use App\Company;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class PrioritiesTableSeeder extends Seeder
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
	        		Priority::create([
						'priority_id' => $faker->uuid,
						'period' => $period->period_id,
						'name' => $faker->word,
						'user' => $user->user_id,
						'company' => $company->company_id,
						'department' => $user->department,
						'description' => $faker->sentence($nbWords = 4),
						'status' => $faker->randomElement(['ASIGNADO','PENDIENTE','AUTORIZADO']),
						'type' => $faker->randomElement(['PERSONAL','DEPARTAMENTO','EMPRESA']),
						'w1' =>  $faker->randomElement([0,1,2,3]),
						'w2' =>  $faker->randomElement([0,1,2,3]),
						'w3' =>  $faker->randomElement([0,1,2,3]),
						'w4' =>  $faker->randomElement([0,1,2,3]),
						'w5' =>  $faker->randomElement([0,1,2,3]),
						'w6' =>  $faker->randomElement([0,1,2,3]),
						'w7' =>  $faker->randomElement([0,1,2,3]),
						'w8' =>  $faker->randomElement([0,1,2,3]),
						'w9' =>  $faker->randomElement([0,1,2,3]),
						'w10' =>  $faker->randomElement([0,1,2,3]),
						'w11' =>  $faker->randomElement([0,1,2,3]),
						'w12' =>  $faker->randomElement([0,1,2,3]),
						'w13' =>  $faker->randomElement([0,1,2,3]),


					]);

	        	}

	        }

        }


    }
}