@extends('layouts.master')

@section('title', '- Users')

@section('content')

                
<h2>Users <a href="/users/create" class="button success">Add new</a></h2>
<div id="table"></div>
<hr>

<script type="text/babel">

    $.get('{!! route('users.index') !!}', function(){},'json')
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
                <td>{this.props.data.position_name}</td>
                <td>{this.props.data.department_name}</td>
                <td> 
                    <a href={"/users/"+this.props.data.user_id+"/edit"} className="button success">Modify</a>
                    &nbsp;
                    <button className="button danger delete_item" data-type="users" data-id={this.props.data.user_id}>Delete</button>
                </td>
                <td className="center"> <label className="input-control checkbox"> <input type="checkbox" checked={Boolean(JSON.parse(this.props.data.active))} /> <span className="check"></span> </label> </td> 


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
    componentDidMount: function() {
    
        $('#datatable').DataTable();
    },
    render: function() {
        return (
            <table id="datatable" className="table striped hovered cell-hovered border bordered">
                <thead>
                    <tr>
                        <th>name</th>
                        <th>lastname</th>
                        <th>position</th>
                        <th>area</th>
                        <th>actions</th>
                        <th>active</th>

                    </tr>
                </thead>
                <tbody>
                    {this.props.list.map(function(data, i) {
                        if (data.user_id) {
                            return (<UserTr data={data} key={i} />)
                        }

                    })}
                </tbody>
            </table>
            );
    }
});
</script>

@stop