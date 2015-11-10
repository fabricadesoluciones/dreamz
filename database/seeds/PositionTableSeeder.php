<?php

use App\Position;
use App\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class PositionTableSeeder extends Seeder
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
        	Position::create([
				'position_id' => $faker->uuid,
				'company' => Company::find($faker->numberBetween($min = 1, $max = 4))->company_id,
				'name' => $faker->word,
				'area_id' => $faker->uuid,
				'active' => $faker->boolean(70),
        	]);
        }
    }
}
