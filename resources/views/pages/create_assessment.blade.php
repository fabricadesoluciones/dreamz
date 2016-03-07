@extends('layouts.master')

@section('title', trans('general.new').' Assessment')

@section('content')
<h2>{{ trans('general.new')}} Assessment</h2>
<hr>
<div>
    {!! Form::model($id, array('route' => array('assessments.store', $id), 'method' => 'POST', 'files'=>true)) !!}
    <div class="grid">
                <div class="row cells3">
                    <div class="cell">
                        <label>Assessment ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" name="assessment_id" name="period_id" value="{!! $id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <br>
                        <div class="input-control select">
                        <label for="department"> Assessment</label>
                            <select name="name" id="name" >
                            <option value="Strengthfinder">Strengthfinder</option>
                            <option value="DISC">DISC</option>
                            <option value="Welth Dynamics">Welth Dynamics</option>
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans_choice('general.dates',1)}}</label> <br>
                        <div class="input-control text">
                            <input name="submit_date" type="date" required="required">
                        </div>
                    </div>
                </div>
                <div class="row cells3">
                    
                    <div class="cell">
                        <br>
                        <div class="input-control select">
                        <label for="department"> User</label>
                            <select name="user" id="user" >
                            @foreach ($users as $user)
                                <option value="{{$user->user_id}}">{{$user->name}} {{$user->lastname}}</option>
                            @endforeach
                            
                            </select>
                        </div>
                    </div>

                    <div class="cell">
                    <br>
                        <div class="input-control file" data-role="input">
                        <label for="file">File</label>
                            <input type="file" name="attachment" >
                            <button class="button"><span class="mif-folder"></span></button>
                        </div>
                    </div>
                    
                </div>

                
            </div>
        <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">{{trans('general.forms.cancel')}}</a>
           
{!! Form::close() !!}

</div>

@stop