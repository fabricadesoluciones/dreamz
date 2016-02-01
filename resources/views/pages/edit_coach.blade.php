@extends('layouts.master')

@section('title', trans('general.edit').' '.trans_choice('general.menu.coaches', 1))

@section('content')
<h2>{{trans('general.edit')}} {{trans_choice('general.menu.coaches', 1)}} </h2>
<hr>
<div>
    

{!! Form::model($coach, array('route' => array('update_coach', $coach->user_id), 'method' => 'POST')) !!}
    <div class="grid">
                <div class="row cells3">
                    <div class="cell">
                        <label>User ID</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" value="{!! $coach->user_id !!}" readonly="readonly">
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="name" type="text" value="{!! $coach->name !!}" >
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.forms.lastname')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" name="lastname" type="text" value="{!! $coach->lastname !!}" >
                        </div>
                    </div>
                </div>
                <div class="row cells4">
                    <div class="cell">
                        <label>Email</label>
                        <div class="input-control text full-size">
                            <input size="65" name="email" type="text" value="{{$coach->email}}" />
                        </div>
                    </div>
                    <div class="cell">
                        <label for="birth_date">{{trans('general.forms.birth_date')}}</label>
                        <div class="input-control text full-size">
                            <input name='birth_date' type="date" 
                            @if (isset($coachdetails))
                            value="{{$coachdetails->birth_date}}" 
                            @endif
                            />
                        </div>
                    </div>
                    <div class="cell">
                        <label>{{trans('general.active')}}</label>
                        <br>
                        <label class="switch" style="padding: 1.2ex 0; ">
                            <input type="checkbox" onchange="if(this.checked) {this.value=1}else{this.value=0}" name="active" value="{{$coach->active}}" 
                            @if ($coach->active)
                                checked="true"
                            @endif
                            >
                            <span class="check"></span>
                        </label>
                        
                    </div>
                    <div class="cell">
                    <br>
                        <div class="input-control select full-size" style="height:auto">
                        <label for="user">{{trans_choice('general.menu.companies',2)}} </label>
                            <select  class="select2" name="companies[]" multiple

                @if (isset($coach_companies))
                
                            data-multiselected="@foreach ($coach_companies as $company){{$company->company_id}},@endforeach"
                @endif 
                />

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