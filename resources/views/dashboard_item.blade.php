<!-- ITEM -->

<div class="dash_element" id="depto_{{$department->department_id}}">
    <div class="dash_section">
        <div class="dash_title">
            {{$department->name}}
        </div>
        <p>lorem</p>
    </div>
    <div class="dash_section">
        <div class="dash_title">
            {{trans_choice('general.menu.objectives',2)}}
        </div>
        <div class="hud objectives">
            <?php include base_path('resources/svg/hud.svg'); ?>
        </div>
    </div>
    <div class="dash_section">
        <div class="dash_title">
            {{trans_choice('general.menu.priorities',2)}}
        </div>
        <div class="hud priorities">
            <?php include base_path('resources/svg/hud.svg'); ?>
        </div>
    </div>
    <div class="dash_section">
        <div class="dash_title">
            {{trans_choice('general.menu.emotions',2)}}
        </div>
        <div class="emotions">
            <?php include base_path('public/img/emociones/alegre.svg');?>
        </div>
    </div>
</div>

<script>
    getObjectivesDepartmentSummary('{{$department->department_id}}');
    getPrioritiesDepartmentSummary('{{$department->department_id}}');
</script>

<!-- ITEM -->
