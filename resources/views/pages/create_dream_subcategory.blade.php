@extends('layouts.master')

@section('title', trans('general.new').' '.trans_choice('general.subcategories', 1))

@section('content')
<h2>{{trans('general.new')}} {{trans_choice('general.subcategories', 1)}} </h2>
<hr>
<div>
    

{!! Form::model($id, array('route' => array('store_dream_subcategory', $id), 'method' => 'POST')) !!}
    <div class="grid">
                <div class="row cells3">
                    <div class="cell">
                        <label>Category ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" name="subcategory_id" value="{!! $id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" >
                        </div>
                    </div>
                    <div class="cell">
                        <br>
                        <div class="input-control select full-size">
                        <label for="position">{{trans_choice('general.categories',1)}}</label>
                            <select name="parent" id="parent" >
                            @foreach ($categories as $category)
                                    <option value="{{$category->category_id}}">{{$category->name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
        <a href="/dreams"  class="button danger">{{trans('general.forms.cancel')}}</a>           
{!! Form::close() !!}
</div>



@stop