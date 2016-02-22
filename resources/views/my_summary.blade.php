<style>
    .square{
        display:inline-block;
        height:1.2em;
        width:1.2em;
    }
    .objectives_charts{
        font-size: 1.7ex;
        width: 1200px;
        height: 800px;
        display: block;
        min-width: 1200px;
        display: flex;
        align-content:flex-start;
        flex-wrap:wrap;
    }
    .objective_chart_container{
        min-width: 600px;
        max-width: 600px;
        height: 400px;
        position: relative;
    }

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}


.line {
  fill: none;
  stroke-width: 0.25ex;
}

.blue{stroke: #1A99C9;}
.bar.blue{fill: #1A99C9;stroke: #1A99C9;}
.aquamarine{stroke: #6AD1BB;}
.bar.aquamarine{fill: #6AD1BB;stroke: #6AD1BB;}
.axis g.tick line {
    stroke: lightgrey;
    opacity: 0.7;
}

span.objective_chart_title {
    position: absolute;
    right: 1ex;
    top: 1ex;
    text-transform: capitalize;
    font-weight: bolder;
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


function renderChart(data){

    var objective  = data;

    objective.daily_green = parseFloat(objective.daily_green);
    objective.daily_objective = parseFloat(objective.daily_objective);
    objective.daily_red = parseFloat(objective.daily_red);
    objective.daily_yellow_ceil = parseFloat(objective.daily_yellow_ceil);
    objective.daily_yellow_floor = parseFloat(objective.daily_yellow_floor);

    objective.weekly_green = objective.daily_green * 7;
    objective.weekly_objective = objective.daily_objective * 7;
    objective.weekly_red = objective.daily_red * 7;
    objective.weekly_yellow_ceil = objective.daily_yellow_ceil * 7;
    objective.weekly_yellow_floor = objective.daily_yellow_floor * 7;

    objective.monthly_green = objective.daily_green * 30;
    objective.monthly_objective = objective.daily_objective * 30;
    objective.monthly_red = objective.daily_red * 30;
    objective.monthly_yellow_ceil = objective.daily_yellow_ceil * 30;
    objective.monthly_yellow_floor = objective.daily_yellow_floor * 30;

    objective.period_green = parseFloat(objective.period_green);
    objective.period_objective = parseFloat(objective.period_objective);
    objective.period_red = parseFloat(objective.period_red);
    objective.period_yellow_ceil = parseFloat(objective.period_yellow_ceil);
    objective.period_yellow_floor = parseFloat(objective.period_yellow_floor);

    debugger;
    data = objective.results;
    cumulativeData = JSON.parse(JSON.stringify(data));

    var cumulativeValue = 0;
    for (var i = 0; i < cumulativeData.length; i++) {
        cumulativeValue += cumulativeData[i].value * 1;
        cumulativeData[i].value = cumulativeValue * 1;
    };

    var array_of_data = data.map(function(d){ return [parseInt(moment(d.progress_date).format('x')), parseFloat(d.value)];});
    var array_of_cumulativeData = cumulativeData.map(function(d){ return [parseInt(moment(d.progress_date).format('x')), parseFloat(d.value)];});
    var min_of_data = _.min(data.map(function(d){ return parseFloat(d.value);}));
    var min_of_cumulativeData = _.min(cumulativeData.map(function(d){ return parseFloat(d.value);}));

    $('.needs_chart').highcharts({
        chart: {
            type: 'spline',
            zoomType: 'x'
        },
        title: {
            text: objective.name
        },
        subtitle: {
            text: objective.description
        },
        xAxis: [{
            crosshair: true,
            type: 'datetime',

        }],
        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value}'
            },
            title: {
                text: 'Daily'
            },
            max:objective.weekly_green,
            min:min_of_data - (min_of_data / 10),
            plotLines: [
                {
                    value: objective.daily_green,
                    color: 'green',
                    dashStyle: 'shortdash',
                    width: 2,
                    label: {
                        text: 'Daily green'
                    }
                }, {
                    value: objective.daily_red,
                    color: 'red',
                    dashStyle: 'shortdash',
                    width: 2,
                    label: {
                        text: 'Daily red',
                        align: 'right',
                    }
                }
            ]
        }, { // Secondary yAxis
            title: {
                text: 'Cumulative'
            },
            labels: {
                format: '{value}'
            },
            max:objective.period_green,
            min:min_of_cumulativeData - (min_of_cumulativeData / 10),
            plotLines: [
                {
                    value: objective.period_green,
                    color: 'green',
                    dashStyle: 'shortdash',
                    width: 2,
                    label: {
                        text: 'Weekly green'
                    }
                }, {
                    value: objective.period_red,
                    color: 'red',
                    dashStyle: 'shortdash',
                    width: 2,
                    label: {
                        text: 'Weekly red',
                        align: 'right',
                    }
                }
            ],
            opposite: true
        }],
        tooltip: {
            shared: true
        },
        legend: {
            
        },
        series: [{
            name: 'Daily',
            type: 'spline',
            data:array_of_data,
            marker: {
                width:4,
                height:4,
                radius:4,
                symbol: 'square'
            },
            color: '#6AD1BB'

        }, {
            name: 'Cumulative',
            type: 'spline',
            yAxis: 1,
            data: array_of_cumulativeData,
            marker: {
                width:4,
                height:4,
                radius:4,
                symbol: 'square'
            },
            color: '#1B9ACB'
        }]
    });
    $('.needs_chart').removeClass('needs_chart');

}

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
        $('.objectives_charts').append('<div class="objective_chart_container needs_chart"></div');
        $('.needs_chart').append('<span class="objective_chart_title">'+objective.name+'</span')
        
        if (objective.days != objective.results.length) {
            var newresults =[]
            loop1:
            for (var i = 0; i < objective.days + 1; i++) {
                var this_value = 0
                loop2:
                for (var j = 0; j < objective.results.length; j++) {
                    if (moment(objective.results[j].progress_date).format('YYYY-MM-DD') == moment(objective.period.start).add(i, 'days').format('YYYY-MM-DD') ){
                    this_value = objective.results[j].value;

                    break loop2;  
                    } 
                }
                newresults.push(
                    {
                        progress_date: moment(objective.period.start).add(i, 'days').format('YYYY-MM-DD HH:mm:ss'),
                        value:this_value
                    }
                )
            }
            objective.results = newresults;
        }


        debugger;
        renderChart(objective);

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

