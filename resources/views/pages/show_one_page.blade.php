@extends('layouts.master')

@section('title', 'One Page')

@section('content')

                
<h2>One Page
    @if(Auth::user()->can('edit-one_page'))
        <a href="/one_page/create" class="button success"> {{ trans('general.forms.add_new') }} </a>
    @endif
</h2>

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
        React.render(
            <OnePageTable list={d.data} />,
            document.getElementById('table')
        );
    });
    

var Tr = React.createClass({

    render: function(){
        return (
            <tr>
                <td>{this.props.index + 1}</td>
                @if(Auth::user()->can('edit-one_page'))
                    <td> 
                        <a href={"/one_page/"+this.props.data.one_page_id+"/edit"} className="button success">{{trans('general.modify')}}</a>
                        &nbsp;
                        <button className="button danger delete_item" data-type="onepages" data-id={this.props.data.one_page_id}>{{trans('general.delete')}}</button>
                    </td>
                @else
                    <td> 
                        <a href={"/one_page/"+this.props.data.one_page_id+"/edit"} className="button success">{{trans('general.modify')}} {{trans_choice('general.mine',1)}} One Page</a>
                    </td>
                @endif
            </tr>


        )
    }
});

var OnePageTable = React.createClass({
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