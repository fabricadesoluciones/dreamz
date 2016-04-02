@extends('layouts.master')

@section('title', trans_choice('general.menu.priorities', 2))

@section('content')

                
<h2>{{ trans_choice('general.menu.priorities', 2) }} <a href="/priorities/create" class="button success"> {{ trans('general.forms.add_new') }} </a></h2>
<div id="table"></div>
<br style="display:block;clear: both;height: 1px;margin: 1px;width: 1px;">
<br style="display:block;clear: both;height: 1px;margin: 1px;width: 1px;">

<hr>

<div data-role="dialog" data-type="info" id="dialog" data-close-button="true" data-overlay="true" data-overlay-color="black" class="padding10">
    <h1>{{trans('general.register_progress')}}:</h1>
    <h4 id="priority_name"></h4>
    <div class="grid">
        <div class="row ">
                    <div class="margin10">
                        <label>Priority ID</label>
                        <div class="input-control text full-size">
                            <input id="priority_id" size="65" type="text" value="" readonly="readonly">
                        </div>
                    </div>
                    </div>
        <div class="row ">
                    <div class="margin10">
                        <div class="input-control select">
                        <label for="department">{{trans('general.select_week')}}</label>
                            <select name="week" id="week">
                                <option value="w1">{{trans('general.week')}} 1</option>
                                <option value="w2">{{trans('general.week')}} 2</option>
                                <option value="w3">{{trans('general.week')}} 3</option>
                                <option value="w4">{{trans('general.week')}} 4</option>
                                <option value="w5">{{trans('general.week')}} 5</option>
                                <option value="w6">{{trans('general.week')}} 6</option>
                                <option value="w7">{{trans('general.week')}} 7</option>
                                <option value="w8">{{trans('general.week')}} 8</option>
                                <option value="w9">{{trans('general.week')}} 9</option>
                                <option value="w10">{{trans('general.week')}} 10</option>
                                <option value="w11">{{trans('general.week')}} 11</option>
                                <option value="w12">{{trans('general.week')}} 12</option>
                                <option value="w13">{{trans('general.week')}} 13</option>
                            </select>
                        </div>
                    </div>
                    <div class="margin10">
                        <div class="input-control select">
                        <label for="department">{{trans('general.select_progress')}}</label>
                            <select name="progress" id="progress">
                                <option value="0">Reset</option>
                                <option value="3">{{trans('general.priorities.verde')}}</option>
                                <option value="2">{{trans('general.priorities.amarillo')}}</option>
                                <option value="1">{{trans('general.priorities.rojo')}}</option>
                                <option value="4">{{trans('general.priorities.azul')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
                <button class="button success save_progress margin10" style="display: inline-block; margin:  0 1em; ">{{trans('general.forms.submit')}}</button>
                <button class="button danger cancel_progress">{{trans('general.forms.cancel')}}</button>
    </div>
</div>
<script>
    
    $(document).on("click",".register_progress",function(event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        $('#progress option:eq(1)').attr('selected','selected');
        $('#priority_id').val($(this).attr('data-id'));
        var name = $(this).parent().parent().find('.name').text();
        $('#priority_name').text(name);
        showDialog('#dialog');
    });

    $(document).on("click",".cancel_progress",function(event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        $('.dialog-close-button').click();
    });

    $(document).on("click",".save_progress",function(event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        var data = {};
        var priority_id = $('#priority_id').val();
        var token = $('input[name="_token"]').val();
        data.week = $('#week').val();
        data.progress = $('#progress').val();
        $.ajax({
            type: 'PUT',
            url: '{!! route('priorities.index') !!}/'+priority_id,
            data: {
                "_token": token,
                "data": data,
                "progress": true,
            },
            success: function(data) {
                $.Notify({
                    caption: data.message,
                    type: 'success',
                    content: data.data,
                    keepOpen: false,
                }); 
                $('.dialog-close-button').click();

            },
            error: function() {

            }
        });





    });
</script>
<script type="text/babel">

    $.get('{!! route('priorities.team') !!}', function(){},'json')
    .done(function(d){
        React.render(
            <PrioritiesTable list={d.data} />,
            document.getElementById('table')
        );
    });
    

var Tr = React.createClass({

    render: function(){
        return (
            <tr>
                <td>{this.props.index + 1}</td>
                <td><span className="period">{this.props.data.period_name}</span></td>
                <td><span className="name">{this.props.data.name}</span></td>
                <td width="150">{this.props.data.description}</td>
                <td>{this.props.data.status}</td>
                <td>{this.props.data.user_name} {this.props.data.user_lastname}</td>
                <td> 
                    <a href='#' className="button success register_progress" data-id={this.props.data.priority_id}>{{trans('general.register_progress')}}</a>&nbsp;
                    <a href={"/priorities/"+this.props.data.priority_id+"/edit"} className="button success" data-id={this.props.data.priority_id}>{{trans('general.edit')}}</a>
                    &nbsp;
                    <button className="button danger delete_item" data-type="priorities" data-id={this.props.data.priority_id}>{{trans('general.delete')}}</button>
                    
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
    componentDidMount: function() {
    
        $('#datatable').DataTable();
    },
    render: function() {
        return (
            <table id="datatable" className="table striped hovered cell-hovered border bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{trans_choice('general.menu.priorities', 1)}}</th>
                        <th>{{trans('general.forms.name')}}</th>
                        <th>{{trans('general.description')}}</th>
                        <th>{{trans('general.status')}}</th>
                        <th>{{trans('general.asigned_to')}}</th>
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