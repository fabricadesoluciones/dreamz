@extends('layouts.master')

@section('title', trans_choice('general.menu.virtues',2))

@section('content')
<h2>{{ trans('general.new')}} {{ trans_choice('general.menu.virtues',2) }}</h2>
<hr>
<div>
    {!! Form::model($id, array('route' => array('virtues.store', $id), 'method' => 'POST', 'files'=>true)) !!}
    <div class="grid">
                <div class="row cells4">
                    <div class="cell">
                        <label>Virtue ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" name="virtue_id" name="period_id" value="{!! $id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label> {{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value=""  required="required" />
                        </div>
                    </div>
                    
                    <div class="cell">
                        <br>
                        <div class="input-control select">
                        <label for="department"> Type</label>
                            <select name="type" id="type" >
                                <option value="valor">Valor</option>
                                <option value="antivalor">Anti Valor</option>
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <label>Weight</label>
                        <div class="input-control text full-size">
                            <input size="65" name="weight" type="number" step="0.01" value=""  required="required" />
                        </div>
                    </div>
                </div>
                <div class="row cells1">
                    <div class="cell">
                        <label for="alergies">{{trans('general.description')}}</label> <br>
                        <div class="input-control textarea"data-role="input" data-text-auto-resize="true">
                            <textarea cols="200" name="description"></textarea>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="row cells3">
                    <div class="cell">
                    <br>
                        <div class="input-control file" data-role="input">
                        <label for="file">File</label>
                            <input type="file" name="attachment" >
                            <button class="button"><span class="mif-folder"></span></button>
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.active')}}</label>
                        <br>
                        <label class="switch" style="padding: 1.2ex 0; ">
                            <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="active" value="" />
                            <span class="check"></span>
                        </label>
                        
                    </div>
                    
                    
                </div>

                
            </div>
        <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">{{trans('general.forms.cancel')}}</a>
           
{!! Form::close() !!}

</div>

@stop