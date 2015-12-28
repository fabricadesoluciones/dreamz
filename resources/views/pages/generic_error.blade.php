@extends('layouts.master')

@section('title', '- Error')

@section('content')
<hr>
<div>
    <h1>An error Ocurred</h1>
    @if( Session::has('update') )
        @if(isset(Session::get('update')['title']))
            <strong>{{ Session::get('update')['title']  }}</strong>
        @endif
        @if(isset(Session::get('update')['message']))
        <br>
            <p>{{ Session::get('update')['message']  }}</p>
        @endif

        
    @endif
</div>

@stop