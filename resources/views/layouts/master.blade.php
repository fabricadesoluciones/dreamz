<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>App Name - @yield('title')</title>
    <link href="/metro/css/metro.min.css" rel="stylesheet">
    <link href="/css/styles.css" rel="stylesheet">
</head>
<body>
    
<div class="container flex-grid">
        @yield('content')
</div>

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="/metro/js/metro.min.js"></script>
