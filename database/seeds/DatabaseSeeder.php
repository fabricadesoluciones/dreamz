<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    public $tables = [
        'users',
        'positions',
        'education_levels'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $tables = DB::select('SHOW TABLES');
        foreach ($this->tables as $table) {
            if ($table !== 'migrations')
                DB::table($table)->truncate();
        }

        $this->call(UserTableSeeder::class);
        $this->call(PositionTableSeeder::class);
        $this->call(Education_levelsTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(IndustriesTableSeeder::class);

        Model::reguard();
    }
}
