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
<br>
<a class="button" href="/home">Home</a>
<a class="button" href="/users">Users</a>

@if( ! Session::has('company') )
<a class="button" href="/companies">Companies</a>
@endif

<a class="button" href="/departments">Departments</a>
<a class="button" href="/positions">Positions</a>
<a class="button btn-primary" id="logout" href="/logout">Logout <span class="mif-icon_name"></span></a>
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
            url: '/api/v1.0/'+$(this).attr('data-type')+'/'+$(this).attr('data-id'),
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
@if( Session::has('update') )
console.log('has update;')
        $.Notify({
        
        @if(Session::get('update')['code'] == 200)
            caption: 'Success!',
            type: 'success',
                
        @else
            caption: 'An error ocurred',
            type: 'alert',
        @endif
        content: '{{ Session::get('update')['message']  }}',
        keepOpen: true,
        }); 
@endif
</script>