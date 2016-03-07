@extends('layouts.master')

@section('title', 'Assessments')

@section('content')

                
<h2>{{ 'Assessments' }} <a href="/assessments/create" class="button success"> {{ trans('general.forms.add_new') }} </a></h2>
<div id="table">
    
<table id="datatable" class="table striped hovered cell-hovered border bordered">
                <thead>
                    <tr>
                        <th> {{ trans('general.forms.name')}} </th>
                        <th> {{ trans_choice('general.menu.users',1)}} </th>
                        <th width="32"> File</th>
                        <th> {{ trans_choice('general.actions',2)}} </th>

                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
</div>
<hr>

<script>

    $.get('{!! route('assessments.index') !!}', function(){},'json')
    .done(function(d){
        var assessments = d.data;

        var rows = '';
        for (var i = 0; i < assessments.length; i++) {
            var assessment = assessments[i]
            rows += '<tr><td>'+assessment.name+'</td> <td>'+assessment.user_name+' '+assessment.user_lastname+'</td> <td align="center" width="32"><a class="download" href="/download/'+assessment.file+'" download="download"> <img src="/img/file.svg" style="max-height:32px" /> </a></td> <td> <button class="button danger delete_item" data-type="assessments" data-id="'+assessment.assessment_id+'">{{trans('general.delete')}}</button> </td></tr>';

        }

        $('#datatable tbody').append(rows)
        $('#datatable').DataTable();
    });



</script>

@stop