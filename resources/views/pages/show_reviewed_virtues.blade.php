@extends('layouts.master')

@section('title', trans_choice('general.menu.virtues',2))

@section('content')

                
<h2>{{ trans_choice('general.menu.virtues',2) }} </h2>
<div data-role="dialog" data-type="info" id="dialog" data-close-button="true" data-overlay="true" data-overlay-color="black" class="padding10">
    <h1>Process:</h1>
    <h4 id="priority_name"></h4>
    <div class="grid">
        <div class="row ">
                    <div class="margin10">
                        <label>Comments</label>
                        <div class="input-control textarea full-size">
                            <textarea name="comments" id="comments" cols="30" rows="5" placeholder="Why are you givin this virtue away?"></textarea>
                        </div>
                    </div>
                    </div>
                {{ csrf_field() }}
                <button class="button success approve">Approve</button>
                <button class="button danger reject">Reject</button>
                <button class="button warning cancel_progress">{{trans('general.forms.cancel')}}</button>
    </div>
</div>
<div id="table">
    
<table id="datatable" class="table striped hovered cell-hovered border bordered">
                <thead>
                    <tr>
                        <th> {{ trans_choice('general.menu.virtues',2)}} </th>
                        <th> {{ trans_choice('general.types',1)}} </th>
                        <th width="450">Story</th>
                        <th> Quién otorga </th>
                        <th> Quién recibe </th>
                        <th> {{ trans_choice('general.actions',2)}} </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($received_virtues as $virtue)
                        <tr>
                            <td>
                                <img src="{{$virtue->public_url}}" alt="{{$virtue->virtue_name}}" style="max-height: 50px;max-width: 50px;" />
                            </td>
                            <td width="120">
                            @if(! $virtue->is_value)
                                Anti -
                            @endif
                                 {{ trans_choice('general.menu.virtues',1)}} 
                            </td>
                            <td>
                                {{$virtue->story}}
                            </td>
                            <td>
                                {{$virtue->giver_name}}
                            </td>
                            <td>
                                {{$virtue->receiver_name}}
                            </td>
                            <td>
                                <a href="#" data-id="{{$virtue->given_virtue_id}}" class="process button info show_dialog">
                                    Process
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
</div>
<hr>

<script>
        $('#datatable').DataTable();
    
    function showDialog(id){
        var dialog = $(id).data('dialog');
        dialog.open();
    }

    function processForm(obj){
        $.ajax({
            type: 'POST',
            url: '{!! route('review_virtue') !!}',
            data: {
                "_token": obj.token,
                "user": obj.user,
                "given_virtue_id": obj.given_virtue_id,
                "comments": obj.comments,
                "approved": obj.approved,
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
        })
        .always(function() {
        location.reload();
        });
 
        
    }

    $(document).on('click','.show_dialog', function (event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        

        $('.reject').attr('data-id', $(this).attr('data-id'));
        $('.approve').attr('data-id', $(this).attr('data-id'));
        showDialog('#dialog');
    });

    $(document).on("click",".cancel_progress",function(event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        $('.dialog-close-button').click();
    });

    $(document).on("click",".reject",function(event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        var data = {

            token: $('input[name="_token"]').val(),
            comments: $('#comments').val(),
            given_virtue_id: $(this).attr('data-id'),
            approved: false,
        }
        processForm(data);
        console.log(data);
    });
    $(document).on("click",".approve",function(event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        var data = {

            token: $('input[name="_token"]').val(),
            comments: $('#comments').val(),
            given_virtue_id: $(this).attr('data-id'),
            approved: true,
        }
        processForm(data);
        console.log(data);

    });
      
</script>

@stop