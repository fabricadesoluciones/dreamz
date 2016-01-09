<br><br>
<h2>{{trans_choice('general.mine',2)}} {{trans_choice('general.menu.priorities',2)}}</h2>
<hr>

<div id="table">
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
                </tr>
            @endforeach
            </tbody>
    </table>

<br><br>
<h2>{{trans_choice('general.mine',2)}} {{trans_choice('general.menu.objectives',2)}}</h2>
<hr>

    <table class="table striped hovered cell-hovered border bordered autowidth">
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
            <?php $i = 0; ?>
            @foreach ($objectives as $objective)
                <?php $i++; ?>
                <tr id="objective_{{$objective->objective_id}}">
                    <td> <?php echo $i; ?> </td>
                    <td>{{$objective->description}}</td>
                    <td><span class="period_objective"></span></td>
                    <td><span class="real"></span></td>
                    <td width="30" align="center"> <span style=" display:inline-block;height:1.2em;width:1.2em; background:#20CD41" ></span
                </tr>
            @endforeach
            </tbody>
    </table>
</div>
@foreach ($objectives as $objective)
<script>
$.get('/get_objective_summary/{{$objective->objective_id}}', function(){},'json')
    .done(function(d){
       $('#objective_{{$objective->objective_id}} .period_objective').text(d.data.period_objective)
       $('#objective_{{$objective->objective_id}} .real').text(d.data.real)
    });
    // get_objective_summary
// $('#datatable').DataTable();
</script>
@endforeach
