@extends('layouts.master')

@section('title', '- Inicio')

@section('content')

<style>
.dashboard{
    display: flex;
    flex-wrap:no-wrap;
}
    
    .dash_element{
        width: 300px;
        min-width: 300px;
        min-height: 500px;
        margin-right: 1em;
        border: solid 1px #DBDBDB;
        border-radius: 1ex;
    }
    .dash_element .dash_title{
        background-color: #E7F2F6;
        line-height: 3em;
    font-weight: bold;
    padding:0 1em;
    color: #1283AB;
    font-size: 1.1em;
    text-transform: capitalize;
    }
    .hud{
        display: flex;
        width: 300px;
        padding: 1em 0;
    }
    .hud svg{
        max-width: 100%;
        height: 120px;
    }
</style>

<script>
var angles = [-60,0,70,140,140].reverse()
function getObjectivesDepartmentSummary(department_id){

    $.get('/get_summary_department/'+department_id, function(){},'json')
    .done(function(d){
        var objectives = d.data;
        objectives.forEach(function(d){
            var props = Object.keys(d);
            for (var i = 0; i < props.length; i++) {
                if ( ! isNaN( parseFloat(d[props[i]]) ) ){
                    d[props[i]] =parseFloat(d[props[i]])
                }
            }
            if (d.real > d.period_green) {
                d.semaf = 3;
            }
            else if (d.real > d.period_yellow_floor) {
                d.semaf = 2;
            }else{
                
                d.semaf = 1;
            }

        });
        var sem_dept = objectives.map(function(d){
            return d.semaf
        }).reduce(function(p,c){return p + c}) / objectives.length ;
        if (sem_dept == 3) {
            sem_dept = 4;
        }
        var rotateto = 'rotate( '+angles[sem_dept]+' 1000 1000)';
        $('#depto_'+department_id+' .objectives #Layer_4').attr('transform', rotateto )
        
    });
}

</script>
<div class="dashboard">
    @foreach ($departments as $department)
        @include('dashboard_item', array('department' => $department)) 
    @endforeach
</div>

@stop