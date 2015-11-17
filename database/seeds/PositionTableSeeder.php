<?php

use App\Position;
use App\Company;
use App\Department;
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

        $companies = Company::all();

        foreach ($companies as $company) {
            
            Position::create([
                'position_id' => $faker->uuid,
                'company' => $company->company_id,
                'name' => 'boss',
                'boss' => 1,
                'active' => $faker->boolean(70),
            ]);
            Position::create([
                'position_id' => $faker->uuid,
                'company' => $company->company_id,
                'name' => 'employee',
                'boss' => 0,
                'active' => $faker->boolean(70),
            ]);
        
        }

    }
}