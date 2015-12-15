<div class="greeting">
                    @if(Auth::user())
                        <img id="profile_pic" src="{{Auth::user()->thumbnail}}" style="border-radius: 50%; width: 2em; ">
                        {{ Auth::user()->name}} {{ Auth::user()->lastname}}
                        <br>
                        @if(Auth::user()->hasRole('super-admin')) 
                            super_admin
                        @elseif(Auth::user()->hasRole('coach')) 
                            coach
                        @elseif(Auth::user()->hasRole('ceo')) 
                            ceo
                        @elseif(Auth::user()->hasRole('champion')) 
                            champion
                        @elseif(Auth::user()->hasRole('employee')) 
                            employee
                        @endif

                        @if(Session::get('company_name'))
                            <br>
                            <small>{{ Session::get('company_name') }}</small>
                                
                        @endif

                    @endif
                </div>
        <a href="/"><img src="/img/logo.svg" width="500"></a>
                