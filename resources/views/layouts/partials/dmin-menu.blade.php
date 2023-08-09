<div class="ui sidebar pointing inverted vertical menu sidebar-menu" style="box-shadow: 0 0 0 3px #80808026;"
    id="sidebar">
    <x-navbar.side-item />
</div>

<nav class="ui top fixed ui pointing menu" style="z-index: 9999;">
    <div class="left menu">
        <a href="#" class="sidebar-menu-toggler item" data-target="#sidebar" style="display: none;">
            <i class="sidebar icon"></i>
        </a>
        <a href="/" class="header" style="margin-right: 250px">
            <img alt="Saamcom"
                src="{{ Gate::allows('is_client', [App\Models\User::class])? Auth::user()->clients()->first()->logo ?? asset('assets/images/app_logo.png'): asset('assets/images/app_logo.png') }}"
                style="height: 32px;position: absolute;margin-top: 4px;">
        </a>

        <div class="hriz-menu">
            <x-navbar.menu />
        </div>

    </div>

    <div class="right menu">
        <div class="ui dropdown item" style="color: #000000f2 !important">
            <i class="user cirlce icon"></i>
            <div class="menu">
                @if (Auth::check())
                    <a href="{{ App\Helpers\Loader::SSOSERVER() }}" class="item" style="opacity:1" target="_blank">
                        <i class="info circle icon"></i> Profil</a>
                    <a href="{{ route('logout') }}" title="Déconnecter" class="item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="sign-out icon"></i>
                        Logout
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf</form>
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>
