<?php

use App\Company;
use App\Industry;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class IndustriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $industries = ['Agricultura', 'Alimentación', 'Comercio ', 'Construcción ', 'Educación ', 'Fabricación de material de transporte ', 'Función pública ', 'Hotelería', 'Industrias químicas ', 'Ingenieria mecánicay eléctria ', 'Medios de comunicación', 'Minería', 'Petroleo y producción de gas', 'Producción de metales básicos ', 'Servicios de correos y de telecomunicaciones ', 'Servicios de salud ', 'Servicios financieros', 'Servicios públicos', 'Silvicultura', 'Tecnologías de la Información', 'Textiles', 'Transporte ', 'Transporte marítimo'];
        foreach ($industries as $industry) {
        	Industry::create([
				'industry_id' => $faker->uuid,
				'name' => $industry,
        	]);
        }
    }
}
