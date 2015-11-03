<?php

use App\User;
use App\Education_level;
use App\Position;
use App\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

    	User::create([
    		'name' => 'Alejandro Tapia',
    		'email' => 'ageofzetta@gmail.com',
    		'password' => Hash::make('admin'),
			'active' => 1,

    	]);

        $i = 0;


        foreach (range(1, 30) as $user) {
    		$i++;
        	User::create([
        		'name' => $faker->firstName($gender = null|'male'|'female'),
        		'email' => $faker->freeEmail,
        		'password' => Hash::make($faker->word),
				'lastname' => $faker->lastName,
				'active' => $faker->boolean(70),
				'company' => Company::find($faker->numberBetween($min = 1, $max = 10))->company_id,
				'user_id' => $faker->uuid,
				'birth_date' => $faker->dateTimeBetween($startDate = '-60 years', $startDate = '-20 years'), 
				'education' => Education_level::find($faker->randomElement([1,2,3,4,5]))->education_level_id,
				'mobile' => $faker->phoneNumber,
				'alergies' => $faker->realText($maxNbChars = 200, $indexSize = 2),
				'blood_type' => $faker->randomElement($array = array ('A-', 'A+', 'B-', 'B+', 'AB-', 'A+B', 'O-', 'O+')),
				'emergency_contact' => $faker->name." ".$faker->phoneNumber,
				'phone' => $faker->phoneNumber,
				'position' => Position::find($faker->randomElement([1,2,3,4,5]))->position_id,
				'boss' => $faker->uuid,
				'admission_date' => $faker->dateTimeBetween($startDate = '-15 years', $startDate = '-1 years'), 
				'facebook' => "facebook.com/".$faker->userName,
				'twitter' => "twitter.com/@".$faker->userName,
				'instagram' => "instagram.com/".$faker->userName,
				'linkedin' => "linkedin.com/".$faker->userName,
				'googlep' => "googlep.com/".$faker->userName,
				'd_s' => $faker->randomDigitNotNull,
				'i_s' => $faker->randomDigitNotNull,
				's_s' => $faker->randomDigitNotNull,
				'c_s' => $faker->randomDigitNotNull,
				'd_a' => $faker->randomDigitNotNull,
				'i_a' => $faker->randomDigitNotNull,
				's_a' => $faker->randomDigitNotNull,
				'c_a' => $faker->randomDigitNotNull,
				'welth_dynamics' => $faker->word,
				'stengths_finder_1' => $faker->word,
				'stengths_finder_2' => $faker->word,
				'stengths_finder_3' => $faker->word,
				'stengths_finder_4' => $faker->word,
				'stengths_finder_5' => $faker->word
        	]);
        }
    }
}


