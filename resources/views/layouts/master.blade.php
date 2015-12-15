<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dreamz @yield('title')</title>
    <link href="/metro/css/metro.min.css" rel="stylesheet">
    <link href="/metro/css/metro-icons.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <script src="/js/all.js"></script>
    <script src="/metro/js/metro.min.js"></script>
    <style>
    html,body,section{
        height: 100%;
    }
    

    </style>
</head>
<body>

    <header>
        @include('header')
    </header>
    <section>
            <nav class="main_navigation">
                <ul>
                    <li>item 1</li>
                    <li>item 1</li>
                    <li>item 1</li>
                    <li>item 1</li>
                </ul>
            </nav>
            <article>
                @yield('content')
            <br class="clear">
            </article>
    </section>



{{-- <div class="container flex-grid">
@if (count($errors) > 0)
    <div class="alert alert-danger">
    <h3>Please fix the following:</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

</div> --}}

@include('foot')