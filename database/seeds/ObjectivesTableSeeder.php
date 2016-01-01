<?php

use App\Objective;
use App\ObjectiveCategory;
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
	        $categories = ObjectiveCategory::where('company','=', $company->company_id)->get();
	        $flat_categories = [];
	        foreach ($categories as $category) {
	        	$flat_categories[] = $category->category_id;
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
						'category' => $faker->randomElement($flat_categories),
						'description' => $faker->sentence($nbWords = 4),
						'measuring_unit' => $faker->uuid,
						'user' => $user->user_id,
						'type' => $faker->randomElement(['PERSONAL','DEPARTAMENTO','EMPRESA']),
						'period_objective' => 9000,
						'period_green' => 'x > 7000',
						'period_yellow' => '7000 > x > 4000',
						'period_red' => 'x < 4000',
						'daily_objective' => 100,
						'daily_green' => 'x > 77',
						'daily_yellow' => '77 > x > 45',
						'daily_red' => 'x < 45',
						'active' => $faker->boolean(70),

					]);

	        	}

	        }

        }


    }
}
