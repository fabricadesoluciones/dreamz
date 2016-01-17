<?php

use App\Priority;
use App\Period;
use App\Company;
use App\User;
use App\Task;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class TasksTableSeeder extends Seeder
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
        	$periods = Period::where('company', $company->company_id)->get();
	        foreach ($periods as $period) {
	        	$users = User::where('company', $company->company_id)->get();
	        	foreach ($users as $user) {
	        		Task::create([
						'task_id' => $faker->uuid,
						'company' => $company->company_id,
						'department' => $user->department,
						'name' => $faker->word,
						'description' => $faker->sentence($nbWords = 4),
						'owner' => $user->user_id,
						'status' => $faker->randomElement(['ASIGNADO','CANCELADO', 'COMENZANDO', 'EN PROCESO', 'TERMINADO']),
						'priority' => $faker->randomElement(['ALTA','MEDIA','BAJA']),
						'due_date' => $faker->dateTimeBetween($startDate = '-5 days', $endDate = '+5 days') 

					]);

	        	}

	        }

        }


    }
}