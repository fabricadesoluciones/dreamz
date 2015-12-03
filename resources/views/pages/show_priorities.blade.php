@extends('layouts.master')

@section('title', '- Priorities')

@section('content')

                
<h2>Priorities</h2>
<div id="table"></div>
<hr>
<button class="button success">Add Priority</button>
<script type="text/babel">

    $.get('{!! route('priorities.index') !!}', function(){},'json')
    .done(function(d){
        debugger;
        React.render(
            <PrioritiesTable list={d.data.priorities} />,
            document.getElementById('table')
        );
    });

var Tr = React.createClass({

    render: function(){
        return (
            <tr>
                <td>{this.props.index + 1}</td>
                <td>{this.props.data.period}</td>
                <td>{this.props.data.name}</td>
                <td>{this.props.data.description}</td>
                <td>{this.props.data.status}</td>
                <td> 
                    <a href={"/priority/"+this.props.data.priority_id+"/edit"} className="button success">Modify</a>
                    
                </td>

            </tr>


        )
    }
});

var PrioritiesTable = React.createClass({
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
                        <th>#</th>
                        <th>period</th>
                        <th>name</th>
                        <th>description</th>
                        <th>status</th>
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