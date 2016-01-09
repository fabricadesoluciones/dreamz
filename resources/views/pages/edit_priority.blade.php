@extends('layouts.master')

@section('title', trans('general.edit').' '.trans_choice('general.menu.priorities', 1))

@section('content')
<h2>{{trans('general.edit')}} {{trans_choice('general.menu.priorities', 1)}} </h2>
<hr>
<div>
    {!! Form::model($user, array('route' => array('priorities.update', $id), 'method' => 'PUT')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>Priority ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" name="priority_id" value="{!! $id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value=" {!! $priority->name  !!}"  required="required" />
                        </div>
                    </div>
                </div>
                <div class="row cells2">
                    <div class="cell">
                        <div class="input-control select">
                        <label for="status">{{trans('general.status')}}</label>
                            <select name="status" id="status">
                                <option value="AUTORIZADO">{{trans('general.authorized')}}</option>
                                <option value="ASIGNADO">{{trans('general.asigned')}}</option>
                                <option value="PENDIENTE">{{trans('general.pending')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control select">
                        <label for="type">{{trans_choice('general.types', 2)}}</label>
                            <select name="type" id="type">
                                <option value="EMPRESA">{{trans_choice('general.menu.companies', 1)}}</option>
                                <option value="DEPARTAMENTO">{{trans_choice('general.menu.departments', 1)}}</option>
                                <option value="PERSONAL">{{trans('general.personal')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row cells2">
                    <div class="cell">
                        <div class="input-control select">
                        <label for="period">{{trans_choice('general.menu.periods', 1)}}</label>
                            <select name="period" id="period">
                            @foreach ($periods as $period)
                                <option value="{{$period->period_id}}">{{$period->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control select">
                        <label for="user">{{trans('general.asigned_to')}}</label>
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
                        <label for="alergies">{{trans('general.description')}}</label> <br>
                        <div class="input-control textarea"data-role="input" data-text-auto-resize="true">
                            <textarea cols="80" name="description">{{$priority->description}}</textarea>
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
    $('#period option[value="{{ $priority->period }}"]').prop('selected', true);
    $('#user option[value="{{ $priority->user }}"]').prop('selected', true);
    $('#type option[value="{{ $priority->type }}"]').prop('selected', true);
    $('#status option[value="{{ $priority->status }}"]').prop('selected', true);
</script>
@stop