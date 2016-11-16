<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                Some Game
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav" id="main-menu">
                @if (!Auth::guest()) {{-- If the user isn't a guest --}}
                @if (!Auth::user()->hasNation) {{-- If the user doesn't have a nation --}}
                <li><a href="{{ url("/nation/view/create") }}">Create Nation</a></li>
                @else
                    <li class="dropdown">
                        @include("layouts.nav.nation")
                    </li>
                    <li class="dropdown">
                        @include("layouts.nav.military")
                    </li>
                    <li class="dropdown">
                        @include("layouts.nav.international")
                    </li>
                    <li class="dropdown">
                        @include("layouts.nav.resources")
                    </li>
                @endif
                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    @include("layouts.nav.community")
                </li>
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        @include("layouts.nav.account")
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>