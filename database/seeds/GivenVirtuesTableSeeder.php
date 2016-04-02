<?php

use App\Virtue;
use App\VirtueGiver;
use App\User;
use App\Period;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
class GivenVirtuesTableSeeder extends Seeder
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
        $virtues = Virtue::all();

        foreach ($users as $user) {
	        foreach ($virtues as $virtue) {
	        	$giver = User::orderByRaw("RAND()")->first();
	        	$periods = Period::where('company', $user->company)->get();
		        foreach ($periods as $period) {
		        	foreach (range(1, 4) as $x) {
		        		$is_value = $faker->boolean(70);
			        	VirtueGiver::create([
							'given_virtue_id' => $faker->uuid,
							'company' => $user->company,
							'department' => $user->department,
							'period' => $period->period_id,
							'virtue' => $virtue->virtue_id,
							'is_value' => $is_value,
							'approved' => true,
							'giver' => $giver->user_id,
							'receiver' => $user->user_id,
							'story' => $faker->realText($maxNbChars = 200, $indexSize = 2)
			        	]);
		        	}
		        }
	        }
	    }
    }
}
