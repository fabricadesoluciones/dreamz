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
    </style>
</head>
<body>
<div class="container flex-grid">
    <div class="row flex-align-center flex-just-center loginForm">
        <div class="cell size6">
            <a href="/"><img src="/img/logo.svg" width="500"></a>
@if(Auth::check())
            <a id="logout" href="/logout">Salir <span class="mif-icon_name"></span></a>
@endif
            <hr>


        </div>
    </div>
</div>
<div class="container flex-grid">
    @yield('content')

</div>
<script>
$(document).on('click','.delete_item', function(){
    var doDelete = window.confirm('Do you really want to delete that record?');
    if (doDelete) {

        $.ajax({
            url: '/api/v0.1/'+$(this).attr('data-type')+'/'+$(this).attr('data-id'),
            type: 'post',
            data: {_method: 'delete', _token :'{{ csrf_token() }}'},
            success: function(result) {
                if (result.code == "10") {
                    $.Notify({
                        caption: 'Success!',
                        content: 'Item deleted',
                        type: 'success'
                    });
                    setTimeout(function(){location.reload();},500)
                }
            }
        }); 
    }
})
</script>