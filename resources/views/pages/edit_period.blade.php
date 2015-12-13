@extends('layouts.master')

@section('title', '- Edit Period')

@section('content')
<h2>Edit Period </h2>
<hr>
</div>
<div class="container">
    

{!! Form::model($period, array('route' => array('periods.update', $period->period_id), 'method' => 'PUT')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>Period ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $period->period_id !!}" disabled="disabled">
                        </div>
                    </div>
                    <div class="cell">
                        <label>Name</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value="{!! $period->name !!}" >
                        </div>
                    </div>
                </div>
                <div class="row cells3">
                    <div class="cell">
                        <label>Start Date</label> <br>
                        <div class="input-control text" data-role="datepicker" data-format='yyyy-mm-dd' data-preset="{{$period->start}}">
                            <input name="start" type="text">
                            <button class="button"><span class="mif-calendar"></span></button>
                        </div>
                    </div>

                    <div class="cell">
                        <label>End Date</label> <br>
                        <div class="input-control text" data-role="datepicker" data-format='yyyy-mm-dd' data-preset="{{$period->end}}">
                            <input name="end" type="text">
                            <button class="button"><span class="mif-calendar"></span></button>
                        </div>
                    </div>
                    <div class="cell">
                        <label>Active</label>
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

        <input type="submit" class="success">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">Cancel</a>
           
{!! Form::close() !!}
</div>



@stop