<?php

use App\ObjectiveCategory;
use App\Period;
use App\Company;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class ObjectiveCategoriesTableSeeder extends Seeder
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

            foreach (range(1, 4) as $user) {
                ObjectiveCategory::create([
                    'category_id' => $faker->uuid,
                    'company' => $company->company_id,
                    'name' => $faker->word,
                    'parent' => 0,
                    'active' => $faker->boolean(70),
                ]);
            }
            foreach (range(1, 4) as $user) {
                
                ObjectiveCategory::create([
                    'category_id' => $faker->uuid,
                    'company' => $company->company_id,
                    'name' => $faker->word,
                    'parent' => DB::table('objective_categories')->skip(rand(0,4))->take(1)->get()[0]->category_id,
                    'active' => $faker->boolean(70),
                ]);
            }
        }

    }
}
