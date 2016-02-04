@extends('layouts.master')

@section('title', trans('general.new').' '.trans_choice('general.menu.categories', 1))

@section('content')
<h2>{{trans('general.new')}} {{trans_choice('general.categories', 1)}} </h2>
<hr>
<div>
    

{!! Form::model($id, array('route' => array('store_objective_category', $id), 'method' => 'POST')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>Category ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" name="category_id" value="{!! $id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" >
                        </div>
                    </div>
                </div>
            </div>

        <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
        <a href="/objectives"  class="button danger">{{trans('general.forms.cancel')}}</a>
           
{!! Form::close() !!}
</div>



@stop