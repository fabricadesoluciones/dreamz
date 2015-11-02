<?php

use App\Position;
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

        foreach (range(1, 30) as $user) {
        	Position::create([
				'position_id' => $faker->uuid,
				'company_id' => $faker->uuid,
				'name' => $faker->word,
				'area_id' => $faker->uuid,
				'active' => $faker->boolean(70),
        	]);
        }
    }
}
