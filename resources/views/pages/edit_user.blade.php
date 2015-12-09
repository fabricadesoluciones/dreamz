@extends('layouts.master')

@section('title', '- Edit User')

@section('content')
<h2>Edit User </h2>
</div>
<div class="container">

{!! Form::model($user, array('route' => array('users.update', $user->user_id), 'method' => 'PUT')) !!}
<h3>Basic Info</h3>
<hr>
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>User ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $user->user_id !!}" name="user_id" disabled="" ="disabled="" ">
                        </div>
                    </div>
                    <div class="cell">
                        <label>Employee Number</label>
                        <div class="input-control text full-size">
                            <input size="65" name="employee_number" type="text" value="{!! $user->employee_number !!}" required="required">
                        </div>
                    </div>
                </div>
                <div class="row cells2">
                    <div class="cell">
                        <label>Name</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value="{!! $user->name !!}"  required="required">
                        </div>
                    </div>
                    <div class="cell">
                    
                        <label>Lastname</label>
                        <div class="input-control text full-size">
                            <input size="65" name="lastname" type="text" value="{!! $user->lastname !!}"  required="required">
                        </div>
                    
                    </div>
                </div>
                <div class="row cells3">
                    <div class="cell">
                        <label>Email</label>
                        <div class="input-control text full-size">
                            <input size="65" name="email" type="text" value="{!! $user->email !!}"  required="required">
                        </div></div>
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

            <h3>User Details</h3>
            <hr>
<div class="grid">
        <div class="row cells2">

            <div class="row cells2">
                <div class="cell">
                    <label for="mobile">mobile</label>
                    <div class="input-control text full-size">
                        <input name='mobile' type="text" value="{{$user->mobile}}" />
                    </div>
                </div>
                <div class="cell">
                    <label for="phone">phone</label>
                    <div class="input-control text full-size">
                        <input name='phone' type="text" value="{{$user->phone}}" />
                    </div>
                </div>
            </div>

            <div class="row cells2">
                <div class="cell">
                    <label for="education">education</label>
                    <div class="input-control text full-size">
                        <input name='education' type="text" value="{{$user->education}}" />
                    </div>
                </div>
            </div>
            
            <div class="row cells3">
                <div class="cell">
                    <label for="blood_type">blood_type</label>
                    <div class="input-control text full-size">
                        <input name='blood_type' type="text" value="{{$user->blood_type}}" />
                    </div>
                </div>
                <div class="cell">
                    <label for="birth_date">birth_date</label>
                    <div class="input-control text full-size">
                        <input name='birth_date' type="date" value="{{$user->birth_date}}" />
                    </div>
                </div>
                <div class="cell">
                    <label for="admission_date">admission_date</label>
                    <div class="input-control text full-size">
                        <input name='admission_date' type="date" value="{{$user->admission_date}}" />
                    </div>
                </div>
            </div>

            <div class="row cells2">
                <div class="cell">
                    <label for="alergies">alergies</label> <br>
                    <div class="input-control textarea"data-role="input" data-text-auto-resize="true">
                        <textarea cols="80" name="alergies">{{$user->alergies}}</textarea>
                    </div>
                </div>
                <div class="cell">
                    <label for="emergency_contact">emergency_contact</label> <br>
                    <div class="input-control textarea"data-role="input" data-text-auto-resize="true">
                        <textarea cols="80" name="emergency_contact">{{$user->emergency_contact}}</textarea>
                    </div>
                </div>
                
            </div>
            
            <div class="row cells2">
                <div class="cell">
                    <label for="facebook">facebook</label>
                    <div class="input-control text full-size">
                        <input name='facebook' type="text" value="{{$user->facebook}}" />
                    </div>
                </div>
                <div class="cell">
                    <label for="twitter">twitter</label>
                    <div class="input-control text full-size">
                        <input name='twitter' type="text" value="{{$user->twitter}}" />
                    </div>
                </div>
            </div>
            
            <div class="row cells2">
                <div class="cell">
                    <label for="instagram">instagram</label>
                    <div class="input-control text full-size">
                        <input name='instagram' type="text" value="{{$user->instagram}}" />
                    </div>
                </div>
                <div class="cell">
                    <label for="linkedin">linkedin</label>
                    <div class="input-control text full-size">
                        <input name='linkedin' type="text" value="{{$user->linkedin}}" />
                    </div>
                </div>
            </div>
            
            <div class="row cells2">
                <div class="cell">
                    <label for="googlep">googlep</label>
                    <div class="input-control text full-size">
                        <input name='googlep' type="text" value="{{$user->googlep}}" />
                    </div>
                </div>
            </div>

            
        </div>
    </div>

        <input type="submit" class="success">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">Cancel</a>
           
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
    $("#department").attr("data-selected", "{{$user->department}}");
    $("#position").attr("data-selected", "{{$user->position}}");
</script>

@stop