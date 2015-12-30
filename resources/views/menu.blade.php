<!-- MENU -->
<nav class="main_navigation">
    <ul>
        <li class="menu_link" ><a href="/home" title="{{ trans('general.menu.home') }}">
            @include('inicio')
        </a></li>

        <li class="menu_link">
            <a title="Administración">
                @include('administracion')
            </a>
            <ul>
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
                <li class="pending">
                    <a href="/emotions" title="{{ trans_choice('general.menu.emotions', 2) }}">
                        {{ trans_choice('general.menu.emotions', 2) }}
                    </a>
                </li>
                <li class="disabled">
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
                <li class="pending">
                    <a href="/dreams" title="{{ trans_choice('general.menu.dreams', 2) }}">
                        {{ trans_choice('general.menu.dreams', 2) }}
                    </a>
                </li>
                <li class="disabled">
                    <a href="/assesments" title="{{ trans_choice('general.menu.assesments', 2) }}">
                        {{ trans_choice('general.menu.assesments', 2) }}
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu_link pending">

            <a title="{{ trans('general.menu.catalogs') }}">
                @include('catalogos')
            </a>
            <ul>
                <li>
                    <a href="/companies" title="{{ trans_choice('general.menu.companies', 2) }}">
                        Escolaridad
                    </a>
                </li>
                <li>
                    <a href="/companies" title="{{ trans_choice('general.menu.companies', 2) }}">
                        Industrias
                    </a>
                </li>
                <li>
                    <a href="/companies" title="{{ trans_choice('general.menu.companies', 2) }}">
                        Paises
                    </a>
                </li>
                
            </ul>
        
        </li>
        <li class="menu_link pending">
            <a href="/objectives" title="KPIs">
                @include('kpis')
            </a>
        </li>

        <li class="menu_link disabled">
            <a href="/rewarding" title="{{ trans('general.menu.rewarding') }}">
                @include('rewarding')
            </a>
        </li>
        <li class="menu_link pending">
            <a href="/tasks" title="{{ trans('general.menu.task_manager') }}">
                @include('task-manager')
            </a>
        </li>
        <li class="menu_link disabled">
            <a href="/one_page" title="{{ trans('general.menu.one_page') }}">
                @include('one-page')
            </a>
        </li>
        <li class="menu_link disabled">
            <a href="/reports" title="{{ trans_choice('general.menu.reports',2) }}">
                @include('reports')
            </a>
        </li>

        @if(Auth::user()->can('list-priorities'))
            <li class="menu_link">
                <a href="/priorities" title="{{ trans_choice('general.menu.priorities', 2) }}">
                    @include('prioridades')
                </a>
            </li>
        @endif
            <li class="menu_link">
                <a href="/users/{{Auth::user()->user_id}}/edit" title='Mi Perfil'>@include('mi-perfil') </a>
            </li>
		<li class="menu_link"><a href="/logout" title="Cerrar Sesión">@include('cerrar-sesion')</a></li>
    </ul>
    {{-- <ul>
				<li><a class="menu_link danger restore" href="/regenerate"><img src="http://www.synchronoss.com/assets/img/icons/restore.svg" alt=""></a></li>

    </ul> --}}

</nav>
<!-- MENU -->