@extends('layouts.master')

@section('title', trans('general.edit').' '.trans_choice('general.menu.companies', 1))

@section('content')
<h2>{{trans('general.new')}} {{trans_choice('general.menu.companies', 1)}} </h2>
<hr>
<div>
    

{!! Form::model($id, array('route' => array('companies.store', $id), 'method' => 'POST')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>Company ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" name="company_id" value="{!! $id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.commercial_name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="commercial_name" type="text" value="" required="required">
                        </div>
                    </div>
                </div>
                <div class="row cells2">
                    <div class="cell">
                        <label>RFC</label>
                        <div class="input-control text full-size">
                            <input size="65" name="rfc" type="text" value="" required="required">
                        </div>
                    </div>
                    <div class="cell">
                        <label>Slogan</label>
                        <div class="input-control text full-size">
                            <input size="65" name="slogan" type="text" value="" required="required">
                        </div>
                    </div>
                </div>
                <div class="row cells4">
                    <div class="cell">
                        <label>Logo (3:1)</label>
                        <div class="input-control text full-size">
                            <input size="65" name="logo" type="text" value="" required="required">
                        </div>
                    </div>
                    <div class="cell">
                        <label>Active</label>
                        <br>
                        <label class="switch" style="padding: 1.2ex 0; ">
                            <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="active">
                            <span class="check"></span>
                        </label>
                        
                    </div>
                    <div class="cell">
                        <div class="input-control select">
                        <label for="language">{{trans('general.language')}}</label>
                            <select name="language" id="language">
                                <option value=""> - </option>
                                <option value="en">English</option>
                                <option value="en">Spanish</option>
                            </select>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="input-control select">
                        <label for="country">{{trans('general.country')}}</label>
                            <select name="country" id="country">
                                <option value=""> - </option>
                                <option value="MX">México</option>
                                <option value="US">United States of America</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                
            </div>

        <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">{{trans('general.forms.cancel')}}</a>
           
{!! Form::close() !!}
</div>

<script>
function isChecked(input){
    debugger;

}
    
</script>

@stop