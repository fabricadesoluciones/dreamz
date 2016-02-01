<?php

use App\ObjectiveCategory;
use App\ObjectiveSubcategory;
use App\Period;
use App\Company;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class ObjectiveSubcategoriesTableSeeder extends Seeder
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
                ObjectiveSubcategory::create([
                    'subcategory_id' => $faker->uuid,
                    'company' => $company->company_id,
                    'name' => $faker->word,
                    'parent' => ObjectiveCategory::where('company','=',$company->company_id)->get()->random(1)->category_id,
                    'active' => $faker->boolean(70),
                ]);
            }
            
        }

    }
}
