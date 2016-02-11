<?php

use App\DreamCategory;
use App\DreamSubcategory;
use App\Period;
use App\Company;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class DreamSubcategoriesTableSeeder extends Seeder
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
                DreamSubcategory::create([
                    'subcategory_id' => $faker->uuid,
                    'company' => $company->company_id,
                    'name' => $faker->word,
                    'parent' => DreamCategory::where('company','=',$company->company_id)->get()->random(1)->category_id,
                    'active' => $faker->boolean(70),
                ]);
            }
            
        }

    }
}
