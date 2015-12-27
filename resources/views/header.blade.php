<div class="greeting">
                    @if(Auth::user())
                        <img id="profile_pic" src="{{Auth::user()->thumbnail}}" style="border-radius: 50%; width: 2em; ">
                        {{ Auth::user()->name}} {{ Auth::user()->lastname}}
                        <br>
                        @if(Auth::user()->hasRole('super-admin')) 
                            {{ trans('general.users.super_admin') }}
                        @elseif(Auth::user()->hasRole('coach')) 
                            {{ trans('general.users.coach') }}
                        @elseif(Auth::user()->hasRole('ceo')) 
                            {{ trans('general.users.ceo') }}
                        @elseif(Auth::user()->hasRole('champion')) 
                            {{ trans('general.users.champion') }}
                        @elseif(Auth::user()->hasRole('employee')) 
                            {{ trans('general.users.employee') }}
                        @endif

                        @if(Session::get('company_name'))
                            <br>
                            <small>{{ Session::get('company_name') }}</small>
                                
                        @endif

                    @endif
                </div>
        <a href="/"><img src="/img/logo.svg" width="500"></a>
                