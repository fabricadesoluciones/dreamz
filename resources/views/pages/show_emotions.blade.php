@extends('layouts.master')

@section('title', trans_choice('general.menu.emotions', 2))

@section('content')

                
<h2>{{trans_choice('general.menu.emotions', 2)}} </h2>
<div id="table"></div>
<br style="display:block;clear: both;height: 1px;margin: 1px;width: 1px;">
<br style="display:block;clear: both;height: 1px;margin: 1px;width: 1px;">

<hr>
 <script>
 $(document).on("change",".activeitem",function(event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        var ischecked = $(this).is(":checked");
        var emotion_id = $(this).attr('data-id');
        $.post('/set_feeling_enabled/'+emotion_id,{active: ischecked, _token: '{{ csrf_token() }}' }, function(){},'json')
        .done(function(d){
            returnNotify(d.message, d.title, d.type);

        });
    });
 </script>
<script type="text/babel">

    $.get('{!! route('emotion.index') !!}', function(){},'json')
    .done(function(d){
        React.render(
            <EmotionsTable list={d.data} />,
            document.getElementById('table')
        );
    });
    

var Tr = React.createClass({

    render: function(){
        return (
            <tr>
                <td>{this.props.index + 1}</td>
                <td><span className="name">{this.props.data.name}</span></td>
                <td className="center"> <label className="input-control checkbox"> <input type="checkbox" className="activeitem" data-id={this.props.data.active_emotion_id} checked={Boolean(JSON.parse(this.props.data.active))} /> <span className="check"></span> </label> </td> 

            </tr>


        )
    }
});

var EmotionsTable = React.createClass({
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
                        <th>{{trans('general.forms.active')}}</th>
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