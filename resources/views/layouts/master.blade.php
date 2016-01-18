<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dreamz - @yield('title')</title>
    <link href="/metro/css/metro.min.css" rel="stylesheet">
    <link href="/metro/css/metro-icons.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <script src="/js/all.js"></script>
    <script src="/metro/js/metro.min.js"></script>
    
</head>
<body>
    <div id="wrapper">
        
        @if(Auth::check())
            <header>
                @include('header')
            </header>
            <div class="gradient"></div>
            
        @endif
        <section>
            @if(Auth::check())
                @include('menu')
            @endif

        <article>
            @if (count($errors) > 0)
                <div class="validation_error">
                <h3>{{trans('general.forms.validation_error') }}</h3>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li> - {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
             @yield('content')
        <br class="clear">
        </article>
        </section>




    </div>
@include('foot')