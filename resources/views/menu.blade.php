<!-- MENU -->
<nav class="main_navigation">
    <ul>
        <li class="menu_link" ><a href="/home" title="{{ trans('general.menu.home') }}">
                <?php include base_path('resources/svg/inicio.svg'); ?>
        </a></li>

        <li class="menu_link">

            <a title="Administración">
                <?php include base_path('resources/svg/administracion.svg'); ?>
            </a>
            <ul>
        @if(! Session::has('original_user'))
                @if(Auth::user()->can('list-companies'))
                    <li>
                        <a href="/companies" title="{{ trans_choice('general.menu.companies', 2) }}">
                            {{ trans_choice('general.menu.companies', 2) }}
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('list-users'))
                    <li>
                        <a href="/users" title="{{ trans_choice('general.menu.users', 2) }}">
                            {{ trans_choice('general.menu.users', 2) }}
                        </a>
                        </li>
                @endif
                @if(Auth::user()->can('list-periods'))
                    <li>
                        <a href="/periods" title="{{ trans_choice('general.menu.periods', 2) }}">
                            {{ trans_choice('general.menu.periods', 2) }}
                        </a>
                    </li>
                @endif
                <li>
                    <a href="/emotions" title="{{ trans_choice('general.menu.emotions', 2) }}">
                        {{ trans_choice('general.menu.emotions', 2) }}
                    </a>
                </li>
                <li>
                    <a href="/virtues" title="{{ trans_choice('general.menu.virtues', 2) }}">
                        {{ trans_choice('general.menu.virtues', 2) }}
                    </a>
                </li>
                @if(Auth::user()->can('list-departments'))
                    <li>
                        <a href="/departments" title="{{ trans_choice('general.menu.departments', 2) }}">
                            {{ trans_choice('general.menu.departments', 2) }}
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('list-positions'))
                    <li>
                        <a class="menu_link" href="/positions" title="{{ trans_choice('general.menu.positions', 2) }}">
                            {{ trans_choice('general.menu.positions', 2) }}
                        </a>
                    </li>
                @endif
                <li>
                    <a href="/dreams" title="{{ trans_choice('general.menu.dreams', 2) }}">
                        {{ trans_choice('general.menu.dreams', 2) }}
                    </a>
                </li>
                <li>
                    <a href="/assessments" title="{{ trans_choice('general.menu.assesments', 2) }}">
                        {{ trans_choice('general.menu.assesments', 2) }}
                    </a>
                </li>
                 @if(Auth::user()->hasRole('super-admin'))
                    <li>
                        <a class="menu_link" href="/coaches" title="Coaches">
                            Coaches
                        </a>
                    </li>
                @endif
        @endif
                <li>
                    <a href="/other_users" title="{{trans_choice('general.others', 2)}} {{ trans_choice('general.menu.users', 2) }}">
                        {{trans_choice('general.others', 1)}} {{ trans_choice('general.menu.users', 2) }}
                    </a>
                </li>
            </ul>
        </li>
        @if(! Session::has('original_user'))
        <li class="menu_link">

            <a title="{{ trans('general.menu.catalogs') }}">
                <?php include base_path('resources/svg/catalogos.svg'); ?>
            </a>
            <ul>
                <li>
                    <a href="/education" title="{{ trans_choice('general.menu.companies', 2) }}">
                        Escolaridad
                    </a>
                </li>
                <li>
                    <a href="/measuring_units" title="{{ trans_choice('general.menu.companies', 2) }}">
                        Unidades de Medida
                    </a>
                </li>
                <li>
                    <a href="/emotions" title="{{ trans_choice('general.menu.companies', 2) }}">
                        Emociones
                    </a>
                </li>
                
            </ul>
        
        </li>
        @endif
        <li class="menu_link">
            @if(! Session::has('original_user'))
            <a href="/objectives/progress" title="KPIs">
                <?php include base_path('resources/svg/kpis.svg'); ?>
            </a>
            @endif
        </li>

        <li class="menu_link disabled">
            <a href="/rewarding" title="{{ trans('general.menu.rewarding') }}">
                <?php include base_path('resources/svg/rewarding.svg'); ?>
            </a>
        </li>
        <li class="menu_link">
            <a href="/tasks" title="{{ trans('general.menu.task_manager') }}">
                <?php include base_path('resources/svg/task-manager.svg'); ?>
            </a>
        </li>
        <li class="menu_link">
            <a href="/one_page" title="{{ trans('general.menu.one_page') }}">
                <?php include base_path('resources/svg/one-page.svg'); ?>
            </a>
        </li>
        <li class="menu_link disabled">
            <a href="/reports" title="{{ trans_choice('general.menu.reports',2) }}">
                <?php include base_path('resources/svg/reports.svg'); ?>
            </a>
        </li>

        @if(Auth::user()->can('list-priorities'))
            <li class="menu_link">
                <a href="/priorities" title="{{ trans_choice('general.menu.priorities', 2) }}">
                <?php include base_path('resources/svg/prioridades.svg'); ?>
                </a>
            </li>
        @endif
        @if(! Session::has('original_user'))
            <li class="menu_link">
                <a href="/users/{{Auth::user()->user_id}}/edit" title='Mi Perfil'>
                <?php include base_path('resources/svg/mi-perfil.svg'); ?>
                </a>
            </li>
        @else
            <li class="menu_link">
                <a href="/login_original" title='Regresar a mi Perfil'>
                <?php include base_path('resources/svg/mi-perfil.svg'); ?>
                </a>
            </li>
        @endif
		<li class="menu_link"><a href="/logout" title="Cerrar Sesión">
                <?php include base_path('resources/svg/cerrar-sesion.svg'); ?>
            </a></li>
    </ul>
    {{-- <ul>
				<li><a class="menu_link danger restore" href="/regenerate"><img src="http://www.synchronoss.com/assets/img/icons/restore.svg" alt=""></a></li>

    </ul> --}}

</nav>
<!-- MENU -->