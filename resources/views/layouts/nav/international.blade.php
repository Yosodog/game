<a href="#">
    International <span class="caret"></span>
</a>

<ul class="dropdown-menu" role="menu">
    <li><a href="{{ url("/nations") }}">Nations</a></li>
    <li><a href="{{ url("/alliances") }}">Alliances</a></li>
    @if (Auth::user()->nation->hasAlliance())
        <li><a href="{{ url("/alliance/".Auth::user()->nation->alliance->id) }}">{{ Auth::user()->nation->alliance->name }}</a></li>
    @else
        <li><a href="{{ url("/alliance/create") }}">Create an Alliance</a></li>
    @endif
    <li><a href="{{ url("#") }}">Wars</a></li>
</ul>