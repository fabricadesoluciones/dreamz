<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->string('task_id');
            $table->string('company');
            $table->string('department');
            $table->string('name');
            $table->text('description');
            $table->string('owner');
            $table->string('status');
            $table->string('priority');
            $table->date('due_date');
            $table->timestamps();
        });

        Schema::create('task_participants', function (Blueprint $table) {
            $table->string('task_participants_id');
            $table->string('task_id');
            $table->string('user');
            $table->string('company');
            $table->string('deparment');
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
        Schema::drop('tasks');
        Schema::drop('task_participants');
    }
}
