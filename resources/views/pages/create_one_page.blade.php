@extends('layouts.master')

@section('title', trans('general.new').' '.' One Page')

@section('content')
<style>
    .one_page_target > div{
        display: block;
        float: left;
        width: 45%;
        margin:0 2.5% 0 0 ;
    }
    .one_page_critical .color {
        width: 2.1em;
        height: 2.1em;
        float: left;
    }
    .one_page_critical .full-size input{
        width: calc(100% - 3em);
        margin-left: 1ex;
    }
</style>
<h2>{{trans('general.new')}} One Page</h2>
<hr>
<div>
    <div class="grid">
{!! Form::model(null, array('route' => array('onepages.store', $id), 'method' => 'POST')) !!}
                <input type="hidden" name="one_page_id" value="{{ $id }}" />
        <div class="row cells3">
            <div class="cell">
                <label for="blood_type">{{trans_choice('general.menu.companies',1)}}</label>
                <div class="input-control text full-size">
                    <input type="text" value="{!! Session::get('company_name')!!}" disabled="disabled" />
                </div>
            </div>
            <div class="cell">
                <br>
                <div class="input-control select full-size">
                <label for="department">{{trans_choice('general.menu.periods',1)}}</label>
                    <select name="period" id="period" >
                         @foreach ($periods as $period)
                            <option value="{{$period->period_id}}">{{$period->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="cell" >
                <label for="admission_date">{{trans_choice('general.dates',1)}}</label>
                <div class="input-control text full-size">
                    <input name='one_page_date' type="date" value="{{ date('Y-m-d') }}" />

                </div>
            </div>
        </div>
        <div class="row cells3">
            <div class="cell">
                <div class="input-control select" style="height:auto">
                <label for="user">{{ trans_choice('general.menu.virtues', 2) }}</label>
                    <select multiple name="one_page_virtues[]" readonly="readonly">
                    @foreach ($virtues as $virtue)
                        <option value="{{$virtue->virtue_id}}">{{$virtue->name}}</option>
                    @endforeach
                    </select>
                </div>
                        <a href="#" class="button success"> {{ trans('general.forms.add_new') }}</a>


            </div>
        </div>
        <hr>
        <div class="row cells1">
            <div class="cell">
                <label for="purpose">{{trans('general.purpose')}}</label> <br>
                <div class="input-control textarea"data-role="input" data-text-auto-resize="true">
                    <textarea cols="80" name="purpose"> </textarea>
                </div>
            </div>
        </div>
        <div class="row cells1">
            <div class="cell">
                <div>
                    <label>{{ trans_choice('general.actions', 2) }}</label>
                    <div class="input-control text full-size one_page_action dup">
                        <input size="65" name="one_page_actions[]" type="text" />
                    </div>
                        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                        <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>

                </div>
            </div>
        </div>
        <div class="row cells1">
            <div class="cell">
                <div>
                    <label>Profit / X</label>
                    <div class="input-control text full-size dup">
                        <input size="65" name="one_page_profit_x[]" type="text" />
                    </div>
                        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                        <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
                </div>
            </div>
        </div>
        <div class="row cells1">
            <div class="cell">
                <div>
                    <label>BHAG</label>
                    <div class="input-control text full-size dup">
                        <input size="65" name="one_page_bhag[]" type="text" />
                    </div>
                        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                        <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
                </div>
            </div>
        </div>
        <hr>
        <h3>Targets (3 a 5 años)</h3>
        <br>
        <div class="row cells1">
            <div class="cellone_page_targets">
                <div class="one_page_target dup">
                    <div>
                        <label>{{trans('general.forms.name')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" name="one_page_targets_name[]" />
                        </div>
                    </div>
                    <div>
                        <label>{{trans('general.description')}}</label>
                        <div class="input-control text full-size">
                            <input size="65" type="text" name="one_page_targets_description[]" />
                        </div>
                    </div>

                </div>
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
            </div>
        </div>
        <div class="row cells1">
            <div class="cell">
                <div>
                    <label>Sandbox</label>
                    <div class="input-control text full-size dup">
                        <input size="65" name="one_page_sandbox" type="text" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row cells1">
            <div class="cell">
                <div>
                    <label>Key Thrusts /Capabilities</label>
                    <div class="input-control text full-size dup">
                        <input size="65" name="one_page_key_thrusts[]" type="text" />
                    </div>
                        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                        <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
                </div>
            </div>
        </div>
        <div class="row cells1">
            <div class="cell">
                <div>
                    <label>Brand Promise KPIs</label>
                    <div class="input-control text full-size dup">
                        <input size="65" name="one_page_brand_promise_kpis[]" type="text" />
                    </div>
                        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                        <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
                </div>
            </div>
        </div>
        <div class="row cells1">
            <div class="cell">
                <div>
                    <label>Goals (1 year)</label>
                    <div class="input-control text full-size dup">
                        <input size="65" name="one_page_goals_1_yr[]" type="text" />
                    </div>
                        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                        <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
                </div>
            </div>
        </div>
        <div class="row cells1">
            <div class="cell">
                <div>
                    <label>KEY Initiatives</label>
                    <div class="input-control text full-size dup">
                        <input size="65" name="one_page_key_initiatives[]" type="text" />
                    </div>
                        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                        <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
                </div>
            </div>
        </div>
        <div class="row cells2 one_page_critical">
            <div class="cell">
                <div >
                    <label>Critical number People or B/S Company</label>
                    <div class="input-control text full-size">
                        <div class="color" style="background-color:#265303"></div>
                        <input size="65" name="one_page_critical_people_company_ggren" type="text">
                    </div>
                    <div class="input-control text full-size">
                        <div class="color" style="background-color:#468b13"></div>
                        <input size="65" name="one_page_critical_people_company_lgreen" type="text">
                    </div>
                    <div class="input-control text full-size">
                        <div class="color" style="background-color:#edce13"></div>
                        <input size="65" name="one_page_critical_people_company_yellow" type="text">
                    </div>
                    <div class="input-control text full-size">
                        <div class="color" style="background-color:#bc0709"></div>
                        <input size="65" name="one_page_critical_people_company_red" type="text">
                    </div>
                </div>
            </div>
            <div class="cell">
                <div >
                    <label>Critical number Process or B/S Company</label>
                    <div class="input-control text full-size">
                        <div class="color" style="background-color:#265303"></div>
                        <input size="65" name="one_page_critical_process_company_ggren" type="text">
                    </div>
                    <div class="input-control text full-size">
                        <div class="color" style="background-color:#468b13"></div>
                        <input size="65" name="one_page_critical_process_company_lgreen" type="text">
                    </div>
                    <div class="input-control text full-size">
                        <div class="color" style="background-color:#edce13"></div>
                        <input size="65" name="one_page_critical_process_company_yellow" type="text">
                    </div>
                    <div class="input-control text full-size">
                        <div class="color" style="background-color:#bc0709"></div>
                        <input size="65" name="one_page_critical_process_company_red" type="text">
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <h3>Process</h3>
        <br>
        <div class="row cells1">
            <div class="cell">
                <div>
                    <label>Make / Buy</label>
                    <div class="input-control text full-size dup">
                        <input size="65" name="one_page_make_buy[]" type="text" />
                    </div>
                        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                        <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
                </div>
            </div>
        </div>
        <div class="row cells1">
            <div class="cell">
                <div>
                    <label>Sell</label>
                    <div class="input-control text full-size dup">
                        <input size="65" name="one_page_sell[]" type="text" />
                    </div>
                        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                        <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
                </div>
            </div>
        </div>
        <div class="row cells1">
            <div class="cell">
                <div>
                    <label>Record Keeping</label>
                    <div class="input-control text full-size dup">
                        <input size="65" name="one_page_record_keeping[]" type="text" />
                    </div>
                        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                        <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
                </div>
            </div>
        </div>
        <hr>
        <h3>People</h3>
        <br>
        <div class="row cells1">
            <div class="cell">
                <div>
                    <label>Empleados</label>
                    <div class="input-control text full-size dup">
                        <input size="65" name="one_page_employees[]" type="text" />
                    </div>
                        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                        <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
                </div>
            </div>
        </div>
        <div class="row cells1">
            <div class="cell">
                <div>
                    <label>Clientes</label>
                    <div class="input-control text full-size dup">
                        <input size="65" name="one_page_clients[]" type="text" />
                    </div>
                        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                        <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
                </div>
            </div>
        </div>
        <div class="row cells1">
            <div class="cell">
                <div>
                    <label>Colaboradores</label>
                    <div class="input-control text full-size dup">
                        <input size="65" name="one_page_colaborators[]" type="text" />
                    </div>
                        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                        <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
                </div>
            </div>
        </div>
        <div class="row cells1">
            <div class="cell">
                <div>
                    <label> Fuerzas</label>
                    <div class="input-control text full-size one_page_action dup">
                        <input size="65" name="one_page_strengths[]" type="text" />
                    </div>
                        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                        <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>

                </div>
            </div>
        </div>

        <div class="row cells1">
            <div class="cell">
                <div>
                    <label> Debilidades</label>
                    <div class="input-control text full-size one_page_action dup">
                        <input size="65" name="one_page_weaknesses[]" type="text" />
                    </div>
                        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                        <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>

                </div>
            </div>
        </div>

        <div class="row cells1">
            <div class="cell">
                <div>
                    <label> Tendencias </label>
                    <div class="input-control text full-size one_page_action dup">
                        <input size="65" name="one_page_trends[]" type="text" />
                    </div>
                        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a>
                        <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>

                </div>
            </div>
        </div>
        <hr>

        <input type="submit" class="success" value="{{trans('general.forms.submit')}}">
        <a href="" onclick="event.preventDefault();location.href = '/'+location.pathname.split('/')[1]" class="button danger">{{trans('general.forms.cancel')}}</a>
        {!! Form::close() !!}
    </div>
</div>


<script>
    
    $('[rel="in_period"]').html('{{$periods[0]->name}}');
    $(document).on('change','select#period', function (event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        $('[rel="in_period"]').html( this.selectedOptions[0].text )        
       });
      

    $(document).on('click','*[rel*="one_page_add_actions"]', function (event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        var this_parent = $(this).parent();
        var new_input = this_parent.find('.dup:first').clone()
        new_input.find('input').val('');
        new_input.insertBefore(this);
        this_parent.find('.danger.hide').removeClass('hide');
    });

    $(document).on('click','*[rel*="one_page_remove_actions"]', function (event) {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        var this_parent = $(this).parent();
        if (this_parent.find('.dup').length > 1) this_parent.find('.dup:last').detach();
        if (this_parent.find('.dup').length == 1) $(this).addClass('hide')
    });

    $.getJSON( "/companies/{{ session('company') }}/departments", function( response ) {
        if (response.code == 200) {
            var records = response.data;

            records.forEach(function(d,i,a){
                $('select#department').append('<option value="'+d.department_id+'">'+d.name+'</option>')
            });


        }
        
    });

</script>

@stop