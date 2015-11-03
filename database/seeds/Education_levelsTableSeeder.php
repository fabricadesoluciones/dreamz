<?php

use App\Education_level;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class Education_levelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 5) as $user) {
        	Education_level::create([
				'education_level_id' => $faker->uuid,
				'company' => $faker->uuid,
				'name' => $faker->word,
				'active' => $faker->boolean(70),
        	]);
        }
    }
}
