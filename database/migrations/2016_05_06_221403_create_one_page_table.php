<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnePageTable extends Migration
{
    
}
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
    }
        
        Schema::create('one_page', function (Blueprint $table) {
            
            $table->string('one_page_id')->unique();
            $table->string('company');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_virtues', function (Blueprint $table) {
            
            $table->string('one_page_virtues_id')->unique();
            $table->string('company');
            $table->string('description');
            $table->boolean('active')->default(0);
            $table->date('target_date');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_general_info', function (Blueprint $table) {
            
            $table->string('one_page_general_info_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('purpose');
            $table->string('sandbox');
            $table->string('period');
            $table->string('date');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_actions', function (Blueprint $table) {
            
            $table->string('one_page_action_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_profit_x', function (Blueprint $table) {
            
            $table->string('one_page_profit_x_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_bhag', function (Blueprint $table) {
            
            $table->string('one_page_bhag_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_targets', function (Blueprint $table) {
            
            $table->string('one_page_target_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_key_thursts', function (Blueprint $table) {
            
            $table->string('one_page_key_thursts_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_bp_kpis', function (Blueprint $table) {
            
            $table->string('one_page_bp_kpis_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_goals', function (Blueprint $table) {
            
            $table->string('one_page_goals_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_key_initiatives', function (Blueprint $table) {
            
            $table->string('one_page_key_initiatives_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_critical_numbers', function (Blueprint $table) {
            
            $table->string('one_page_key_criticals_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->string('number_type');
            $table->string('critical_type');
            $table->string('period');
            $table->string('level');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_make_buy', function (Blueprint $table) {
            
            $table->string('one_page_make_buy_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_sell', function (Blueprint $table) {
            
            $table->string('one_page_sell_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_record_keeping', function (Blueprint $table) {
            
            $table->string('one_page_recrod_keeping_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_employees', function (Blueprint $table) {
            
            $table->string('one_page_employees_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_customers', function (Blueprint $table) {
            
            $table->string('one_page_customers_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_colaborators', function (Blueprint $table) {
            
            $table->string('one_page_colaborators_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_objectives', function (Blueprint $table) {
            
            $table->string('one_page_objectives_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->string('type');
            $table->string('user');
            $table->boolean('selected')->default(0);
            $table->boolean('active')->default(0);
            $table->date('target_date');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_theme', function (Blueprint $table) {
            
            $table->string('one_page_theme_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('period');
            $table->string('description');
            $table->string('dead_line');
            $table->string('critical_number');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_celebration', function (Blueprint $table) {
            
            $table->string('one_page_celebration_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('period');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_strengths', function (Blueprint $table) {
            
            $table->string('one_page_strengths_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('period');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_weaknesses', function (Blueprint $table) {
            
            $table->string('one_page_weaknesses_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('period');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_trends', function (Blueprint $table) {
            
            $table->string('one_page_trends_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('one_page_priorities', function (Blueprint $table) {
            
            $table->string('one_page_priorities_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('description');
            $table->string('type');
            $table->string('user');
            $table->boolean('selected')->default(0);
            $table->boolean('active')->default(0);
            $table->date('target_date');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('one_page_core_values', function (Blueprint $table) {
            
            $table->string('one_page_core_values_id')->unique();
            $table->string('one_page_id');
            $table->string('company');
            $table->string('one_page_virtues_id');
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
        
        Schema::drop('one_page');
        Schema::drop('one_page_virtues');
        Schema::drop('one_page_general_info');
        Schema::drop('one_page_actions');
        Schema::drop('one_page_profit_x');
        Schema::drop('one_page_bhag');
        Schema::drop('one_page_targets');
        Schema::drop('one_page_key_thursts');
        Schema::drop('one_page_bp_kpis');
        Schema::drop('one_page_goals');
        Schema::drop('one_page_key_initiatives');
        Schema::drop('one_page_critical_numbers');
        Schema::drop('one_page_make_buy');
        Schema::drop('one_page_sell');
        Schema::drop('one_page_record_keeping');
        Schema::drop('one_page_employees');
        Schema::drop('one_page_customers');
        Schema::drop('one_page_colaborators');
        Schema::drop('one_page_objectives');
        Schema::drop('one_page_priorities');
        Schema::drop('one_page_theme');
        Schema::drop('one_page_celebration');
        Schema::drop('one_page_strengths');
        Schema::drop('one_page_weaknesses');
        Schema::drop('one_page_trends');
        Schema::drop('one_page_core_values');

    }
}