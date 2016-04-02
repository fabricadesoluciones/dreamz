@extends('layouts.master')

@section('title', trans_choice('general.menu.users', 2))

@section('content')

                
<h2>{{ trans_choice('general.menu.users', 2) }} </h2>
<div id="table"></div>
<hr>

@if($virtues)
<div data-role="dialog" data-type="info" id="dialog" data-close-button="true" data-overlay="true" data-overlay-color="black" class="padding10">
    <h1>{{trans('general.register_progress')}}:</h1>
    <h4 id="priority_name"></h4>
    <div class="grid">
        <div class="row ">
                    <div class="margin10">
                        <div class="input-control select">
                        <label for="department">{{trans_choice('general.menu.virtues',1)}}</label>
                            <select name="virtue" id="virtue">
                                @foreach($virtues as $virtue)
                                <option value="{{$virtue->virtue_id}}">{{$virtue->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="user" name="user">
                </div>
                <div class="row ">
                    <div class="margin10">
                        <div class="input-control select">
                        <label for="department">{{trans_choice('general.types',1)}}</label>
                            <select name="type" id="type" data-selected="valor">
                                <option value="valor">{{trans_choice('general.menu.virtues',1)}}</option>
                                <option value="anti">Anti - {{trans_choice('general.menu.virtues',1)}}</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="user" name="user">
                </div>
        <div class="row ">
                    <div class="margin10">
                        <label>Story</label>
                        <div class="input-control textarea full-size">
                            <textarea name="story" id="story" cols="30" rows="5" placeholder="Why are you givin this virtue away?"></textarea>
                        </div>
                    </div>
                    </div>
                {{ csrf_field() }}
                <button class="button success save_progress margin10" style="display: inline-block; margin:  0 1em; ">{{trans('general.forms.submit')}}</button>
                <button class="button danger cancel_progress">{{trans('general.forms.cancel')}}</button>
    </div>
</div>
<script>
    function showDialog(id){
        var dialog = $(id).data('dialog');
        dialog.open();
    }
    $(document).on('click','.give_virtue', function (event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        var this_val = $(this).attr('data-user');
        $('#user').val(this_val);
        $('#story').val('');
        $('#virtue').select2("val", '{{$virtues[0]->virtue_id}}');
        showDialog('#dialog')

    });

    $(document).on("click",".cancel_progress",function(event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        $('.dialog-close-button').click();
    });

    $(document).on("click",".save_progress",function(event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        var data = {};
        var token = $('input[name="_token"]').val();
        var user = $('#user').val();
        var story = $('#story').val();
        var virtue = $('#virtue').val();
        var value_type = $('#type').val();
        $.ajax({
            type: 'POST',
            url: '{!! route('give_virtue') !!}',
            data: {
                "_token": token,
                "user": user,
                "story": story,
                "virtue": virtue,
                "type": value_type,
            },
            success: function(data) {
                console.log(data);
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
@else
<script>
    $.Notify({
        content:'No hay valores para la empresa',
        caption:'Error',
        type: 'alert',
    }); 
</script>
@endif
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
                <td className="center"> <label className="input-control checkbox"> <input type="checkbox" checked={Boolean(JSON.parse(this.props.data.active))} /> <span className="check"></span> </label> </td> 
                    <td> 
                        <a href={"/set_user/"+this.props.data.user_id} className="button success">Ver Perfil</a>
                        @if($virtues)
                        &nbsp;
                        <button data-user={this.props.data.user_id} className="give_virtue button info">Give virtue</button>
                        @endif
                    </td>


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
                        <th> {{ trans('general.forms.name')}} </th>
                        <th> {{ trans('general.forms.lastname')}} </th>
                        <th> {{ trans_choice('general.menu.positions', 1) }} </th>
                        <th> {{ trans_choice('general.menu.areas',1)}} </th>
                        <th> {{ trans('general.active')}} </th>
                        <th> {{ trans_choice('general.actions',2)}} </th>

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