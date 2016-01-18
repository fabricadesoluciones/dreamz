@extends('layouts.master')

@section('title', trans('general.edit').' '.trans_choice('general.menu.dreams', 1))

@section('content')
<h2>{{trans('general.edit')}} {{trans_choice('general.menu.dreams', 1)}} </h2>
<hr>
<div>
    

{!! Form::model($dream, array('route' => array('dreams.update', $dream->dreams_id), 'method' => 'PUT')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>Dream ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $dream->dreams_id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                    <br>
                        <div class="input-control select">
                        <label for="department">{{trans_choice('general.menu.periods',1)}}</label>
                            <select name="period" id="period" data-selected="{{$dream->period}}">
                                 @foreach ($periods as $period)
                                    <option value="{{$period->period_id}}">{{$period->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                </div>
                <div class="row cells1">
                    <div class="cell">
                        <label for="alergies">{{trans_choice('general.menu.dreams', 1)}}</label> <br>
                        <div class="input-control textarea"data-role="input" data-text-auto-resize="true">
                            <textarea cols="80" name="description">{{$dream->description}}</textarea>
                        </div>
                    </div>
                </div>
            </div>

        <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">{{trans('general.forms.cancel')}}</a>
           
{!! Form::close() !!}
</div>



@stop