@extends('layouts.master')

@section('title', trans_choice('general.menu.dreams', 2))

@section('content')

                
<h2>{{trans_choice('general.menu.dreams', 2)}} <a href="/dreams/create" class="button success">{{ trans('general.forms.add_new') }} </a></h2>
<div id="table"></div>
<br style="display:block;clear: both;height: 1px;margin: 1px;width: 1px;">
<br style="display:block;clear: both;height: 1px;margin: 1px;width: 1px;">

<hr>

<script type="text/babel">

    $.get('{!! route('dreams.index') !!}', function(){},'json')
    .done(function(d){
        debugger;
        React.render(
            <DreamsTable list={d.data} />,
            document.getElementById('table')
        );
    });
    

var Tr = React.createClass({

    render: function(){
        return (
            <tr>
                <td>{this.props.index + 1}</td>
                <td><span className="name">{this.props.data.description}</span></td>
                <td> 
                    <a href={"/dreams/"+this.props.data.dreams_id+"/edit"} className="button success" data-id={this.props.data.dreams_id}>{{trans('general.modify')}}</a>
                    &nbsp;
                    <button className="button danger delete_item" data-type="dreams" data-id={this.props.data.dreams_id}>{{trans('general.delete')}}</button>
                    
                </td>

            </tr>


        )
    }
});

var DreamsTable = React.createClass({
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
                        <th>#</th>
                        <th>{{trans_choice('general.menu.dreams', 1)}}</th>
                        <th>{{trans_choice('general.actions', 2)}}</th>
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