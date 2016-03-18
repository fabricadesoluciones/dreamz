<!-- ITEM -->

<div class="dash_element" id="depto_{{$department->department_id}}">
    <div class="dash_section">
        <div class="dash_title">
            {{$department->name}}
        </div>
        <div class="sub">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis molestias distinctio animi velit sed earum aliquid dicta libero consequuntur laudantium corrupti iure nisi quae, delectus quis repudiandae enim porro dolor.
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
    <div class="dash_section">
        <div class="dash_title">
            {{trans_choice('general.menu.virtues',2)}}
        </div>
        <div class="virtues">
            <table>
                <tbody>
                    @foreach ($virtues as $virtue)
                        <tr>
                        <td><img src="{{$virtue->public_url}}" alt="{{$virtue->name}}" style="margin:1ex;  width: 3em; margin:1ex;  height: 3em" alt=""> </td>
                        <td width="200" style="font-weight: bolder">{{$virtue->name}}</td>
                        <td><strong style="font-weight: bolder" class="count" id="virtue_{{$virtue->virtue_id}}"></strong></td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    getObjectivesDepartmentSummary('{{$department->department_id}}');
    getPrioritiesDepartmentSummary('{{$department->department_id}}');
    getEmotionsDepartmentSummary('{{$department->department_id}}');
    getVirtuesDepartmentSummary('{{$department->department_id}}');
</script>

<!-- ITEM -->
