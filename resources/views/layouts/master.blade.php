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
<div class="loader" style="display:none;">
    <img src="https://thomas.vanhoutte.be/miniblog/wp-content/uploads/light_blue_material_design_loading.gif" alt="">
</div>
<div class="container flex-grid">
    <div class="row flex-align-center flex-just-center loginForm">
        <div class="cell size12">
            <div class="greeting">
                @if(Session::get('name'))
                    <img id="profile_pic" src="{{Auth::user()->thumbnail}}" style="border-radius: 50%; width: 2em; ">
                @endif
                {{ Session::get('name')}}
                @if(Session::get('company_name'))
                    <br>
                    <small>{{ Session::get('company_name') }}</small>
                        
                @endif
            </div>
            <a href="/"><img src="/img/logo.svg" width="500"></a>
@if(Auth::check())
<br>
<a class="button" href="/home">Home</a>
@if( ! Session::has('company') )
<a class="button" href="/companies">Companies</a>
@endif
@if( Session::has('company') )
<a class="button" href="/users">Users</a>
<a class="button" href="/departments">Departments</a>
<a class="button" href="/positions">Positions</a>
<a class="button" href="/priorities">Priorities</a>
@endif
<a class="button btn-primary" id="logout" href="/logout">Logout <span class="mif-icon_name"></span></a>
<a class="button danger restore" href="/regenerate">Restore</a>
@endif
            <hr>


        </div>
    </div>
</div>
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
<script>

$(document).on('click','.restore', function(){
    $('.loader').attr('style','display:block;text-align:center')
});
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
        @if(Session::get('update')['code'] == 200)
            var default_title = 'Success!';
            var type = 'success';
                
        @else
            var default_title = 'An error ocurred';
            var type = 'alert';
        @endif
        var title = default_title;
        @if(isset(Session::get('update')['title']))
            var title = '{{ Session::get('update')['title']  }}';
        @endif
        $.Notify({
        caption:title,
        type:type,
        content: '{{ Session::get('update')['message']  }}',
        keepOpen: true,
        }); 
@endif

$('select').select2();

setTimeout(function(){
    $('select').each(function(d){
        if ($(this).attr("data-selected")) {
            $(this).select2("val", $(this).attr("data-selected"));
        }
    });
},500)
</script>
