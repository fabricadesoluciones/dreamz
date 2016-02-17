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

	        		foreach (range(1, 4) as $x) {

		        		$target = (int) $faker->numberBetween($min = 1000, $max = 100000);
		        		$green_percentage = (int) $faker->numberBetween($min = 70, $max = 95);
		        		$red_percentage = (int) $faker->numberBetween($min = 20, $max = 60);
		        		$green_value = $target * ( $green_percentage / 100 );
		        		$red_value = $target * ( $red_percentage / 100 );
		        		$yellow_ceil = $green_value - 0.01;
		        		$yellow_floor = $red_value + 0.01;

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
							'period_objective' => $target,
							'period_green' => $green_value,
							'period_yellow_ceil' => $yellow_ceil,
							'period_yellow_floor' => $yellow_floor,
							'period_red' => $red_value,
							'daily_objective' => $target / 90,
							'daily_green' => $green_value / 90,
							'daily_yellow_ceil' => $yellow_ceil / 90,
							'daily_yellow_floor' => $yellow_floor / 90,
							'daily_red' => $red_value / 90,
							'active' => $faker->boolean(70),
						]);
	        		}

	        	}

	        }

        }


    }
}
