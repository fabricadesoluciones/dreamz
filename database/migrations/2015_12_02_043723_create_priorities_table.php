<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrioritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('priorities', function (Blueprint $table) {

            $table->increments('id');
            $table->string('priority_id');
            $table->string('period');
            $table->string('name');
            $table->string('user');
            $table->string('company');
            $table->string('description');
            $table->string('status');
            $table->string('type');
            $table->tinyInteger('w1');
            $table->tinyInteger('w2');
            $table->tinyInteger('w3');
            $table->tinyInteger('w4');
            $table->tinyInteger('w5');
            $table->tinyInteger('w6');
            $table->tinyInteger('w7');
            $table->tinyInteger('w8');
            $table->tinyInteger('w9');
            $table->tinyInteger('w10');
            $table->tinyInteger('w11');
            $table->tinyInteger('w12');
            $table->tinyInteger('w13');

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
        Schema::drop('priorities');
    }
}
