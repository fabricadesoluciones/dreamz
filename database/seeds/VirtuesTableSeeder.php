<?php

use App\Virtue;
use App\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
class VirtuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $companies = Company::all();


		$assessments = ['DISC', 'Welth Dynamics', 'Strengthfinder'];

        foreach ($companies as $company) {
        	foreach (range(1, 4) as $i) {
	        	Virtue::create([

					'virtue_id' => $faker->uuid,
					'company' => $company->company_id,
					'name' => $faker->word,
					'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
					'type' => $faker->randomElement(['valor','antivalor']),
					'file' => 'abcde',
					'weight' =>  $faker->randomFloat(2,0,10),
					'active' => $faker->boolean(70),

	        	]);
	        }
        }
    }
}
