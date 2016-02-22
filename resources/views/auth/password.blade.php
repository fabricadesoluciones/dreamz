@extends('layouts.master')

@section('title', 'Login')

@section('content')

<div class="login">

    <img src="/img/login-logo.svg" hegiht="294" alt="">
    <div class="relleno">
        <form method="POST" action="/password/email">
            {!! csrf_field() !!}

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
            <br>
                <button class="button success" type="submit">
                    Send Password Reset Link
                </button>
            </div>
        </form>
    </div>
    </div>

</div>
@stop