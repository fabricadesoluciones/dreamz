@extends('layouts.master')

@section('title', '- Inicio')

@section('content')
<style>
    .feelings{
        display: flex;
        flex-wrap: wrap;
    }
    .feeling{
        width: 200px;
    }
    .feeling svg{
        width: 100%;
        margin-top: 2em;
        margin-bottom: 1em;
    }
    .feeling_name{
        font-weight: bolder;
        text-align: center;
    }
    .feelings {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        width: 90%;
        margin: auto;
        justify-content: center;
    }

    .feelings h1 {
        font-size: 3.5em;
        color: #1283AB;
    }
    .feelings h2 {
        margin: 1ex 0;
        font-size: 1.7em;
        color: #00A185;
    }
</style>

<div class="feelings">
    <h1>{{trans('general.emotions.welcome') }}</h1>
</div>
<div class="feelings">
    <h2>{{trans('general.emotions.pick_one') }}</h2>
</div>
<div class="feelings">
    @foreach ($emotions as $emotion)
        <div class="feeling">
            <a class="select_this_feeling" data-id="id" href="#"><?php include base_path('public/img/emociones/'.$emotion->name.'.svg');?></a>
            <div class="feeling_name"><a class="select_this_feeling" data-id="{{ $emotion->active_emotion_id }}" href="#"> {{trans('general.emotions.'.$emotion->name)}} </a></div>
        </div>
    @endforeach
</div>



<script>
    $(document).on('click','.select_this_feeling', function(){
        return false;
    })
</script>

@stop