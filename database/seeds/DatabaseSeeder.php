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
        'companies'
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
        $this->call(CompanyTableSeeder::class);
        $this->call(PositionTableSeeder::class);
        $this->call(Education_levelsTableSeeder::class);
        $this->call(IndustriesTableSeeder::class);
        $this->call(UserTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();
    }
}
