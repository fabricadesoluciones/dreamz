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
            
            $departments = Department::where('company','=', $company->company_id)->get();
            foreach ($departments as $department) {
                foreach (range(1, 5) as $user) {

                    Position::create([
                        'position_id' => $faker->uuid,
                        'company' => $company->company_id,
                        'department' => $department->department_id,
                        'name' => $faker->word,
                        'area_id' => $faker->uuid,
                        'active' => $faker->boolean(70),
                    ]);
            
                }
            }
        }

    }
}