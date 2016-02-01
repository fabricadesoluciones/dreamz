@extends('layouts.master')

@section('title', trans('general.new').' '.trans_choice('general.menu.coaches', 1))

@section('content')
<h2>{{trans('general.new')}} {{trans_choice('general.menu.coaches', 1)}} </h2>
<hr>
<div>
    

{!! Form::model($id, array('route' => array('store_coach', $id), 'method' => 'POST')) !!}
    <div class="grid">
                <div class="row cells3">
                    <div class="cell">
                        <label>User ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" name="user_id" value="{!! $id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text"  >
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.lastname')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="lastname" type="text"  >
                        </div>
                    </div>
                </div>
                <div class="row cells3">
                    <div class="cell">
                        <label>Email</label>
                        <div class="input-control text full-size">
                            <input size="65" name="email" type="text"  />
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.active')}}</label>
                        <br>
                        <label class="switch" style="padding: 1.2ex 0; ">
                            <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="active" />
                            <span class="check"></span>
                        </label>
                        
                    </div>
                    <div class="cell">
                    <br>
                        <div class="input-control select full-size" style="height:auto">
                        <label for="user">{{trans_choice('general.menu.companies',2)}} </label>
                            <select  class="select2" name="companies[]" multiple >

                            @foreach ($companies as $company)
                                <option value="{{$company->company_id}}">{{$company->commercial_name}}</option>
                            @endforeach
                            </select>

                        </div>

                    </div>
                </div>
                
                
                
                
            </div>

        <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">{{trans('general.forms.cancel')}}</a>
           
{!! Form::close() !!}
</div>



@stop