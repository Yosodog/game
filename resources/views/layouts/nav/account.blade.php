<a href="#">
    {{ Auth::user()->name }} <span class="caret"></span>
</a>

<ul class="dropdown-menu" role="menu">
    <li><a href="{{ url('/account/inbox') }}"></i>Messages</a></li>
    <li><a href="{{ url('#') }}"></i>Notifications</a></li>
    <li><a href="{{ url('/account') }}">Account</a></li>
    <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
</ul>