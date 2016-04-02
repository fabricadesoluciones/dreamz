<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGivenVirtuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('given_virtues', function (Blueprint $table) {
            $table->string('given_virtue_id')->unique();
            $table->string('company');
            $table->string('department');
            $table->string('period');
            $table->string('virtue');
            $table->boolean('is_value');
            $table->boolean('approved');
            $table->string('giver');
            $table->string('receiver');
            $table->text('story');
            $table->text('coach_comments');
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
        Schema::drop('given_virtues');
    }
}
