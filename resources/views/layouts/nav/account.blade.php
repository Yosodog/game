<a href="#" class="nav-link dropdown-toggle">
    {{ Auth::user()->name }} @if(Auth::user()->newThreadsCount() > 0)<span class="badge">{{ Auth::user()->newThreadsCount() }}@endif</span> <span class="caret"></span>
</a>

<ul class="dropdown-menu" role="menu">
    <li><a href="{{ url('/account/inbox') }}" class="dropdown-item"></i>Messages @if(Auth::user()->newThreadsCount() > 0)<span class="badge">{{ Auth::user()->newThreadsCount() }}@endif</a></li>
    <li><a href="{{ url('#') }}" class="dropdown-item"></i>Notifications</a></li>
    <li><a href="{{ url('/account') }}" class="dropdown-item">Account</a></li>
    <li><a href="{{ url('/logout') }}" class="dropdown-item"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
</ul>