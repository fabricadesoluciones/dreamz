<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyEmotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_emotions', function (Blueprint $table) {
            $table->string('daily_emotion_id')->unique();
            $table->string('company');
            $table->string('department');
            $table->string('period');
            $table->string('user');
            $table->string('emotion');
            $table->date('emotion_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('daily_emotions');
    }
}
