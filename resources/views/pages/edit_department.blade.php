@extends('layouts.master')

@section('title', trans('general.edit').' '.trans_choice('general.menu.departments', 1))

@section('content')
<h2>{{ trans('general.edit')}} {{trans_choice('general.menu.departments', 1) }}</h2>
<hr>
<div>
    

{!! Form::model($department, array('route' => array('departments.update', $department->department_id), 'method' => 'PUT')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>Department ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $department->department_id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value="{!! $department->name !!}" >
                        </div>
                    </div>
                </div>
                <div class="row cells2">
                    <div class="cell">
                        <label>{{trans('general.parent')}}</label>
                        <div class="input-control text full-size">
                            <select name="parent" id="parent">
                                <option value="0">-- ROOT --</option>
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.active')}}</label>
                        <br>
                        <label class="switch" style="padding: 1.2ex 0; ">
                            <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="active" value="{{$department->active}}" 
                            @if ($department->active)
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

<script>
$.getJSON( "/companies/{{$department->company}}/departments", function( response ) {
        if (response.code == 200) {
            var records = response.data;

            records.forEach(function(d,i,a){
                if (d.department_id != '{{$department->department_id}}') {
                    $('select#parent').append('<option value="'+d.department_id+'">'+d.name+'</option>')
                }
            });
            if ("{!! $department->parent !!}") {

                $('select#parent').attr("data-selected" ,"{{$department->parent}}");
            }


        }
        
    });    
</script>

@stop