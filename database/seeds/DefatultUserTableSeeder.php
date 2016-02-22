<?php

use App\User;
use App\EducationLevel;
use App\Position;
use App\Department;
use App\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;


class DefatultUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        $alex = User::create(['name' => 'Alejandro', 'lastname' => 'Tapia', 'email' => 'ageofzetta@gmail.com', 'password' => Hash::make('admin'), 'active' => 1, 'user_id' => $faker->uuid, 'thumbnail' => 'https://randomuser.me/api/portraits/thumb/men/96.jpg']);
    	$rony = User::create(['name' => 'Rony', 'lastname' => 'Zagursky', 'email' => 'rony@adaptable.com.mx', 'password' => Hash::make('admin'), 'active' => 1, 'user_id' => $faker->uuid, 'thumbnail' => 'https://randomuser.me/api/portraits/thumb/men/96.jpg']);
    	 

        
    }
}


