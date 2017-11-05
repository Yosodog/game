<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                Some Game
            </a>
        </div>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto" id="main-menu">
                @if (!Auth::guest()) {{-- If the user isn't a guest --}}
                @if (!Auth::user()->hasNation) {{-- If the user doesn't have a nation --}}
                <li class="nav-item"><a href="{{ url("/nation/view/create") }}">Create Nation</a></li>
                @else
                    <li class="dropdown nav-item">
                        @include("layouts.nav.nation")
                    </li>
                    <li class="dropdown nav-item">
                        @include("layouts.nav.military")
                    </li>
                    <li class="dropdown nav-item">
                        @include("layouts.nav.international")
                    </li>
                    <li class="dropdown nav-item">
                        @include("layouts.nav.resources")
                    </li>
                @endif
                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right mr-2">
                <li class="dropdown nav-item">
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