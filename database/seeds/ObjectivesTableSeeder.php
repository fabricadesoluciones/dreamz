<?php

use App\Objective;
use App\ObjectiveSubcategory;
use App\MeasuringUnit;
use App\Period;
use App\Company;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class ObjectivesTableSeeder extends Seeder
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
        $companies = Company::get();


        foreach ($companies as $company) {
        	$periods = Period::where('company', $company->company_id)->get();
	        $subcategories = ObjectiveSubcategory::where('company','=', $company->company_id)->get();
	        $flat_subcategories = [];
	        foreach ($subcategories as $subcategory) {
	        	$flat_subcategories[] = $subcategory->subcategory_id;
	        }
	        $munits = MeasuringUnit::where('company','=', $company->company_id)->get();
	        $flat_munits = [];
	        foreach ($munits as $munit) {
	        	$flat_munits[] = $munit->measuring_unit_id;
	        }
	        foreach ($periods as $period) {
	        	$users = User::where('company', $company->company_id)->get();
	        	foreach ($users as $user) {
	        		Objective::create([

						'objective_id' => $faker->uuid,
						'company' => $company->company_id,
						'department' => $user->department,
						'period' => $period->period_id,
						'name' => $faker->word,
						'subcategory' => $faker->randomElement($flat_subcategories),
						'description' => $faker->sentence($nbWords = 4),
						'measuring_unit' => $faker->randomElement($flat_munits),
						'user' => $user->user_id,
						'type' => $faker->randomElement(['PERSONAL','DEPARTAMENTO','EMPRESA']),
						'period_objective' => 9000,
						'period_green' => '7000',
						'period_yellow_ceil' => '6999.99',
						'period_yellow_floor' => '4000.01',
						'period_red' => '4000',
						'daily_objective' => 100,
						'daily_green' => '77',
						'daily_yellow_ceil' => '76.99',
						'daily_yellow_floor' => '45.01',
						'daily_red' => '45',
						'active' => $faker->boolean(70),

					]);

	        	}

	        }

        }


    }
}
