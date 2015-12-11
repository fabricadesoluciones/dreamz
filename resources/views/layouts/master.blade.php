<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dreamz @yield('title')</title>
    <link href="/metro/css/metro.min.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <script src="/js/all.js"></script>
    <script src="/metro/js/metro.min.js"></script>
    <style>
    .center{
        text-align: center;
    }
    .greeting{
    display: inline-block;
    float: right;
    margin: 1em;
    font-size: 1.7em;
    font-weight: bolder;
    text-align: right
}
.dialog-overlay{
    opacity: 0.5;
    background-color: #000;
}

    </style>
</head>
<body>
@include('menu')

<div class="container flex-grid">
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
    @yield('content')

</div>
@include('foot')
