@extends('layouts.master')

@section('title', '- Edit Department')

@section('content')
<h2>Edit Department </h2>
<hr>
</div>
<div class="container">
    

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
                        <label>Name</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value="{!! $department->name !!}" >
                        </div>
                    </div>
                </div>
                <div class="row cells2">
                    <div class="cell">
                        <label>Parent</label>
                        <div class="input-control text full-size">
                            <select name="parent" id="parent">
                                <option value="0">-- ROOT --</option>
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <label>Active</label>
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

        <input type="submit" class="success">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">Cancel</a>
           
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