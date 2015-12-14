<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objectives', function (Blueprint $table) {
            $table->string('objective_id');
            $table->string('company');
            $table->string('department');
            $table->string('name');
            $table->string('category');
            $table->string('description');
            $table->string('measuring_unit');
            $table->string('user');
            $table->string('type');
            $table->float('period_objective');
            $table->float('period_green');
            $table->float('period_yellow');
            $table->float('period_red');
            $table->float('daily_objective');
            $table->float('daily_green');
            $table->float('daily_yellow');
            $table->float('daily_red');
            $table->boolean('active');
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
        Schema::drop('objectives');
    }
}
