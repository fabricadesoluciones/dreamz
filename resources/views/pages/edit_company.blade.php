@extends('layouts.master')

@section('title', '- Edit Company')

@section('content')
<h2>Edit Company </h2>
<hr>
</div>
<div class="container">
    

{!! Form::model($company, array('route' => array('companies.update', $company->company_id), 'method' => 'PUT')) !!}
    <div class="grid">
                <div class="row cells2">
                    <div class="cell">
                        <label>Company ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $company->company_id !!}" disabled="disabled">
                        </div>
                    </div>
                    <div class="cell">
                        <label>Commercial Name</label>
                        <div class="input-control text full-size">
                            <input size="65" name="commercial_name" type="text" value="{!! $company->commercial_name !!}" >
                        </div>
                    </div>
                </div>
                <div class="row cells2">
                    <div class="cell">
                        <label>RFC</label>
                        <div class="input-control text full-size">
                            <input size="65" name="rfc" type="text" value="{!! $company->rfc !!}" >
                        </div>
                    </div>
                    <div class="cell">
                        <label>Slogan</label>
                        <div class="input-control text full-size">
                            <input size="65" name="slogan" type="text" value="{!! $company->slogan !!}" >
                        </div>
                    </div>
                </div>
                <div class="row cells2">
                    <div class="cell">
                        <label>Logo (url)</label>
                        <div class="input-control text full-size">
                            <input size="65" name="logo" type="text" value="{!! $company->logo !!}" >
                        </div>
                    </div>
                    <div class="cell">
                        <label>Active</label>
                        <br>
                        <label class="switch" style="padding: 1.2ex 0; ">
                            <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="active" value="{{$company->active}}" 
                            @if ($company->active)
                                checked="true"
                            @endif
                            >
                            <span class="check"></span>
                        </label>
                        
                    </div>
                </div>
                
                
            </div>

        <input type="submit" class="success">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">Cancel</a>
           
{!! Form::close() !!}
</div>

<script>
function isChecked(input){
    debugger;

}
    
</script>

@stop