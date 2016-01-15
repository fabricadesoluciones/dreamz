@extends('layouts.master')

@section('title', trans('general.edit').' '.trans_choice('general.measuring_unit', 1))

@section('content')
<h2>{{trans('general.edit')}} {{trans_choice('general.measuring_unit', 1)}} </h2>
<hr>
<div>
    

{!! Form::model($measuring_unit, array('route' => array('measuring_unit.update', $measuring_unit->measuring_unit_id), 'method' => 'PUT')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>Measure Unit ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $measuring_unit->measuring_unit_id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value="{!! $measuring_unit->name !!}" >
                        </div>
                    </div>
                </div>
                
                
                
                
            </div>

        <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">{{trans('general.forms.cancel')}}</a>
           
{!! Form::close() !!}
</div>



@stop