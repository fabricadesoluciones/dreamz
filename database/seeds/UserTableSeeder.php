<?php

use App\User;
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

        foreach (range(1, 50) as $user) {
        	User::create([
        		'name' => $faker->name,
        		'email' => $faker->freeEmail,
        		'password' => Hash::make($faker->word),
				'lastname' => $faker->lastName,
				'active' => $faker->boolean(70),
				'user_id' => $faker->md5,
				'birth_date' => $faker->dateTime($max = 'now'),
				'education' => $faker->numberBetween($min = 0, $max = 20),
				'mobile' => $faker->phoneNumber,
				'blood_type' => $faker->name,
				'alergies' => $faker->randomElement($array = array ('A-', 'A+', 'B-', 'B+', 'AB-', 'A+B', 'O-', 'O+')),
				'emergency_contact' => $faker->name." ".$faker->phoneNumber,
				'phone' => $faker->phoneNumber,
				'position' => $faker->word,
				'boss' => $faker->md5,
				'admission_date' => $faker->dateTime($max = 'now'),
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


