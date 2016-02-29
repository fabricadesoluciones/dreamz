@extends('layouts.master')

@section('title', trans('general.new').' '.trans_choice('general.menu.objectives', 1))

@section('content')
<h2>{{trans('general.new')}} {{trans_choice('general.menu.objectives', 1)}} </h2>
<hr>
<div>
    

{!! Form::model($user, array('route' => array('objectives.store', $id), 'method' => 'POST')) !!}
    <div class="grid">
                <div class="row cells3">
                    <div class="cell">
                        <label>Objective ID</label>
                        <div class="input-control text full-size">
                            <input  type="text" name="objective_id" value="{!! $id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input  name="name" type="text"  >
                        </div>
                    </div>
                    <div class="cell">
                        <br>
                        <div class="input-control select full-size">
                        <label for="department">{{trans_choice('general.menu.periods',1)}}</label>
                            <select name="period" id="period" >
                                 @foreach ($periods as $period)
                                    <option value="{{$period->period_id}}">{{$period->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row cells1">
                    
                    <div class="cell">
                        <label>{{trans('general.objectives.ignore')}}</label>
                        <br>
                        <label class="switch" style="padding: 1.2ex 0; ">
                            <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="ignore" value="" />
                            <span class="check"></span>
                        </label>
                    </div>
                </div>
                <div class="row cells1">
                    <div class="cell">
                        <label for="alergies">{{trans('general.description')}}</label> <br>
                        <div class="input-control textarea"data-role="input" data-text-auto-resize="true">
                            <textarea cols="200" name="description"></textarea>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="row cells4">
                    
                    <div class="cell">
                        <div class="input-control select">
                        <label for="position">{{trans_choice('general.measuring_unit',1)}}</label>
                            <select name="measuring_unit" id="measuring_unit" >
                            @foreach ($measuring_units as $measuring_unit)
                                    <option value="{{$measuring_unit->measuring_unit_id}}">{{$measuring_unit->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control select">
                        <label for="position">{{trans_choice('general.categories',1)}}</label>
                            <select name="category" id="category" >
                            @foreach ($categories as $category)
                                    <option value="{{$category->category_id}}">{{$category->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control select has_subcategory">
                        <label for="position">{{trans_choice('general.subcategories',1)}}</label>
                            <select name="subcategory" id="subcategory" >
                            @foreach ($subcategories as $subcategory)
                                    <option value="{{$subcategory->subcategory_id}}">{{$subcategory->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    
                </div>
                
                
            </div>
                
                
                
                
            </div>
            <div class="grid">
                <h3>{{trans('general.objectives.period_target')}}</h3>    
                <hr>
                <br>
                <div class="row cells2">
                    <div class="cell">
                        <div class="">
                        <label for="department">{{trans('general.objectives.inverted_goals')}}</label>
                        <br>
                        <input type="checkbox" onchange="if(this.checked) {this.value=1; KPI.type = 'inverted'}else{this.value=0; KPI.type = 'normal'}" name="type" value="" />
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control text">
                        <label for="department">{{trans('general.objectives.target')}}</label>
                            <input type="number" value="0" pattern="[0-9.,]+" step="0.01" name="period_objective" id="period_objective"  />
                        </div>
                    </div>
                </div>
                <div class="row cells3 inlined">
                    <div class="cell">
                        <div class="input-control text">
                        <label for="department">{{trans('general.objectives.green')}}</label>
                           <input   class="auto" type="number" value="0" pattern="[0-9.,]+" step="0.01" name="period_green" id="period_green" />
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control text">
                        <label for="department">{{trans('general.objectives.red')}}</label>
                           <input  class="auto" type="number" value="0" pattern="[0-9.,]+" step="0.01" name="period_red" id="period_red" />
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control text">
                        <label for="department">{{trans('general.objectives.yellow')}}</label> 
                            <input class="auto" type="number" value="0" pattern="[0-9.,]+" step="0.01" readonly="readonly" name="period_yellow_ceil" id="period_yellow_ceil" /> - 
                            <input class="auto" type="number" value="0" pattern="[0-9.,]+" step="0.01" readonly="readonly" name="period_yellow_floor" id="period_yellow_floor" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid">
                <h3>{{trans('general.objectives.daily_target')}}</h3>    
                <hr>
                <br>
                <div class="row cells1">
                    <div class="cell">
                        <div class="input-control text">
                        <label for="department">{{trans('general.objectives.target')}}</label>
                            <input type="number" value="0" pattern="[0-9.,]+" step="0.01" name="daily_objective" id="daily_objective" />
                        </div>
                    </div>
                </div>
                <div class="row cells3 inlined">
                    <div class="cell">
                        <div class="input-control text">
                        <label for="department">{{trans('general.objectives.green')}}</label>
                           <input   class="auto" type="number" value="0" pattern="[0-9.,]+" step="0.01" name="daily_green" id="daily_green" />
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control text">
                        <label for="department">{{trans('general.objectives.red')}}</label>
                           <input  class="auto" type="number" value="0" pattern="[0-9.,]+" step="0.01" name="daily_red" id="daily_red" />
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control text">
                        <label for="department">{{trans('general.objectives.yellow')}}</label> 
                            <input class="auto" type="number" value="0" pattern="[0-9.,]+" step="0.01" readonly="readonly" name="daily_yellow_ceil" id="daily_yellow_ceil" /> - 
                            <input class="auto" type="number" value="0" pattern="[0-9.,]+" step="0.01" readonly="readonly" name="daily_yellow_floor" id="daily_yellow_floor" />
                        </div>
                    </div>
                </div>
            </div>

        <input type="button" class="success validate" value="{{trans('general.forms.submit')}}">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">{{trans('general.forms.cancel')}}</a>
           
{!! Form::close() !!}
</div>
<script>
function returnNotify(msg, title, type){
    var datitle = title || 'Error';
    var datype = type || 'alert';

    $.Notify({
        caption:datitle,
        type:datype,
        content: msg,
    }); 
}
    var
    
    KPI = {}
    KPI.type = 'normal';
    KPI.period = {},
    KPI.daily = {},
    KPI.period.target_value = 0;
    KPI.period.green = 0;
    KPI.period.red = 0;
    KPI.daily.target_value = 0;
    KPI.daily.green = 0;
    KPI.daily.red = 0;


    KPI.green_valid = function(obj){
        switch(KPI.type) {
            case 'normal':
                if ( !!obj.green && ! isNaN(obj.green) &&  obj.green >= obj.red && obj.green <= obj.target_value) return true;
                break;
            case 'inverted':
                if ( !!obj.green && ! isNaN(obj.green) &&  obj.green <= obj.red && obj.green >= obj.target_value) return true;
                break;
        }

        console.log('INVALID GREEN',obj);
        return false;
    }

    KPI.red_valid = function(obj){
        switch(KPI.type) {
            case 'normal':
                if ( !!obj.red && ! isNaN(obj.red) && obj.red <= obj.green) return true;
                break;
            case 'inverted':
                if ( !!obj.red && ! isNaN(obj.red) && obj.red >= obj.green) return true;
                break;
        }

        console.log('INVALID RED',obj);
        return false;
    }

    KPI.period_valid = function(obj){
        switch(KPI.type) {
            case 'normal':
                if ( !!obj.target_value && ! isNaN(obj.target_value) &&  obj.target_value >= obj.green && obj.target_value >= obj.red) return true;
                break;
            case 'inverted':
                if ( !!obj.target_value && ! isNaN(obj.target_value) &&  obj.target_value <= obj.green && obj.target_value <= obj.red) return true;
                break;
        }
        console.log('INVALID TARGET',obj);

        return false;
    }

    var validateObjectives = function(){

        if (
                KPI.green_valid(KPI.daily) &&
                KPI.red_valid(KPI.daily) &&
                KPI.period_valid(KPI.daily) &&
                KPI.green_valid(KPI.period) &&
                KPI.red_valid(KPI.period) &&
                KPI.period_valid(KPI.period)
            ){

            var daily_ceil = KPI.daily.green - .01;
            var period_ceil = KPI.period.green - .01;
            var daily_floor = KPI.daily.red + .01;
            var period_floor = KPI.period.red + .01;

            if (KPI.type == 'inverted') {
                var daily_floor = KPI.daily.red - .01;
                var period_floor = KPI.period.red - .01;
                var daily_ceil = KPI.daily.green + .01;
                var period_ceil = KPI.period.green + .01;
            }
            
            $('#daily_yellow_floor').val(daily_floor);
            $('#daily_yellow_ceil').val(daily_ceil);
            $('#period_yellow_floor').val(period_floor);
            $('#period_yellow_ceil').val(period_ceil);

            return true;
        }
        return false;

    }

    $(document).on('change','#period_red',function(){
        if ( isNaN( $(this).val() ) ) return false;
        KPI.period.red = parseFloat($(this).val());
        KPI.daily.red = KPI.period.red / 90;
        $('#daily_red').val(KPI.daily.red);
    });

    $(document).on('change','#period_green',function(){
        if ( isNaN( $(this).val() ) ) return false;
        KPI.period.green = parseFloat($(this).val());
        KPI.daily.green = KPI.period.green / 90;
        $('#daily_green').val(KPI.daily.green);
    });

    $(document).on('change','#period_objective',function(){
        if ( isNaN( $(this).val() ) ) return false;
        KPI.period.target_value = parseFloat($(this).val());
        KPI.daily.target_value = KPI.period.target_value / 90;
        $('#daily_objective').val(KPI.daily.target_value);
    });

    $(document).on('change','#daily_red',function(){
        if ( isNaN( $(this).val() ) ) return false;
        KPI.daily.red = parseFloat($(this).val());
    });

    $(document).on('change','#daily_green',function(){
        if ( isNaN( $(this).val() ) ) return false;
        KPI.daily.green = parseFloat($(this).val());
    });

    $(document).on('blur','#daily_objective',function(){
        if ( isNaN( $(this).val() ) ) return false;
        KPI.daily.target_value = parseFloat($(this).val());
    });
    $(document).on('click','input.validate',function(){
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        if (! validateObjectives()){
            returnNotify('Por favor revise los valores para los semáforos de objetivos');
        }
        else{
            document.querySelector('form').submit();
        }
    });

 
    $(document).on('change','#category',function(){
        $.get('/get_subcategories/'+$(this).val(), function(){},'json')
        .done(function(d){
            $("#subcategory").select2('destroy'); 
            $('#subcategory').detach();
            var select = '<select id="subcategory" name="subcategory">';
            var subcategories = d.data;
            for (var i = 0; i < subcategories.length; i++) {
                select += '<option value="'+subcategories[i].subcategory_id+'">'+subcategories[i].name+'</option>'
            };            
            select += '</select>';
            $('.has_subcategory').append(select);

            $("#subcategory").select2(); 

        });
    });
</script>




@stop