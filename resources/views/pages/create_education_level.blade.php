@extends('layouts.master')

@section('title', trans('general.new').' '.trans('general.menu.education'))

@section('content')
<h2>{{trans('general.new')}} {{trans('general.menu.education')}} </h2>
<hr>
<div>
    

{!! Form::model($id, array('route' => array('education_level.store', $id), 'method' => 'POST')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>Education ID</label>
                        <div class="input-control text full-size">
                            <input name="education_level_id" size="65" type="text" value="{!! $id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value="" >
                        </div>
                    </div>
                </div>
                
                
                
                
            </div>

        <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">{{trans('general.forms.cancel')}}</a>
           
{!! Form::close() !!}
</div>



@stop