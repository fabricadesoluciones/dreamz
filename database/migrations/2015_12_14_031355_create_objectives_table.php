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
            $table->string('period');
            $table->string('name');
            $table->string('subcategory');
            $table->string('description');
            $table->string('measuring_unit');
            $table->string('user');
            $table->string('type');
            $table->float('period_objective',16,2);
            $table->float('period_green',16,2);
            $table->float('period_yellow_ceil',16,2);
            $table->float('period_yellow_floor',16,2);
            $table->float('period_red',16,2);
            $table->float('daily_objective',16,2);
            $table->float('daily_green',16,2);
            $table->float('daily_yellow_ceil',16,2);
            $table->float('daily_yellow_floor',16,2);
            $table->float('daily_red',16,2);
            $table->boolean('active');
            $table->timestamps();
            $table->softDeletes();
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
