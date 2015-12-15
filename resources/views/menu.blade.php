<!-- MENU -->

<div class="container flex-grid">
    <div class="row flex-align-center flex-just-center loginForm">
        <div class="cell size12">
            
            <a href="/"><img src="/img/logo.svg" width="500"></a>

			@if(Auth::check())

			    
				<br>
				
				<a class="button" href="/home">Home</a>
			    @if(Auth::user()->can('list-users'))
                    <a class="button" href="/users">Users</a>
                @endif
                @if(Auth::user()->can('list-departments'))
                    <a class="button" href="/departments">Departments</a>
                @endif
                @if(Auth::user()->can('list-positions'))
                    <a class="button" href="/positions">Positions</a>
                @endif
                @if(Auth::user()->can('list-priorities'))
                    <a class="button" href="/priorities">Priorities</a>
                @endif
                @if(Auth::user()->can('list-companies'))
                    <a class="button" href="/companies">Companies</a>
                @endif
                @if(Auth::user()->can('list-periods'))
					<a class="button" href="/periods">Periods</a>
			    @endif
				<a class="button btn-primary" id="logout" href="/logout">Logout <span class="mif-icon_name"></span></a>
				<a class="button danger restore" href="/regenerate">Restore</a>

			@endif
            <hr>


        </div>
    </div>
</div>


<!-- MENU -->