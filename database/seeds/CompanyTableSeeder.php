<?php

use App\Company;
use App\Country;
use App\Industry;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 4) as $user) {
        	Company::create([
				'company_id' => $faker->uuid,
				'active' => $faker->boolean(70),
				'commercial_name' => $faker->company,
				'country' => Country::where('id','=', $faker->numberBetween($min = 1, $max = 249))->first()->country_id,
				'language' => $faker->locale,
				'logo' => "https://logo.clearbit.com/".$faker->freeEmailDomain,
				'slogan' => $faker->catchPhrase,
				'rfc' => $faker->swiftBicNumber,
                'industry' => Industry::all()->random(1)->industry_id,
        	]);
        }
    }
}