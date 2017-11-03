<a href="#">
    {{ Auth::user()->name }} @if(Auth::user()->newThreadsCount() > 0)<span class="badge">{{ Auth::user()->newThreadsCount() }}@endif</span> <span class="caret"></span>
</a>

<ul class="dropdown-menu" role="menu">
    <li><a href="{{ url('/account/inbox') }}"></i>Messages @if(Auth::user()->newThreadsCount() > 0)<span class="badge">{{ Auth::user()->newThreadsCount() }}@endif</a></li>
    <li><a href="{{ url('#') }}"></i>Notifications</a></li>
    <li><a href="{{ url('/account') }}">Account</a></li>
    <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
</ul>