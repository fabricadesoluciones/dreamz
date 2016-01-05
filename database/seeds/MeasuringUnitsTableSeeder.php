<?php

use App\Objective;
use App\ObjectiveCategory;
use App\Period;
use App\Company;
use App\MeasuringUnit;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;


class MeasuringUnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$units = ['PESOS', 'UPTIME', 'PIEZAS', ];
    	$faker = Faker::create();

        $companies = Company::all();
        $companies = Company::get();

        foreach ($companies as $company) {
        	foreach ($units as $unit) {
	        	MeasuringUnit:: create([

				'measuring_unit_id' => $faker->uuid,
				'company' => $company->company_id,
				'name' => $unit,
				'currency' => false,
				'active' => $faker->boolean(70),
	        	]);
        	}
        }
    }
}
