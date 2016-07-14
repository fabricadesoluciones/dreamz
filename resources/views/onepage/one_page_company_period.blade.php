<input type="hidden" name="one_page_id" value="{{ $id }}" />
<input type="hidden" name="onepage_type" value="company_period">
<input type="hidden" name="period" value="{{$onepageinfo->period}}">

<div class="row cells4">
    <div class="cell">
        <div class="input-control select" style="height:auto">
        <label for="user"> {{trans_choice('general.menu.objectives', 2)}}</label>
            <select multiple name="one_page_company_objectives[]">
            @foreach ($company_objectives as $company_objective)
                <option @if($company_objective->selected) selected @endif value="{{$company_objective->one_page_objectives_id}}">{{$company_objective->description}}</option>
            @endforeach
            </select>
        </div>
                <a href="#" class="button success" rel="new_extra" data-extra="company_objectives" data-target="one_page_company_objectives[]"> {{ trans('general.forms.add_new') }}</a>


    </div>
    <div class="cell">
        <div class="input-control select" style="height:auto">
        <label for="user"> {{trans_choice('general.menu.priorities', 2)}}</label>
            <select multiple name="one_page_company_priorities[]">
                @foreach ($company_priorities as $company_priority)
                    <option @if($company_priority->selected) selected @endif value="{{$company_priority->one_page_priorities_id}}">{{$company_priority->description}}</option>
                @endforeach
            </select>
        </div>
                <a href="#" class="button success" rel="new_extra" data-extra="company_priorities" data-target="one_page_company_priorities[]"> {{ trans('general.forms.add_new') }}</a>
    </div>
</div>
<div class="row cells2 one_page_critical">
    <div class="cell">
        <div >
            <label>Critical number People or B/S Company Trimestral</label>
            <div class="input-control text full-size">
                <div class="color" style="background-color:#265303"></div>
                <input size="65" name="one_page_critical_people_company_period_ggren" type="text" value="@if( isset($onecritical_people_company_period_numbers[0]) ){{ $onecritical_people_company_period_numbers[0]->description }}@endif">
            </div>
            <div class="input-control text full-size">
                <div class="color" style="background-color:#468b13"></div>
                <input size="65" name="one_page_critical_people_company_period_lgreen" type="text" value="@if( isset($onecritical_people_company_period_numbers[1]) ){{ $onecritical_people_company_period_numbers[1]->description }}@endif">
            </div>
            <div class="input-control text full-size">
                <div class="color" style="background-color:#edce13"></div>
                <input size="65" name="one_page_critical_people_company_period_yellow" type="text" value="@if( isset($onecritical_people_company_period_numbers[2]) ){{ $onecritical_people_company_period_numbers[2]->description }}@endif">
            </div>
            <div class="input-control text full-size">
                <div class="color" style="background-color:#bc0709"></div>
                <input size="65" name="one_page_critical_people_company_period_red" type="text" value="@if( isset($onecritical_people_company_period_numbers[3]) ){{ $onecritical_people_company_period_numbers[3]->description }}@endif">
            </div>
        </div>
    </div>
    <div class="cell">
        <div >
            <label>Critical number Process or B/S Company Trimestral</label>
            <div class="input-control text full-size">
                <div class="color" style="background-color:#265303"></div>
                <input size="65" name="one_page_critical_process_company_period_ggren" type="text" value="@if( isset($onecritical_process_company_period_numbers[0]) ){{ $onecritical_process_company_period_numbers[0]->description }}@endif">
            </div>
            <div class="input-control text full-size">
                <div class="color" style="background-color:#468b13"></div>
                <input size="65" name="one_page_critical_process_company_period_lgreen" type="text" value="@if( isset($onecritical_process_company_period_numbers[1]) ){{ $onecritical_process_company_period_numbers[1]->description }}@endif">
            </div>
            <div class="input-control text full-size">
                <div class="color" style="background-color:#edce13"></div>
                <input size="65" name="one_page_critical_process_company_period_yellow" type="text" value="@if( isset($onecritical_process_company_period_numbers[2]) ){{ $onecritical_process_company_period_numbers[2]->description }}@endif">
            </div>
            <div class="input-control text full-size">
                <div class="color" style="background-color:#bc0709"></div>
                <input size="65" name="one_page_critical_process_company_period_red" type="text" value="@if( isset($onecritical_process_company_period_numbers[3]) ){{ $onecritical_process_company_period_numbers[3]->description }}@endif">
            </div>
        </div>
    </div>
</div>

<div class="row cells1" style="margin-bottom: 0; ">
    <div class="cell">
        <div>
            <label for="one_page_company_period_tema">Tema</label>
            <div class="input-control text full-size dup">
                <input size="65" id="one_page_company_period_tema" name="one_page_company_period_tema" type="text" value="@if ( isset($onepagetheme) && isset($onepagetheme->description) ){{ $onepagetheme->description }}@endif" />
            </div>
        </div>
    </div>
</div>
<div class="row cells1">
    <div class="cell">
        <div>
            <div class="input-control text" style="width: 49.91%; ">
                <input name="one_page_company_period_deadline" placeholder="Deadline" type="text" style="width: 100%; "  value="@if ( isset($onepagetheme) && isset($onepagetheme->dead_line) ) {{ $onepagetheme->dead_line }}@endif " />
            </div>
            <div class="input-control text" style="width: 49.66%; ">
                <input name="one_page_company_period_numero_critico" placeholder="Número Crítico" type="text" style="width: 100%; " value="@if ( isset($onepagetheme) && isset($onepagetheme->critical_number) ) {{ $onepagetheme->critical_number }}@endif " />
            </div>
        </div>
    </div>
</div>
<div class="row cells1">
    <div class="cell">
        <div>
            <label>Celebration</label>
            <div class="input-control text full-size dup">
                <input size="65" name="one_page_company_period_celebration" type="text" value="@if(isset($onepagecelebration)){{$onepagecelebration->description}}@endif">
            </div>
        </div>
    </div>
</div>
<div class="row cells1">
    <div class="cell">
        <div>
            <label>Reward</label>
            <div class="input-control text full-size dup">
                <input size="65" name="one_page_company_period_reward[]" type="text" value="@if(isset($onepagereward)){{$onepagereward->description}}@endif">
            </div>
        </div>
    </div>
</div>
