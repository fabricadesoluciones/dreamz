@extends('layouts.master')

@section('title', trans('general.edit').' '.trans_choice('general.menu.periods', 1))

@section('content')
<h2>{{trans('general.edit')}} {{trans_choice('general.menu.periods', 1)}} </h2>
<hr>
<div>
    

{!! Form::model($period, array('route' => array('periods.update', $period->period_id), 'method' => 'PUT')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>Period ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $period->period_id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value="{!! $period->name !!}" >
                        </div>
                    </div>
                </div>
                <div class="row cells3">
                    <div class="cell">
                        <label>{{trans('general.from')}}</label> <br>
                        <div class="input-control text">
                            <input name="start" type="date" value="{{$period->start}}" required="required">
                        </div>
                    </div>

                    <div class="cell">
                        <label>{{trans('general.to')}}</label> <br>
                        <div class="input-control text">
                            <input name="end" type="date" value="{{$period->end}}" required="required">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.active')}}</label>
                        <br>
                        <label class="switch" style="padding: 1.2ex 0; ">
                            <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="active" value="{{$period->active}}" 
                            @if ($period->active)
                                checked="true"
                            @endif
                            >
                            <span class="check"></span>
                        </label>
                        
                    </div>
                </div>
                
                
                
            </div>

        <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">{{trans('general.forms.cancel')}}</a>
           
{!! Form::close() !!}
</div>



@stop