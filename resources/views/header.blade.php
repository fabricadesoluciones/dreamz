<style>
    
.autowidth{
    width: auto;
}
    .inlined .input-control.text{
        width:100%;
    }
    .inlined input.auto{
        width:auto;

    }
    .inlined span.select2.select2-container.select2-container--default{
        width: 40% !important;
    }
    .company_logo{
        background-repeat: no-repeat; background-size: 100% 100%;
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
    }
    .company_logo label{
        display: block;
        padding: 1ex;
        background-color: #fff;
    }

</style>
<div class="logo">
    <a href="/"><img src="/img/main-logo.svg"></a>
</div>
    @if(Auth::user())
<div>
<div>
    
<div>{{ date('d/m/Y') }} <span class="time"> {{ date('H:i') }}</span></div>
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
        {{-- 
        @if(Session::get('company_name'))
            <br>
            <small>{{ Session::get('company_name') }}</small>
                
        @endif
         --}}

</div>
</div>
<div>
    <span class="name">
        {{ Auth::user()->name}} {{ Auth::user()->lastname}}
        @if(Session::get('department_name'))
            <br> {{Session::get('department_name')}}
        @endif
        
    </span>
    <img class="profile_pic" src="{{Auth::user()->thumbnail}}">
</div>
<div class="company_logo" style="background-image:url({{ Session::get('company_logo')}})">

    <select id="lang" data-selected="{{ Session::get('language')}}">
        <option value="es">Español</option>
        <option value="en">English</option>
    </select>
    
</div>
    @endif
