@extends('layouts.master')

@section('title', trans_choice('general.menu.virtues',2))

@section('content')

                
<h2>{{ trans_choice('general.menu.virtues',2) }} <a href="/assessments/create" class="button success"> {{ trans('general.forms.add_new') }} </a></h2>
<div id="table">
    
<table id="datatable" class="table striped hovered cell-hovered border bordered">
                <thead>
                    <tr>
                        <th> {{ trans_choice('general.menu.virtues',2)}} </th>
                        <th> {{ trans_choice('general.types',1)}} </th>
                        <th width="450">Story</th>
                        <th> Quién otorga </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($received_virtues as $virtue)
                        <tr>
                            <td>
                                <img src="{{$virtue->public_url}}" alt="{{$virtue->virtue_name}}" style="max-height: 80px;max-width: 80px;" />
                            </td>
                            <td>{{$virtue->virtue_type}}
                            </td>
                            <td>
                                {{$virtue->story}}
                            </td>
                            <td>
                                {{$virtue->user_name}} {{$virtue->user_lastname}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
</div>
<hr>

<script>
        $('#datatable').DataTable();
    
</script>
@stop