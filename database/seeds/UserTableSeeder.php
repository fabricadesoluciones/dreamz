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
        		'password' => Hash::make($faker->word)
        	]);
        }
    }
}
