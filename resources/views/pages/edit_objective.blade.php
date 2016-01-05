@extends('layouts.master')

@section('title', trans('general.edit').' '.trans_choice('general.menu.objectives', 1))

@section('content')
<h2>{{trans('general.edit')}} {{trans_choice('general.menu.objectives', 1)}} </h2>
<hr>
<div>
    

{!! Form::model($objective, array('route' => array('objectives.update', $id), 'method' => 'PUT')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>Objective ID</label>
                        <div class="input-control text full-size">
                            <input  type="text" value="{!! $id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input  name="name" type="text" value="{!! $objective->name !!}" >
                        </div>
                    </div>
                </div>
                <div class="row cells1">
                <div class="cell">
                    <label for="alergies">{{trans('general.description')}}</label> <br>
                    <div class="input-control textarea"data-role="input" data-text-auto-resize="true">
                        <textarea cols="200" name="description">{{$objective->description}}</textarea>
                        <br>
                        <br>
                    </div>
                </div>
                <div class="row cells4">
                    <div class="cell">
                        <div class="input-control select">
                        <label for="department">{{trans_choice('general.menu.periods',1)}}</label>
                            <select name="period" id="period" data-selected="{{$objective->period}}">
                                 @foreach ($periods as $period)
                                    <option value="{{$period->period_id}}">{{$period->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control select">
                        <label for="position">{{trans_choice('general.measuring_unit',1)}}</label>
                            <select name="measuring_unit" id="measuring_unit" data-selected="{{$objective->measuring_unit}}">
                            @foreach ($measuring_units as $measuring_unit)
                                    <option value="{{$measuring_unit->measuring_unit_id}}">{{$measuring_unit->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control select">
                        <label for="position">{{trans_choice('general.categories',1)}}</label>
                            <select name="category" id="category" data-selected="{{$objective->category}}">
                            @foreach ($categories as $category)
                                    <option value="{{$category->category_id}}">{{$category->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control select">
                        <label for="type">{{trans_choice('general.types', 1)}}</label>
                            <select name="type" id="type" data-selected="{{$objective->type}}">
                                <option value="EMPRESA">{{trans_choice('general.menu.companies', 1)}}</option>
                                <option value="DEPARTAMENTO">{{trans_choice('general.menu.departments', 1)}}</option>
                                <option value="PERSONAL">{{trans('general.personal')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                
            </div>
                
                
                
                
            </div>
            <div class="grid">
                <h3>Semáforos para el período</h3>    
                <hr>
                <br>
                <div class="row cells1">
                    <div class="cell">
                        <div class="input-control text">
                        <label for="department">Valor Objetivo</label>
                            <input type="number" pattern="[0-9.,]+" step="0.01" name="period_objective" id="period_objective" placeholder="{{$objective->measuring_unit_name}}" value="{{$objective->period_objective}}"/>
                        </div>
                    </div>
                </div>
                <div class="row cells3 inlined">
                    <div class="cell">
                        <div class="input-control text">
                        <label for="department">Valor Verde</label>
                           Mayor o igual a:  <input placeholder="{{$objective->measuring_unit_name}}"  class="auto" type="number" pattern="[0-9.,]+" step="0.01" name="period_green" id="period_green" value="{{$objective->period_green}}"/>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control text">
                        <label for="department">Valor Rojo</label>
                           Menor a:   <input placeholder="{{$objective->measuring_unit_name}}" class="auto" type="number" pattern="[0-9.,]+" step="0.01" name="period_red" id="period_red" value="{{$objective->period_red}}"/>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control text">
                        <label for="department">Valor Amarillo</label> 
                            <input class="auto" type="number" pattern="[0-9.,]+" step="0.01" readonly="readonly" name="period_yellow_ceil" id="period_yellow_ceil" value="{{$objective->period_yellow_ceil}}"/> - 
                            <input class="auto" type="number" pattern="[0-9.,]+" step="0.01" readonly="readonly" name="period_yellow_floor" id="period_yellow_floor" value="{{$objective->period_yellow_floor}}"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid">
                <h3>Semáforos por día</h3>    
                <hr>
                <br>
                <div class="row cells1">
                    <div class="cell">
                        <div class="input-control text">
                        <label for="department">Valor Objetivo</label>
                            <input type="number" pattern="[0-9.,]+" step="0.01" name="daily_objective" id="daily_objective" placeholder="{{$objective->measuring_unit_name}}" value="{{$objective->daily_objective}}" readonly="readonly" />
                        </div>
                    </div>
                </div>
                <div class="row cells3 inlined">
                    <div class="cell">
                        <div class="input-control text">
                        <label for="department">Valor Verde</label>
                           Mayor o igual a:  <input placeholder="{{$objective->measuring_unit_name}}"  class="auto" type="number" pattern="[0-9.,]+" step="0.01" name="daily_green" id="daily_green" value="{{$objective->daily_green}}"/>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control text">
                        <label for="department">Valor Rojo</label>
                           Menor a:   <input placeholder="{{$objective->measuring_unit_name}}" class="auto" type="number" pattern="[0-9.,]+" step="0.01" name="daily_red" id="daily_red" value="{{$objective->daily_red}}"/>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control text">
                        <label for="department">Valor Amarillo</label> 
                            <input class="auto" type="number" pattern="[0-9.,]+" step="0.01" readonly="readonly" name="daily_yellow_ceil" id="daily_yellow_ceil" value="{{$objective->daily_yellow_ceil}}"/> - 
                            <input class="auto" type="number" pattern="[0-9.,]+" step="0.01" readonly="readonly" name="daily_yellow_floor" id="daily_yellow_floor" value="{{$objective->daily_yellow_floor}}"/>
                        </div>
                    </div>
                </div>
            </div>

        <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
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
    KPI.period = {},
    KPI.daily = {},
    KPI.period.value = parseFloat($('#period_objective').val()).toFixed(2),
    KPI.period.green = parseFloat($('#period_green').val()).toFixed(2),
    KPI.period.red = parseFloat($('#period_red').val()).toFixed(2);
    KPI.daily.value = parseFloat($('#daily_objective').val()).toFixed(2),
    KPI.daily.green = parseFloat($('#daily_green').val()).toFixed(2),
    KPI.daily.red = parseFloat($('#daily_red').val()).toFixed(2);

    $(document).on('blur','#period_red',function(){
        var red = parseFloat((parseFloat($(this).val()) + .01).toFixed(2));
        if (isNaN(red)) { returnNotify('El número es inválido'); $('#period_red').val(KPI.period.red); return false; };
        if (red >= KPI.period.green) {  

            $.Notify({
                caption:'Error',
                type:'alert',
                content: 'El Valor Rojo debe ser menor que el valor verde',
            }); 
            $('#period_red').val(KPI.period.red);
        }else{

            KPI.period.red = $(this).val();
            $('#period_yellow_floor').val(red);
        }
    });

    $(document).on('blur','#period_green',function(){
        var green = parseFloat((parseFloat($(this).val()) - .01).toFixed(2));
        if (isNaN(green)) { returnNotify('El número es inválido'); $('#period_green').val(KPI.period.green); return false; };
        if (green <= KPI.period.red) {  

            returnNotify('El Valor Verde debe ser mayor que el valor rojo')
            $('#period_green').val(KPI.period.green);
        }else if(green >= KPI.period.value){
            returnNotify('El Valor Verde no debe ser mayor que el valor objetivo')
            $('#period_green').val(KPI.period.green);
        }else{

            KPI.period.green = $(this).val();
            $('#period_yellow_ceil').val(green);
        }
    });
    $(document).on('blur','#period_objective',function(){
        var target_value = parseFloat((parseFloat($(this).val())).toFixed(2));
        if (isNaN(target_value)) { returnNotify('El número es inválido'); $('#period_objective').val(KPI.period.value); return false; };
        if (target_value < KPI.period.green) {  

            returnNotify('El Valor Objetivo debe ser mayor o igual que el valor verde')
            $('#period_objective').val(KPI.period.value);
        }else if ((target_value / 90) < KPI.daily.green) {  

            returnNotify('El Valor Objetivo diario debe ser mayor o igual que el valor verde diario')
            $('#period_objective').val(KPI.period.value);
        }else{
            KPI.period.value = target_value;
            KPI.daily.value = parseFloat(parseFloat(target_value / 90).toFixed(2));
            $('#daily_objective').val(KPI.daily.value );
        }
    });


    $(document).on('blur','#daily_red',function(){
        var red = parseFloat((parseFloat($(this).val()) + .01).toFixed(2));
        if (isNaN(red)) { returnNotify('El número es inválido'); $('#daily_red').val(KPI.daily.red); return false; };
        if (red >= KPI.daily.green) {  

            returnNotify('El Valor Rojo debe ser menor que el valor verde')
            $('#daily_red').val(KPI.daily.red);
        }else{

            KPI.daily.red = $(this).val();
            $('#daily_yellow_floor').val(red);
        }
    });

    $(document).on('blur','#daily_green',function(){
        var green = parseFloat((parseFloat($(this).val()) - .01).toFixed(2));
        if (isNaN(green)) { returnNotify('El número es inválido'); $('#daily_green').val(KPI.daily.green); return false; };
        if (green <= KPI.daily.red) {  

            returnNotify('El Valor Verde debe ser mayor que el valor rojo')
            $('#daily_green').val(KPI.daily.green);
        }else if(green >= KPI.daily.value){
            returnNotify('El Valor Verde no debe ser mayor que el valor objetivo')
            $('#daily_green').val(KPI.daily.green);
        }else{

            KPI.daily.green = $(this).val();
            $('#daily_yellow_ceil').val(green);
        }
    });
    $(document).on('blur','#daily_objective',function(){
        var green = parseFloat((parseFloat($(this).val())).toFixed(2));
        if (isNaN(green)) { returnNotify('El número es inválido'); $('#daily_objective').val(KPI.daily.value); return false; };
        if (green < KPI.daily.green) {  

            returnNotify('El Valor Objetivo debe ser mayor o igualque el valor verde')
            $('#daily_objective').val(KPI.daily.value);
        }else{
            KPI.daily.value = $(this).val();
        }
    });

</script>




@stop