<!-- MENU -->
<div class="container flex-grid">
    <div class="row flex-align-center flex-just-center loginForm">
        <div class="cell size12">
            <div class="greeting">
                @if(Session::get('name'))
                    <img id="profile_pic" src="{{Auth::user()->thumbnail}}" style="border-radius: 50%; width: 2em; ">
                @endif
                {{ Session::get('name')}}
                @if(Session::get('company_name'))
                    <br>
                    <small>{{ Session::get('company_name') }}</small>
                        
                @endif
            </div>
            <a href="/"><img src="/img/logo.svg" width="500"></a>

			@if(Auth::check())

			    
				<br>
				
				<a class="button" href="/home">Home</a>
				<a class="button" href="/users">Users</a>
				<a class="button" href="/departments">Departments</a>
				<a class="button" href="/positions">Positions</a>
				<a class="button" href="/priorities">Priorities</a>
			    @if(Auth::user()->hasRole('champion'))
					<a class="button" href="/companies">Companies</a>
			    @endif
				<a class="button btn-primary" id="logout" href="/logout">Logout <span class="mif-icon_name"></span></a>
				<a class="button danger restore" href="/regenerate">Restore</a>

			@endif
            <hr>


        </div>
    </div>
</div>
<!-- MENU -->