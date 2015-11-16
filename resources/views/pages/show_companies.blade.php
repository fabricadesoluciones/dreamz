@extends('layouts.master')

@section('title', '- Companies')

@section('content')

                
<h2>Companies</h2>
<div id="table"></div>
<hr>
<button class="button success">Add Company</button>
<script type="text/babel">

    $.get('{!! route('companies.index') !!}', function(){},'json')
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
                <td>{this.props.data.commercial_name}</td>
                <td className="center"> <label className="input-control checkbox"> <input type="checkbox"checked={this.props.data.active} /> <span className="check"></span> </label> </td> 
                <td className="center"><img src="http://placehold.it/200x50" /></td>
                <td> 
                    <a href={"/companies/"+this.props.data.company_id+"/edit"} className="button success">Modify</a>
                    &nbsp;
                    <button className="button small-button danger delete_item" data-type="companies" data-id={this.props.data.company_id}>Delete</button>
                    &nbsp;
                    <a href={"/companies/"+this.props.data.company_id+"/users"} className="button" data-type="companies" data-id={this.props.data.company_id}>Users</a>
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
                        <th>name</th>
                        <th>commercial_name</th>
                        <th>active</th>
                        <th>logo</th>
                        <th>actions</th>
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