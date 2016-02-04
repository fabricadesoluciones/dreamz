<?php

use App\Emotion;
use App\DailyEmotion;
use App\User;
use App\Period;
use App\ActiveEmotion;
use App\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class DailyEmotionsTableSeeder extends Seeder
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
        	$users = User::where('company', $company->company_id)->get();
        	
        	$whereClause = ['active_emotions.active' => 1, 'active_emotions.company' => $company->company_id];

        	$emotions = DB::table('active_emotions')
            ->join('emotions', 'active_emotions.emotion', '=', 'emotions.emotion_id')
            ->select('active_emotions.*', 'emotions.name AS emotion_name')
            ->where($whereClause)
            ->get();


            $current_period = Period::where('company', $company->company_id)->first();
            $dStart = new DateTime(date('Y-m-d',strtotime(date($current_period->start))));
            $dEnd  = new DateTime();
            $dDiff = $dStart->diff($dEnd);
	        foreach ($periods as $period) {
	        	for ($i=0; $i < $dDiff->days; $i++) {
	        		$this_date = date('Y-m-d', strtotime($period->start . ' +'.$i.' days'));
			        foreach ($users as $user) {
		        		$emotion = $faker->randomElement($emotions);

		        		DailyEmotion::create([
		        			'daily_emotion_id' => $faker->uuid,
		        			'company' => $company->company_id,
		        			'period' => $period->period_id,
		        			'department' => $user->department,
		        			'user' => $user->user_id,
		        			'emotion' => $emotion->active_emotion_id,
		        			'emotion_date' => $this_date,


		        		]);
			        	
			        }
	        	}
	        }

        }

    }
}
