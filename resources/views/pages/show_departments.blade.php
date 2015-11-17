@extends('layouts.master')

@section('title', '- Departments')

@section('content')

                
<h2>Departments</h2>
<div id="table"></div>
<hr>
<button class="button success">Add Department</button>
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
                    <a href={"/departments/"+this.props.data.department_id+"/edit"} className="button success">Modify</a>
                    &nbsp;
                    <button className="button warning delete_item" data-type="departments" data-id={this.props.data.department_id}>Disable</button>
                    
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
                        <th>company</th>
                        <th>active</th>
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