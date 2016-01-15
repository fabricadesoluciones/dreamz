<?php

use App\Company;
use App\EducationLevel;
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
        $companies = Company::all();

        foreach ($companies as $company) {
            foreach (range(1, 5) as $user) {
                EducationLevel::create([
                    'education_level_id' => $faker->uuid,
                    'company' => $company->company_id,
                    'name' => $faker->word,
                    'active' => $faker->boolean(70),
                ]);
            }
        }
    }
}
