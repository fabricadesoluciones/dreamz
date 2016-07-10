@extends('layouts.master')

@section('title', trans('general.edit').' '.' One Page')

@section('content')
<style>
    hr{
        height: 3px;
    }
    .one_page_target > div{
        display: block;
        float: left;
        width: 45%;
        margin:0 2.5% 0 0 ;
    }
    .one_page_critical .color {
        width: 2.1em;
        height: 2.1em;
        float: left;
    }
    .one_page_critical .full-size input{
        width: calc(100% - 3em);
        margin-left: 1ex;
    }
</style>
<h2>{{ trans('general.edit')}}  One Page</h2>
<hr>
<div>

    <?php
    $params = array(
            'id' => $id,
            'periods' => $periods,
            'virtues' => $virtues,
            'onepagetargets' => $onepagetargets,
            'onecritical_people_company_numbers' => $onecritical_people_company_numbers,
            'onecritical_process_company_numbers' => $onecritical_process_company_numbers,
            'onepageinfo' => $onepageinfo,
            'onepageactions' => $onepageactions,
            'oneprofitxs' => $oneprofitxs,
            'onebhags' => $onebhags,
            'onepagekeythrusts' => $onepagekeythrusts,
            'onepagebrandpromisekpis' => $onepagebrandpromisekpis,
            'onepagegoals' => $onepagegoals,
            'onepagekeyinitiatives' => $onepagekeyinitiatives,
            'onepagemakebuys' => $onepagemakebuys,
            'onepagesells' => $onepagesells,
            'onepagerecordkeepings' => $onepagerecordkeepings,
            'onepageemployees' => $onepageemployees,
            'onepageclients' => $onepageclients,
            'onepagecolaborators' => $onepagecolaborators,
            'onepagevirtues' => $onepagevirtues,
            'onepagestrengths' => $onepagestrengths,
            'onepageweaknesses' => $onepageweaknesses,
            'onepagetrends' => $onepagetrends
        );
     ?>

    <div class="grid">


        {{-- ONE PAGE COMPANY PERIOD --}}
        {!! Form::model(null, array('route' => array('onepages.update', $id), 'method' => 'PUT')) !!}
        <h3><a href="#" rel="collapse" > Summary </a></h3>
        <br>
        <div class="collapsable">
            @include('onepage.one_page_company', $params) 
            <hr>
            <div class="bg-grayLighter padding10">        
                @if ( Auth::user()->can('edit-one_page') )
                    <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
                @endif
                <a href="#" rel="collapse" class="button primary">  Collapse </a>
            </div>
        </div>
        <hr>
        {!! Form::close() !!}
        <br>

        {{-- ONE PAGE COMPANY PERIOD --}}
        {!! Form::model(null, array('route' => array('onepages.update', $id), 'method' => 'PUT')) !!}
        <h3><a href="#" rel="collapse" > {{trans_choice('general.menu.companies',1)}} </a></h3>
        <br>
        <div class="collapsable">
            @include('onepage.one_page_company_period', $params)
            <hr>
            <div class="bg-grayLighter padding10">        
                @if ( Auth::user()->can('edit-one_page') )
                    <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
                @endif
                <a href="#" rel="collapse" class="button primary">  Collapse </a>
            </div>
        </div>
        <hr>
        {!! Form::close() !!}
        <br>

        {{-- MY ONE PAGE --}}
        {!! Form::model(null, array('route' => array('onepages.update', $id), 'method' => 'PUT')) !!}
        <h3><a href="#" rel="collapse" > {{trans_choice('general.mine',1)}} One Page </a></h3>
        <br>
        <div class="collapsable">
            @include('onepage.my_one_page_personal_period', $params)
            <hr>
            <div class="bg-grayLighter padding10">        
                <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
                <a href="#" rel="collapse" class="button primary">  Collapse </a>
            </div>
        </div>
        <hr>
        {!! Form::close() !!}
        <br>

    </div>
</div>


<script>
    
    $('[rel="in_period"]').html('{{$periods[0]->name}}');
    $(document).on('change','select#period', function (event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        $('[rel="in_period"]').html( this.selectedOptions[0].text )        
    });
      

