@extends('layouts.master')

@section('title', trans_choice('general.menu.companies', 2))

@section('content')
<style>
    article .company_logo{
     display:block; max-height:50px;
     margin: auto;
    }
</style>
                
<h2>{{ trans_choice('general.menu.companies', 2) }} <a href="/companies/create" class="button success"> {{ trans('general.forms.add_new') }} </a></h2>
<div id="table"></div>
<hr>
<script type="text/babel">

    $.get('{!! route('companies.index') !!}', function(){},'json')
    .done(function(d){
        React.render(
            <CompanyTable list={d.data} />,
            document.getElementById('table')
        );
    });

var Tr = React.createClass({

    render: function(){
        return (
            <tr>
                <td>{this.props.index + 1}</td>
                <td>{this.props.data.commercial_name}</td>
                <td className="center"> <label className="input-control checkbox"> <input type="checkbox" checked={Boolean(JSON.parse(this.props.data.active))} /> <span className="check"></span> </label> </td> 
                <td className="center"><img className="company_logo" src={this.props.data.logo} /></td>
                @if(Auth::user()->can('edit-companies'))
                    <td> 
                        <a href={"/companies/"+this.props.data.company_id+"/edit"} className="button success">{{trans('general.modify')}}</a>
                        &nbsp;
                        <button className="button warning delete_item" data-type="companies" data-id={this.props.data.company_id}>{{trans('general.disable')}}</button>
                        &nbsp;
                        <a href={"/set_company/"+this.props.data.company_id} className="button use_this" data-type="companies" data-id={this.props.data.company_id}>{{trans_choice('general.select_this', 2)}}</a>
                    </td>
                @endif

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
    render: function() {
        return (
            <table className="table striped hovered cell-hovered border bordered">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> {{ trans('general.forms.commercial_name')}} </th>
                        <th> {{ trans('general.active')}} </th>
                        <th>logo</th>
                        @if(Auth::user()->can('edit-companies'))
                            <th> {{ trans_choice('general.actions',2)}} </th>
                        @endif
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
// $(document).on('click','.use_this', function (event) {
//         event.preventDefault ? event.preventDefault() : event.returnValue = false;

//         var this_id = $(this).attr('data-id');
//         $.get('/set_company/'+this_id, function(d){
//             $.Notify({
        
//                 caption: 'Company changed',
//                 type: 'success',
//                 content: d,
//                 }); 
//             setTimeout(function(){
                
//             location.reload();
//             },500)
//         })
//         .done(function(d){
//             // location.reload();
//         });


    
//     });
</script>

@stop