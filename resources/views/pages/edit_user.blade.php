@extends('layouts.master')

@section('title', '- Edit User')

@section('content')
<h2>Edit User 
    @if( Session::has('update') )
        - 
        @if(Session::get('update') == 200)
            <span class="button success">
                Success
            </span>
        @else
            <span class="button danger">
                Error
            </span>
        @endif
    @endif
</h2>
<hr>
</div>
<div class="container">
    
{!! Form::model($user, array('route' => array('users.update', $user->user_id), 'method' => 'PUT')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>User ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $user->user_id !!}" disabled="disabled">
                        </div>
                    </div>
                    <div class="cell">
                        <label>Employee Number</label>
                        <div class="input-control text full-size">
                            <input size="65" name="employee_number" type="text" value="{!! $user->employee_number !!}" >
                        </div>
                    </div>
                </div>
                <div class="row cells2">
                    <div class="cell">
                        <label>Name</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value="{!! $user->name !!}" >
                        </div>
                    </div>
                    <div class="cell">
                        <label>Email</label>
                        <div class="input-control text full-size">
                            <input size="65" name="email" type="text" value="{!! $user->email !!}" >
                        </div>
                    </div>
                </div>
                <div class="row cells3">
                    <div class="cell">
                        <label>Lastname</label>
                        <div class="input-control text full-size">
                            <input size="65" name="lastname" type="text" value="{!! $user->lastname !!}" >
                        </div>
                    </div>
                    <div class="cell">
                        <label>Active</label>
                        <br>
                        <label class="switch" style="padding: 1.2ex 0; ">
                            <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="active" value="{{$user->active}}" 
                            @if ($user->active)
                                checked="true"
                            @endif
                            >
                            <span class="check"></span>
                        </label>
                        
                    </div>
                    <div class="cell">
                        <label>High Potential</label>
                        <br>
                        <label class="switch" style="padding: 1.2ex 0; ">
                            <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="high_potential" value="{{$user->high_potential}}" 
                            @if ($user->high_potential)
                                checked="true"
                            @endif
                            >
                            <span class="check"></span>
                        </label>
                        
                    </div>
                </div>
                
                <div class="row cells2">
                    <div class="cell">
                        <div class="input-control select">
                        <label for="department">Department</label>
                            <select name="department" id="department">
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control select">
                        <label for="position">Position</label>
                            <select name="position" id="position">
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        <input type="submit" class="success">
        <a href="" onclick="window.history.back();" class="button danger">Cancel</a>
           
{!! Form::close() !!}
{!! Form::model($user, array('route' => array('password.email'), 'method' => 'POST')) !!}
<input size="65" name="email" type="hidden" value="{!! $user->email !!}" >
<input type="submit" value="Reset password" class="info">
{!! Form::close() !!}
</div>

<script>
    $.getJSON( "/companies/{{$user->company}}/departments", function( response ) {
        if (response.code == 200) {
            var records = response.data;

            records.forEach(function(d,i,a){
                $('select#department').append('<option value="'+d.department_id+'">'+d.name+'</option>')
            });
            $('select#department').val("{{$user->department}}");


        }
        
    });

    $.getJSON( "/companies/{{$user->company}}/positions", function( response ) {
        if (response.code == 200) {
            var records = response.data;

            records.forEach(function(d,i,a){
                $('select#position').append('<option value="'+d.position_id+'">'+d.name+'</option>')
            });
            $('select#position').val("{{$user->position}}");


        }

    });
</script>

@stop