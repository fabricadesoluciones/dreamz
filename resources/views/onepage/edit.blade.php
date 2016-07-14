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
            <div class="bg-grayLighter padding10 personals">
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
    $( "input" ).not( $( "div.personals input, #dialog input, [name='_method' ], [name='_token' ], [name='onepage_type' ], [name='one_page_id' ]" ) ).attr('disabled','disabled').removeAttr('name');
    $( "select" ).not( $( "div.personals select, #dialog select, [name='_method' ], [name='_token' ], [name='onepage_type' ], [name='one_page_id' ]" ) ).attr('disabled','disabled').removeAttr('name');
    $( "textarea" ).not( $( "div.personals textarea, #dialog textarea, [name='_method' ], [name='_token' ], [name='onepage_type' ], [name='one_page_id' ]" ) ).attr('disabled','disabled').removeAttr('name');
});
</script>        
    @endif
<div data-role="dialog" data-type="info" id="dialog" data-close-button="true" data-overlay="true" data-overlay-color="black" class="padding10">
    <input type="hidden" name="extra_type">
    <h1>{{trans('general.forms.add_new')}}:</h1>
    <h4 id="priority_name"></h4>
    <div class="grid">
        <div class="row ">
            <div class="margin10">
                <label>{{ trans('general.forms.name') }}</label>
                <div class="input-control text full-size">
                    <input id="name" size="65" type="text" name="new_extra_name" />
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="margin10">
                <div class="input-control text full-size">
                    <label>{{trans_choice('general.dates',1)}}</label>
                    <input name='new_extra_date' type="date" value="{{ date('Y-m-d')}}" />

                </div>

            </div>
            <div class="margin10">
                <div class="input-control select">
                    <label style=" margin-top: 1ex; ">Active</label>
                    <label class="switch" style="padding: 1.2ex 0;clear: left;margin-top: 3ex;">
                        <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="active" value="">
                        <span class="check"></span>
                    </label>

                </div>
            </div>
        </div>
        {{ csrf_field() }}
        <button class="button success save_progress margin10" style="display: inline-block; margin:  0 1em; ">{{trans('general.forms.submit')}}</button>
        <button class="button danger cancel_progress">{{trans('general.forms.cancel')}}</button>
    </div>
</div>
<script>
    $(document).on('click','.cancel_progress', function(event) {
        event.preventDefault();
        event.stopPropagation();
        var dialog_obj = $('#dialog').data('dialog');
        dialog_obj.close();
    });
    $(document).on('click','[rel*="new_extra"]', function(event){
        event.preventDefault();
        event.stopPropagation();
        $('#dialog input').val('');
        var type = $(this).data('extra');
        var target = $(this).data('target');
        $('.save_progress').attr('data-target',target);
        $('[name="extra_type"]').val(type);
        showDialog('#dialog');
    });
    $(document).on('click','.save_progress', function(event){
        event.preventDefault();
        event.stopPropagation();
        if (
            ! $('[name="extra_type"]').val() ||
            ! $('[name="new_extra_date"]').val() ||
            ! $('[name="new_extra_name"]').val()
        ){
            returnNotify('Completa todos los campos','Error','alert')
            return false;
        }
        var target = $(this).attr('data-target');
        var request = $.post( "{!! route('store_extras') !!}",
                {
                    _token:$('[name="_token"]:eq(0)').val(),
                    one_page_id:$('[name="one_page_id"]').val(),
                    type: $('[name="extra_type"]').val(),
                    new_extra_date: $('[name="new_extra_date"]').val(),
                    new_extra_name: $('[name="new_extra_name"]').val(),
                    active: $('[name="active"]').val(),
                }  , function() {}, 'json');
        request
            .done(function( response ) {
                console.log(response);
                returnNotify('Se añadió el elemento','Success','success');
                var id = response.data.id;
                var name = response.data.name;
                var option = '<option value="'+id+'">'+name+'</option>'
                $('[name="'+target+'"]').append(option);

            })
            .fail(function( response ) {
                console.log( 'fail', response )
                returnNotify('Ocurrió un error','Error','alert')
            })
            .always(function( response ) {
                var dialog_obj = $('#dialog').data('dialog');
                dialog_obj.close();
            });
    });

</script>

@stop
