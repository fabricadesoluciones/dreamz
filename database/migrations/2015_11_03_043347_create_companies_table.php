<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_id')->unique();
            $table->boolean('active');
            $table->string('country');
            $table->string('language');
            $table->string('commercial_name');
            $table->string('logo');
            $table->string('slogan');
            $table->string('rfc');
            
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
        Schema::drop('companies');
    }
}
