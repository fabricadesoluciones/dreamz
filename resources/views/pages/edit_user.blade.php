@extends('layouts.master')

@section('title', trans('general.edit').' '.trans_choice('general.menu.users', 1))

@section('content')
<h2>{{trans('general.edit')}} {{trans_choice('general.menu.users', 1)}} </h2>
<div>

{!! Form::model($user, array('route' => array('users.update', $user->user_id), 'method' => 'PUT')) !!}
<h3>{{trans('general.forms.basic_info')}}</h3>
<hr>
    <div class="grid">
                
                <div class="row cells2" @if( ! Auth::user()->can('edit-users')) style="display:none;" @endif>
                    <div class="cell">
                        <label>User ID {{trans('general.http.200u')}} </label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $user->user_id !!}" name="user_id" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.employee_number')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="employee_number" type="text" value="{!! $user->employee_number !!}" required="required">
                        </div>
                    </div>
                </div>
                <div class="row cells2">
                    <div class="cell">
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value="{!! $user->name !!}"  required="required">
                        </div>
                    </div>
                    <div class="cell">
                    
                        <label>{{trans('general.forms.lastname')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="lastname" type="text" value="{!! $user->lastname !!}"  required="required">
                        </div>
                    
                    </div>
                </div>
                <div class="row cells3" @if( ! Auth::user()->can('edit-users')) style="display:none;" @endif>
                    <div class="cell">
                        <label>Email</label>
                        <div class="input-control text full-size">
                            <input size="65" name="email" type="text" value="{!! $user->email !!}"  required="required">
                        </div></div>
                    <div class="cell">
                        <label>{{trans('general.active')}}</label>
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
                
                <div class="row cells2" @if( ! Auth::user()->can('edit-users')) style="display:none;" @endif>
                    <div class="cell">
                        <div class="input-control select">
                        <label for="department">{{trans_choice('general.menu.departments',1)}}</label>
                            <select name="department" id="department">
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control select">
                        <label for="position">{{trans_choice('general.menu.positions',1)}}</label>
                            <select name="position" id="position">
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <h3>{{trans('general.forms.user_details')}}</h3>
            <hr>
<div class="grid">
        <div class="row cells2">

            <div class="row cells2">
                <div class="cell">
                    <label for="mobile">{{trans('general.forms.mobile')}}</label>
                    <div class="input-control text full-size">
                        <input name='mobile' type="text" value="{{$user->mobile}}" />
                    </div>
                </div>
                <div class="cell">
                    <label for="phone">{{trans('general.forms.phone')}}</label>
                    <div class="input-control text full-size">
                        <input name='phone' type="text" value="{{$user->phone}}" />
                    </div>
                </div>
            </div>

            <div class="row cells2">
                <div class="cell">
                    <label for="education">{{trans('general.forms.education')}}</label>
                    <div class="input-control text full-size">
                        <input name='education' type="text" value="{{$user->education}}" />
                    </div>
                </div>
            </div>
            
            <div class="row cells3">
                <div class="cell">
                    <label for="blood_type">{{trans('general.forms.blood_type')}}</label>
                    <div class="input-control text full-size">
                        <input name='blood_type' type="text" value="{{$user->blood_type}}" />
                    </div>
                </div>
                <div class="cell">
                    <label for="birth_date">{{trans('general.forms.birth_date')}}</label>
                    <div class="input-control text full-size">
                        <input name='birth_date' type="date" value="{{$user->birth_date}}" />
                    </div>
                </div>
                <div class="cell" @if( ! Auth::user()->can('edit-users')) style="display:none;" @endif>
                    <label for="admission_date">{{trans('general.forms.admission_date')}}</label>
                    <div class="input-control text full-size">
                        <input name='admission_date' type="date" value="{{$user->admission_date}}" />
                    </div>
                </div>
            </div>

            <div class="row cells2">
                <div class="cell">
                    <label for="alergies">{{trans('general.forms.alergies')}}</label> <br>
                    <div class="input-control textarea"data-role="input" data-text-auto-resize="true">
                        <textarea cols="80" name="alergies">{{$user->alergies}}</textarea>
                    </div>
                </div>
                <div class="cell">
                    <label for="emergency_contact">{{trans('general.forms.emergency_contact')}}</label> <br>
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
                    <label for="googlep">google+</label>
                    <div class="input-control text full-size">
                        <input name='googlep' type="text" value="{{$user->googlep}}" />
                    </div>
                </div>
            </div>

            
        </div>
    </div>

        <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">{{trans('general.forms.cancel')}}</a>
           
{!! Form::close() !!}
{!! Form::model($user, array('route' => array('password.email'), 'method' => 'POST')) !!}
<input size="65" name="email" type="hidden" value="{!! $user->email !!}" >
<input type="submit" value="{{trans('general.forms.reset_password')}}" class="info">
{!! Form::close() !!}
</div>

<script>
    $.getJSON( "/companies/{{ session('company') }}/departments", function( response ) {
        if (response.code == 200) {
            var records = response.data;

            records.forEach(function(d,i,a){
                $('select#department').append('<option value="'+d.department_id+'">'+d.name+'</option>')
            });
            $('select#department').val("{{$user->department}}");


        }
        
    });

    $.getJSON( "/companies/{{ session('company') }}/positions", function( response ) {
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