<?php

use App\Industry;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class IndustriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 30) as $user) {
        	Industry::create([
				'industry_id' => $faker->uuid,
				'company_id' => $faker->uuid,
				'name' => $faker->word,
				'active' => $faker->boolean(70),
        	]);
        }
    }
}
