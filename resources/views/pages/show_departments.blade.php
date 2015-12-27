@extends('layouts.master')

@section('title', trans_choice('general.menu.departments', 2))

@section('content')

                
<h2> {{ trans_choice('general.menu.departments', 2) }} </h2>
<div id="table"></div>
<hr>
<button class="button success">{{ trans('general.forms.add_new') }}</button>
<script type="text/babel">

    $.get('{!! route('departments.index') !!}', function(){},'json')
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
                <td> 
                    <a href={"/departments/"+this.props.data.department_id+"/edit"} className="button success">{{trans('general.modify')}}</a>
                    &nbsp;
                    <button className="button warning delete_item" data-type="departments" data-id={this.props.data.department_id}>{{trans('general.disable')}}</button>
                    
                </td>

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
    render: function() {
        return (
            <table className="table striped hovered cell-hovered border bordered">
                <thead>
                    <tr>


                        
                        <th> {{ trans('general.forms.name')}} </th>
                        <th>{{ trans_choice('general.menu.companies', 1) }}</th>
                        <th> {{ trans('general.active')}} </th>
                        <th> {{ trans_choice('general.actions',2)}} </th>
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