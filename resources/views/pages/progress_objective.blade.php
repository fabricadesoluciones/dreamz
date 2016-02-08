@extends('layouts.master')

@section('title', trans('general.register_progress').' '.trans_choice('general.menu.objectives', 1))

@section('content')
<h2>{{trans('general.register_progress')}} {{trans_choice('general.menu.objectives', 1)}} </h2>
<hr>
<div>
    

{!! Form::model($objective, array('route' => array('objectives.update_objective_progress', $objective->objective_id), 'method' => 'POST')) !!}
    <div class="grid">
                <div class="row cells4">
                    <div class="cell">
                        <label>Objective ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" name="objective" value="{!! $objective->objective_id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value="{!! $objective->name !!}" >
                        </div>
                    </div>
                    <div class="cell">
                        <label>Fecha:</label> <br>
                        <div class="input-control text">
                            <input  type="date" id="today" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>Hora:</label> <br>
                        <div class="input-control text">
                            <input  type="time" id="now" readonly="readonly">   
                        </div>
                    </div>
                </div>
                <div class="row cells4">
                    <div class="cell">
                        <label>{{trans_choice('general.menu.periods', 1)}}</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $objective->period_name !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans_choice('general.measuring_unit', 1)}}</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $objective->measuring_unit_name !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans_choice('general.categories', 1)}}</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $objective->objective_category_name !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans_choice('general.subcategories', 1)}}</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $objective->objective_subcategory_name !!}" readonly="readonly">
                        </div>
                    </div>
                </div>
                <div class="row cells3">
                    <div class="cell">
                        <label>Acumulado</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $objective->real !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.objectives.target')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $objective->period_objective !!}" readonly="readonly">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row cells3">
                    <div class="cell">
                        <label>{{trans('general.register_progress')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" type="number" name="progress" />
                        </div>
                    </div>
                    
                </div>
                
                
                
            </div>

        <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">{{trans('general.forms.cancel')}}</a>
           
{!! Form::close() !!}
</div>
<script>
    
$('#today').val(moment().format('YYYY-MM-DD'));
$('#now').val(moment().format('HH:mm:ss'));

</script>


@stop