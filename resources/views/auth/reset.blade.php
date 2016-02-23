@extends('layouts.master')

@section('title', 'Login')

@section('content')

<div class="login">

    <img src="/img/login-logo.svg" hegiht="294" alt="">
    <div class="relleno">
        <form method="POST" action="/password/reset">
            {!! csrf_field() !!}
            <input type="hidden" name="token" value="{{ $token }}">

            @if (count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div>
                Email
                <input type="email" name="email" value="{{ old('email') }}">
            </div>

            <div>
                Password
                <input type="password" name="password">
            </div>

            <div>
                Confirm Password
                <input type="password" name="password_confirmation">
            </div>

            <div>
                <button type="submit" class="button success">
                    Reset Password
                </button>
            </div>
        </form>
    </div>

</div>
@stop