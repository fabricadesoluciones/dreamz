<?php

use App\User;
use App\EducationLevel;
use App\Position;
use App\Department;
use App\Company;
use App\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class UserDetailsTableSeeder extends Seeder
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

        foreach ($users as $user) {
            UserDetail::create([
				'user_details_id' => $faker->uuid,
            	'user' => $user->user_id,
            	'birth_date' => $faker->dateTimeBetween($startDate = '-60 years', $startDate = '-20 years'), 
				'education' => EducationLevel::where('id','=', $faker->numberBetween($min = 1, $max = 20))->first()->education_level_id,
				'mobile' => $faker->phoneNumber,
				'alergies' => $faker->realText($maxNbChars = 200, $indexSize = 2),
				'blood_type' => $faker->randomElement($array = array ('A-', 'A+', 'B-', 'B+', 'AB-', 'A+B', 'O-', 'O+')),
				'emergency_contact' => $faker->name." ".$faker->phoneNumber,
				'phone' => $faker->phoneNumber,
				'admission_date' => $faker->dateTimeBetween($startDate = '-15 years', $startDate = '-1 years'), 
				'facebook' => "facebook.com/".$faker->userName,
				'twitter' => "twitter.com/@".$faker->userName,
				'instagram' => "instagram.com/".$faker->userName,
				'linkedin' => "linkedin.com/".$faker->userName,
				'googlep' => "googlep.com/".$faker->userName

            ]);
            
        }

        
    }
}


