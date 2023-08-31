<div class="ui pointing menu stackable hriz-menu" style="font-size:13px; border-radius: 0;">
    <a href="/" class="header logo" style="margin-right:250px">
        <img alt="Saamcc" src="{{ asset('assets/images/app_logo_sq.png') }}"
            style="height: 41px;position: absolute;padding:5px; border: 1px solid red">
    </a>

    <x-navbar.menu />

    <div class="right menu">
        @if (Auth::check())
            <div class="item" style="padding:0px !important;margin:0px !important;">
                <a href="{{ App\Helpers\Loader::SSOSERVER() }}" style="opacity:1" target="_blank">
                    <span class="ui label green" style="font-size:11px;margin-left:7px">
                        <div class="ui dropdown" id="ABMenu">
                            {{ Auth::user()->Prenom . ' ' . Auth::user()->Nom }}
                            ({{ Auth::user()->Profil }})
                        </div>
                    </span>
                </a>
            </div>

            <div class="item">
                <a href="{{ route('logout') }}" title="Déconnecter" style="text-decoration:none"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                        class="sign-out icon"></i> Quitter</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </div>
        @endif

    </div>

    <div class="hamburger">
        <span class="hamburger-bun"></span>
        <span class="hamburger-patty"></span>
        <span class="hamburger-bun"></span>
    </div>
</div>
