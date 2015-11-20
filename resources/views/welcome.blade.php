@extends('layouts.master')

@section('title', '- Inicio')

@section('content')
<h2>Pick a company</h2>
<div class="companies">
    
</div>


<script type="text/javascript">

    $.get('{!! route('companies.index') !!}', function(){},'json')
    .done(function(d){
        if (d.code == 200){
            var records = d.data;
            records.forEach(function(d,i,a){

                $('.companies').append('<a href="" class="button use_this" data-id="'+d.company_id+'">'+d.commercial_name+'</a> ')
            });
        }
    });
    $(document).on('click','.use_this', function (event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;

        var this_id = $(this).attr('data-id');
        $.get('/set_company/'+this_id, function(d){
            $.Notify({
        
                caption: 'Company changed',
                type: 'success',
                content: d,
                }); 
            setTimeout(function(){
                
            location.reload();
            },500)
        })
        .done(function(d){
            // location.reload();
        });


    
    });
</script>
@stop