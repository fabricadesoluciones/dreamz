<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastnameToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('lastname');
            $table->boolean('active');
            $table->string('user_id');
            $table->date('birth_date');
            $table->string('education',4);
            $table->string('mobile');
            $table->string('blood_type');
            $table->text('alergies');
            $table->text('emergency_contact');
            $table->string('phone', 45);
            $table->string('position');
            $table->string('boss');
            $table->date('admission_date');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('instagram');
            $table->string('linkedin');
            $table->string('googlep');
            $table->integer('d_s');
            $table->integer('i_s');
            $table->integer('s_s');
            $table->integer('c_s');
            $table->integer('d_a');
            $table->integer('i_a');
            $table->integer('s_a');
            $table->integer('c_a');
            $table->string('welth_dynamics', 150);
            $table->string('stengths_finder_1', 150);
            $table->string('stengths_finder_2', 150);
            $table->string('stengths_finder_3', 150);
            $table->string('stengths_finder_4', 150);
            $table->string('stengths_finder_5', 150);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn(['lastname', 'active', 'user_id','birth_date', 'education', 'mobile', 'blood_type', 'alergies', 'emergency_contact','phone', 'position', 'boss', 'admission_date', 'facebook', 'twitter', 'instagram', 'linkedin', 'googlep', 'd_s', 'i_s', 's_s', 'c_s', 'd_a', 'i_a', 's_a', 'c_a', 'welth_dynamics', 'stengths_finder_1', 'stengths_finder_2', 'stengths_finder_3', 'stengths_finder_4', 'stengths_finder_5']);

        });
    }
}

 

/*


*/