@extends('layouts.master')

@section('title', trans_choice('general.menu.tasks', 2))

@section('content')

                
<h2> {{ trans_choice('general.menu.tasks', 2) }} <a href="/tasks/create" class="button success"> {{ trans('general.forms.add_new') }} </a></h2>
<div id="table"></div>
<hr>
<script type="text/babel">

    $.get('{!! route('task.index') !!}', function(){},'json')
    .done(function(d){
        d.data.forEach(function(d,i,a){


            d.done = false;
            if (d.status == 'TERMINADO') {
                d.text_due = 'fg-grayDark';
                d.done =  moment(d.updated_at).format("DD/MM/YYYY");

            }else{
                if(moment(d.due_date).isBefore(moment())){
                    d.text_due = 'fg-darkRed';
                }else if (moment(d.due_date).isAfter(moment().add(3, 'days'))){
                    d.text_due = 'fg-emerald';
                }else{
                    d.text_due = 'fg-yellow';
                }
            }
            d.due_date = moment(d.due_date).format("DD/MM/YYYY");

        });
        React.render(
            <CompanyTable list={d.data} />,
            document.getElementById('table')
        );
    });

var Tr = React.createClass({
getInitialState: function() {


    if ( ! this.props.data.done) {
    this.props.data.done = 'NO COMPLETADO';
    } 
    return {
        data: this.props.data
    };
  },
    render: function(){
        return (
            <tr>
                <td>{this.props.index + 1}</td>
                <td className={this.props.data.text_due}><strong> {this.props.data.due_date}</strong></td>
                <td>{this.props.data.name}</td>
                <td>{this.props.data.description}</td>
                <td>{this.props.data.user_name} {this.props.data.user_lastname}</td>
                <td>{this.props.data.status}</td>
                <td>{this.props.data.done}</td>
                <td>{this.props.data.priority}</td>
                
                    <td> 
                        <a href={"/tasks/"+this.props.data.task_id+"/edit"} className="button success">{{trans('general.modify')}}</a>
                        &nbsp;
                        <button className="button danger delete_item" data-type="task" data-id={this.props.data.task_id}>{{trans('general.delete')}}</button>
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
    componentDidMount: function() {
    
        $('#datatable').DataTable();
    },
    render: function() {
        return (
            <table id="datatable" className="table striped hovered cell-hovered border bordered">
                <thead>
                    <tr>
                        <th> # </th>
                        <th>Fecha límite</th>
                        <th>{{ trans_choice('general.menu.tasks', 1) }}</th>
                        <th>{{ trans('general.description') }}</th>
                        <th>{{ trans_choice('general.menu.users', 1) }}</th>
                        <th>Status</th>
                        <th>{{ trans('general.forms.completed_on') }}</th>
                        <th>{{ trans_choice('general.menu.priorities', 1) }}</th>
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