@extends('layouts.master')

@section('title', trans_choice('general.measuring_unit', 2))

@section('content')

                
<h2>{{trans_choice('general.measuring_unit', 2)}} <a href="/measuring_units/create" class="button success">{{ trans('general.forms.add_new') }} </a></h2>
<div id="table"></div>
<br style="display:block;clear: both;height: 1px;margin: 1px;width: 1px;">
<br style="display:block;clear: both;height: 1px;margin: 1px;width: 1px;">

<hr>
 
<script type="text/babel">

    $.get('{!! route('measuring_unit.index') !!}', function(){},'json')
    .done(function(d){
        debugger;
        React.render(
            <EducationLevelsTable list={d.data} />,
            document.getElementById('table')
        );
    });
    

var Tr = React.createClass({

    render: function(){
        return (
            <tr>
                <td>{this.props.index + 1}</td>
                <td><span className="name">{this.props.data.name}</span></td>
                <td> 
                    <a href={"/measuring_units/"+this.props.data.measuring_unit_id+"/edit"} className="button success" data-id={this.props.data.measuring_unit_id}>{{trans('general.modify')}}</a>
                    &nbsp;
                    <button className="button danger delete_item" data-type="education_level" data-id={this.props.data.measuring_unit_id}>{{trans('general.delete')}}</button>
                    
                </td>

            </tr>


        )
    }
});

var EducationLevelsTable = React.createClass({
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
                        <th>{{trans('general.forms.name')}}</th>
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