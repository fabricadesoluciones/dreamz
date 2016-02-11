<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    public $tables = [
        'users',
        'positions',
        'education_levels',
        'industries',
        'countries',
        'companies',
        'departments',
        'periods',
        'priorities',
        'tasks',
        'task_participants',
        'dreams',
        'roles',
        'role_user',
        'permissions',
        'permission_role',
        'tasks',
        'user_details',
        'measuring_units',
        'objective_categories',
        'objective_subcategories',
        'dreams_categories',
        'dreams_subcategories',
        'objectives',
        'objectives_progress',
        'emotions',
        'active_emotions',
        'daily_emotions'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($this->tables as $table) {
            if ($table !== 'migrations')
                DB::table($table)->truncate();
        }

        $this->call(CountriesTableSeeder::class);
        $this->call(IndustriesTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(EmotionsTableSeeder::class);
        $this->call(ActiveEmotionsTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(PeriodsTableSeeder::class);
        $this->call(PositionTableSeeder::class);
        $this->call(Education_levelsTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(UserDetailsTableSeeder::class);
        $this->call(PrioritiesTableSeeder::class);
        $this->call(TasksTableSeeder::class);
        $this->call(EntrustTablesSeeder::class);
        $this->call(MeasuringUnitsTableSeeder::class);
        $this->call(DailyEmotionsTableSeeder::class);
        $this->call(ObjectiveCategoriesTableSeeder::class);
        $this->call(ObjectiveSubcategoriesTableSeeder::class);
        $this->call(DreamCategoriesTableSeeder::class);
        $this->call(DreamSubcategoriesTableSeeder::class);
        $this->call(DreamsTableSeeder::class);
        $this->call(ObjectivesTableSeeder::class);
        $this->call(ObjectivesProgressTableSeeder::class);
        
        

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();
    }
}
