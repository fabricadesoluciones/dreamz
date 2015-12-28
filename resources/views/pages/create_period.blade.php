@extends('layouts.master')

@section('title', '- New Period')

@section('content')
<h2>New Period </h2>
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
                        <label>Name</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value=""  required="required" />
                        </div>
                    </div>
                </div>
                <div class="row cells3">
                    
                    <div class="cell">
                        <label>Start Date</label> <br>
                        <div class="input-control text" data-role="datepicker" data-format='yyyy-mm-dd'>
                            <input name="start" type="text">
                            <button class="button"><span class="mif-calendar"></span></button>
                        </div>
                    </div>

                    <div class="cell">
                        <label>End Date</label> <br>
                        <div class="input-control text" data-role="datepicker" data-format='yyyy-mm-dd'>
                            <input name="end" type="text">
                            <button class="button"><span class="mif-calendar"></span></button>
                        </div>
                    </div>
                    <div class="cell">
                        <label>Active</label>
                        <br>
                        <label class="switch" style="padding: 1.2ex 0; ">
                            <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="active">
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