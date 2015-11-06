@extends('layouts.master')

@section('title', '- Inicio')

@section('content')

                

<div id="table"></div>
<hr>
<button class="button success">Add User</button>
<script type="text/babel">

    $.get('api/v0.1/users/', function(){},'json')
    .done(function(d){
        React.render(
            <UserTable list={d.data} />,
            document.getElementById('table')
        );
    });

var UserTr = React.createClass({

    render: function(){
        return (
            <tr>
                <td>{this.props.data.name}</td>
                <td>{this.props.data.lastname}</td>
                <td>{this.props.data.email}</td>
                <td className="center"> <label className="input-control checkbox"> <input type="checkbox"checked={this.props.data.active} /> <span className="check"></span> </label> </td> 
                <td>{this.props.data.position}</td>
                <td> 
                    <button className="button small-button success">Modify</button>
                    &nbsp;
                    <button className="button small-button danger delete_item" data-type="users" data-id={this.props.data.user_id}>Delete</button>
                </td>


            </tr>


        )
    }
});


var UserTable = React.createClass({
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
                        <th>lastname</th>
                        <th>email</th>
                        <th>active</th>
                        <th>position</th>
                        <th>actions</th>

                    </tr>
                </thead>
                <tbody>
                    {this.props.list.map(function(data, i) {
                        return (<UserTr data={data} key={i} />)

                    })}
                </tbody>
            </table>
            );
    }
});
</script>

@stop