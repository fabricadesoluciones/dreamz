@extends('layouts.master')

@section('title', trans('general.new').' '.trans_choice('general.menu.users', 1))

@section('content')
<h2>{{ trans('general.new')}} {{trans_choice('general.menu.users', 1) }}</h2>
<hr>
<div>
    {!! Form::model($user, array('route' => array('users.update', $id), 'method' => 'PUT')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>User ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" name="user_id" value="{!! $id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.employee_number')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="employee_number" type="text" value=""  required="required" />
                        </div>
                    </div>
                </div>
                <div class="row cells2">
                    <div class="cell">
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value=""  required="required" />
                        </div>
                    </div>
                    <div class="cell">
                        <label>Email</label>
                        <div class="input-control text full-size">
                            <input size="65" name="email" type="text" value=""  required="required" />
                        </div>
                    </div>
                </div>
                <div class="row cells3">
                    <div class="cell">
                        <label>{{trans('general.forms.lastname')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="lastname" type="text" value=""  required="required" />
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.active')}}</label>
                        <br>
                        <label class="switch" style="padding: 1.2ex 0; ">
                            <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="active" value="" />
                            <span class="check"></span>
                        </label>
                        
                    </div>
                    <div class="cell">
                        <label>High Potential</label>
                        <br>
                        <label class="switch" style="padding: 1.2ex 0; ">
                            <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="high_potential" value="" />
                            <span class="check"></span>
                        </label>
                        
                    </div>
                </div>
                
                <div class="row cells2">
                    <div class="cell">
                        <div class="input-control select">
                        <label for="department">{{trans_choice('general.menu.departments',1)}}</label>
                            <select name="department" id="department" >
                            <option value=""> - </option>
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control select">
                        <label for="position">{{trans_choice('general.menu.positions',1)}}</label>
                            <select name="position" id="position" >
                            <option value=""> - </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        <input type="hidden" name="company" value="{{$user->company}}">
        <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">{{trans('general.forms.cancel')}}</a>
           
{!! Form::close() !!}

</div>

<script>
    $.getJSON( "/companies/{{$user->company}}/departments", function( response ) {
        if (response.code == 200) {
            var records = response.data;

            records.forEach(function(d,i,a){
                $('select#department').append('<option value="'+d.department_id+'">'+d.name+'</option>')
            });


        }
        
    });

    $.getJSON( "/companies/{{$user->company}}/positions", function( response ) {
        if (response.code == 200) {
            var records = response.data;

            records.forEach(function(d,i,a){
                $('select#position').append('<option value="'+d.position_id+'">'+d.name+'</option>')
            });


        }

    });
</script>

@stop