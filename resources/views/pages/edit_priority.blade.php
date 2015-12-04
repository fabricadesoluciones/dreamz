@extends('layouts.master')

@section('title', '- Edit Priority')

@section('content')
<h2>Edit Priority </h2>
<hr>
</div>
<div class="container">
    {!! Form::model($user, array('route' => array('priorities.update', $id), 'method' => 'PUT')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>Priority ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" name="user_id" value="{!! $id !!}" disabled="disabled">
                        </div>
                    </div>
                    <div class="cell">
                        <label>Name</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value=" {!! $priority->name  !!}"  required="required" />
                        </div>
                    </div>
                </div>
                <div class="row cells2">
                    <div class="cell">
                        <div class="input-control select">
                        <label for="status">Status</label>
                            <select name="status" id="status">
                                <option value="AUTORIZADO">AUTORIZADO</option>
                                <option value="ASIGNADO">ASIGNADO</option>
                                <option value="PENDIENTE">PENDIENTE</option>
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control select">
                        <label for="type">Type</label>
                            <select name="type" id="type">
                                <option value="EMPRESA">EMPRESA</option>
                                <option value="DEPARTAMENTO">DEPARTAMENTO</option>
                                <option value="PERSONAL">PERSONAL</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row cells2">
                    <div class="cell">
                        <div class="input-control select">
                        <label for="period">Periods</label>
                            <select name="period" id="period">
                            @foreach ($periods as $period)
                                <option value="{{$period->period_id}}">{{$period->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control select">
                        <label for="user">Asigned to</label>
                            <select name="user" id="user">
                            @foreach ($users as $user)
                                <option value="{{$user->user_id}}">{{$user->name}} {{$user->lastname}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row cells2">
                    <div class="cell2">
                        <label for="alergies">description</label> <br>
                        <div class="input-control textarea"data-role="input" data-text-auto-resize="true">
                            <textarea cols="80" name="description">{{$priority->description}}</textarea>
                        </div>
                    </div>
                    
                </div>
            </div>
        <input type="hidden" name="company" value="{{$user->company}}">
        <input type="submit" class="success">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">Cancel</a>
           
{!! Form::close() !!}

</div>
<script>
    $('#period option[value="{{ $priority->period }}"]').prop('selected', true);
    $('#user option[value="{{ $priority->user }}"]').prop('selected', true);
    $('#type option[value="{{ $priority->type }}"]').prop('selected', true);
    $('#status option[value="{{ $priority->status }}"]').prop('selected', true);
</script>
@stop