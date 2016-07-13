<input type="hidden" name="one_page_id" value="{{ $id }}" />
<input type="hidden" name="onepage_type" value="my_one_page">
<input type="hidden" name="period" value="{{$onepageinfo->period}}">

<div class="personals">
    
    <div class="row cells4">
        <div class="cell">
            <div class="input-control select" style="height:auto">
            <label for="user"> {{trans_choice('general.menu.objectives', 2)}}</label>
                <select multiple name="one_page_virtues[]">
                @foreach ($virtues as $virtue)
                    <option value="{{$virtue->virtue_id}}">{{$virtue->name}}</option>
                @endforeach
                </select>
            </div>
                    <a href="#" class="button success"> {{ trans('general.forms.add_new') }}</a> 


        </div>
        <div class="cell">
            <div class="input-control select" style="height:auto">
            <label for="user"> {{trans_choice('general.menu.priorities', 2)}}</label>
                <select multiple name="one_page_virtues[]">
                @foreach ($virtues as $virtue)
                    <option value="{{$virtue->virtue_id}}">{{$virtue->name}}</option>
                @endforeach
                </select>
            </div>
                    <a href="#" class="button success"> {{ trans('general.forms.add_new') }}</a> 


        </div>
    </div>
    <div class="row cells2 one_page_critical">
        <div class="cell">
            <div >
                <label>Critical number People or B/S Personal Trimestral</label>
                <div class="input-control text full-size">
                    <div class="color" style="background-color:#265303"></div>
                    <input size="65" name="one_page_critical_people_personal_period_ggren" type="text" value="@if( isset($onecritical_people_personal_numbers[0]) ){{$onecritical_people_personal_numbers[0]->description}}@endif">
                </div>
                <div class="input-control text full-size">
                    <div class="color" style="background-color:#468b13"></div>
                    <input size="65" name="one_page_critical_people_personal_period_lgreen" type="text" value="@if( isset($onecritical_people_personal_numbers[1]) ){{$onecritical_people_personal_numbers[1]->description}}@endif">
                </div>
                <div class="input-control text full-size">
                    <div class="color" style="background-color:#edce13"></div>
                    <input size="65" name="one_page_critical_people_personal_period_yellow" type="text" value="@if( isset($onecritical_people_personal_numbers[2]) ){{$onecritical_people_personal_numbers[2]->description}}@endif">
                </div>
                <div class="input-control text full-size">
                    <div class="color" style="background-color:#bc0709"></div>
                    <input size="65" name="one_page_critical_people_personal_period_red" type="text" value="@if( isset($onecritical_people_personal_numbers[3]) ){{$onecritical_people_personal_numbers[3]->description}}@endif">
                </div>
            </div>
        </div>
        <div class="cell">
            <div >
                <label>Critical number Process or B/S Personal Trimestral</label>
                <div class="input-control text full-size">
                    <div class="color" style="background-color:#265303"></div>
                    <input size="65" name="one_page_critical_process_personal_period_ggren" type="text" value="@if( isset($onecritical_process_personal_numbers[0]) ){{$onecritical_process_personal_numbers[0]->description}}@endif">
                </div>
                <div class="input-control text full-size">
                    <div class="color" style="background-color:#468b13"></div>
                    <input size="65" name="one_page_critical_process_personal_period_lgreen" type="text" value="@if( isset($onecritical_process_personal_numbers[1]) ){{$onecritical_process_personal_numbers[1]->description}}@endif">
                </div>
                <div class="input-control text full-size">
                    <div class="color" style="background-color:#edce13"></div>
                    <input size="65" name="one_page_critical_process_personal_period_yellow" type="text" value="@if( isset($onecritical_process_personal_numbers[2]) ){{$onecritical_process_personal_numbers[2]->description}}@endif">
                </div>
                <div class="input-control text full-size">
                    <div class="color" style="background-color:#bc0709"></div>
                    <input size="65" name="one_page_critical_process_personal_period_red" type="text" value="@if( isset($onecritical_process_personal_numbers[3]) ){{$onecritical_process_personal_numbers[3]->description}}@endif">
                </div>
            </div>
        </div>
    </div>
</div>