@extends('layouts.master')

@section('title', 'Login')

@section('content')

                
<div class="row flex-align-center flex-just-center loginForm">
    <div class="cell size6">
        <form method="POST" action="/login">
            {!! csrf_field() !!}
<br>
            <div class="input-control text" data-role="input">
                <label>Email</label>
                {{-- <input type="email" name="email" value="{{ old('email') }}"> --}}
                <input type="email" name="email" value="kreyes@fabricadesoluciones.com">
                <button class="button helper-button clear"><span class="mif-cross"></span></button>
            </div>
            <br>
            <br>

            <div class="input-control text" data-role="input">
                <label>Password</label>
                <input type="password" name="password" id="password" value="admin">
                <button class="button helper-button clear"><span class="mif-cross"></span></button>
            </div>

            <div>
            <br>
                <a href="{{ URL::to('password/email') }}"> Forgot my password </a>
            <br>
            <br>
            </div>

            <div>
                <button type="submit">Login</button>
            <br>

            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('#logout').detach()
</script>
@stop