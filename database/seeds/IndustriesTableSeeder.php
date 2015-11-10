<?php

use App\Company;
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
				'company' => Company::find($faker->numberBetween($min = 1, $max = 4))->company_id,
				'name' => $faker->word,
				'active' => $faker->boolean(70),
        	]);
        }
    }
}
