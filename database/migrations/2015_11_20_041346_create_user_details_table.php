<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {

            $table->increments('id');
            $table->string('user_details_id');
            $table->string('user');
            $table->string('mobile');
            $table->string('phone', 45);
            $table->date('birth_date');
            $table->string('education');
            $table->string('blood_type');
            $table->text('alergies');
            $table->text('emergency_contact');
            $table->date('admission_date');
            $table->string('facebook');
            $table->string('twitter');
            $table->string('instagram');
            $table->string('linkedin');
            $table->string('googlep');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_details');
    }
}
