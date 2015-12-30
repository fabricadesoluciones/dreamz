@extends('layouts.master')

@section('title', 'Login')

@section('content')

<div class="login">

    <img src="/img/login-logo.svg" hegiht="294" alt="">
    <div class="relleno">
        <form method="POST" action="/login">
        {!! csrf_field() !!}
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="kreyes@fabricadesoluciones.com" required="required" autofocus="autofocus">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="admin" required="required">
            <div style="text-align:right">
                <p>
                    <button class="button success" type="submit">{{ trans('general.login') }}</button>
                </p>
                <p>
                    <a href="{{ URL::to('password/email') }}">{{ trans('general.forms.forgot_my_password') }}</a>
                </p>

            </div>
        </form>
    </div>

</div>
@stop