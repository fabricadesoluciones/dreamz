<?php

use App\Assessment;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class AssessmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $users = User::all();


		$assessments = ['DISC', 'Welth Dynamics', 'Strengthfinder'];

        foreach ($users as $user) {
        	foreach (range(1, 3) as $i) {
	        	Assessment::create([

					'assessment_id' => $faker->uuid,
					'company' => $user->company,
					'department' => $user->department,
					'user' => $user->user_id,
					'name' => $assessments[$i-1],
					'submit_date' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = '+1 years'), 
					'file' => 'abcd'

	        	]);
	        }
        }
    }
}
