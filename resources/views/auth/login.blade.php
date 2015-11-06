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
                <input type="email" name="email" value="ageofzetta@gmail.com">
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
                <input type="checkbox" name="remember"> Remember Me
            </div>

            <div>
            <br>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('#logout').detach()
</script>
@stop