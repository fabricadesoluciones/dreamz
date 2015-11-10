<!-- resources/views/auth/password.blade.php -->
@extends('layouts.master')

@section('title', 'Login')

@section('content')
<div class="row flex-align-center flex-just-center loginForm">
    <div class="cell size6">
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
                <button type="submit">
                    Send Password Reset Link
                </button>
            </div>
        </form>
    </div>
</div>
@stop