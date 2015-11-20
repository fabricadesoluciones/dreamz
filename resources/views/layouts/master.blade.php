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
                    <img id="profile_pic"  style="border-radius: 50%; width: 2em; ">
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
@endif
<a class="button btn-primary" id="logout" href="/logout">Logout <span class="mif-icon_name"></span></a>
<a class="button danger restore" href="/regenerate">Restore</a>
@endif
            <hr>


        </div>
    </div>
</div>
<div class="container flex-grid">
    @yield('content')

</div>
<script>
    $.ajax({
      url: 'https://randomuser.me/api/',
      dataType: 'json',
      success: function(data){
        var pic_src = data.results[0].user.picture.thumbnail;
        $('#profile_pic').attr('src', pic_src)

      }
    });

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
