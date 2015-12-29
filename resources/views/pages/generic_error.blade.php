@extends('layouts.master')

@section('title', '- Error')

@section('content')
<hr>
<div>
    <h1>Error
    @if(isset(Session::get('update')['message']))
        {{ Session::get('update')['code']  }}
     @endif
    </h1>
    <hr>
    @if( Session::has('update') )

        @if(isset(Session::get('update')['title']))
            <h2>{{ Session::get('update')['title']  }}</h2>
        @endif
        @if(isset(Session::get('update')['message']))
        <br>
            <h3>{{ Session::get('update')['message']  }}</h3>
        @endif

        
    @endif
</div>

@stop