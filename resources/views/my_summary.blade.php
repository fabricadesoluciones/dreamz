<style>
    .square{
        display:inline-block;
        height:1.2em;
        width:1.2em;
    }
</style>
<br><br>
<h2>{{trans_choice('general.mine',2)}} {{trans_choice('general.menu.priorities',2)}}</h2>
<hr>

<div>
    <table class="table striped hovered cell-hovered border bordered autowidth">
            <thead>
                <tr>
                    <th>#</th>
                    <th>
                        {{trans('general.description')}}
                    </th>
                    <th>
                        {{trans('general.semaforo')}}
                    </th>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                    <th>6</th>
                    <th>7</th>
                    <th>8</th>
                    <th>9</th>
                    <th>10</th>
                    <th>11</th>
                    <th>12</th>
                    <th>13</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 0; ?>
            @foreach ($priorities as $priority)
                <?php $i++; ?>
                <tr>
                    <td> <?php echo $i; ?> </td>
                    <td>{{$priority->description}}</td>
                    <td width="30" align="center"> <span style=" display:inline-block;height:1.2em;width:1.2em; background:#E9CD42" ></span></td>
                    <td width="42" class="week" data-week="{{$priority->w1}}"></td>
                    <td width="42" class="week" data-week="{{$priority->w2}}"></td>
                    <td width="42" class="week" data-week="{{$priority->w3}}"></td>
                    <td width="42" class="week" data-week="{{$priority->w4}}"></td>
                    <td width="42" class="week" data-week="{{$priority->w5}}"></td>
                    <td width="42" class="week" data-week="{{$priority->w6}}"></td>
                    <td width="42" class="week" data-week="{{$priority->w7}}"></td>
                    <td width="42" class="week" data-week="{{$priority->w8}}"></td>
                    <td width="42" class="week" data-week="{{$priority->w9}}"></td>
                    <td width="42" class="week" data-week="{{$priority->w10}}"></td>
                    <td width="42" class="week" data-week="{{$priority->w11}}"></td>
                    <td width="42" class="week" data-week="{{$priority->w12}}"></td>
                    <td width="42" class="week" data-week="{{$priority->w13}}"></td>
                </tr>
            @endforeach
            </tbody>
    </table>


</div>

<div>
    <br><br>
    <h2>{{trans_choice('general.mine',2)}} {{trans_choice('general.menu.objectives',2)}}</h2>
    <hr>

        <table class="table striped hovered cell-hovered border bordered autowidth" id="my-objectives">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            {{trans('general.description')}}
                        </th>
                        <th>
                            {{trans('general.expected')}}
                        </th>
                        <th>
                            {{trans('general.actual')}}
                        </th>
                        <th>
                            {{trans('general.semaforo')}}
                        </th>

                    </tr>
                </thead>
                <tbody>
                </tbody>
        </table>
</div>
<div>
    <br><br>
    <h2>{{trans_choice('general.mine',2)}} {{trans_choice('general.menu.dreams',2)}}</h2>
    <hr>
        <table class="table striped hovered cell-hovered border bordered autowidth">
                <thead>
                    <tr>
                        <th>#</th>
                        <th> {{trans_choice('general.menu.dreams',2)}} </th>
                    </tr>
                </thead>
                <tbody>
                <?php $i = 0; ?>
                @foreach ($dreams as $dream)
                    <?php $i++; ?>
                    <tr>
                        <td> <?php echo $i; ?> </td>
                        <td>{{$dream->description}}</td>
                    </tr>
                @endforeach
                </tbody>
        </table>
</div>
<script>
var days = {{ session('elapsed_days')}};
var counter_i = 0;
function retrieveObjective(objective_id){
    $.get('/get_objective_summary/'+objective_id, function(){},'json')
    .done(function(d){
        var objective = d.data;
        counter_i++;
        var row = '<tr>';
        var color_class;
        var cumulative = parseFloat(objective.real/objective.days)
            if (cumulative > objective.daily_yellow_ceil) { color_class = 'emerald'; }
            else if (cumulative > objective.daily_yellow_floor) { color_class = 'yellow'; }
            else {color_class = 'darkRed';}

        var row = '<tr> <td>'+counter_i+'</td> <td>'+objective.description+'</td> <td>'+objective.period_objective+'</td> <td>'+objective.real+'</td> <td width="30" align="center"> <span class="square bg-'+color_class+'" ></span> </td> </tr>' ;
        $('#my-objectives tbody').append(row);

    });
}


$('.week').each(function(){
    var this_priority_value = $(this).data('week');
    if (this_priority_value == 3) { $(this).addClass('bg-lightGreen'); return true; }
    else if (this_priority_value == 2) { $(this).addClass('bg-yellow'); return true; }
    else if (this_priority_value == 1) { $(this).addClass('bg-red'); return true; }
    $(this).addClass('bg-white'); return true; 

});

@foreach ($objectives as $objective)
    retrieveObjective('{{$objective->objective_id}}');
@endforeach

</script>
