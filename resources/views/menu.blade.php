<!-- MENU -->
<nav class="main_navigation">
    <ul>
        <li class="menu_link" ><a href="/home" title="{{ trans('general.menu.home') }}"><img src="/img/home.svg" alt=""> </a></li>

        <li class="menu_link">
            <a title="Administración"><img src="/img/gear.svg" alt=""></a>
            <ul>
                @if(Auth::user()->can('list-companies'))
                    <li>
                        <a class="menu_link" href="/companies" title="{{ trans_choice('general.menu.companies', 2) }}">
                            {{ trans_choice('general.menu.companies', 2) }}
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('list-users'))
                    <li>
                        <a class="menu_link" href="/users" title="{{ trans_choice('general.menu.users', 2) }}">
                            {{ trans_choice('general.menu.users', 2) }}
                        </a>
                        </li>
                @endif
                @if(Auth::user()->can('list-periods'))
                    <li>
                        <a class="menu_link" href="/periods" title="{{ trans_choice('general.menu.periods', 2) }}">
                            {{ trans_choice('general.menu.periods', 2) }}
                        </a>
                    </li>
                @endif
                @if(Auth::user()->can('list-departments'))
                    <li>
                        <a class="menu_link" href="/departments" title="{{ trans_choice('general.menu.departments', 2) }}">
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
            </ul>
        </li>
        @if(Auth::user()->can('list-priorities'))
            <li class="menu_link">
                <a href="/priorities" title="{{ trans_choice('general.menu.priorities', 2) }}"> <img src="/img/star.svg" alt=""> </a>
            </li>
        @endif
            <li class="menu_link">
                <a href="/users/{{Auth::user()->user_id}}/edit" title='Mi Perfil'> <img src="/img/user1.svg" alt=""> </a>
            </li>
		<li class="menu_link"><a href="/logout" title="Cerrar Sesión"><img src="/img/logout.svg" alt=""></a></li>
    </ul>
    {{-- <ul>
				<li><a class="menu_link danger restore" href="/regenerate"><img src="http://www.synchronoss.com/assets/img/icons/restore.svg" alt=""></a></li>

    </ul> --}}
</nav>
<!-- MENU -->