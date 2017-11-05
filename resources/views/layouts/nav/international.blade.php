<a href="#" class="nav-link dropdown-toggle">
    International <span class="caret"></span>
</a>

<ul class="dropdown-menu" role="menu">
    <li><a href="{{ url("/nations") }}" class="dropdown-item">Nations</a></li>
    <li><a href="{{ url("/alliances") }}" class="dropdown-item">Alliances</a></li>
    @if (Auth::user()->nation->hasAlliance())
        <li><a href="{{ url("/alliance/".Auth::user()->nation->alliance->id) }}" class="dropdown-item">{{ Auth::user()->nation->alliance->name }}</a></li>
    @else
        <li><a href="{{ url("/alliance/create") }}" class="dropdown-item">Create an Alliance</a></li>
    @endif
    <li><a href="{{ url("#") }}" class="dropdown-item">Wars</a></li>
</ul>