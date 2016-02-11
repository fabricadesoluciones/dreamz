<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDreamsCategoriesSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dreams_categories', function (Blueprint $table) {
            $table->string('category_id')->unique();
            $table->string('company');
            $table->string('name');
            $table->string('parent');
            $table->boolean('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('dreams_subcategories', function (Blueprint $table) {
            $table->string('subcategory_id')->unique();
            $table->string('company');
            $table->string('name');
            $table->string('parent');
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
        Schema::drop('dreams_categories');
        Schema::drop('dreams_subcategories');
    }
}