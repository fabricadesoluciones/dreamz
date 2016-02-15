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
        border:solid 1px #000;
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
    cumulativeData = JSON.parse(JSON.stringify(data));
    data.forEach(function(d){
        d.progress_date = moment(d.progress_date).toDate();
        d.value = parseFloat(d.value);
    });
    var cumulativeValue = 0;
    for (var i = 0; i < cumulativeData.length; i++) {
        cumulativeValue += cumulativeData[i].value * 1;
        cumulativeData[i].value = cumulativeValue * 1;
    };
    console.log(data);

    var margin = {top: 30, right: 20, bottom: 30, left: 50},
    width = 600 - margin.left - margin.right,
    height = 400 - margin.top - margin.bottom;


    var formatDate = d3.time.format("%Y-%m-%d");

    var x = d3.time.scale()
        .range([0, width]);

    var y = d3.scale.linear()
        .range([height, 0]);

    var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom")
        .innerTickSize(-height)
        .outerTickSize(0)
        .tickPadding(10);

    var yAxis = d3.svg.axis()
        .scale(y)
        .orient("left")
        .innerTickSize(-width)
        .outerTickSize(0)
        .tickPadding(10);

    var line = d3.svg.line()
        .x(function(d) { return x(moment(d.progress_date).toDate()); })
        .y(function(d) { return y(parseFloat(d.value)); });

    var svg = d3.select(".needs_chart").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
      .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    x.domain([data[0].progress_date,data[data.length - 1].progress_date]);
    y.domain([0,d3.max(data.map(function(d){return d.value}))]);
    // y.domain([0,d3.max(cumulativeData.map(function(d){return d.value}))]);

    svg.append("g")
    .attr("class", "x axis")
    .attr("transform", "translate(0," + height + ")")
    .call(xAxis);

    svg.append("g")
      .attr("class", "y axis")
      .call(yAxis)

    svg.append('path')
      .attr('d', line(data))
      .attr('class', 'line aquamarine')

    // svg.append('path')
    //   .attr('d', line(cumulativeData))
    //   .attr('class', 'line blue')

    svg.selectAll(".bar")
      .data(data)
    .enter().append("rect")
      .attr("class", "aquamarine bar")
      .attr("x", function(d) { return x(moment(d.progress_date).toDate()) -3; })
      .attr("width", "6")
      .attr("y", function(d) { return y(parseFloat(d.value)) -3 ; })
      .attr("height", "6");

    // svg.selectAll(".blue.bar")
    //   .data(cumulativeData)
    // .enter().append("rect")
    //   .attr("class", "blue bar")
    //   .attr("x", function(d) { return x(moment(d.progress_date).toDate()) -3; })
    //   .attr("width", "6")
    //   .attr("y", function(d) { return y(parseFloat(d.value)) -3 ; })
    //   .attr("height", "6");

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
        renderChart(objective.results);

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

