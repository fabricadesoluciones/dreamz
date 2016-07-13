<input type="hidden" name="one_page_id" value="{{ $id }}" />
<input type="hidden" name="onepage_type" value="company">

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
            <select name="period" id="period" data-selected="{{$onepageinfo->period}}">
                 @foreach ($periods as $period)
                    <option value="{{$period->period_id}}">{{$period->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="cell">
        <label for="admission_date">{{trans_choice('general.dates',1)}}</label>
        <div class="input-control text full-size">
            <input name='one_page_date' type="date" value="{{ $onepageinfo->date }}" />

        </div>
    </div>
</div>
<div class="row cells3">
    <div class="cell">
        <div class="input-control select" style="height:auto">
        <label for="user">{{ trans_choice('general.menu.virtues', 2) }}</label>
            <select multiple name="one_page_virtues[]">
            @foreach ($core_values as $core_value)
                <option @if($core_value->selected) selected @endif value="{{$core_value->one_page_core_values_id}}">{{$core_value->description}}</option>
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
            <textarea cols="80" name="purpose">{{ $onepageinfo->purpose }}</textarea>
        </div>
    </div>
</div>
<div class="row cells1">
    <div class="cell">
        <div>
            <label>{{ trans_choice('general.actions', 2) }}</label>
            @foreach ($onepageactions as $onepageaction)
            <div class="input-control text full-size one_page_action dup">
                <input size="65" name="one_page_actions[]" type="text" value="{{$onepageaction->description}}" />
            </div>
            @endforeach
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
                <a href="#" class="button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>

        </div>
    </div>
</div>
<div class="row cells1">
    <div class="cell">
        <div>
            <label>Profit / X</label>
            @foreach ($oneprofitxs as $oneprofitx)
            <div class="input-control text full-size one_page_action dup">
                <input size="65" name="one_page_profit_x[]" type="text" value="{{$oneprofitx->description}}" />
            </div>
            @endforeach
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
                <a href="#" class="button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
        </div>
    </div>
</div>
<div class="row cells1">
    <div class="cell">
        <div>
            <label>BHAG</label>
            @foreach ($onebhags as $onebhag)
            <div class="input-control text full-size one_page_action dup">
                <input size="65" name="one_page_bhag[]" type="text" value="{{$onebhag->description}}" />
            </div>
            @endforeach
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
                <a href="#" class="button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
        </div>
    </div>
</div>
<hr>
<h3>Targets (3 a 5 años)</h3>
<br>
<div class="row cells1">
    <div class="cellone_page_targets">
    @foreach ($onepagetargets as $onepagetarget)
        <div class="one_page_target dup">
            <div>
                <label>{{trans('general.forms.name')}}</label>
                <div class="input-control text full-size">
                    <input size="65" type="text" name="one_page_targets_name[]" value="{{$onepagetarget->name }}" />
                </div>
            </div>
            <div>
                <label>{{trans('general.description')}}</label>
                <div class="input-control text full-size">
                    <input size="65" type="text" name="one_page_targets_description[]" value="{{$onepagetarget->description }}" />
                </div>
            </div>
        </div>
    @endforeach
        <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
        <a href="#" class="button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
    </div>
</div>
<div class="row cells1">
    <div class="cell">
        <div>
            <label>Sandbox</label>
            <div class="input-control text full-size dup">
                <input size="65" name="one_page_sandbox" type="text" {{$onepageinfo->sandbox}}/>
            </div>
        </div>
    </div>
</div>
<div class="row cells1">
    <div class="cell">
        <div>
            <label>Key Thrusts /Capabilities</label>
            @foreach ($onepagekeythrusts as $onepagekeythrust)
            <div class="input-control text full-size one_page_action dup">
                <input size="65" name="one_page_key_thrusts[]" type="text" value="{{$onepagekeythrust->description}}" />
            </div>
            @endforeach
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
                <a href="#" class="button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
        </div>
    </div>
</div>
<div class="row cells1">
    <div class="cell">
        <div>
            <label>Brand Promise KPIs</label>
            @foreach ($onepagebrandpromisekpis as $onepagebrandpromisekpi)
            <div class="input-control text full-size one_page_action dup">
                <input size="65" name="one_page_brand_promise_kpis[]" type="text" value="{{$onepagebrandpromisekpi->description}}" />
            </div>
            @endforeach
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
                <a href="#" class="button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
        </div>
    </div>
</div>
<div class="row cells1">
    <div class="cell">
        <div>
            <label>Goals (1 year)</label>
            @foreach ($onepagegoals as $onepagegoal)
            <div class="input-control text full-size one_page_action dup">
                <input size="65" name="one_page_goals_1_yr[]" type="text" value="{{$onepagegoal->description}}" />
            </div>
            @endforeach
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
                <a href="#" class="button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
        </div>
    </div>
</div>
<div class="row cells1">
    <div class="cell">
        <div>
            <label>KEY Initiatives</label>
            @foreach ($onepagekeyinitiatives as $onepagekeyinitiative)
            <div class="input-control text full-size one_page_action dup">
                <input size="65" name="one_page_key_initiatives[]" type="text" value="{{$onepagekeyinitiative->description}}" />
            </div>
            @endforeach
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
                <a href="#" class="button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
        </div>
    </div>
</div>
<div class="row cells2 one_page_critical">
    <div class="cell">
        <div >
            <label>Critical number People or B/S Company</label>
            <div class="input-control text full-size">
                <div class="color" style="background-color:#265303"></div>
                <input size="65" name="one_page_critical_people_company_ggren" type="text" value="@if( isset( $onecritical_people_company_numbers[0]) ){{ $onecritical_people_company_numbers[0]->description }}@endif">
            </div>
            <div class="input-control text full-size">
                <div class="color" style="background-color:#468b13"></div>
                <input size="65" name="one_page_critical_people_company_lgreen" type="text" value="@if( isset( $onecritical_people_company_numbers[1]) ){{ $onecritical_people_company_numbers[1]->description }}@endif">
            </div>
            <div class="input-control text full-size">
                <div class="color" style="background-color:#edce13"></div>
                <input size="65" name="one_page_critical_people_company_yellow" type="text" value="@if( isset( $onecritical_people_company_numbers[2]) ){{ $onecritical_people_company_numbers[2]->description }}@endif">
            </div>
            <div class="input-control text full-size">
                <div class="color" style="background-color:#bc0709"></div>
                <input size="65" name="one_page_critical_people_company_red" type="text" value="@if( isset( $onecritical_people_company_numbers[3]) ){{ $onecritical_people_company_numbers[3]->description }}@endif">
            </div>
        </div>
    </div>
    <div class="cell">
        <div >
            <label>Critical number Process or B/S Company</label>
            <div class="input-control text full-size">
                <div class="color" style="background-color:#265303"></div>
                <input size="65" name="one_page_critical_process_company_ggren" type="text" value="@if( isset( $onecritical_process_company_numbers[0]) ){{ $onecritical_process_company_numbers[0]->description }}@endif">
            </div>
            <div class="input-control text full-size">
                <div class="color" style="background-color:#468b13"></div>
                <input size="65" name="one_page_critical_process_company_lgreen" type="text" value="@if( isset( $onecritical_process_company_numbers[1]) ){{ $onecritical_process_company_numbers[1]->description }}@endif">
            </div>
            <div class="input-control text full-size">
                <div class="color" style="background-color:#edce13"></div>
                <input size="65" name="one_page_critical_process_company_yellow" type="text" value="@if( isset( $onecritical_process_company_numbers[2]) ){{ $onecritical_process_company_numbers[2]->description }}@endif">
            </div>
            <div class="input-control text full-size">
                <div class="color" style="background-color:#bc0709"></div>
                <input size="65" name="one_page_critical_process_company_red" type="text" value="@if( isset( $onecritical_process_company_numbers[3]) ){{ $onecritical_process_company_numbers[3]->description }}@endif">
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
            @foreach ($onepagemakebuys as $onepagemakebuy)
            <div class="input-control text full-size one_page_action dup">
                <input size="65" name="one_page_make_buy[]" type="text" value="{{$onepagemakebuy->description}}" />
            </div>
            @endforeach
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
                <a href="#" class="button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
        </div>
    </div>
</div>
<div class="row cells1">
    <div class="cell">
        <div>
            <label>Sell</label>
            @foreach ($onepagesells as $onepagesell)
            <div class="input-control text full-size one_page_action dup">
                <input size="65" name="one_page_sell[]" type="text" value="{{$onepagesell->description}}" />
            </div>
            @endforeach
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
                <a href="#" class="button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
        </div>
    </div>
</div>
<div class="row cells1">
    <div class="cell">
        <div>
            <label>Record Keeping</label>
            @foreach ($onepagerecordkeepings as $onepagerecordkeeping)
            <div class="input-control text full-size one_page_action dup">
                <input size="65" name="one_page_record_keeping[]" type="text" value="{{$onepagerecordkeeping->description}}" />
            </div>
            @endforeach
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
                <a href="#" class="button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
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
            @foreach ($onepageemployees as $onepageemployee)
            <div class="input-control text full-size one_page_action dup">
                <input size="65" name="one_page_employees[]" type="text" value="{{$onepageemployee->description}}" />
            </div>
            @endforeach
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
                <a href="#" class="button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
        </div>
    </div>
</div>
<div class="row cells1">
    <div class="cell">
        <div>
            <label>Clientes</label>
            @foreach ($onepageclients as $onepageclient)
            <div class="input-control text full-size one_page_action dup">
                <input size="65" name="one_page_clients[]" type="text" value="{{$onepageclient->description}}" />
            </div>
            @endforeach
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
                <a href="#" class="button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
        </div>
    </div>
</div>
<div class="row cells1">
    <div class="cell">
        <div>
            <label>Colaboradores</label>
            @foreach ($onepagecolaborators as $onepagecolaborator)
            <div class="input-control text full-size one_page_action dup">
                <input size="65" name="one_page_colaborators[]" type="text" value="{{$onepagecolaborator->description}}" />
            </div>
            @endforeach
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
                <a href="#" class="button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>
        </div>
    </div>
</div>
<div class="row cells1">
    <div class="cell">
        <div>
            <label> Fuerzas</label>
            @foreach ($onepagestrengths as $onepagestrength)
            <div class="input-control text full-size one_page_action dup">
                <input size="65" name="one_page_strengths[]" type="text" value="{{$onepagestrength->description}}" />
            </div>
            @endforeach
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
                <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>

        </div>
    </div>
</div>

<div class="row cells1">
    <div class="cell">
        <div>
            <label> Debilidades</label>
            @foreach ($onepageweaknesses as $onepageweakness)
            <div class="input-control text full-size one_page_action dup">
                <input size="65" name="one_page_weaknesses[]" type="text" value="{{$onepageweakness->description}}" />
            </div>
            @endforeach
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
                <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>

        </div>
    </div>
</div>

<div class="row cells1">
    <div class="cell">
        <div>
            <label> Tendencias </label>
            @foreach ($onepagetrends as $onepagetrend)
            <div class="input-control text full-size one_page_action dup">
                <input size="65" name="one_page_trends[]" type="text" value="{{$onepagetrend->description}}" />
            </div>
            @endforeach
                <a href="#" class="button success" rel="one_page_add_actions"> {{ trans('general.forms.add_new') }}</a> 
                <a href="#" class="hide button danger" rel="one_page_remove_actions">{{trans('general.delete')}}</a>

        </div>
    </div>
</div>
