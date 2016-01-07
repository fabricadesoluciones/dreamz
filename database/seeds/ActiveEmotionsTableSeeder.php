<?php

use App\Emotion;
use App\ActiveEmotion;
use App\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class ActiveEmotionsTableSeeder extends Seeder
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
        $emotions = Emotion::all();

        foreach ($companies as $company) {

        	foreach ($emotions as $emotion) {
	        	ActiveEmotion::create([
					'active_emotion_id' => $faker->uuid,
					'company' => $company->company_id,
					'emotion' => $emotion->emotion_id,
					'active' => $faker->boolean(70),
	        	]);
        	}
        }
    }
}
