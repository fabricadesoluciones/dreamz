@extends('layouts.master')

@section('title', trans('general.edit').' '.trans_choice('general.menu.tasks', 1))

@section('content')
<h2>{{trans('general.edit')}} {{trans_choice('general.menu.tasks', 1)}} </h2>
<hr>
<div>
    

{!! Form::model($task, array('route' => array('task.update', $task->task_id), 'method' => 'PUT')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>Period ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" name="task_id"  value="{!! $task->task_id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value="{!! $task->name !!}" >
                        </div>
                    </div>
                    
                </div>
                <div class="row cells1">
                    <div class="cell">
                    <label for="description">{{trans('general.description')}}</label> <br>
                    <div class="input-control textarea"data-role="input" data-text-auto-resize="true">
                        <textarea cols="80" name="description">{{$task->description}}</textarea>
                    </div>
                </div>
                </div>
                <div class="row cells3">
                    <div class="cell">
                        <div class="input-control select">
                        <label for="type">{{trans_choice('general.menu.priorities', 1)}}</label>
                            <select name="priority" id="priority" data-selected="{{$task->priority}}">
                            <option value="ALTA">ALTA</option>
                            <option value="MEDIA">MEDIA</option>
                            <option value="BAJA">BAJA</option>
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control select">
                        <label for="type">Status</label>
                            <select name="status" id="status" data-selected="{{$task->status}}">
                                <option value="ASIGNADO">ASIGNADO</option>
                                <option value="CANCELADO">CANCELADO</option>
                                <option value="COMENZANDO">COMENZANDO</option>
                                <option value="EN PROCESO">EN PROCESO</option>
                                <option value="TERMINADO">TERMINADO</option>
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control select">
                        <label for="user">{{trans('general.asigned_to')}}</label>
                            <select name="owner" id="owner" data-selected="{{$task->owner}}">
                            @foreach ($owners as $owner)
                                <option value="{{$owner->user_id}}">{{$owner->name}} {{$owner->lastname}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row cells3">
                    <div class="cell">
                        <div class="input-control select" style="height:auto">
                        <label for="user">Participantes</label>
                            <select multiple>
                            @foreach ($all_dept_users as $all_dept_user)
                                <option value="{{$all_dept_user->user_id}}">{{$all_dept_user->name}} {{$all_dept_user->lastname}}</option>
                            @endforeach
                            </select>

                        </div>

                    </div>
                    <div class="cell">
                        <label>Fecha límite</label> <br>
                        <div class="input-control text">
                            <input name="due_date" type="date" value="{{$task->due_date}}" required="required">
                        </div>
                    </div>

                </div>
                
                
                
            </div>
            <br class="clear-float">

        <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">{{trans('general.forms.cancel')}}</a>
           
{!! Form::close() !!}
</div>



@stop