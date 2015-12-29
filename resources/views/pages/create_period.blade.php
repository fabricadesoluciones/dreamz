@extends('layouts.master')

@section('title', trans('general.new').' '.trans_choice('general.menu.periods', 1))

@section('content')
<h2>{{ trans('general.new')}} {{trans_choice('general.menu.periods', 1) }}</h2>
<hr>
<div>
    {!! Form::model($user, array('route' => array('periods.store', $id), 'method' => 'POST')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>Period ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" name="period_id" value="{!! $id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value=""  required="required" />
                        </div>
                    </div>
                </div>
                <div class="row cells3">
                    
                    <div class="cell">
                        <label>{{trans('general.from')}}</label> <br>
                        <div class="input-control text">
                            <input name="start" type="date" required="required">
                        </div>
                    </div>

                    <div class="cell">
                        <label>{{trans('general.to')}}</label> <br>
                        <div class="input-control text">
                            <input name="end" type="date" required="required">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.active')}}</label>
                        <br>
                        <label class="switch" style="padding: 1.2ex 0; ">
                            <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="active">
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