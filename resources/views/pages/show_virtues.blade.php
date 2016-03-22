@extends('layouts.master')

@section('title', trans_choice('general.menu.virtues',2))

@section('content')

                
<h2>{{ trans_choice('general.menu.virtues',2) }} <a href="/virtues/create" class="button success"> {{ trans('general.forms.add_new') }} </a>
@if ( Auth::user()->hasRole('super-admin') || Auth::user()->hasRole('coach') || Auth::user()->hasRole('champion') )
<a href="/review_virtues/" class="button success"> {{ trans('general.review') }} {{trans_choice('general.menu.virtues',2)}} </a>
@endif
</h2>
<div id="table">
    
<table id="datatable" class="table striped hovered cell-hovered border bordered">
                <thead>
                    <tr>
                        <th> {{ trans('general.forms.name')}} </th>
                        <th> {{ trans('general.description')}} </th>
                        <th width="32"> Ícono </th>
                        <th> {{ trans_choice('general.actions',2)}} </th>

                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
</div>
<hr>

<script>

    $.get('{!! route('virtues.index') !!}', function(){},'json')
    .done(function(d){
        if (d.code != 200) {returnNotify('Error al cargar los datos'); return false;}
        var virtues = d.data;

        var rows = '';
        for (var i = 0; i < virtues.length; i++) {
            var virtue = virtues[i];
            image_tag = '';
            if (virtue.public_url) {
                image_tag = '<img src="'+virtue.public_url+'" widht="45" />'
            }
            rows += '<tr> <td>'+virtue.name+'</td> <td>'+virtue.description+'</td>  <td>'+image_tag+'</td> <td> <a href="/virtues/'+virtue.virtue_id+'/edit" class="button success">{{trans('general.modify')}}</a> &nbsp;<button class="button danger delete_item" data-type="virtues" data-id="'+virtue.virtue_id+'">{{trans('general.delete')}}</button> </td> </tr>';

        }

        $('#datatable tbody').append(rows)
        $('#datatable').DataTable();
    });



</script>

@stop