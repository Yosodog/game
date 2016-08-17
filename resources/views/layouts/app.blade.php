<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Some Game</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

    <!-- Styles -->
    <!--
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    Yeti.css contains default bootstrap so no need to load it
    -->
    <link rel="stylesheet" href="{{ url("/lib/css/yeti/yeti.css") }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.smartmenus/1.0.0/addons/bootstrap/jquery.smartmenus.bootstrap.min.css">
    <link rel="stylesheet" href="{{ url("/lib/css/custom.css") }}">
</head>
<body id="app-layout">
<header>
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
                                <a href="#">
                                    Nation <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url("/nation/view/".Auth::user()->nation->id) }}">View Nation</a></li>
                                    <li class="dropdown"><a href="{{ url("#") }}">Cities <i class="fa fa-caret-right" aria-hidden="true"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ url("/cities") }}">View All</a></li>
                                            <li class="divider"></li>
                                            @foreach (Auth::user()->nation->cities as $city)
                                                <li><a href="{{ url("cities/view/".$city->id) }}">{{ $city->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#">
                                    Military <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url("#") }}">Army</a></li>
                                    <li><a href="{{ url("#") }}">Air Force</a></li>
                                    <li><a href="{{ url("#") }}">Navy</a></li>
                                    <li><a href="{{ url("#") }}">Your Wars</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#">
                                    International <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url("/nations") }}">Nations</a></li>
                                    <li><a href="{{ url("#") }}">Alliances</a></li>
                                    <li><a href="{{ url("#") }}">Your Alliance</a></li>
                                    <li><a href="{{ url("#") }}">Wars</a></li>
                                </ul>
                            </li>
                        @endif
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#">
                            Community <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url("#") }}">Forums</a></li>
                            <li><a href="{{ url("#") }}">IRC</a></li>
                        </ul>
                    </li>
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/account/inbox') }}"></i>Messages</a></li>
                                <li><a href="{{ url('#') }}"></i>Notifications</a></li>
                                <li><a href="{{ url('#') }}">Account</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>

<main>
    <div class="container">
        @include("alerts") {{-- Include the template for alerts. This checks if there's something needed to display --}}
        @yield('content')
    </div>
</main>

<footer>
    <div class="container text-center">
        <ul class="small">
            <li><a href="">Task List</a></li>
            <li><a href="https://github.com/Yosodog/game">Source</a></li>
        </ul>
    </div>
</footer>

    <!-- JavaScripts -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.smartmenus/1.0.0/jquery.smartmenus.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.smartmenus/1.0.0/addons/bootstrap/jquery.smartmenus.bootstrap.min.js"></script>
    <script>
        $.SmartMenus.prototype.isTouchMode = function() {
            return true;
        };

        $(function() {
            $('#main-menu').smartmenus({
                subIndicators: false,
            });
            // activate touch mode permanently
        });
    </script>
    @yield("scripts") {{-- For loading custom scripts on pages --}}
</body>
</html>
