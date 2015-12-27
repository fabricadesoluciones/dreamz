<!-- FOOTER -->

<div class="loader" style="display:none;">
    {{-- <img src="https://thomas.vanhoutte.be/miniblog/wp-content/uploads/light_blue_material_design_loading.gif" alt=""> --}}
</div>

<script>

$(document).on('click','.restore', function(){
    $('.loader').attr('style','display:block;text-align:center')
});
$(document).on('click','.delete_item', function(){
    var doDelete = window.confirm('{{trans('general.confirm_delete')}}');
    if (doDelete) {

        $.ajax({
            url: '/api/v1.0/'+$(this).attr('data-type')+'/'+$(this).attr('data-id'),
            type: 'post',
            data: {_method: 'delete', _token :'{{ csrf_token() }}'},
            success: function(result) {
                
            }
        }); 
    }
})
@if( Session::has('update') )
        @if(Session::get('update')['code'] == 200)
            var default_title = '{{trans('general.success')}}';
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
$( document ).ajaxComplete(function( event,request, settings ) {
    debugger;
    if (request.status == 200) {
        return;
    }
    if (request.status == 204) {
        $.Notify({
            caption: '{{trans('general.success')}}',
            content: '{{trans('general.http.204')}} / {{trans('general.http.204b')}}',
            type: 'success'
        });
        setTimeout(function(){location.reload();},1200)
    }else if(request.status == 403) {
        $.Notify({
            caption:'Forbidden',
            type:'alert',
            content: request.responseJSON.message,
            keepOpen: true,
        }); 

    } else {

    $.Notify({
        caption:'An error ocurred: Error ' + request.responseJSON.code,
        type:'alert',
        content: request.responseJSON.message,
        keepOpen: true,
        }); 
  }
});

</script>
<!-- FOOTER -->