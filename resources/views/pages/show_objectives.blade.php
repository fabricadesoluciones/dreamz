@extends('layouts.master')

@section('title', trans_choice('general.menu.objectives', 2))

@section('content')

                
<h2> {{ trans_choice('general.menu.objectives', 2) }} <a href="/objectives/create" class="button success"> {{ trans('general.forms.add_new') }} </a>
@if ( Auth::user()->hasRole('super-admin') || Auth::user()->hasRole('coach') || Auth::user()->hasRole('champion') )
<a href="/objective_category/create" class="button success"> {{ trans('general.forms.add_new') }} {{trans_choice('general.categories',1)}} </a>
<a href="/objective_subcategory/create" class="button success"> {{ trans('general.forms.add_new') }} {{trans_choice('general.subcategories',1)}}</a>
@endif
</h2>
<div id="table"></div>
<hr>
<script type="text/babel">

    $.get('{!! route('objectives.index') !!}', function(){},'json')
    .done(function(d){
        React.render(
            <CompanyTable list={d.data} />,
            document.getElementById('table')
        );
    });

var Tr = React.createClass({

    render: function(){
        return (
            <tr>
                <td>{this.props.index + 1}</td>
                <td>{this.props.data.name}</td>
                <td>{this.props.data.description}</td>
                <td>{this.props.data.measuring_unit_name}</td>
                <td>{this.props.data.user_name} {this.props.data.user_lastname}</td>
                
                @if(Auth::user()->can('edit-objectives'))
                    <td width="300"> 
                        <a href={"/objectives/"+this.props.data.objective_id+"/edit"} className="button success">{{trans('general.modify')}}</a>
                        &nbsp;
                        <button className="button danger delete_item" data-type="objectives" data-id={this.props.data.objective_id}>{{trans('general.delete')}}</button>
                    </td>
                @endif

            </tr>


        )
    }
});

var CompanyTable = React.createClass({
    getInitialState: function() {
        return {
            data: this.props.data
        };
    },
    componentDidMount: function() {
    
        $('#datatable').DataTable();
    },
    render: function() {
        return (
            <table id="datatable" className="table striped hovered cell-hovered border bordered">
                <thead>
                    <tr>
                        <th> # </th>
                        <th>{{ trans_choice('general.menu.objectives', 1) }}</th>
                        <th>{{ trans('general.description') }}</th>
                        <th> Unidad </th>
                        <th>{{ trans_choice('general.menu.users', 1) }}</th>
                        @if(Auth::user()->can('edit-objectives'))
                            <th> {{ trans_choice('general.actions',2)}} </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    {this.props.list.map(function(data, i) {

                        return (<Tr data={data} index={i} />)
                    })}
                </tbody>
            </table>
            );
    }
});
</script>

@stop