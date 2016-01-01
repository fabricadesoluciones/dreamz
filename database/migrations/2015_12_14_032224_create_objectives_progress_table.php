<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectivesProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objectives_progress', function (Blueprint $table) {
            $table->string('objectives_progress_id');
            $table->dateTime('progress_date');
            $table->string('objective');
            $table->string('company');
            $table->string('department');
            $table->float('value');
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
        Schema::drop('objectives_progress');
    }
}
