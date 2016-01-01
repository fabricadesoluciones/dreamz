<?php

use App\ObjectiveCategory;
use App\Period;
use App\Company;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class ObjectiveCategoriesTableSeeder extends Seeder
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

        foreach (range(1, 4) as $user) {
	        foreach ($companies as $company) {
	    		ObjectiveCategory::create([
					'category_id' => $faker->uuid,
					'company' => $company->company_id,
					'name' => $faker->word,
					'parent' => $faker->uuid,
					'active' => $faker->boolean(70),
				]);

	        }
        }


    }
}
