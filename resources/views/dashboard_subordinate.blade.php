<!-- ITEM -->

<div class="dash_element" id="subordinate_{{$user->user_id}}">
    <div class="dash_section">
        <div class="dash_title">
            <a href="/set_user/{{$user->user_id}}">{{$user->name}} {{$user->lastname}}</a>
        </div>
        <div class="sub">
            <p>
                 {{$user->description}}
            </p>
        </div>
    </div>
    <div class="dash_section">
        <div class="dash_title">
            {{trans_choice('general.menu.objectives',2)}}
        </div>
        <div class="hud objectives">
            <?php include base_path('resources/svg/hud2.svg'); ?>
        </div>
    </div>
    <div class="dash_section">
        <div class="dash_title">
            {{trans_choice('general.menu.priorities',2)}}
        </div>
        <div class="hud priorities">
            <?php include base_path('resources/svg/hud2.svg'); ?>
        </div>
    </div>
    <div class="dash_section">
        <div class="dash_title">
            {{trans_choice('general.menu.emotions',2)}}
        </div>
        <div class="emotions">
            <img title="" class="most_emotion" src="/img/emociones/none.svg" alt="">
        </div>
    </div>
</div>

<script>
    getObjectivesSubordinateSummary('{{$user->user_id}}');
    getPrioritiesSubordinateSummary('{{$user->user_id}}');
    getEmotionsSubordinateSummary('{{$user->user_id}}');
</script>

<!-- ITEM -->