function demo(){

    $( '[rel="one_page_add_actions"]' ).trigger( "click" );

    $('[name="one_page_critical_people_ggren"]').val('one_page_critical_people_ggren yey!');
    $('[name="one_page_critical_people_lgreen"]').val('one_page_critical_people_lgreen yey!');
    $('[name="one_page_critical_people_yellow"]').val('one_page_critical_people_yellow yey!');
    $('[name="one_page_critical_people_red"]').val('one_page_critical_people_red yey!');
    $('[name="one_page_critical_process_ggren"]').val('one_page_critical_process_ggren yey!');
    $('[name="one_page_critical_process_lgreen"]').val('one_page_critical_process_lgreen yey!');
    $('[name="one_page_critical_process_yellow"]').val('one_page_critical_process_yellow yey!');
    $('[name="one_page_critical_process_red"]').val('one_page_critical_process_red yey!');

    $('[name="purpose"]').val('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum quaerat, aliquam. Maiores dicta ratione quibusdam, recusandae eligendi optio odio illum voluptates, vitae tempore a sed dolorem explicabo odit, magni pariatur.')
    $('[name="one_page_actions[]"]:first').val('Actions yey!')
    $('[name="one_page_actions[]"]:eq(1)').val('Actions 2 yey!')
    $('[name="one_page_profit_x[]"]:first').val('Profit X yey!')
    $('[name="one_page_profit_x[]"]:eq(1)').val('Profit X 2 yey!')
    $('[name="one_page_bhag[]"]:first').val('BHAG yey!')
    $('[name="one_page_bhag[]"]:eq(1)').val('BHAG 2 yey!')
    $('[name="one_page_targets_name[]"]:first').val('Targets name yey!')
    $('[name="one_page_targets_description[]"]:first').val('Targets desc yey!')
    $('[name="one_page_targets_name[]"]:eq(1)').val('Targets 2 name yey!')
    $('[name="one_page_targets_description[]"]:eq(1)').val('Targets 2 desc yey!')
    $('[name="one_page_sandbox[]"]:first').val('sandbox yey!')
    $('[name="one_page_sandbox[]"]:eq(1)').val('sandbox 2 yey!')
    $('[name="one_page_key_thrusts[]"]:first').val('Thrusts yey!')
    $('[name="one_page_key_thrusts[]"]:eq(1)').val('Thrusts 2 yey!')
    $('[name="one_page_brand_promise_kpis[]"]:first').val('Brand Promise yey!')
    $('[name="one_page_brand_promise_kpis[]"]:eq(1)').val('Brand Promise 2 yey!')
    $('[name="one_page_goals_1_yr[]"]:first').val('Goals 1yr yey!')
    $('[name="one_page_goals_1_yr[]"]:eq(1)').val('Goals 1yr 2 yey!')
    $('[name="one_page_key_initiatives[]"]:first').val('KEY Initiatives yey!')
    $('[name="one_page_key_initiatives[]"]:eq(1)').val('KEY Initiatives 2 yey!')

    $('[name="one_page_make_buy[]"]:first').val('one_page_make_buy yey!');
    $('[name="one_page_make_buy[]"]:eq(1)').val('one_page_make_buy 2 yey!');
    $('[name="one_page_sell[]"]:first').val('one_page_sell yey!');
    $('[name="one_page_sell[]"]:eq(1)').val('one_page_sell 2 yey!');
    $('[name="one_page_record_keeping[]"]:first').val('one_page_record_keeping yey!');
    $('[name="one_page_record_keeping[]"]:eq(1)').val('one_page_record_keeping 2 yey!');
    $('[name="one_page_employees[]"]:first').val('one_page_employees yey!');
    $('[name="one_page_employees[]"]:eq(1)').val('one_page_employees 2 yey!');
    $('[name="one_page_clients[]"]:first').val('one_page_clients yey!');
    $('[name="one_page_clients[]"]:eq(1)').val('one_page_clients 2 yey!');
    $('[name="one_page_colaborators[]"]:first').val('one_page_colaborators yey!');
    $('[name="one_page_colaborators[]"]:eq(1)').val('one_page_colaborators 2 yey!');


}

    $(document).on('click','*[rel*="one_page_add_actions"]', function (event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        var this_parent = $(this).parent();
        var new_input = this_parent.find('.dup:first').clone()
        new_input.find('input').val('');
        new_input.insertBefore(this);
        this_parent.find('.danger.hide').removeClass('hide');
    });

    $(document).on('click','*[rel*="one_page_remove_actions"]', function (event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        var this_parent = $(this).parent();
        if (this_parent.find('.dup').length > 1) this_parent.find('.dup:last').detach();
        if (this_parent.find('.dup').length == 1) $(this).addClass('hide')
    });

    $.getJSON( "/companies/{{ session('company') }}/departments", function( response ) {
        if (response.code == 200) {
            var records = response.data;

            records.forEach(function(d,i,a){
                $('select#department').append('<option value="'+d.department_id+'">'+d.name+'</option>')
            });


        }
        
    });

    $(document).on('click','[rel="collapse"]', function (event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;

        var this_el = $(this);
        $('html, body').animate({
            scrollTop: this_el.closest('form').find( "h3" ).offset().top
        }, 12, function(){
            

        });

        this_el.closest('form').find( ".collapsable" ).animate({
            height: "toggle"
        }, 750, function() {
            console.log('done');
        });

        
    });
  
</script>
@if(! Auth::user()->can('edit-one_page'))
<script>
$(document).ready(function (d) {
    // body...
    $( "input" ).not( $( "div.personals input, [name='_method' ], [name='_token' ], [name='one_page_id' ]" ) ).attr('disabled','disabled').removeAttr('name');
    $( "select" ).not( $( "div.personals select, [name='_method' ], [name='_token' ], [name='one_page_id' ]" ) ).attr('disabled','disabled').removeAttr('name');
    $( "textarea" ).not( $( "div.personals textarea, [name='_method' ], [name='_token' ], [name='one_page_id' ]" ) ).attr('disabled','disabled').removeAttr('name');
});
</script>        
    @endif
@stop