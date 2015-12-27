<!-- MENU -->
<nav class="main_navigation">
    <ul>
			@if(Auth::check())

			    
				<br>
				
				<li><a class="menu_link" href="/home" title="{{ trans('general.menu.home') }}"><img src="/img/home.svg" alt=""> </a></li>
			    @if(Auth::user()->can('list-users'))
                    <li><a class="menu_link" href="/users" title="{{ trans_choice('general.menu.users', 2) }}"> <img src='http://simpleicon.com/wp-content/uploads/multy-user.svg' alt=""> </a></li>
                @endif
                @if(Auth::user()->can('list-departments'))
                    <li><a class="menu_link" href="/departments" title="{{ trans_choice('general.menu.departments', 2) }}"> <img src="/img/gear.svg" alt=""> </a></li>
                @endif
                @if(Auth::user()->can('list-positions'))
                    <li><a class="menu_link" href="/positions" title="{{ trans_choice('general.menu.positions', 2) }}"> <img src="/img/gear.svg" alt=""> </a></li>
                @endif
                @if(Auth::user()->can('list-priorities'))
                    <li><a class="menu_link" href="/priorities" title="{{ trans_choice('general.menu.priorities', 2) }}"> <img src="/img/gear.svg" alt=""> </a></li>
                @endif
                @if(Auth::user()->can('list-companies'))
                    <li><a class="menu_link" href="/companies" title="{{ trans_choice('general.menu.companies', 2) }}"> <img src="http://simpleicon.com/wp-content/uploads/building-3.svg" alt=""> </a></li>
                @endif
                @if(Auth::user()->can('list-periods'))
					<li><a class="menu_link" href="/periods" title="{{ trans_choice('general.menu.periods', 2) }}"> <img src="/img/gear.svg" alt=""> </a></li>
			    @endif
				<li><a class="menu_link btn-primary" id="logout" href="/logout"><img src="http://uxrepo.com/static/icon-sets/font-awesome/svg/logout.svg" alt=""></a></li>
				<li><a class="menu_link danger restore" href="/regenerate"><img src="http://www.synchronoss.com/assets/img/icons/restore.svg" alt=""></a></li>

			@endif
    </ul>
</nav>
<!-- MENU -->
