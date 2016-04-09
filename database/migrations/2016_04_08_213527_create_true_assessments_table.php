<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrueAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('true_assessments', function (Blueprint $table) {
            $table->string('true_assessment_id')->unique();
            $table->string('user')->unique();
            $table->integer('disc_d');
            $table->integer('disc_i');
            $table->integer('disc_s');
            $table->integer('disc_c');
            $table->integer('adapted_disc_d');
            $table->integer('adapted_disc_i');
            $table->integer('adapted_disc_s');
            $table->integer('adapted_disc_c');
            $table->string('welth_dynamics');
            $table->string('strengths_finder_1');
            $table->string('strengths_finder_2');
            $table->string('strengths_finder_3');
            $table->string('strengths_finder_4');
            $table->string('strengths_finder_5');
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
        Schema::drop('true_assessments');
    }
}
