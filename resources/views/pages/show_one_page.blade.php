@extends('layouts.master')

@section('title', 'One Page')

@section('content')

                
<h2>One Page <a href="/one_page/create" class="button success"> {{ trans('general.forms.add_new') }} </a></h2>
<div id="table"></div>
<br style="display:block;clear: both;height: 1px;margin: 1px;width: 1px;">
<br style="display:block;clear: both;height: 1px;margin: 1px;width: 1px;">
<style>
    .emotion_list_img{
        height: 3em !important;
    }

</style>
<hr>
<script type="text/babel">

    $.get('{!! route('onepages.index') !!}', function(){},'json')
    .done(function(d){
        console.log(d);
        {{-- React.render(
            <EmotionsTable list={d.data} />,
            document.getElementById('table')
        ); --}}
    });
    

var Tr = React.createClass({

    render: function(){
        return (
            <tr>
                <td>{this.props.index + 1}</td>
                <td><span className="name">{this.props.data.name}</span></td>
                <td> <img className="emotion_list_img" src={'/img/emociones/'+this.props.data.name+'.svg'} height="25" /></td>
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
                        <th>Ícono</th>
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