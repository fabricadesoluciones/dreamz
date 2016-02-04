<?php

use App\Objective;
use App\ObjectiveCategory;
use App\ObjectiveProgress;
use App\Period;
use App\Company;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class ObjectivesProgressTableSeeder extends Seeder
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
        	$periods_array =[];
        	$periods = Period::where('company', $company->company_id)->get();
        	$objectives = Objective::where('company', $company->company_id)->get();
	        foreach ($periods as $period) {
	        	$periods_array[$period->period_id] = $period;
	        }

        	$current_period = Period::where('company', $company->company_id)->first();
			$dStart = new DateTime(date('Y-m-d',strtotime(date($current_period->start))));
			$dEnd  = new DateTime();
			$dDiff = $dStart->diff($dEnd);

	        foreach ($objectives as $objective) {

	        	for ($i=0; $i < $dDiff->days; $i++) {

	        		$this_date = date('Y-m-d', strtotime($periods_array[$objective->period]->start . ' +'.$i.' days'));
		    		ObjectiveProgress::create([
						'objectives_progress_id' => $faker->uuid,
						'progress_date' => $this_date,
						'objective' => $objective->objective_id,
						'value' => $faker->numberBetween(($objective->daily_yellow_ceil),$objective->daily_objective + 15),
						'company' => $company->company_id,
						'department' => $objective->department,
						
					]);
	        	}
		        	
	        }

        }

    }
}
