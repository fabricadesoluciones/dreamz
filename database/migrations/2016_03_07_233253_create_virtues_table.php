<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVirtuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtues', function (Blueprint $table) {
            $table->string('virtue_id')->unique();
            $table->string('company');
            $table->string('name');
            $table->text('description');
            $table->string('file');
            $table->float('weight',16,4);
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
        Schema::drop('virtues');
    }
}
