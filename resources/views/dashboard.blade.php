@extends('layouts.master')

@section('title', '- Inicio')

@section('content')

<style>
.hide{
    display: none;
}
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
    .emotions{
        display: flex;
        align-items: center;
        justify-content: space-around;
    }
    .emotions img.most_emotion {
        width: 5.5em;
        height: 6em;
    }
    .emotions .percentage{
        font-size: 2.5em;
        padding-right: 0.5ex;
    }
</style>

<script>
var angles = [-60,0,70,140,140].reverse()
function getEmotionsDepartmentSummary(department_id){

    $.get('/get_emotion_summary_department/'+department_id, function(){},'json')
    .done(function(d){
        var rawactive = d.active
        var emotions = {}
        emotions.counts = {};
        emotions.names = {};
        for (var i = 0; i < rawactive.length; i++) {
            emotions.names[rawactive[i].active_emotion_id] = rawactive[i].name;
            emotions.counts[rawactive[i].active_emotion_id] = 0;
            emotions.total = 0;
        };
        var all_emotions = d.data;

        all_emotions.forEach(function(d){
            this.counts[d.emotion]++;
            this.total++;
        },emotions)

        var ids = Object.keys(emotions.counts);
        var current = 0; var maximum = 0;

        for (var i = 0; i < ids.length; i++) {
            if (emotions.counts[ids[i]] > maximum){
                current = ids[i];
                maximum = emotions.counts[ids[i]];
            }
        };

        var final_emotion = emotions.names[current];

        var percentage = ((1 / (emotions.total / maximum))  * 100).toFixed(2)

        $('#depto_'+department_id+' .most_emotion').attr('src', '/img/emociones/'+final_emotion+'.svg' );
        $('#depto_'+department_id+' .emotions').append('<span class="percentage"> '+percentage+'% </span' );
    });
}
function getObjectivesDepartmentSummary(department_id){

    $.get('/get_objective_summary_department/'+department_id, function(){},'json')
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
function getPrioritiesDepartmentSummary(department_id){

    $.get('/get_priority_summary_department/'+department_id, function(){},'json')
    .done(function(d){
        var priorities = d.data;

        var sem_priorities = [];
        priorities.forEach(function(d){
            var weeks = [d.w1, d.w2, d.w3, d.w4, d.w5, d.w6, d.w7, d.w8, d.w9, d.w10, d.w11, d.w12, d.w13];

            var sem_priority = weeks.reduce(function(p,c){ return parseFloat(p)+parseFloat(c)}) / weeks.length;

            sem_priorities.push(sem_priority);
        });

        var sem_priority = sem_priorities.reduce(function(p,c){ return parseFloat(p)+parseFloat(c)}) / sem_priorities.length;
        var rotateto = 'rotate( '+angles[Math.ceil(sem_priority)]+' 1000 1000)';
        
        $('#depto_'+department_id+' .priorities #Layer_4').attr('transform', rotateto )
        
    });
}

</script>
<div class="hide"> <img src="/img/emociones/agradecido.svg" alt=""> <img src="/img/emociones/alegre.svg" alt=""> <img src="/img/emociones/ansioso.svg" alt=""> <img src="/img/emociones/apasionado.svg" alt=""> <img src="/img/emociones/emocionado.svg" alt=""> <img src="/img/emociones/enojado.svg" alt=""> <img src="/img/emociones/esperanzado.svg" alt=""> <img src="/img/emociones/estresado.svg" alt=""> <img src="/img/emociones/frustracion.svg" alt=""> <img src="/img/emociones/inspirado.svg" alt=""> <img src="/img/emociones/none.svg" alt=""> </div>
<div class="dashboard">
    @foreach ($departments as $department)
        @include('dashboard_item', array('department' => $department)) 
    @endforeach
</div>

@stop