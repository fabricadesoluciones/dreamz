<?php

use App\Period;
use App\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class PeriodsTableSeeder extends Seeder
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
		$quarters = ['0','01','04','07','10'];

        foreach ($companies as $company) {
        	$i= 0;
	        foreach (range(1, 4) as $period) {
	        	$i++;
				
				$curMonth = $i*3;
				$curQuarter = ceil($curMonth/3) ;
				$month = $quarters[$curQuarter];
				$date = "2015-$month-01";
				$next = date('Y-m-d', strtotime("+3 months", strtotime($date)));
				$ends = date('Y-m-d', strtotime("-1 day", strtotime($next)));

	        	Period::create([
						'period_id' => $faker->uuid,
		        		'name' => '2015 Q'.$i,
						'company' => $company->company_id,
						'active' => $faker->boolean(100),
						'start' =>   $date,
						'end' =>   $ends,

					]);
	        }

        	$i= 0;
	        foreach (range(1, 4) as $period) {
	        	$i++;
				$curMonth = $i*3;
				$curQuarter = ceil($curMonth/3) ;
				$month = $quarters[$curQuarter];
				$date = "2016-$month-01";
				$next = date('Y-m-d', strtotime("+3 months", strtotime($date)));
				$ends = date('Y-m-d', strtotime("-1 day", strtotime($next)));

	        	Period::create([
						'period_id' => $faker->uuid,
		        		'name' => '2016 Q'.$i,
						'company' => $company->company_id,
						'active' => $faker->boolean(100),
						'start' =>   $date,
						'end' =>   $ends,

					]);
	        }

        }


    }
}