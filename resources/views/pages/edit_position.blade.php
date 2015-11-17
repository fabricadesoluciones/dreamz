@extends('layouts.master')

@section('title', '- Edit Position')

@section('content')
<h2>Edit Position 
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
    

{!! Form::model($position, array('route' => array('positions.update', $position->position_id), 'method' => 'PUT')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>position ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $position->position_id !!}" disabled="disabled">
                        </div>
                    </div>
                    <div class="cell">
                        <label>Name</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value="{!! $position->name !!}" >
                        </div>
                    </div>
                </div>
                <div class="row cells2">
                    <div class="cell">
                        <label>Boss</label>
                        <br>
                        <label class="switch" style="padding: 1.2ex 0; ">
                            <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="active" value="{{$position->boss}}" 
                            @if ($position->boss)
                                checked="true"
                            @endif
                            >
                            <span class="check"></span>
                        </label>
                        
                    </div>
                    <div class="cell">
                        <label>Active</label>
                        <br>
                        <label class="switch" style="padding: 1.2ex 0; ">
                            <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="active" value="{{$position->active}}" 
                            @if ($position->active)
                                checked="true"
                            @endif
                            >
                            <span class="check"></span>
                        </label>
                        
                    </div>
                </div>
                
                
                
            </div>

        <input type="submit" class="success">
        <a href="" onclick="window.history.back();" class="button danger">Cancel</a>
           
{!! Form::close() !!}
</div>


@stop