<?php

use App\Department;
use App\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class DepartmentsTableSeeder extends Seeder
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

	        foreach (range(1, 2) as $user) {
	        	Department::create([
					'area_id' => $faker->uuid,
					'company' => $company->company_id,
					'parent' => 0,
					'name' => $faker->word,
					'active' => $faker->boolean(70),
	        	]);
	        }
	        foreach (range(1, 4) as $user) {
	        	Department::create([
					'area_id' => $faker->uuid,
					'company' => $company->company_id,
					'parent' => Department::find($faker->numberBetween($min = 1, $max = 2))->area_id,
					'name' => $faker->word,
					'active' => $faker->boolean(70),
	        	]);
	        }
        }
    }
}