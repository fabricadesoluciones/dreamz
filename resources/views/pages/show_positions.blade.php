@extends('layouts.master')

@section('title', trans_choice('general.menu.positions', 2))

@section('content')

                
<h2> {{ trans_choice('general.menu.positions', 2) }} <a href="/positions/create" class="button success"> {{ trans('general.forms.add_new') }} </a></h2>
<div id="table"></div>
<hr>
<script type="text/babel">

    $.get('{!! route('positions.index') !!}', function(){},'json')
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
                <td>{this.props.data.name}</td>
                <td>{this.props.data.company_name}</td>
                <td className="center"> <label className="input-control checkbox"> <input type="checkbox" checked={Boolean(JSON.parse(this.props.data.active))} /> <span className="check"></span> </label> </td> 
                <td className="center"> <label className="input-control checkbox"> <input type="checkbox" checked={Boolean(JSON.parse(this.props.data.boss))} /> <span className="check"></span> </label> </td> 
                @if(Auth::user()->can('edit-positions'))
                    <td> 
                        <a href={"/positions/"+this.props.data.position_id+"/edit"} className="button success">{{trans('general.modify')}}</a>
                        &nbsp;
                        <button className="button warning delete_item" data-type="positions" data-id={this.props.data.position_id}>{{trans('general.disable')}}</button>
                        
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
            <table className="table striped hovered cell-hovered border bordered">
                <thead>
                    <tr>
                        <th> {{ trans('general.forms.name')}} </th>
                        <th>{{ trans_choice('general.menu.companies', 1) }}</th>
                        <th> {{ trans('general.active')}} </th>
                        <th>{{trans('general.boss')}}</th>
                        @if(Auth::user()->can('edit-positions'))
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