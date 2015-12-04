@extends('layouts.master')

@section('title', '- Priorities')

@section('content')

                
<h2>Priorities</h2>
<div id="table"></div>
<br style="display:block;clear: both;height: 1px;margin: 1px;width: 1px;">
<br style="display:block;clear: both;height: 1px;margin: 1px;width: 1px;">

<hr>
<a href="/priorities/create" class="button success">Add Priority</a>
<div data-role="dialog" data-type="info" id="dialog" data-close-button="true" data-overlay="true" data-overlay-color="black" class="padding10">
    <h1>Register Progress for: </h1>
    <h4 id="priority_name"></h4>
    <div class="grid">
        <div class="row ">
                    <div class="margin10">
                        <label>Priority ID</label>
                        <div class="input-control text full-size">
                            <input id="priority_id" size="65" type="text" value="" disabled="disabled">
                        </div>
                    </div>
                    </div>
        <div class="row ">
                    <div class="margin10">
                        <div class="input-control select">
                        <label for="department">Select Week</label>
                            <select name="week" id="week">
                                <option value="w1">Week 1</option>
                                <option value="w2">Week 2</option>
                                <option value="w3">Week 3</option>
                                <option value="w4">Week 4</option>
                                <option value="w5">Week 5</option>
                                <option value="w6">Week 6</option>
                                <option value="w7">Week 7</option>
                                <option value="w8">Week 8</option>
                                <option value="w9">Week 9</option>
                                <option value="w10">Week 10</option>
                                <option value="w11">Week 11</option>
                                <option value="w12">Week 12</option>
                                <option value="w13">Week 13</option>
                            </select>
                        </div>
                    </div>
                    <div class="margin10">
                        <div class="input-control select">
                        <label for="department">Select Progress</label>
                            <select name="progress" id="progress">
                                <option value="0">Reset</option>
                                <option value="3">No Progress</option>
                                <option value="2">Some Progress</option>
                                <option value="1">Completed</option>
                            </select>
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
                <button class="button success save_progress margin10" style="display: inline-block; margin:  0 1em; ">Save</button>
                <button class="button danger cancel_progress">Cancel</button>
    </div>
</div>
<script>
    function showDialog(id){
        var dialog = $(id).data('dialog');
        dialog.open();
    }
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
                    <a href='#' className="button success register_progress" data-id={this.props.data.priority_id}>Register progress</a>&nbsp;
                    <a href={"/priorities/"+this.props.data.priority_id+"/edit"} className="button success" data-id={this.props.data.priority_id}>Edit</a>
                    &nbsp;
                    <button className="button danger delete_item" data-type="priorities" data-id={this.props.data.priority_id}>Delete</button>
                    
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
                        <th>period</th>
                        <th>name</th>
                        <th>description</th>
                        <th>status</th>
                        <th>asigned to</th>
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