<style>
     .profile_pic{border-radius: 50%; width: 3.5em; margin-left:2em; }
</style>
<div class="logo">
    <a href="/"><img src="/img/main-logo.svg"></a>
</div>
    @if(Auth::user())
<div>
{{ date('d/m/Y H:i:s') }}
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

</div>
<div>
    <span class="name">
        {{ Auth::user()->name}} {{ Auth::user()->lastname}}
    </span>
    <img class="profile_pic" src="{{Auth::user()->thumbnail}}">
</div>
<div style="background-image:url(http://placehold.it/150x150);background-repeat: no-repeat; background-size: 100% 100%;">
    
</div>
    @endif
