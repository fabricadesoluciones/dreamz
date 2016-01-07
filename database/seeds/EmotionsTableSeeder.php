<?php

use App\Emotion;
use App\ActiveEmotion;
use App\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class EmotionsTableSeeder extends Seeder
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

		$emotions = ['agradecido', 'alegre', 'ansioso', 'apasionado', 'emocionado', 'enojado', 'esperanzado', 'estresado', 'frustracion', 'inspirado'];
        	
	        foreach ($emotions as $emotion) {
	        	Emotion::create([
					'name' => $emotion,
	        	]);
	        }

	}
}
